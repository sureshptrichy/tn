<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings/Subevaluations
 */

final class Controller_Settings_Subevaluations_Field extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Sub Evaluation Field'),
			'view' => 'settings/field'
		);
		$this->permission = array(
			'authenticated',
			'viewSubevaluation'
		);
		$this->showPageNav = FALSE;
		$this->componentPrefix = 'addfieldsubevalutaioncomponent'; // Repeated in /views/default/js/main.js
		$this->componentFieldPrefix = 'field';
		return parent::config($method);
	}
	
	/**
	 * The default method.
	 */
	
	public function config_addcomponent($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addSubevaluation';
	}

	public function call_addcomponent($params) {
		$subevalComponentForm = $this->build_subevalcomp_form('new');
		tpl_set('subevalComponentForm', $subevalComponentForm);
		parent::display();
	}
	
	public function config_getcomponents($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_get';
		$this->permission[] = 'editSubevaluation';
	}
	
	public function call_getcomponents($params) {
		$fields = get_model('subevaluation')->fields($params[0]);
		tpl_set('fields', $fields);
		parent::display(false);
	}
	
	public function config_editcomponent($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_edit';
		$this->permission[] = 'editSubevaluation';
	}
	
	public function call_editcomponent($params) {
		$preload = array();
		$model = get_model('subevaluation');
		$field = $model->field($params[0]);
		$preload['subevaluation_id'] = $params[0];
		$preload['fields[]'] = $params[0];
		foreach($field as $item){
			$fieldName = $item['name'];
			$preload = array_merge($item, $preload);
		}
		//print_r($preload);
		$subevalComponentForm = $this->build_subevalcomp_form('edit', array_merge(array(
			'subevaluation_id' => $params[0]
		),  $preload));
		tpl_set('fieldName', $fieldName);
		tpl_set('fieldId', $params[0]);
		tpl_set('subevalComponentForm', $subevalComponentForm);
		parent::display();
	}
	
	public function config_deletecomponent($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteSubevaluation';
	}
	
	public function call_deletecomponent($params) {
		$model = get_model('field');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->cid = $this->G->user->id;
			$model->save();
		} else {
			flash(_('This field could not be removed'), 'danger');
		}
	}
	private function build_subevalcomp_form($type, $preload = NULL) {
		//$suffix = $this->G->url->getQuerystringBit('fp');
		//$suffix = '_' . preg_replace('/[^a-z0-9-_]/i', '', $suffix);
		//if ($suffix == '') {
			$suffix = '[]';
		//}
		$fields = array();
		if (strtolower($type) == 'edit') {
			foreach($preload as $item => $val){
				if ($item == 'name' || /*$item == 'title' ||*/ $item == 'type' || $item == 'description' || $item == 'subcategory'){
					$preload['field'.$item.$suffix] = $val;
				}
			}
		}
		$form = new Form($this->G, array(
			'name' => $type . '-subevalcomp-field',
			'class' => 'form form-subevalcomp',
			'chrome' => FALSE
		), $preload);
		$form->addHidden(array(
			'name' => 'fields[]'
		));
		//pr($preload);
		
		$form->addText(array(
			'name' => $this->componentFieldPrefix.'subcategory' . $suffix,
			'class' => 'form-control',
			'label' => _('Sub Category'),
			'default' => TRUE
		));		
		$form->addText(array(
			'required' => true,
			'name' => $this->componentFieldPrefix.'name' . $suffix,
			'class' => 'form-control',
			'label' => _('Field Name'),
			'default' => TRUE
		));
/*		$form->addText(array(
			'required' => true,
			'name' => $this->componentFieldPrefix.'title' . $suffix,
			'class' => 'form-control',
			'label' => _('Title')
		));*/
		$form->addSelect(array(
			'required' => true,
			'name' => $this->componentFieldPrefix.'type' . $suffix,
			'class' => 'form-control',
			'label' => _('Field Type'),
			'values' => array(
				'' => _('Select Field Type'),
				'rating' => _('Rating'),
				'text' => _('Text')
			),
			'default' => ''
		));
		$form->addTextArea(array(
			'required' => false,
			'name' => $this->componentFieldPrefix.'description' . $suffix,
			'class' => 'form-control field-description',
			'label' => _('Description / Content')
		));
		return $form;
	}
}
