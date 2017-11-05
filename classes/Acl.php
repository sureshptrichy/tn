<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * ACL class.
 *
 * @package    truenorthng
 * @subpackage ACL
 */

class Acl extends Object {
	//private $data = array();
	private $model;
	//private $G;

	public function __construct(G $G, $userRole) {
		$this->G = $G;
		$this->model = get_model('acl');
		//$this->data['role'] = $userRole;
		$this->data['role'] = $this->model->loadRole($userRole);                
                $this->data['acl'] = $this->model->loadAcl($this->data['role']['name']);
	}

	/**
	 * Checks if object instance has a specific permission (or array of permissions).
	 *
	 * @param $level
	 *
	 * @return bool
	 */
	public function has($level, $userId = NULL) {
		$return = FALSE;
		if (!is_array($level)) {
			$level = array($level);
		}
		if (empty($userId)) {
			$found = 0;
			foreach ($level as $perm) {
				if (in_array($perm, $this->data['acl'])) {
					$found++;
				}
			}
			if ($found == count($level)) {
				$return = TRUE;
			}
		} else {
			$user = get_model('user')->loadUser($userId);
			return $user['acl']->has($level);
		}

		return $return;
	}

	public function is($role, $userId = NULL) {
		if (!is_array($role)) {
			$role = array($role);
		}
		if (empty($userId)) {
			foreach ($role as $roleName) {
				if (is_int($roleName)) {
					if ($roleName == $this->data['role']['level']) {
						return TRUE;
					}
				} else {
					if (strtolower($roleName) == strtolower($this->data['role']['name'])) {
						return TRUE;
					}
				}
			}
			return FALSE;
		} else {
			$user = get_model('user')->loadUser($userId);
			return $user['acl']->is($role);
		}
	}
}
