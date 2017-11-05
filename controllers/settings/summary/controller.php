<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Summary extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('True North Summary'),
			'view' => 'settings/summary',
			'main_order' =>61
			
		);
		$this->permission = array(
			'authenticated',
			'viewSummary'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('summary');
		tpl_set('summary', $model->getSummary(session('property'), user_is('Super User')));
		parent::display();
	}

}
