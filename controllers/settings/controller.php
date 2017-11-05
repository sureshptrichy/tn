<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Primary Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Settings'),
			'view' => 'settings',
			'main_order' => 100
		);
		$this->permission = array(
			'authenticated'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		parent::display();
	}

	public function config_togglenav($params = NULL) {
		$this->route['view'] = $this->route['view'];
	}

	public function call_togglenav($url) {
		if (session('togglenav') && session('togglenav') == 'Show Navigation'){
			session('togglenav', 'Hide Navigation');
			//echo 'Hide Nav';
		} elseif(session('togglenav') && session('togglenav') == 'Hide Navigation') {
			session('togglenav', 'Show Navigation');
			//echo 'Show Nav';
		} elseif(!session('togglenav')) {
			session('togglenav', 'Show Navigation');
			//echo 'Toggle = '.session('togglenav');
		}
	}
}
