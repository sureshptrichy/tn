<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Matrix Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings/CompiledForms/Matrix
 */

final class Controller_Settings_Compiledforms_Signature extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Signature'),
			'view' => 'settings/signature'
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
		$signId = 'SIGN' . $this->G->ids->createID();
		//$addId = $this->G->ids->addID();
		/* $model = get_model('Matrix');
		$model->status = 1;
		$model->active = 1;
		$model->id = $matrixId;
		$model->cid = $this->G->user->id; */
		/*
		$model->save();
		$addSection = get_model('Compiledform')->addSection($params[0], $model->id);
		*/
		tpl_set('signId', $signId);
		parent::display();
	}
}
