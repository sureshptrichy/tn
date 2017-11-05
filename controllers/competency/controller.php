<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Competency extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Competency'),
			'view' => 'competency'
		);
		$this->permission = array(
			'authenticated',
			'viewCompetency'
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

	public function config_hide($params = NULL) {
		$this->route['view'] = $this->route['view'].'_hide';
		$this->permission[] = 'hideCompetency';
	}

	public function call_hide($params) {
		if (isset($params[0]) && $params[0] != '') {
			$sql = 'INSERT INTO `#__Property_Exclusions` (`property_id`, `exclusion_id`) VALUES (?, ?)';
			$args = array(session('property'), $params[0]);
			$this->G->db->executeQuery($sql, $args);
		}
		locate($this->G->url->getQuerystringBit('rf'));
	}

	public function config_unhide($params = NULL) {
		$this->route['view'] = $this->route['view'].'_hide';
		$this->permission[] = 'hideCompetency';
	}

	public function call_unhide($params) {
		if (isset($params[0]) && $params[0] != '') {
			$sql = 'DELETE FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` = ?';
			$args = array(session('property'), $params[0]);
			$this->G->db->executeQuery($sql, $args);
		}
		locate($this->G->url->getQuerystringBit('rf'));
	}
}
