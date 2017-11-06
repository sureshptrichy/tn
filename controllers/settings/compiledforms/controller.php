<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings/Subevaluations
 */
 
final class Controller_Settings_Compiledforms extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Review Forms'),
			'view' => 'settings/compiledforms',
			'main_order' => 210
		);
		$this->permission = array(
			'authenticated',
			'viewSubevaluation'
		);
		$this->evaluationTypes = array(
			'me' => array(
				'id' => 'me',
				'name' => _('Management Reviews')
			),
			'ae' => array(
				'id' => 'ae',
				'name' => _('Associate Reviews')
			)
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('Compiledform');
		$compiledforms = $model->compiledforms();
		$compiledformstypes = $this->evaluationTypes;
		foreach ($compiledformstypes as $type => $key){
			$count = 0;
			foreach ($compiledforms as $compiledform){
				if ($compiledform['evaltype'] == $type){
					$count = $count+1;
					$compiledformstypes[$type]['compiledform'][$compiledform['id']] = $compiledform;
				}
			}
			$compiledformstypes[$type]['type_count'] = $count;
		}
		tpl_set('compiledforms', $compiledformstypes);
		parent::display();
	}
	
	public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addSubevaluation';
	}
	
	public function call_new($params) {
		$preload = array();
		$subevals = get_model('Compiledform')->allsubevaluations($params[0]);
		$preload['subevaluations_fulllist'] = $subevals;
		$preload['evaltype'] = $params[0];
		$compiledForm = $this->build_subeval_form('new', array_merge($preload));
		if (FALSE === $compiledForm->valid()) {
			tpl_set('compiledForm', $compiledForm);
		} else {
			$compiledForm = $compiledForm->valid();
			$model = get_model('Compiledform');
			if (isset($compiledForm['active'])) {
				$compiledForm['active'] = 1;
			} else {
				$compiledForm['active'] = 0;
			}
			$model->setAll($compiledForm);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->code = generateCodeFromTitle($model->name);
			$model->save();
			$model->removeSections($model->id);
			if (isset($compiledForm['subevaluations']) AND $compiledForm['subevaluations'] != ''){
				foreach ($compiledForm['subevaluations'] as $subevaluation) {
					$model->addSection($model->id, $subevaluation);
				}
			}
			$model->removeProperties($model->id);
			$model->addProperty($model->id, $compiledForm['property_id']);
			flash(_('The review form has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editSubevaluation';
	}

	public function call_edit($params) {
		$preload = array();
		$model = get_model('Compiledform');
		$preload = $model->getOne($params[0], 'id');
		$sections = $model->sections($params[0]);
		$preload['sections'] = $sections;
		$subevaluations = $model->allsubevaluations($preload['evaltype'], $params[0], true);
		
		$preload['subevaluations_fulllist'] = $subevaluations;
		$compiledForm = $this->build_subeval_form('edit', array_merge($preload));
			
		if (FALSE === $compiledForm->valid()) {
			tpl_set('compiledForm', $compiledForm);
		} else {
			$compiledForm = $compiledForm->valid();
			/* if(array_key_exists('locked', $compiledForm) AND $compiledForm['locked'] == 0){ */
				$model = get_model('Compiledform');
				if (isset($compiledForm['active'])) {
					$compiledForm['active'] = 1;
				} else {
					$compiledForm['active'] = 0;
				}
				$model->setAll($compiledForm, TRUE);
				$model->status = 1;
				//echo $preload["name"];echo $model->name;exit;
				if($preload["name"] != $model->name || !$model->code) {
					$model->code =generateCodeFromTitle($model->name);
				}
				
				$model->cid = $this->G->user->id;
				$model->save();
				$model->removeSections($model->id);
				if (isset($compiledForm['subevaluations']) AND $compiledForm['subevaluations'] != ''){
					foreach ($compiledForm['subevaluations'] as $subevaluation) {
						$model->addSection($model->id, $subevaluation);
					}
				}
				$model->removeProperties($model->id);
				$model->addProperty($model->id, $compiledForm['property_id']);
				flash(_('The review form has been saved.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			/* } else {
				flash(_('Sorry but this review form has been locked. No further changes can be made.'), 'danger');
				locate($this->G->url);
			} */
		}
		parent::display();
	}

	public function config_copy($params = NULL) {
		$this->route['view'] = $this->route['view'].'_copy';
		$this->permission[] = 'editSubevaluation';
	}

	public function call_copy($params) {
		$preload = array();
		$model = get_model('Compiledform');
		$preload = $model->getOne($params[0], 'id');
		$sections = $model->sections($params[0]);
		$preload['sections'] = $sections;
		$preload['name'] = "Copy of ".$preload['name'];
		$subevaluations = $model->allsubevaluations($preload['evaltype'], $params[0], true);
		$preload['subevaluations_fulllist'] = $subevaluations;
		$compiledForm = $this->build_subeval_form('copy', array_merge($preload));
			
		if (FALSE === $compiledForm->valid()) {
			tpl_set('compiledForm', $compiledForm);
		} else {
			$compiledForm = $compiledForm->valid();
			/* if(array_key_exists('locked', $compiledForm) AND $compiledForm['locked'] == 0){ */
				$model = get_model('Compiledform');
				if (isset($compiledForm['active'])) {
					$compiledForm['active'] = 1;
				} else {
					$compiledForm['active'] = 0;
				}
				$model->setAll($compiledForm, TRUE);
				$model->status = 1;
				$model->code = generateCodeFromTitle($model->name);
				$model->cid = $this->G->user->id;
				$model->save();
				$model->removeSections($model->id);
				if (isset($compiledForm['subevaluations']) AND $compiledForm['subevaluations'] != ''){
					foreach ($compiledForm['subevaluations'] as $subevaluation) {
						$model->addSection($model->id, $subevaluation);
					}
				}
				$model->removeProperties($model->id);
				$model->addProperty($model->id, $compiledForm['property_id']);
				flash(_('The review form has been saved.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			/* } else {
				flash(_('Sorry but this review form has been locked. No further changes can be made.'), 'danger');
				locate($this->G->url);
			} */
		}
		parent::display();
	}
	
	public function config_preview($params = NULL) {
		$this->route['view'] = $this->route['view'].'_preview';
		$this->permission[] = 'editSubevaluation';
	}
	
	public function call_preview($params) {
		//$form = compileForm($this->G, $params[0], 'Compiledform', true);		
		//tpl_set('form', $form);
			
		$preload = array();
		$preload = get_model('Compiledform')->getOne($params[0], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($params[0]);
		foreach ($subevaluations as $subevaluation){
			
			$subevaluation['fields'] = get_model('subevaluation')->fields($subevaluation['id']);
			foreach ($subevaluation['fields'] as $field){
				$subevaluation['fields'][$field['id']]['value'] = '';
				$subevaluation['fields'][$field['id']]['donotsave'] = '';
				$subevaluation['fields'][$field['id']]['rateable'] = true;
				$subevaluation_type = 'manager';
				if ($subevaluation['peer'] == '1'){$subevaluation_type = 'peer';}
				$subevaluation['fields'][$field['id']]['subevaluation_type'] = $subevaluation_type;
			}
			$preload['sections'][$subevaluation['id']] = $subevaluation;
		}
		
		$form = $this->compile_form('review', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('form', $form);
		} else {
			tpl_set('form', $form);
			$form = $form->valid();
			if ($form['locked'] == 1){
				flash(_('This review has been locked. No further changes can be made.'), 'danger');
			} else {
				flash(_('The preview works!.'), 'success');
			}
			//locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteSubevaluation';
	}
	
	public function call_delete($params) {
		$model = get_model('Compiledform');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('This review has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}		
	
	private function build_subeval_form($type, $preload = array()) {
		$suffix = '[]';
		$disabled = null;
		/* if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$disabled = true;
		} */
		$form = new Form($this->G, array(
			'name' => $type . '-subeval',
			'class' => 'form compiled-form',
			'header' => array(
				'text' => sprintf(_('%1$s Compiled Review Form'), ucfirst($type)),
				'class' => 'form-subeval-heading'
			),
			'disabled' => $disabled
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		
		/* if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$form->addCheckbox(array(
				'name' => 'locked',
				'class' => 'checkbox',
				'label' => _('Locked'),
				'value' => $preload['locked']
			));
		} else {
			$form->addHidden(array(
				'name' => 'locked'
			));
		} */
		
		$form->addHidden(array(
			'name' => 'evaltype'
		));
		$form->addHidden(array(
			'name' => 'code'
		));		
		$users = get_model('user');
		$currentUser = $users->loadUser(session('user'));
		if (empty($users->property)) {
			$property = $users->getProperties();
		} else {
			$property = $users->property;
		}
		foreach ($property as $data){
			$propertyId = $data['id'];
			$propertyName = $data['name'];
		}
		
		$form->addHiddenArray(array(
			'name' => 'property_id',
			'values' => array(
				'id' => $propertyId
			)
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Form Name'),
			'disabled' => $disabled
		));
		$form->addTextArea(array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Description'),
			'disabled' => $disabled
		));
		$full_list = array();
		$short_list = array();
		foreach($preload['subevaluations_fulllist'] as $subevaluation){
			$full_list[$subevaluation['id']] = $subevaluation;
		}

		if (strtolower($type) == 'edit' || strtolower($type) == 'copy') {
			foreach($preload['sections'] as $section){
				$short_list[$section['join_id']]['id'] = $section['id'];
				$short_list[$section['join_id']]['name'] = $section['name'];
				$short_list[$section['join_id']]['description'] = $section['description'];
				if($section['cummulation'] != ''){
					$short_list[$section['join_id']]['cummulation'] = $section['cummulation'];
				}
				if($section['content'] != ''){
					$short_list[$section['join_id']]['type'] = 'static';
				} elseif($section['aid'] == '' && $section['name'] == 'Results/Culture Matrix'){
					$short_list[$section['join_id']]['type'] = 'rcMatrix';
				} elseif($section['aid'] == '' && $section['name'] == 'Signature'){
					$short_list[$section['join_id']]['type'] = 'signature';
				}
				else {
					$short_list[$section['join_id']]['type'] = 'subevaluation';
				}
			}
		}
		$form->addList(array(
			'name' => '',
			'class' => 'form-control evaluations',
			'size' => '10',
			'fullList' => $full_list,
			'shortList' => $short_list
			)
		);
		$form->addSubmit(array(
			'name' => 'save',
			'class' => 'btn-primary',
			'label' => 'Save Form'
		));
		return $form;
	}
	
	private function randomTagId(){
		return md5(rand().time().rand());
	}	
	
	private function compile_form($type, $preload = array()) {
		$disabled = null;
		if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$disabled = true;
		}
		$form = new Form($this->G, array(
			'name' => 'compiledform',
			'class' => 'form compiled-form',
			'header' => array(
				'text' => sprintf(_($preload['name']), ucfirst($type)),
				//'text' => 'PERFORMANCE MANAGEMENT',
				'class' => 'form-subeval-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		
		$form->addHidden(array(
			'name' => 'locked'
		));
		$users = get_model('user');
		$targetUser = $users->loadUser(session('user'));
		$targetUser = $targetUser['firstname'].' '.$targetUser['lastname'];
		$manager = $users->loadUser(session('user'));
		$manager = $manager['firstname'].' '.$manager['lastname'];
		
		if (empty($users->property)) {
			$property = $users->getProperties();
		} else {
			$property = $users->property;
		}
		foreach ($property as $data){
			$propertyId = $data['id'];
			$propertyName = $data['name'];
		}
		
		if (empty($users->department)) {
			$department = array_merge(array(
				'all' => array(
					'id' => 'all',
					'name' => _('All Departments')
				)
			), $users->getDepartments());
		} else {
			$department = $users->department;
		}
		foreach ($department as $data){
			$departmentName = $data['name'];
		}
		
		/* $form->reviewFormInfo(array(
			'name' => 'Employee Info',
			'target_user' => $targetUser,
			'property' => $propertyName,
			'review_cycle' => '2014',
			'manager' => $manager,
			'department' => $departmentName
		)); */
		$form->reviewFormInfo(array(
			'name' => 'Employee Info',
			'hourly_name' => '',
			'property_id' => '',
			'property_name' => '',
			'review_cycle' => '',
			'manager_name' => '',
			'hourly_position' => '', 
			'reviewform_name' => '',
			'last_review_date' => '',
			'current_rate' => '',
			'hire_date' => '',
			'position_date' => '',
			'seniority_date' => '',
			'hourly_department' => '',
			'hourly_division' => '',
			'target_user' => $targetUser,
			'property' => $propertyName,
			'review_cycle' => '2014',
			'manager' => $manager,
			'department' => $departmentName
		));		
		
		$form->addHiddenArray(array(
			'name' => 'property_id',
			'values' => array(
				'id' => $propertyId
			)
		));
		$form->reviewFormRatingKey(array(
			'name' => 'ratingkey'
		));
		if(array_key_exists('sections', $preload)){
			foreach ($preload['sections'] as $section){
				
				if (isset($section['cummulation'])){
					$form->openTag(array(
						'name' => $this->randomTagId(),
						'tag' => 'h2',
						'class' => 'cummulation',
						'nowrapper' => true
					));
					$form->addStatic(array(
						'name' => $this->randomTagId(),
						'class' => '',
						'label' => ucwords($section['name']),
						'nowrapper' => true
					));
					$form->closeTag(array(
						'name' => $this->randomTagId(),
						'tag' => 'h2',
						'nowrapper' => true
					));
				}
				if (isset($section['content']) AND $section['content'] != 'none'){
					$form->reviewFormStaticSection(array(
						'name' => $section["id"],
						'class' => '',
						'nowrapper' => true,
						'sectionName' => $section['name'],
						'sectionContent' => $section["content"],
					));
				}
				if (array_key_exists('fields', $section) && !empty($section['fields'])){
					foreach($section['fields'] as $field){
						if (!empty($field)){
							$rating = rand(1,5);
							$rating = mt_rand (1*10, 5*10) / 10;
							$rating = '3.3';
							$form->reviewFormSection(array(
								'name' => $field["id"],
								'class' => '',
								'nowrapper' => true,
								'sectionName' => $field['name'],
								'sectionType' => $field["type"],
								'sectionSubCategory' => $field["subcategory"],
								'sectionId' => $field["id"],
								'sectionDescription' => $field['description'],
								'value' => $field['value'],
								'rateable' => $field['rateable'],
								'donotsave' => $field['donotsave'],
								'subevaluation_type' => $field['subevaluation_type'],
								'rating_avg' => $rating,
								'ratings' => array(
									'Nick' => mt_rand(1, 5),
									'Rob' => rand(1, 5),
									'John' => rand(1, 5)					
								)
							));
						}
					}
				}
				if ($section['name'] == 'Results/Culture Matrix'){
					$rating_avg = mt_rand (1*10, 5*10) / 10;
					$result_avg = mt_rand (1*10, 5*10) / 10;
					$culture_avg = mt_rand (1*10, 5*10) / 10;
					$form->matrix(array(
						'name' => $this->randomTagId(),
						'result_avg' => $result_avg,
						'culture_avg' => $culture_avg,
						'rating_avg' => $rating_avg,
						'ratings' => array(
							'Nick' => array(
								'results' => mt_rand (1*10, 5*10) / 10,
								'culture' => mt_rand (1*10, 5*10) / 10
							),
							'Rob' => array(
								'results' => mt_rand (1*10, 5*10) / 10,
								'culture' => mt_rand (1*10, 5*10) / 10
							),
							'John' => array(
								'results' => mt_rand (1*10, 5*10) / 10,
								'culture' => mt_rand (1*10, 5*10) / 10
							)
						)
					));
				}
				if ($section['name'] == 'Signature'){
					$form->signature(array('name' => $this->randomTagId()));
				}
			}
		}
		
		$form->plainText(array(
			'name' => 'go-back',
			'value' => '<a class="btn  btn-primary pull-left "  style="margin-right: 30px; display: inline;" href="javascript:;" onclick="window.history.go(-1);">&laquo; Go Back</a>'
		));
		return $form;
	}
}
