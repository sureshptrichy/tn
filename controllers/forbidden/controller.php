<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Forbidden controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Forbidden extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Forbidden'),
			'view' => 'forbidden'
		);
		$this->permission = array(
			'authenticated'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = FALSE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		parent::display();
	}
}
