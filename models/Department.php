<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Department model.
 *
 * @package    truenorthng
 * @subpackage Department
 */

final class Model_Department extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'name' => NULL,
			'default' => NULL,
			'code' => NULL,
			'cid' => NULL
		);
	}

	public function getDivision($departmentId = 0, $super = FALSE){
		$sql = 'SELECT `#__Division_Department`.* FROM `#__Division_Department` WHERE `#__Division_Department`.`department_id` = ?';
		$this->G->db->executeQuery($sql, $departmentId);
		while ($result = $this->G->db->getRows()) {
			return $result;
		}
	}
	
	public function getDepartments($divisionId = 0, $super = FALSE) {
		$return = array();
		$rawList = array();
		
		/* 
		// First get all the Default Departments
		$sql = 'SELECT `#__Department`.*, `#__Division`.`name` AS `division_name`, `#__Division`.`id` AS `division_id` FROM `#__Department`, `#__Division`, `#__Division_Department` WHERE `#__Department`.`status` = 1 AND `#__Department`.`default` = 1 AND `#__Division`.`status` = 1 AND `#__Division_Department`.`division_id` = `#__Division`.`id` AND `#__Department`.`id` = `#__Division_Department`.`department_id` GROUP BY `#__Department`.`name` ORDER BY `#__Department`.`name`, `division_name`';
		$result = $this->execute($sql);
		foreach ($result as $department) {
			$rawList[$department['id']] = $department;
		} */

		// Next the Departments that belong to the Property and Divisions.
		$divisions = get_model('division')->getDivisions(session('property'), $super);
		$sql = 'SELECT `#__Department`.*, `#__Division`.`name` AS `division_name`, `#__Division`.`id` AS `division_id` FROM `#__Department` LEFT JOIN `#__Property_Department` ON `#__Property_Department`.`department_id` = `#__Department`.`id` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id`, `#__Division` WHERE `#__Property_Department`.`property_id` = ? AND `#__Division_Department`.`division_id` IN ("'.implode('", "', array_keys($divisions)).'") AND `#__Department`.`status` = 1 AND `#__Department`.`default` = 0 AND `#__Division`.`id` = `#__Division_Department`.`division_id` ORDER BY `#__Department`.`name` ASC';
		$result = $this->execute($sql, array(session('property')));
		foreach ($result as $department) {
			$rawList[$department['id']] = $department;
		}

		if ($super) {
			$return = $rawList;
		} else {
			// Remove everything that doesn't belong to the passed Division.
			foreach ($rawList as $id => $department) {
				if ($department['division_id'] == $divisionId) {
					$return[$id] = $department;
				}
			}
		}

		// Remove excluded Departments.
		if (count($return) > 0) {
			$sql = 'SELECT `#__Property_Exclusions`.* FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` IN ("'.implode('", "', array_keys($return)).'")';
			$result = $this->execute($sql, session('property'));
			foreach ($result as $exclude) {
				if (array_key_exists($exclude['exclusion_id'], $return)) {
					unset($return[$exclude['exclusion_id']]);
				}
			}
		}
		
		// Remove departments which are deleted for the specific division
		if($divisionId) {
			$sql = 'SELECT `#__Department`.name FROM `#__Department`, `#__Division_Department`  WHERE `#__Department`.`status` = 0 AND `#__Department`.`id` = `#__Division_Department`.`department_id` AND `#__Division_Department`.`division_id` = ?';
			
			//print_r($return);
			$this->G->db->executeQuery($sql, $divisionId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					foreach($return as $item=>$key){
						if ($key['name'] == $result['name']){
							unset($return[$item]);
						}		
					}		
				}
			}
		}		

		uasort($return, function ($a, $b) {
			return strcmp(trim($a['name']), trim($b['name']));
		});
		if (!$super && (user_is(SUPER_USER) || user_is(PROPERTY_MANAGER) || user_is(DIVISION_DIRECTOR))){
			if (count($return) > 1){
				$add = array('id' => 'all', 'name' => 'All Departments');
				array_unshift($return, $add);
			} elseif ($divisionId == 'all'){
				$add = array('id' => 'all', 'name' => 'All Departments');
				array_unshift($return, $add);
			}
		}

		return $return;
	}

	/**
	 * Find all users attached to a department.
	 *
	 * @param string $departmentId
	 *
	 * @return array
	 */
	public function getUsers($departmentId) {
		die('models/Department->getUsers() is DEPRECATED!');
		$return = array();

		// First, users belonging to default departments.
		$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department` ON `#__Department`.`id` = `#__Department_User`.`department_id` WHERE `#__User`.`status` = 1 AND `#__Department`.`default` = 1 AND `#__Department`.`status` = 1 AND `#__Department_User`.`department_id` = ?';
		$result = $this->execute($sql, $departmentId);
		foreach ($result as $user) {
			$return[$user['id']] = $user;
		}

		// Second, users belonging to property-specific departments.
		$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Property_Department` ON `#__Property_Department`.`department_id` = `#__Department_User`.`department_id` WHERE `#__User`.`status` = 1 AND `#__Property_Department`.`property_id` = ? AND `#__Department_User`.`department_id` = ?';
		$result = $this->execute($sql, array(session('property'), $departmentId));
		foreach ($result as $user) {
			$return[$user['id']] = $user;
		}

		return $return;
	}

	public function getManagerFromCode($code, $propertyId = NULL) {
		$return = array();
		if (empty($propertyId)) {
			$propertyId = session('property');
		}

		// Get the Department ID from the code.
		$sql = 'SELECT `id` FROM `#__Department` WHERE `code` = ?';
		$result = $this->execute($sql, $code);
		if (count($result) > 0) {
			$departmentId = $result[0]['id'];
			$return = $this->getManager($departmentId, $propertyId);
		}

		return $return;
	}

	public function getManager($departmentId, $propertyId = NULL) {
		$return = array();
		if (empty($propertyId)) {
			$propertyId = session('property');
		}

		// First, users belonging to default departments.
		$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department` ON `#__Department`.`id` = `#__Department_User`.`department_id` WHERE `#__User`.`status` = 1 AND `#__Department`.`default` = 1 AND `#__Acl_Roles`.`level` = '.DEPARTMENT_MANAGER.' AND `#__Department`.`status` = 1 AND `#__Department_User`.`department_id` = ?';
		$result = $this->execute($sql, $departmentId);

		// Second, users belonging to property-specific departments.
		$sql = 'SELECT `#__User`.*, `#__Acl_Roles`.`name` as `role`, `#__Acl_Roles`.`level` as `role_level` FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Property_Department` ON `#__Property_Department`.`department_id` = `#__Department_User`.`department_id` WHERE `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = '.DEPARTMENT_MANAGER.' AND `#__Property_Department`.`property_id` = ? AND `#__Department_User`.`department_id` = ?';
		$result = array_merge($result, $this->execute($sql, array($propertyId, $departmentId)));

		foreach ($result as $userArray) {
			$user = get_model('user');
			$user->loadUser($userArray['id']);
			$return[$userArray['id']] = $user;
		}
		return $return;
	}
	
	public function removeFromDivision($departmentId) {
		$this->delete($departmentId, 'department_id', '#__Division_Department');
	}
	
	public function addToProperty($propertyId, $departmentId) {
		$sql = "INSERT INTO `#__Property_Department` (`property_id`, `department_id`) VALUES (?, ?)";
		$params = array($propertyId, $departmentId);
		$this->execute($sql, $params);
	}

	public function addToDivision($divisionId, $departmentId) {
		$sql = "INSERT INTO `#__Division_Department` (`division_id`, `department_id`) VALUES (?, ?)";
		$params = array($divisionId, $departmentId);
		$this->execute($sql, $params);
	}

	public function addObjective($departmentId, $objectiveId) {
		$this->delete($objectiveId, 'objective_id', '#__Department_Objective');
		$sql = "INSERT INTO `#__Department_Objective` (`department_id`, `objective_id`) VALUES (?, ?)";
		$params = array($departmentId, $objectiveId);
		$this->execute($sql, $params);
	}

	public function addStrategy($departmentId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Department_Strategy');
		$sql = "INSERT INTO `#__Department_Strategy` (`department_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($departmentId, $strategyId);
		$this->execute($sql, $params);
	}
}
