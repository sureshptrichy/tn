<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Annual Strategic Plan controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Annualstrategicplan extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Annual Operating Plan'),
			'view' => 'annualstrategicplan',
			'main_order' => 30
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
		$items = getFiltered($this->G, 0, 0, NULL, NULL, NULL, NULL, NULL, TRUE);
		//pr($items);
		tpl_set('items', $items);
		parent::display();
	}
}
