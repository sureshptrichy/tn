<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Division controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Division extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Division'),
			'view' => 'division'
		);
		$this->permission = array(
			'authenticated',
			'viewDivision'
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
			session('division', $ids[0]);
			if ($ids[0] == 'all') {
				session('department', 'all');
			}
			if ($this->G->user->acl->role['level'] == PROPERTY_MANAGER) {
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
