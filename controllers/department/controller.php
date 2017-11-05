<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Division controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Department extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Department'),
			'view' => 'department'
		);
		$this->permission = array(
			'authenticated',
			'viewDepartment'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = FALSE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		echo "$url";
		die();
	}

	public function call_switch($ids) {
		if (count($ids) > 0) {
			session('department', $ids[0]);
			if ($this->G->user->acl->role['level'] == DIVISION_DIRECTOR) {
				session('year', date('Y', time()));
				session('month', 0);
			}
		}
		if (NULL != $this->G->url->getQuerystringBit('rf')) {
			locate($this->G->url->getQuerystringBit('rf'));
		} else {
			locate(URL);
		}
	}
}
