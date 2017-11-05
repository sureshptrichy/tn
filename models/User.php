<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * User model.
 *
 * @package    truenorthng
 * @subpackage User
 */

final class Model_User extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'loggedin' => FALSE,
			'role' => $this->G->defaultRole,
			'role_id' => NULL,
			'role_level' => NULL,
			'property' => NULL,
			'division' => NULL,
			'department' => NULL,
			'supervisor' => NULL, 
			'acl' => NULL,
			'id' => 0,
			'username' => NULL,
			'password' => NULL,
			'key' => NULL,
			'firstname' => NULL,
			'lastname' => NULL,
			'created' => NULL,
			'status' => NULL,
			'last' => NULL,
			'remember' => NULL,
			'passwordreset' => NULL,
			'competencies' => NULL,
			'cid' => NULL
		);

		$this->data['acl'] = $this->G->getObject('acl', FALSE, $this->data['role']);
	}

	public function login($user, $pass, $remember = FALSE) {
		$return = FALSE;
		$result = $this->getOne(array($user, 1), array('username', 'status'));
		//echo "<pre>USER LOOKUP: ".print_r($result, TRUE)."</pre>";
		if (count($result) > 0) {
			if (Crypt::checkHashedString($pass, $result['password'])) {
				// Login matched!
				$return = TRUE;
				if ($remember) {
					$remember = $this->G->ids->createID(32, FALSE) . ':' . $result['id'];
					//session('remember', $remember);
					bake('rememberme', $remember, (time() + 60 * 60 * 24 * 30));
				}
				$this->loadUser($result['id']);
				if ($this->loggedin) {
					session('user', $result['id']);
				}
				if ($remember) {
					$this->remember = $remember;
					$this->save();
				}
			}
		}
		return $return;
	}

	public function loadUser($id, $token = NULL, $stopHere = null) {
		$associates = null;
		$reviewId = null;
		$user = null;
		$userType = null;
		$uType = $this->G->ids->type($id);
		$items = explode("_", $uType);
		$uType = array_reverse($items);
		$userType = $uType[0];
		if($userType == 'associates'){
			$associates = $uType[1].'_'.$uType[0];
			$reviewId = $uType[1];
		}
		if($userType == 'emails'){
			$reviewId = $uType[1];
			$emails = $uType[1].'_'.$uType[0];
		}
		if (session('reviewcycle')) {
			$reviewId = session('reviewcycle');
		}
		if ($userType == 'User' || $userType == null){
			$sql = 'SELECT `#__User`.*, `#__User_Role`.`role_id`, `roles`.`name` as `role_name`, `roles`.`level` as `role_level` FROM `#__User`, `#__User_Role` INNER JOIN (SELECT * FROM `#__Acl_Roles`) AS `roles` ON `roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__User`.`id` = ?';
			$params = $id;
			if ($token) {
				$sql .= ' AND `#__User`.`remember` = ?';
				$params = array($id, $token);
			}
			$sql .= ' AND `#__User`.`id` = `#__User_Role`.`user_id`';
		} elseif ($userType == 'associates'){
			$sql = 'SHOW TABLES FROM '.$this->dbname.' LIKE "tnng_RC_'.$associates.'"';
			$result = $this->execute($sql);
			if (!empty($result)){
				$tableName = '`#__RC_' . $associates.'`';
				$sql = "SELECT $tableName.*, `#__Acl_Roles`.`id` as `role_id`, `#__Acl_Roles`.`name` as `role_name`, `#__Acl_Roles`.`level` as `role_level` FROM $tableName, `#__Acl_Roles` WHERE $tableName.`id` = ? AND `#__Acl_Roles`.`level` = " . REVIEWER;
				$params = $id;
			}
		} else {
			$sql = 'SHOW TABLES FROM '.$this->dbname.' LIKE "tnng_RC_'.$emails.'"';
			$result = $this->execute($sql);
				$tableName = '`#__RC_' . $reviewId . '_emails`';
				$sql = "SELECT $tableName.*, `#__Acl_Roles`.`id` as `role_id`, `#__Acl_Roles`.`name` as `role_name`, `#__Acl_Roles`.`level` as `role_level` FROM $tableName, `#__Acl_Roles` WHERE $tableName.`id` = ? AND `#__Acl_Roles`.`level` = " . REVIEWER;
				$params = $id;
			
		}
		$result = $this->execute($sql, $params);
		//pr($result, 'USER '.$id.': ');

		if (count($result) == 1) {
			$user = $result[0]; // Convenience only.
			if (null !== $reviewId) {
				if (!array_key_exists('username', $user)){
					if (array_key_exists('name', $user)){
						$user['username'] = $user['name'];
					} else {
						$user['username'] = $user['email'];
					}
				} else {
					if (array_key_exists('role_id', $user)){
						$user['firstname'] = $user['firstname'];
						$user['lastname'] = $user['lastname'];
						$user['status'] = 1;
					} else {
						$user['firstname'] = 'Peer';
						$user['lastname'] = 'Reviewer';
						$user['status'] = 1;
					}
				}
			}
			if ($associates != null){
				$user['username'] = $user['name'];
				$user['firstname'] = $user['name'];
				$user['lastname'] = '';
				$user['status'] = 1;
			}

			foreach ($user as $key => $value) {
				if (array_key_exists($key, $this->data)) {
					$this->data[$key] = $value;
				}
			}

			$this->loggedin = TRUE;
			$this->role = $user['role_name'];
			$this->property = $this->getProperty();
			$this->division = $this->getDivision();
			$this->department = $this->getDepartment();
			$this->acl = $this->G->getObject('acl', FALSE, $this->role);

			return $this->data;
		}
	}

	public function OLD_loadUser($id, $token = NULL, $reviewId = null, $userType = null) {
		if ($reviewId != null){
			if (session('reviewcycle')) {
				$reviewId = session('reviewcycle');
			}
		}
		if (null === $reviewId) {
			$sql = 'SELECT `#__User`.*, `#__User_Role`.`role_id`, `roles`.`name` as `role_name`, `roles`.`level` as `role_level` FROM `#__User`, `#__User_Role` INNER JOIN (SELECT * FROM `#__Acl_Roles`) AS `roles` ON `roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__User`.`id` = ?';
			$params = $id;
			if ($token) {
				$sql .= ' AND `#__User`.`remember` = ?';
				$params = array($id, $token);
			}
			$sql .= ' AND `#__User`.`id` = `#__User_Role`.`user_id`';
		} elseif ($userType != null){
			pr("WHAAAAT");
			
		} else {
			$sql = 'SHOW TABLES FROM '.$this->dbname.' LIKE "tnng_RC_'.$reviewId.'_emails"';
			$result = $this->execute($sql);
			if (!empty($result)){
				$tableName = '`#__RC_' . $reviewId . '_emails`';
				$sql = "SELECT $tableName.*, `#__Acl_Roles`.`id` as `role_id`, `#__Acl_Roles`.`name` as `role_name`, `#__Acl_Roles`.`level` as `role_level` FROM $tableName, `#__Acl_Roles` WHERE $tableName.`id` = ? AND `#__Acl_Roles`.`level` = " . REVIEWER;
				$params = $id;
			}
		}
		$result = $this->execute($sql, $params);
		//pr($result, 'USER '.$id.': ');

		if (count($result) == 1) {
			$user = $result[0]; // Convenience only.
			if (null !== $reviewId) {
				$user['username'] = $user['email'];
				$user['firstname'] = 'Peer';
				$user['lastname'] = 'Reviewer';
				$user['status'] = 1;
			}

			foreach ($user as $key => $value) {
				if (array_key_exists($key, $this->data)) {
					$this->data[$key] = $value;
				}
			}

			$this->loggedin = TRUE;
			$this->role = $user['role_name'];
			$this->property = $this->getProperty();
			$this->division = $this->getDivision();
			$this->department = $this->getDepartment();
			$this->acl = $this->G->getObject('acl', FALSE, $this->role);

			return $this->data;
		}
	}

	public function findRememberedUser() {
		//echo "<pre>COOKIES: ".print_r($_COOKIE, TRUE).'</pre>';
		if (session('user')) {
			//echo "REMEMBERED SESSION!<br>";die();
			if (session('reviewcycle')) {
				$this->loadUser(session('user'), null);
			}
			$this->loadUser(session('user'));
		} elseif (!$this->loggedin && cookie('rememberme')) {
			//echo "REMEMBERED TOKEN!<br>";
			$rememberme = cookie('rememberme');
			$id = substr($rememberme, strrpos($rememberme, ':') + 1);
			$token = $rememberme;
			$this->loadUser($id, $token);
			if ($this->loggedin) {
				session('user', $id);
			}
		}
	}

	/**
	 * If the user is assigned to a specific property, return it; otherwise NULL.
	 */
	private function getProperty() {
		$return = NULL;
		if (session('reviewcycle') && session('property')) {
			$sql = 'SELECT `#__Property`.* FROM `#__Property` WHERE `#__Property`.`id` = ?';
			$result = $this->execute($sql, session('property'));
		} else {
			$sql = 'SELECT `#__Property`.* FROM `#__Property` LEFT JOIN `#__Property_User` ON `#__Property_User`.`property_id` = `#__Property`.`id` WHERE `#__Property_User`.`user_id` = ?';
			$result = $this->execute($sql, $this->id);
		}

		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}

	/**
	 * If the user is assigned to a specific property, return it; otherwise NULL.
	 */
	private function getDivision() {
		$return = NULL;
		$sql = 'SELECT `#__Division`.* FROM `#__Division` LEFT JOIN `#__Division_User` ON `#__Division_User`.`division_id` = `#__Division`.`id` WHERE `#__Division_User`.`user_id` = ?';
		$result = $this->execute($sql, $this->id);

		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}

	/**
	 * If the user is assigned to a specific property, return it; otherwise NULL.
	 */
	private function getDepartment() {
		$return = NULL;
		$sql = 'SELECT `#__Department`.* FROM `#__Department` LEFT JOIN `#__Department_User` ON `#__Department_User`.`department_id` = `#__Department`.`id` WHERE `#__Department_User`.`user_id` = ?';
		$result = $this->execute($sql, $this->id);

		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}

	public function getProperties() {
		$return = array();
		if ($this->loggedin) {
			$sql = 'SELECT `#__Property`.* FROM `#__Property`, `#__Property_User` WHERE `#__Property`.`status` = 1 AND `#__Property`.`id` = `#__Property_User`.`property_id` AND `#__Property_User`.`user_id` = ? ORDER BY `#__Property`.`name`';
			$result = $this->execute($sql, $this->id);
			if (count($result) > 0) {
				// This is a normal user.
				$return = $result;
			} else {
				// This might be a super user, or it might be a problem.
				if (user_is(SUPER_USER)) {
					$propertyModel = get_model('property');
					$properties = $propertyModel->getAll(1, 'name');
					if (count($properties) > 0) {
						$return = $properties;
					}
				}
			}
		}
		return $return;
	}

	public function getDivisions() {
		$return = array();
		if ($this->loggedin) {
			$propertyModel = get_model('property');
			$valid = $propertyModel->getDivisions();
			$sql = 'SELECT `#__Division`.* FROM `#__Division` LEFT JOIN `#__Division_User` ON `#__Division_User`.`division_id` = `#__Division`.`id` WHERE `#__Division`.`status` = 1 AND `#__Division_User`.`user_id` = ? AND `#__Division`.`id` IN ("' . implode('","', array_keys($valid)) . '") ORDER BY `#__Division`.`name`';
			$result = $this->execute($sql, $this->id);
			if (count($result) > 0) {
				// This is a normal user.
				$return = $result;
			} else {
				// This might be a super user, or it might be a problem.
				if (!user_is(ASSOCIATE)) {
					$return = $valid;
				}
				// TODO: THROW EXCEPTION IF
			}
		}
		return $return;
	}

	public function getDepartments() {
		$return = array();
		if ($this->loggedin) {
			$divisionModel = get_model('division');
			$valid = $divisionModel->getDepartments();
			if (count($valid) > 0) {
				$sql = 'SELECT `#__Department`.*, `#__Division_Department`.`division_id` FROM `#__Department` LEFT JOIN `#__Department_User` ON `#__Department_User`.`department_id` = `#__Department`.`id` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id` WHERE `#__Department`.`status` = 1 AND `#__Department_User`.`user_id` = ? AND `#__Department`.`id` IN ("' . implode('","', array_keys($valid)) . '") ORDER BY `#__Department`.`name`';
			} else {
				$sql = 'SELECT `#__Department`.*, `#__Division_Department`.`division_id` FROM `#__Department` LEFT JOIN `#__Department_User` ON `#__Department_User`.`department_id` = `#__Department`.`id` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id` WHERE `#__Department`.`status` = 1 AND `#__Department_User`.`user_id` = ? ORDER BY `#__Department`.`name`';
			}
			$result = $this->execute($sql, $this->id);
			if (count($result) > 0) {
				// This is a normal user.
				$return = $result;
			} else {
				// This might be a super user, or it might be a problem.
				if (user_is(SUPER_USER) || user_is(PROPERTY_MANAGER)) {
					$return = $valid;
				}
				// TODO: THROW EXCEPTION IF
			}
		}
		return $return;
	}

	public function getDivisionsNav($propertyId = 0) {
		$return = array();
		$sql = NULL;
		$params = array();
		$sql = 'SELECT `#__Division`.* FROM `#__Division` WHERE `#__Division`.`status` = 1 ORDER BY `#__Division`.`name`';
		$this->G->db->executeQuery($sql);
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				//$return[$result['id']] = $result;
			}
		}

		// Get all default divisions.
		$sql = 'SELECT `#__Division`.* FROM `#__Division` WHERE `default` = 1 AND `status` = 1';
		$this->G->db->executeQuery($sql);
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$return[$result['id']] = $result;
				$return[$result['id']]['property_name'] = 'Default';
			}
		}
		$default = array_keys($return);
		array_walk($default, function (&$item, $key) {
			$item = "'$item'";
		});
		// Get property-specific divisions.
		$sql = 'SELECT `#__Division`.*, `#__Property`.`name` AS `property_name` FROM `#__Division`, `#__Property`, `#__Property_Division` WHERE ((`#__Division`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ?) OR (`#__Division`.`default` = 1 AND `#__Division`.`status` = 1)) AND `#__Property_Division`.`property_id` = `#__Property`.`id` AND `#__Division`.`id` = `#__Property_Division`.`division_id` GROUP BY `#__Division`.`name` ORDER BY `property_name`, `#__Division`.`name`';
		$this->G->db->executeQuery($sql, $propertyId);
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$return[$result['id']] = $result;
			}
		}

		if (count($default) > 0) {
			// Remove excluded divisions.
			$sql = 'SELECT `#__Property_Exclusions`.* FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` IN (' . implode(',', $default) . ')';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					if (isset($return[$result['exclusion_id']])) {
						unset($return[$result['exclusion_id']]);
					}
				}
			}
		}
		uasort($return, function ($a, $b) {
			return strcmp(trim($a['name']), trim($b['name']));
		});
		return $return;
	}
	
	public function getDepartmentsNav($divisionId = 0, $propertyId = 0) {
		$return = array();
		$rawList = array();

		// First get all the Default Departments
		$sql = 'SELECT `#__Department`.*, `#__Division`.`name` AS `division_name`, `#__Division`.`id` AS `division_id` FROM `#__Department`, `#__Division`, `#__Division_Department` WHERE `#__Department`.`status` = 1 AND `#__Department`.`default` = 1 AND `#__Division`.`status` = 1 AND `#__Division_Department`.`division_id` = `#__Division`.`id` AND `#__Department`.`id` = `#__Division_Department`.`department_id` GROUP BY `#__Department`.`name` ORDER BY `division_name`, `#__Department`.`name`';
		$result = $this->execute($sql);
		foreach ($result as $department) {
			$rawList[$department['id']] = $department;
		}

		// Next the Departments that belong to the Property and Divisions.
		$divisions = $this->getDivisions($propertyId, true);
		$sql = 'SELECT `#__Department`.*, `#__Division`.`name` AS `division_name`, `#__Division`.`id` AS `division_id` FROM `#__Department` LEFT JOIN `#__Property_Department` ON `#__Property_Department`.`department_id` = `#__Department`.`id` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id`, `#__Division` WHERE `#__Property_Department`.`property_id` = ? AND `#__Division_Department`.`division_id` IN ("'.implode('", "', array_keys($divisions)).'") AND `#__Department`.`status` = 1 AND `#__Department`.`default` = 0 AND `#__Division`.`id` = `#__Division_Department`.`division_id`';
		$result = $this->execute($sql, array($propertyId));
		foreach ($result as $department) {
			$rawList[$department['id']] = $department;
		}
		foreach ($rawList as $id => $department) {
			if ($department['division_id'] == $divisionId) {
				$return[$id] = $department;
			}
		}
		// Remove excluded Departments.
		if (count($return) > 0) {
			$sql = 'SELECT `#__Property_Exclusions`.* FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` IN ("'.implode('", "', array_keys($return)).'")';
			$result = $this->execute($sql, $propertyId);
			foreach ($result as $exclude) {
				if (array_key_exists($exclude['exclusion_id'], $return)) {
					unset($return[$exclude['exclusion_id']]);
				}
			}
		}
		return $return;
	}

	public function addProperty($userId, $propertyId) {
		$this->delete($userId, 'user_id', '#__Property_User');
		$sql = "INSERT INTO `#__Property_User` (`property_id`, `user_id`) VALUES (?, ?)";
		$params = array($propertyId, $userId);
		$this->execute($sql, $params);
	}

	public function addDivision($userId, $divisionId) {
		$this->delete($userId, 'user_id', '#__Division_User');
		$sql = "INSERT INTO `#__Division_User` (`division_id`, `user_id`) VALUES (?, ?)";
		$params = array($divisionId, $userId);
		$this->execute($sql, $params);
	}

	public function addDepartment($userId, $departmentId) {
		$this->delete($userId, 'user_id', '#__Department_User');
		$sql = "INSERT INTO `#__Department_User` (`department_id`, `user_id`) VALUES (?, ?)";
		$params = array($departmentId, $userId);
		$this->execute($sql, $params);
	}
	
	public function removeFromLocations($userId) {
		$this->delete($userId, 'user_id', '#__Property_User');
		$this->delete($userId, 'user_id', '#__Division_User');
		$this->delete($userId, 'user_id', '#__Department_User');
	}

	public function addRole($userId, $roleId) {
		$this->delete($userId, 'user_id', '#__User_Role');
		$sql = "INSERT INTO `#__User_Role` (`user_id`, `role_id`) VALUES (?, ?)";
		$params = array($userId, $roleId);
		$this->execute($sql, $params);
	}

	public function addStrategy($userId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__User_Strategy');
		$sql = "INSERT INTO `#__User_Strategy` (`user_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($userId, $strategyId);
		$this->execute($sql, $params);
	}

	public function getAllUsers($propertyId = NULL) {
		$return = array();
		if (empty($propertyId)) {
			$propertyId = session('property');
		}

		// Get all Users without a Property assignment.
		$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` > '.PROPERTY_MANAGER.' ORDER BY `role_level` DESC, `#__User`.`lastname`, `#__User`.`firstname`';
		$result = $this->execute($sql);

		// Get all Property Users.
		$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` <= '.PROPERTY_MANAGER.' AND `#__Acl_Roles`.`level` > '.ANONYMOUS.' ORDER BY `role_level` DESC, `#__User`.`lastname`, `#__User`.`firstname`';
		$params = array(
			$propertyId
		);
		$result = array_merge($result, $this->execute($sql, $params));

		// Fix the array to be indexed by 'id'.
		foreach ($result as $proposedUser) {
			$return[$proposedUser['id']] = $proposedUser;
		}

		// Sort by role level then last name.
		foreach ($return as $key => $row) {
			$roleLevel[$key]  = $row['role_level'];
			$lastName[$key] = $row['lastname'];
		}
		array_multisort($roleLevel, SORT_DESC, $lastName, SORT_ASC, $return);

		return $return;
	}

	public function getManager($userId = NULL, $propertyId = NULL) {
		$return = FALSE;

		if (NULL === $userId) {
			$userId = session('user_filter');
		}
		if (NULL === $userId || $userId == 'all') {
			$userId = session('user');
		}
		if (empty($propertyId)) {
			$propertyId = session('property');
		}
		$user = get_model('user');
		$user->loadUser($userId);

		$managers = array_reverse($this->getAllUsers($propertyId));

		foreach ($managers as $uId => $manager) {
			if ($manager['role_level'] > $user->role_level && $manager['role_level'] >= DEPARTMENT_MANAGER) {
				$return = $uId;
				break;
			}
		}

		return $return;
	}

	public function getValidUsers($userId = NULL, $restrictDepth = 100, $forDisplay = FALSE, $propertyId = NULL, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $currentUserId = NULL) {
		$return = array();
		if (empty($propertyId)) {
			$propertyId = session('property');
		}
		if (empty($divisionId)) {
			$divisionId = session('division');
		}
		if (empty($departmentId)) {
			$departmentId = session('department');
		}
		if (empty($filterId)) {
			$filterId = session('user_filter');
		}
		if (empty($currentUserId)) {
			$currentUserId = session('user');
		}
		if (empty($userId)) {
			$userId = $filterId;
		}
		if (empty($userId) || $userId == 'all') {
			$userId = $currentUserId;
		}
		// Load the selected (or current) User.
		$user = get_model('user')->loadUser($userId);

		// Load the forced-login user.
		if ($forDisplay) {
			$loggedUser = $user;
		} else {
			$loggedUser = get_model('user')->loadUser($currentUserId);
		}

		if ($user) {
			// Get all Users for a Property, provided their Role level is no more than $restrictDepth levels below the $user.
			$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id`';
			if ($divisionId != 'all') {
				// Further restrict to the same Division as the $user.
				$sql .= ' LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id`';
			}
			if ($departmentId != 'all') {
				// Further restrict to the same Department as the $user.
				$sql .= ' LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id`';
			}
			$sql .= ' WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` < ?';
			$params = array(
				$propertyId,
				$user['acl']->role['level']
			);
			if ($divisionId != 'all') {
				$sql .= ' AND `#__Division_User`.`division_id` = ?';
				$params[] = $divisionId;
			}
			if ($departmentId != 'all') {
				$sql .= ' AND `#__Department_User`.`department_id` = ?';
				$params[] = $departmentId;
			}
			//echo $divisionId;
			
			if ($restrictDepth > 0) {
				// We get the Role levels from the Acl_Roles table so that we don't have to care about the actual level numbers.
				$role = $user['acl']->role['level'] - 1;
				$roleSql = 'SELECT `#__Acl_Roles`.`level` FROM `#__Acl_Roles` WHERE `#__Acl_Roles`.`status` = 1 AND `#__Acl_Roles`.`level` < ?';
				$roleSql .= ' AND `#__Acl_Roles`.`level` > '.ANONYMOUS;
				$roleSql .= ' ORDER BY `#__Acl_Roles`.`level` DESC LIMIT 0, '.$restrictDepth;
				$roles = $this->execute($roleSql, $loggedUser['acl']->role['level']);
				if (count($roles) > 0) {
					$roles = array_pop($roles);
					if (array_key_exists('level', $roles)) {
						// This is the lowest role level returned and is used for the comparison.
						$role = (int)$roles['level'];
					}
				}
				if (!is_int($role)) {
					// If we didn't find any roles, just default to the $user role level minus 1.
					$role = $user['acl']->role['level'] - 1;
				}
				$sql .= ' AND `#__Acl_Roles`.`level` >= '.$role;
			}
			$sql .= ' AND `#__Acl_Roles`.`level` > '.ANONYMOUS;
			// Also restrict user list to users whose role level is lower than the currently logged in user.
			$sql .= ' AND `#__Acl_Roles`.`level` < ?';
			$params[] = $loggedUser['acl']->role['level'];
			$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
			$result = $this->execute($sql, $params);

			// Get the current Property Manager if a Property is selected.
			if ($propertyId != 'all' && PROPERTY_MANAGER < $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					PROPERTY_MANAGER
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}

			/* // Get all Users assigned with ALL for divisions.
			if ($propertyId != 'all' && DIVISION_DIRECTOR <= $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__Division_User`.`division_id` = ? AND `#__User`.`status` = 1';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					'all'
				);
				$result = array_merge($result, $this->execute($sql, $params));
			} */
			
			// Get all Division Directors if a Property is selected and a Division is not.
			if ($propertyId != 'all' && $divisionId == 'all' && DIVISION_DIRECTOR < $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					DIVISION_DIRECTOR
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}

			// Get the current Division Director if a Division is selected.
			if ($propertyId != 'all' && $divisionId != 'all' && DIVISION_DIRECTOR < $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND (`#__Division_User`.`division_id` = ? || `#__Division_User`.`division_id` = "äll") AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					$divisionId,
					DIVISION_DIRECTOR
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}

			// Get all Department Managers if a Division is selected and a Department is not.
			if ($propertyId != 'all' && $divisionId != 'all' && $departmentId == 'all' && DEPARTMENT_MANAGER < $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND (`#__Division_User`.`division_id` = ? || `#__Division_User`.`division_id` = "äll") AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					$divisionId,
					DEPARTMENT_MANAGER
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}

			// Get the current Department Manager, and all Associates and Supervisors if a Department is selected.
			if ($propertyId != 'all' && $divisionId != 'all' && $departmentId != 'all' && DEPARTMENT_MANAGER < $loggedUser['acl']->role['level']) {
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND (`#__Division_User`.`division_id` = ? || `#__Division_User`.`division_id` = "äll") AND (`#__Department_User`.`department_id` = ? || `#__Department_User`.`department_id` = "äll") AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` <= ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					$divisionId,
					$departmentId,
					DEPARTMENT_MANAGER
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}

			// Get all Associates and Supervisors if the current user is a Department Manager.
			if (user_is(DIVISION_DIRECTOR, $currentUserId)) {

				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND (`#__Division_User`.`division_id` = ? || `#__Division_User`.`division_id` = "äll")  AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` < ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					$divisionId,
					DIVISION_DIRECTOR
				);
				
				$result = array_merge($result, $this->execute($sql, $params));
			}			

			// Get all Associates and Supervisors if the current user is a Department Manager.
			if (user_is(DEPARTMENT_MANAGER, $currentUserId)) {

				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND (`#__Division_User`.`division_id` = ? || `#__Division_User`.`division_id` = "äll")  AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` < ?';
				$sql .= ' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array(
					$propertyId,
					$divisionId,
					DEPARTMENT_MANAGER
				);
				$result = array_merge($result, $this->execute($sql, $params));
			}			

			// Include the selected User as well.
			$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__User`.`id` = ?';
			$result = array_merge($result, $this->execute($sql, $userId));

			// Include the logged-in User as well.
			$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__User`.`id` = ?';
			$result = array_merge($result, $this->execute($sql, $currentUserId));

			if (user_is(SUPER_USER, $currentUserId)) {
				// If the *current* User is a SuperUser, we want to display all other SuperUsers as well.
				$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = '.SUPER_USER.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$result = array_merge($result, $this->execute($sql));
			}

			// Fix the array to be indexed by 'id'.
			foreach ($result as $proposedUser) {
				$return[$proposedUser['id']] = $proposedUser;
			}

			// Sort by role level then last name.
			foreach ($return as $key => $row) {
				$roleLevel[$key]  = $row['role_level'];
				$lastName[$key] = $row['lastname'];
			}
			array_multisort($roleLevel, SORT_DESC, $lastName, SORT_ASC, $return);
		}
		//pr($return);

		return $return;
	}
}
