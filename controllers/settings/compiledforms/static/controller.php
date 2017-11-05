<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings/CompiledForms/StaticContent
 */

final class Controller_Settings_Compiledforms_Static extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Static Content'),
			'view' => 'settings/static'
		);
		$this->permission = array(
			'authenticated',
			'viewSubevaluation'
		);
		$this->showPageNav = FALSE;
		return parent::config($method);
	}
	
	/**
	 * The default method.
	 */
	
	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'editCompiledform';
	}

	public function call_add($params) {
		$js = null;
		$preload = array();
		$staticForm = $this->build_static_form('new', $preload);
		if (FALSE === $staticForm->valid()) {
			tpl_set('staticForm', $staticForm);
		} else {
			$staticForm = $staticForm->valid();
			if(array_key_exists('locked', $staticForm) AND $staticForm['locked'] == 0){
				$name = $staticForm['name'];
				if (isset($staticForm['active'])) {
					$staticForm['active'] = 1;
				} else {
					$staticForm['active'] = 0;
				}
				$model = get_model('Static');
				$model->setAll($staticForm);
				$model->status = 1;
				$model->cid = $this->G->user->id;
				$model->save();
				$addSection = get_model('Compiledform')->addSection($params[0], $model->id);
				tpl_set('id', $model->id);
				tpl_set('name', $name);
			} else {
				tpl_set('locked', 'locked');
				flash(_('Sorry but this static content has been locked. No further changes can be made.'), 'danger');
				locate($this->G->url);
			}
		}
		parent::display();
	}

	
	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_edit';
		$this->permission[] = 'editCompiledform';
	}

	public function call_edit($params) {
		$preload = get_model('Compiledform')->staticsection($params[0]);
		$staticForm = $this->build_static_form('edit', array_merge($preload));
		if (FALSE === $staticForm->valid()) {
			tpl_set('staticForm', $staticForm);
		} else {
			$staticForm = $staticForm->valid();
			if(array_key_exists('locked', $staticForm) AND $staticForm['locked'] == 0){
				$name = $staticForm['name'];
				if (isset($staticForm['active'])) {
					$staticForm['active'] = 1;
				} else {
					$staticForm['active'] = 0;
				}
				$model = get_model('Static');
				$model->setAll($staticForm, TRUE);
				$model->status = 1;
				$model->cid = $this->G->user->id;
				$model->save();
				tpl_set('id', $model->id);
				tpl_set('name', $name);
			} else {
				tpl_set('locked', 'locked');
				flash(_('This review has been locked. No further changes can be made.'), 'danger');
			}
		}
		parent::display();
	}
	

	private function build_static_form($type, $preload = NULL) {
		$disabled = null;
		if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$disabled = true;
		}
		$form = new Form($this->G, array(
			'name' => $type . '-subeval',
			'class' => 'form static-form',
			'disabled' => $disabled
		), $preload);
		if (strtolower($type) == 'edit') {
			$form->addHidden(array(
				'name' => 'id'
			));
			$static_type = 'edit';
		} else {
			$static_type = 'add';
		}
		$form->addHiddenArray(array(
			'name' => 'static-type',
			'values' => array(
				'edit' => $static_type
			) 
		));
		
		$form->addHidden(array(
			'name' => 'locked'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Section Name'),
			'default' => TRUE
		));
		$form->addTextArea(array(
			'required' => true,
			'name' => 'content',
			'class' => 'form-control content',
			'label' => _('Content')
		));
		$form->addSubmit(array(
			'name' => 'save',
			'class' => 'btn-primary',
			'label' => 'Save Static Content'
		));
		return $form;
	}
}
