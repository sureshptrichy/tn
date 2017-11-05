<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Logout controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Logout extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Logout'),
			'view' => 'logout',
			'sidebar_order' => 100
		);
		$this->permission = array(
			'authenticated'
		);
		if (session('reviewcycle')) {
			$this->permission = array(
				'peerReview'
			);
		}
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = FALSE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		session_del('property');
		session_del('division');
		session_del('department');
		session_del('user_filter');
		session_del('user');
		session_del('reviewcycle');
		bake('rememberme', '', (time()-86400));
		session_destroy();
		locate(URL);
	}
	
	public function call_close($params = NULL) {
		
		session_del('property');
		session_del('division');
		session_del('department');
		session_del('user_filter');
		session_del('user');
		session_del('reviewcycle');
		@session_destroy();
		locate(URL);
	}	
}
