<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Month controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Month extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Month'),
			'view' => 'month'
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
		echo "$url";
		die();
	}

	public function call_switch($ids) {
		if (count($ids) > 0) {
			session('month', $ids[0]);
		}
		if (NULL != $this->G->url->getQuerystringBit('rf')) {
			locate($this->G->url->getQuerystringBit('rf'));
		} else {
			locate(URL);
		}
	}
}
