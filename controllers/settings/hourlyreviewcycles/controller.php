<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Review Cycle Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Hourlyreviewcycles extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Hourly Review Cycles'),
			'view' => 'settings/hourlyreviewcycles',
			'main_order' => 200,
			'separator' => _('Reviews')
		);
		$this->permission = array(
			'authenticated',
			'viewReviewcycle'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('hourlyreviewcycle');
		tpl_set('reviews', $model->get(null, null, -1, session('property')));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_add($params) {
		$model = get_model('hourlyreviewcycle');

		$form = $this->build_form_1('new', array());
		if (FALSE === $form->valid()) {
			tpl_set('form', $form);
		} else {
			$review = $form->valid();
			if (isset($review['start'])) {
				$review['start'] = strtotime($review['start']);
			}
			if (isset($review['due'])) {
				$review['due'] = strtotime($review['due']);
			}
			$review['cid'] = session('user');

			$model->setAll($review);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->property_id = session('property');
			$model->save();
			
			flash(_('The review cycle has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl().'/edit/'.$model->id.'/2');
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		if ($this->G->url->getUrlBit(4) == 8) {
			$this->route['view'] = $this->route['view'] . '_LAUNCH';
		} else {
			$this->route['view'] = $this->route['view'] . '_edit';
		}
		$this->permission[] = 'editReviewcycle';
	}

	public function call_edit($params) {
		$reviewId = $params[0];
		$step = 1;
		if (isset($params[1]) && $params[1] > 0) {
			$step = $params[1];
		}
		tpl_set('step', $step);
		$model = get_model('hourlyreviewcycle');
		$preload = $model->getOne($reviewId, 'id');
		//print_r($preload);exit;
		$formList = array();

		switch ($step) {
			case 1:
				$form = $this->build_form_1('edit', array_merge($preload, $formList));
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$review = $form->valid();
					if (isset($review['start'])) {
						$review['start'] = strtotime($review['start']);
					}
					if (isset($review['due'])) {
						$review['due'] = strtotime($review['due']);
					}

					$model->setAll(array_merge($preload, $review));
					$model->id = $review['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->property_id = session('property');
					$model->save();
					
					locate(URL.$this->G->url->parentUrl().'/2');
				}
				break;
			case 2:
				$preload['hourlies-previous'] = $preload['hourlies'];
				$form = $this->build_form_2('edit', $preload);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$hourliesFile = $form->valid();
					$success = TRUE;
					$csvPath = NULL;

					if (isset($_FILES['hourlies']) && isset($_FILES['hourlies']['size']) && $_FILES['hourlies']['size'] > 1) {
						$csvPath = $hourliesFile['tnngtoken'].'-'.$_FILES['hourlies']['name'];
						if (!move_uploaded_file($_FILES['hourlies']['tmp_name'], UPLOAD_PATH.$csvPath)) {
							$success = FALSE;
						}
					} elseif (isset($preload['hourlies-previous'])) {
						$csvPath = $preload['hourlies-previous'];
					} else {
						$success = false;
					}
					if (false === $success) {
						flash(_('The CSV file could not be uploaded'), 'danger');
					}

					$preload['hourlies'] = $csvPath;
					if(!$preload['hourly_data'] || (isset($_FILES['hourlies']['size']) && $_FILES['hourlies']['size'] > 1)) {
						$hourlies = loadHourlyCSV(UPLOAD_PATH . $preload['hourlies']);
						$preload['hourly_data'] = json_encode($hourlies);
					}
					
					$model->setAll($preload);
					$model->id = $preload['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->property_id = session('property');
					$model->save();

					locate(URL.$this->G->url->parentUrl().'/3');
				}
				break;
			case 3:
			
				$hourlies = json_decode($preload['hourly_data'], true);
				$hourlyFormModel = get_model('hourlyreviewform');
				$hourlyForms = $hourlyFormModel->getFormsofHourlyCycle($preload['id']);
				
				//print_r($hourlies);exit;
				
				//$form = $this->build_form_3('edit', $preload, $hourlies);
				//print_r($_POST);exit;
				if (isset($_POST["continue"]) && $_POST["continue"]) {

					//echo 'save data';
					//print_r($_POST);
					//exit;
					$propertyModel = get_model('property');
					$propertyInfo = $propertyModel->getOne(session('property'), 'id');
					//print_r($propertyInfo);exit;
					$manager = $_POST['manager'];
					$review_form = $_POST['review_form'];
					
					if($_POST["continue"] == 'save') {
						foreach($hourlyForms as $key => $hourlyForm) {
							$hourlyReviewForm = get_model('hourlyreviewform');
							if(!array_key_exists($key, $manager)) { continue;}
							$manager_info = explode("@@@", $manager[$key]);
							$form_info = explode("@@@", $review_form[$key]);
							
							$hourlyReviewFormData = $hourlyReviewForm->getOne($hourlyForm->id, 'id');
							$hourlyReviewForm->setAll($hourlyReviewFormData);
							$hourlyReviewForm->id = $hourlyForm->id;
							$hourlyReviewForm->manager_id = $manager_info[2];
							$hourlyReviewForm->manager_name = $manager_info[0];
							$hourlyReviewForm->reviewform_id = $form_info[1];
							$hourlyReviewForm->reviewform_code = $form_info[0];
							$hourlyReviewForm->reviewform_name = $form_info[2];
							$hourlyReviewForm->status = 0;
							$hourlyReviewForm->cid = $this->G->user->id;
							$hourlyReviewForm->save();
						}
						
						flash('The Hourly Review Cycle has been saved!', 'success');

					} else {
						$hourlyReviewForm = get_model('hourlyreviewform');
						$hourlyReviewForm->removeForms($preload['id']);
						$hourlies_updated = array();
						foreach($hourlies as $key => $hourly) {
							$hourlyReviewForm = get_model('hourlyreviewform');
							$manager_info = explode("@@@", $manager[$key]);
							$form_info = explode("@@@", $review_form[$key]);
							$hourly['Manager/Evaluator Name'] = $manager_info[0];
							$hourly['Manager/Evaluator Email'] = $manager_info[1];
							$hourly['Review Form Code'] = $form_info[0];
							$hourlies_updated[] = $hourly;
							
							$hourlyReviewForm->hourly_name = $hourly['Name'];
							$hourlyReviewForm->hourly_department = $hourly['Department'];
							$hourlyReviewForm->hourly_division = $hourly['Division'];
							$hourlyReviewForm->hourly_position = $hourly['Position'];
							$hourlyReviewForm->manager_id = $manager_info[2];
							$hourlyReviewForm->manager_name = $manager_info[0];
							$hourlyReviewForm->reviewform_id = $form_info[1];
							$hourlyReviewForm->reviewform_code = $form_info[0];
							$hourlyReviewForm->reviewform_name = $form_info[2];
							$hourlyReviewForm->review_cycle = $hourly['Review Cycle'];
							$hourlyReviewForm->last_review_date = $hourly['Last Review Date'];
							$hourlyReviewForm->current_rate = $hourly['Current Rate'];
							$hourlyReviewForm->hourly_cycle_id = $preload['id'];
							$hourlyReviewForm->property_id = session('property');
							$hourlyReviewForm->property_name = $propertyInfo["name"];
							$hourlyReviewForm->hire_date = $hourly['Date of Hire'];
							$hourlyReviewForm->position_date = $hourly['Date of Current Position'];
							$hourlyReviewForm->seniority_date = $hourly['Seniorty Date'];
							$hourlyReviewForm->status = 0;
							$hourlyReviewForm->cid = $this->G->user->id;
							$hourlyReviewForm->save();
													
						}
					
						$model->setAll($preload);
						$model->id = $preload['id'];
						$model->status = 1;
						$model->cid = $this->G->user->id;
						$model->property_id = session('property');
						$model->hourly_data = json_encode($hourlies_updated);
						$model->save();						
						flash('The Hourly Review Cycle has been launched!', 'success');
					}

					
					locate(URL.$this->G->url->parentUrl(3));
					
				} else {
					$user = get_model('user');
					$review_form = get_model('compiledform');
					$userData = array_reverse($user->getAllUsers(session('property')));
					$managers = array();
					foreach ($userData as $uId => $manager) {
						//if ($manager['role_level'] == DEPARTMENT_MANAGER) {
							$managers[] = $manager;
						//}
					}
					$review_forms = $review_form->compiledforms();
					
					
					//print_r($hourlyForms);exit;

					tpl_set('hourlies', $hourlies);
					tpl_set('hourly_forms', $hourlyForms);
					tpl_set('managers', $managers);
					tpl_set('review_forms', $review_forms);
					
				}	
				break;
		}
		parent::display();
	}

	public function config_view($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_view';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_view($params) {
		$reviewId = $params[0];
		
		$model = get_model('hourlyreviewcycle');
		$preload = $model->getOne($reviewId, 'id');

		$hourlies = json_decode($preload['hourly_data'], true);
		$hourlyFormModel = get_model('hourlyreviewform');
		$hourlyForms = $hourlyFormModel->getFormsofHourlyCycle($preload['id']);

		$user = get_model('user');
		$review_form = get_model('compiledform');
		$userData = array_reverse($user->getAllUsers(session('property')));
		$managers = array();
		foreach ($userData as $uId => $manager) {
			if ($manager['role_level'] == DEPARTMENT_MANAGER) {
				$managers[] = $manager;
			}
		}
		$review_forms = $review_form->compiledforms();
		
		
		//print_r($hourlyForms);exit;

		tpl_set('hourlies', $hourlies);
		tpl_set('hourly_forms', $hourlyForms);
		tpl_set('managers', $managers);
		tpl_set('review_forms', $review_forms);

		parent::display();
	}
	
	public function config_review($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_review';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_review ($params){

		$preload = array();
		$property = array();
		$division = array();
		$department = array();
		$ratings = array();
		$matrix = array();
		$averages = array();
		$peerAnswers = array();
		$resultAvg = 0;
		$cultureAvg = 0;
		$managerClearance = null;
		$arbirtary = null;
	
	
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] >= DEPARTMENT_MANAGER)){
			$managerClearance = true;
		}
		
		//print_r($params);exit;
		
		// 
		$hourlyform = get_model('hourlyreviewform')->getOne($params[0], 'id');
		
		$sectionAnswers = array();
		if($hourlyform["answer"]) {
			$managerAnswers = json_decode($hourlyform["answer"], true);
			$sectionAnswers = $managerAnswers["sections"];
		}
		//print_r($sectionAnswers);exit;
		// COMPILED FORM
		$preload = get_model('Compiledform')->getOne($hourlyform['reviewform_id'], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($hourlyform['reviewform_id']);
		
		// CHECK USER
		$userId = session('user_filter');
		if ($userId == '' || $userId == null || $userId == 'all'){
			$userId = session('user');
		}
		
		// SUB EVALUATION
		foreach ($subevaluations as $subevaluation){
			$subevaluationModel = get_model('subevaluation');
			$loadSubEval = true;
			$donotsave = null;
			$allowOverride = null;
			$rateable = true;
			$discrete = true;
			
			// LOAD SUB EVALUATION
			if ($loadSubEval != null){
				//$preload['sections'][$subevaluation['id']] = $subevaluation;
				
				// LOAD FIELDS
				$subevaluation['fields'] = $subevaluationModel->fields($subevaluation['id']);
				foreach ($subevaluation['fields'] as $field){
					
					$subevaluation['fields'][$field['id']]['value'] = '';
					if ($rateable != null) {
						$subevaluation['fields'][$field['id']]['rateable'] = true;
					}
					
					if(array_key_exists($subevaluation['id'], $sectionAnswers)) {
						$section_id = $subevaluation['id'];
						$field_id = $field['id'];
						$sectionAnswer = $sectionAnswers[$subevaluation['id']]['fields'];
						if(array_key_exists($field_id, $sectionAnswer)) {
							$subevaluation['fields'][$field['id']]['value'] = $sectionAnswer[$field['id']];
							$subevaluation['fields'][$field['id']]['managerAnswer'] = $sectionAnswer[$field['id']];
						}
					}
				}
				
				
				$preload['sections'][$subevaluation['id']] = $subevaluation;
			}			
			
			// MATRIX SUB EVALUATION
			if($subevaluation['name'] == 'Results/Culture Matrix') {
				//pr("THE MATRIX HAS YOU...");
				$preload['sections'][$subevaluation['id']] = $subevaluation;	
				$preload['sections'][$subevaluation['id']]['fields'] = array();
			}
		}
		//pr($preload['sections']);
		// RETRIEVE POSTED DATA AND ADD TO PRELOAD
		if ($this->G->url->getPostBit('tnngtoken') != null){
			$posted = $this->G->url->getPost();
			foreach ($preload['sections'] as $psection){
				if (array_key_exists('sections', $posted)){
					if (array_key_exists($psection['id'], $posted['sections'])){
						foreach ($psection['fields'] as $field){
							foreach($posted['sections'] as $section){
								if (array_key_exists($field['id'], $section['fields'])){
									$preload['sections'][$psection['id']]['fields'][$field['id']]['value'] = $section['fields'][$field['id']];
								}
							}
						}
					}
				}
			}
		}
		
		
		$preload['results_avg'] = $resultAvg;
		$preload['culture_avg'] = $cultureAvg;
		
		// Compile Form
		$form = $this->compile_form('review', array_merge($preload, $hourlyform));
		tpl_set('form', $form);

		parent::display();
	}	

	private function build_form_1($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Hourly Review Cycle'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Cycle Name'),
			'default' => TRUE
		));
		$form->addTextarea(array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Cycle Description')
		));
		$form->addDate(array(
			'required' => true,
			'name' => 'due',
			'class' => 'form-control',
			'label' => _('Expected Due Date')
		));

		
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_2($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Hourly Review Cycle'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$hourlies = NULL;
		if (isset($preload['hourlies'])) {
			$hourlies = $preload['hourlies'];
		}
		$form->addHidden(array(
			'name' => 'hourlies-previous',
			'value' => $hourlies
		));
		$form->addFile(array(
			'name' => 'hourlies',
			'class' => '',
			'label' => _('Upload "Hourlies" CSV'),
			'types' => array(
				'csv'
			)
		));
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}
	
	private function randomTagId(){
		return md5(rand().time().rand());
	}	

	private function compile_form($type, $preload = array()) {
		$disabled = null;
		$rating_value = null;
		$ratings_avg = null;
		$ratings = array();

		$form = new Form($this->G, array(
			'name' => 'compiledform',
			'class' => 'form compiled-form',
			'header' => array(
				'text' => sprintf(_($preload['name']), ucfirst($type)),
				'class' => 'form-subeval-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		
		$form->addHidden(array(
			'name' => 'locked'
		));
		$form->reviewFormInfo(array(
			'name' => 'Employee Info',
			'hourly_name' => $preload['hourly_name'],
			'property_id' => $preload['property_id'],
			'property_name' => $preload['property_name'],
			'review_cycle' => $preload['review_cycle'],
			'manager_name' => $preload['manager_name'],
			'hourly_position' => $preload['hourly_position'], 
			'reviewform_name' => $preload['reviewform_name'],
			'last_review_date' => $preload['last_review_date'],
			'current_rate' => $preload['current_rate'],
			'hire_date' => $preload['hire_date'],
			'position_date' => $preload['position_date'],
			'seniority_date' => $preload['seniority_date'],
			'hourly_department' => $preload['hourly_department'],
			'hourly_division' => $preload['hourly_division'],
		));
		$form->reviewFormRatingKey(array(
			'name' => 'ratingkey'
		));		
		

		if(array_key_exists('sections', $preload)){
			foreach ($preload['sections'] as $section){
				if (array_key_exists('cummulation', $section) AND $section['cummulation'] != 'none' AND $section['cummulation'] != ''){
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
				if (array_key_exists('content', $section) AND $section['content'] != 'none' AND $section['content'] != ''){
					$form->reviewFormStaticSection(array(
						'name' => $section["id"],
						'class' => '',
						'nowrapper' => true,
						'sectionName' => $section['name'],
						'sectionContent' => $section["content"]
					));
				}
				if (array_key_exists('fields', $section)  && !empty($section['fields'])){
					foreach($section['fields'] as $field){
						//pr($field, $field['id'].' ');
						$rating_avg = null;
						$rateable = null;
						$answer = null;
						$peerAnswers = null;
						$managerAnswer = null;
						$rating_value = 0;
						if (array_key_exists('value', $field)){
							$rating_value = $field['value'];
						}
						if (array_key_exists('answer', $field) && $field['answer'] != null){
							$answer = $field['answer'];
						}
						if (array_key_exists('managerAnswer', $field) && $field['managerAnswer'] != null){
							$managerAnswer = $field['managerAnswer'];
						}
						if (array_key_exists('rateable', $field)){
							$rateable = $field['rateable'];
						}
						if (array_key_exists('rating_avg', $field)){
							$rating_avg = $field['rating_avg'];
						}
						if (array_key_exists('ratings', $field)){
							$ratings = $field['ratings'];
						}
						if (array_key_exists('peerAnswers', $field)){
							$peerAnswers = $field['peerAnswers'];
						}
						//$rating = '3.3';
						//pr($rating_value, $section["id"].' ');
						$form->reviewFormSection(array(
							'name' => 'sections['.$section["id"].'][fields]['.$field["id"].']',
							'class' => '',
							'nowrapper' => true,
							'sectionName' => $field['name'],
							'sectionId' => $field['id'],
							'sectionType' => $field["type"],
							'sectionDescription' => $field['description'],
							'value' => $rating_value,
							'answer' => $answer,
							'peerAnswers' => $peerAnswers,
							'managerAnswer' => $managerAnswer,
							'rateable' => $rateable,
							'rating_avg' => $rating_avg,
							'ratings' => $ratings
						));
					}
				}
				//pr($section['name']);
				if ($section['name'] == 'Results/Culture Matrix'){
					$rating_avg = mt_rand (1*10, 5*10) / 10;
					$result_avg = mt_rand (1*10, 5*10) / 10;
					$culture_avg = mt_rand (1*10, 5*10) / 10;
					$form->matrix(array(
						'name' => $this->randomTagId(),
						'result_avg' => $preload['results_avg'],
						'culture_avg' => $preload['culture_avg'],
						'rating_avg' => $rating_avg
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
