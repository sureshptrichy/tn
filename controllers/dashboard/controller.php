<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Default front-end controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Dashboard extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Dashboard'),
			'view' => 'dashboard'
			//'main_order' => 0
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
		/*
		$competencyModel = get_model('competency');
		$strategyModel = get_model('strategy');
		$tacticModel = get_model('tactic');
		$attachmentModel = get_model('attachment');
		$competencies = array();
		$objectives = array();
		$strategies = array();
		$tactics = array();
		$attachments = array();
		$ids = array();
		if (user_has('viewCompetency')) {
			$competencyList = $competencyModel->getCompetencies(session('property'), FALSE, FALSE);
			foreach ($competencyList as $id => $competency) {
				if (!isset($competency['hidden']) || !$competency['hidden']) {
					$competencies[$id] = $competency;
					$ids[] = $id;
					if (user_has('viewStrategy')) {
						$strategies[$id] = $strategyModel->getStrategies($id, session('property'), $id);
						foreach ($strategies[$id] as $sid => $strategy) {
							$ids[] = $sid;
							if (user_has('viewTactic')) {
								$tactics[$sid] = $tacticModel->getTactics($sid);
								foreach ($tactics[$sid] as $tid => $tactic) {
									$ids[] = $tid;
								}
							}
						}
					}
				}
			}
		}
		if (user_has('viewAttachment')) {
			$attachmentList = $attachmentModel->getAttachments($ids);
			foreach ($attachmentList as $attachment) {
				if (!isset($attachments[$attachment['parent_id']])) {
					$attachments[$attachment['parent_id']] = array();
				}
				$attachments[$attachment['parent_id']] = array_merge($attachments[$attachment['parent_id']], array($attachment['id'] => $attachment));
			}
		}
		//echo "<pre>".print_r($attachments, TRUE)."</pre>";
		tpl_set('competencies', $competencies);
		tpl_set('strategies', $strategies);
		tpl_set('tactics', $tactics);
		tpl_set('attachments', $attachments);

		$userlist = get_model('user')->getValidUsers(session('user'));
		$users = array();
		foreach ($userlist as $user) {
			$user_object = get_model('user');
			$user_object->loadUser($user['id']);
			$users[$user['id']] = $user_object;
		}
		tpl_set('users', $users);
		parent::display();
		*/
	}
}
