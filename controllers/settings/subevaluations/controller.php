<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Subevaluations extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Review Sections'),
			'view' => 'settings/subevaluations',
			'main_order' => 220
		);
		$this->permission = array(
			'authenticated',
			'viewSubevaluation'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		$this->evaluationTypes = array(
			'me' => array(
				'id' => 'me',
				'name' => _('Leadership Evaluations')
			),
			'ae' => array(
				'id' => 'ae',
				'name' => _('Associate Evaluations')
			)
		);
		$this->componentPrefix = 'addfieldsubevalutaioncomponent'; // Repeated in /views/default/js/main.js
		$this->componentFieldPrefix = 'field';
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('subevaluation');
		$subevaluations = $model->getAllWithFields();
		$subevaluationtypes = $this->evaluationTypes;
		foreach ($subevaluationtypes as $type => $key){
			$count = 0;
			foreach ($subevaluations as $subevaluation){
				if ($subevaluation['evaltype'] == $type){
					$count = $count+1;
					$subevaluationtypes[$type]['subevaluations'][$subevaluation['id']] = $subevaluation;
				}
			}
			$subevaluationtypes[$type]['type_count'] = $count;
		}
		tpl_set('subevaluations', $subevaluationtypes);
		parent::display();
	}

	public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addSubevaluation';
	}

	public function call_new($params) {
		$subevalForm = $this->build_subeval_form('new', array('evaltype' => $params[0]));
		if (FALSE === $subevalForm->valid()) {
			tpl_set('subevalForm', $subevalForm);
		} else {
			$subeval = $subevalForm->valid();
			$model = get_model('subevaluation');
			if (isset($subeval['active'])) {
				$subeval['active'] = 1;
			} else {
				$subeval['active'] = 0;
			}
			
			$fields = array();
			for ($i = 0; $i <= count($subeval['fieldname'])-1; $i++) {
				$fields[$i]['name'] = $subeval['fieldname'][$i];
				$fields[$i]['title'] = $subeval['fieldname'][$i];
			}
/*			for ($i = 0; $i <= count($subeval['fieldtitle'])-1; $i++) {
				$fields[$i]['title'] = $subeval['fieldtitle'][$i];
			}*/
			for ($i = 0; $i <= count($subeval['fieldtype'])-1; $i++) {
				$fields[$i]['type'] = $subeval['fieldtype'][$i];
			}
			for ($i = 0; $i <= count($subeval['fielddescription'])-1; $i++) {
				$fields[$i]['description'] = $subeval['fielddescription'][$i];
			}
			
			for ($i = 0; $i <= count($subeval['fieldsubcategory'])-1; $i++) {
				$fields[$i]['subcategory'] = $subeval['fieldsubcategory'][$i];
			}
			
			$model->setAll($subeval);
			$model->status = 1;
			//if(!isset($subeval['cummulation'][0])) $subeval['cummulation'][0] = 'none';
			$model->cummulation = $subeval['cummulation'][0];
			foreach ($subeval['assignment'] as $a => $value){
				if ($value == 'self'){
					$model->self = 1;
					$model->manager = 1;
				} else {
					$model->$value = 1;
				}
			}
			$model->cid = $this->G->user->id;
			$model->save();
			$model->removeFields($model->id);
			foreach ($fields as $field) {
				$fieldModel = get_model('field');
				$field['subevaluation_id'] = $model->id;
				$fieldModel->setAll($field);
				$fieldModel->status = 1;
				$fieldModel->active = 1;
				$fieldModel->cid = $this->G->user->id;
				$fieldModel->save();
				$model->addField($model->id, $fieldModel->id);
			}
			flash(_('The Review reviewFormSection has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editSubevaluation';
	}

	public function call_edit($params) {
		$model = get_model('subevaluation');
		$preload = $model->getOne($params[0], 'id');
		if ($preload['self'] == 1){
			$preload['assignment'] = 'self';
		} elseif ($preload['self'] != 1 && $preload['manager'] == 1){
			$preload['assignment'] = 'manager';
		} else {
			$preload['assignment'] = 'peer';
		}
		$subevalForm = $this->build_subeval_form('edit', $preload);
		if (FALSE === $subevalForm->valid()) { 
			tpl_set('subevalForm', $subevalForm);
		} else {
			$subeval = $subevalForm->valid();
			if(array_key_exists('locked', $subeval) AND $subeval['locked'] == 0){
				if (isset($subeval['active'])) {
					$subeval['active'] = 1;
				} else {
					$subeval['active'] = 0;
				}
				$fields = array();
				if (isset($subeval['fieldname'])){
					for ($i = 0; $i <= count($subeval['fieldname'])-1; $i++) {
						$fields[$i]['name'] = $subeval['fieldname'][$i];
						$fields[$i]['title'] = $subeval['fieldname'][$i];
					}
/*					for ($i = 0; $i <= count($subeval['fieldtitle'])-1; $i++) {
						$fields[$i]['title'] = $subeval['fieldtitle'][$i];
					}*/
					for ($i = 0; $i <= count($subeval['fieldtype'])-1; $i++) {
						$fields[$i]['type'] = $subeval['fieldtype'][$i];
					}
					for ($i = 0; $i <= count($subeval['fielddescription'])-1; $i++) {
						$fields[$i]['description'] = $subeval['fielddescription'][$i];
					}
					
					for ($i = 0; $i <= count($subeval['fieldsubcategory'])-1; $i++) {
						$fields[$i]['subcategory'] = $subeval['fieldsubcategory'][$i];
					}					
				}
				$model->setAll($subeval, TRUE);
				$model->status = 1;
				$model->cummulation = $subeval['cummulation'][0];
				foreach ($subeval['assignment'] as $a => $value){
					if ($value == 'self'){
						$model->self = 1;
						$model->manager = 1;
					} else {
						$model->$value = 1;
					}
				}
				$model->cid = $this->G->user->id;
				$model->save();
				$model->removeFields($model->id);
				foreach ($fields as $field) {
					$fieldModel = get_model('field');
					$field['subevaluation_id'] = $model->id;
					$fieldModel->setAll($field, TRUE);
					$fieldModel->status = 1;
					$fieldModel->active = 1;
					$fieldModel->cid = $this->G->user->id;
					$fieldModel->save();
					$model->addField($model->id, $fieldModel->id);
				}
				flash(_('The review section has been saved.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			} else {
				flash(_('This review section has been locked. No further changes can be made.'), 'danger');
				locate($this->G->url);
			}
		}
		parent::display();
	}

	public function config_preview($params = NULL) {
		$this->route['view'] = $this->route['view'].'_preview';
		$this->permission[] = 'editSubevaluation';
	}
	
	public function call_preview($params) {
		$sections = array();
		$model = get_model('subevaluation');
		$preload = $model->getOne( $params[0], 'id');
		$fields = $model->fields($params[0]);
		$preload['fields'] = $fields;
		foreach ($preload['fields'] as $field){
			$preload['fields'][$field['id']]['value'] = '';
		}
		$form = $this->compile_form('Subevaluation', $preload);
		tpl_set('form', $form);
		parent::display();
	}
	
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteSubevaluation';
	}
	
	public function call_delete($params) {
		$model = get_model('subevaluation');
		if (isset($params[0]) && $params[0] != '') {
			//$model->removeFields($params[0]);
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('This evaluation has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}	

	private function build_subeval_form($type, $preload = array()) {
		$suffix = '[]';
		$disabled = null;
		if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$disabled = true;
		}
		$form = new Form($this->G, array(
			'name' => $type . '-subeval',
			'class' => 'form form-subeval',
			'header' => array(
				'text' => sprintf(_('%1$s Review Section'), ucfirst($type)),
				'class' => 'form-subeval-heading'
			),
			'disabled' => $disabled
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
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
		}
		$form->addHidden(array(
			'name' => 'evaltype'
		));
		$form->addText(array(
			'name' => 'name',
			'required' => true,
			'class' => 'form-control',
			'label' => _('Evaluation Name'),
			'default' => TRUE
		));
		$form->addTextArea(array(
			'name' => 'description',
			'required' => true,
			'class' => 'form-control evaluation-description',
			'label' => _('Description')
		));
		/*
		$form->addCheckbox(array(
			'name' => 'assignment',
			'value' => array(
				'self' => _('Self'),
				'manager' => _('Manager'),
				'peer' => _('Peer')
			),
			'class' => 'checkbox',
			'label' => _('Assignment')
		));
		*/
		$assignments = array();
		if ($preload['evaltype'] == 'ae'){
			$assignments = array(
				'manager' => _('Manager')
			);
		} else {
			$assignments = array(
				'self' => _('Self/Manager'),
				'manager' => _('Manager'),
				'peer' => _('Peer')
			);
		}
		$form->addRadio(array(
			'required' => true,
			'name' => 'assignment',
			'value' => $assignments,
			'default' => 'peer',
			'class' => 'radio',
			'label' => _('Cummulation')
		));
		$form->addRadio(array(
			'required' => true,
			'name' => 'cummulation',
			'value' => array(
				'results' => _('Results'),
				'culture' => _('Culture'),
				'none' => _('None')
			),
			'default' => 'none',
			'class' => 'radio',
			'label' => _('Cummulation')
		));
		$form->addButton(array(
			'name' => 'addcomponent',
			'class' => 'btn-info addcomponent',
			'label' => _('Add Field')
		));
		$name = 'create';
		$label = _('Create');
		if (strtolower($type) == 'edit') {
			$name = 'update';
			$label = _('Update');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-primary',
			'label' => $label
		));
		return $form;
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
				'class' => 'form-subeval-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		
		$form->addHidden(array(
			'name' => 'locked'
		));
		if(array_key_exists('fields', $preload)){

		foreach($preload['fields'] as $field){
			if (!empty($field)){
				$answer = rand(1,5);
				$rating = mt_rand (1*10, 5*10) / 10;
				//$rating = '3.3';
				$ratings = array (
					$field['id'] => array(
						'field_id' => $field['id'],
						'user_by_id' => '123',
						'answer' => $answer,
						'user_name' => 'John'					
					),
					$field['id'] => array(
						'field_id' => $field['id'],
						'user_by_id' => '123',
						'answer' => $answer,
						'user_name' => 'Matthew'					
					),
					$field['id'] => array(
						'field_id' => $field['id'],
						'user_by_id' => '123',
						'answer' => $answer,
						'user_name' => 'Paul'					
					),
					$field['id'] => array(
						'field_id' => $field['id'],
						'user_by_id' => '123',
						'answer' => $answer,
						'user_name' => 'Peter'					
					),
					$field['id'] => array(
						'field_id' => $field['id'],
						'user_by_id' => '123',
						'answer' => $answer,
						'user_name' => 'Issac'					
					)
				);
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
					'rateable' => 'rateable',
					'ratings' => $ratings
				));
			}
		}
		/*
			foreach($preload['fields'] as $field){
				$rating = mt_rand (1*10, 5*10) / 10;
				$form->reviewFormSection(array(
					'name' => $field["id"],
					'class' => '',
					'nowrapper' => true,
					'sectionName' => $field['name'],
					'sectionType' => $field["type"],
					'sectionId' => $field["id"],
					'sectionDescription' => $field['description'],
					'value' => $field['value']
				));
			}
		*/
		}
		
		$form->addSubmit(array(
			'name' => 'save',
			'class' => 'btn-primary',
			'label' => 'Save Form'
		));
		return $form;
	}
}
