<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Property model.
 *
 * @package    truenorthng
 * @subpackage Property
 */

final class Model_Property extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'name' => NULL,
			'logo' => NULL,
			'openUserView' => 0,
			'restrictSt' => 0,
			'restrictAsp' => 0,
			'code' => NULL,
			'cid' => NULL
		);
	}

	/**
	 * Find all users attached to a property. If the current user is a Super User, returns all Super Users as well.
	 *
	 * @param string $propertyId
	 *
	 * @return array
	 */
	public function getUsers($propertyId, $ignoreOpenUserView = FALSE) {
		$return = array();

		if ($this->G->defaultProperty['openUserView'] == 1 && FALSE === $ignoreOpenUserView) {
			if (user_is(SUPER_USER)) {
				$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` <= '.$this->G->user->acl->role['level'].' AND `#__Acl_Roles`.`level` > '.ANONYMOUS.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = $propertyId;
			} else {
				$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` < '.$this->G->user->acl->role['level'].' AND `#__Acl_Roles`.`level` > '.ANONYMOUS.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = $propertyId;
			}
		} else {
			if (session('division') == 'all' && session('department') == 'all') {
				// Current view is all Division Directors (plus Administration if current user is Super User)
				if (user_is(SUPER_USER)) {
					$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` >= '.DIVISION_DIRECTOR.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
					$params = $propertyId;
				} else {
					$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = '.DIVISION_DIRECTOR.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
					$params = $propertyId;
				}
			} elseif (session('division') != 'all' && session('department') == 'all') {
				// Current view is all Department Managers
				$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__Division_User`.`division_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` = '.DEPARTMENT_MANAGER.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array($propertyId, session('division'));
			} else {
				// Current view is all Supervisors and Associates
				$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Department_User` ON `#__Department_User`.`user_id` = `#__User`.`id` WHERE `#__Property_User`.`property_id` = ? AND `#__Division_User`.`division_id` = ? AND `#__Department_User`.`department_id` = ? AND `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` < '.DEPARTMENT_MANAGER.' AND `#__Acl_Roles`.`level` > '.ANONYMOUS.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$params = array($propertyId, session('division'), session('department'));
			}
		}

		$result = $this->execute($sql, $params);
		foreach ($result as $user) {
			$return[$user['id']] = $user;
		}

		// Second pass to add Property Managers and Super Users if needed.
		if ((session('division') == 'all' && session('department') == 'all') || ($this->G->defaultProperty['openUserView'] == 1 && FALSE === $ignoreOpenUserView)) {
			if (user_is(SUPER_USER)) {
				$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__User_Role` ON `#__User_Role`.`user_id` = `#__User`.`id` LEFT JOIN `#__Acl_Roles` ON `#__Acl_Roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`status` = 1 AND `#__Acl_Roles`.`level` >= '.PROPERTY_MANAGER.' ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
				$result = $this->execute($sql, $propertyId);
				foreach ($result as $user) {
					$return[$user['id']] = $user;
				}
			}
		}

		return $return;
	}
	
	public function getUsers_old($propertyId) {
		$return = array();
		$sql = 'SELECT `#__User`.* FROM `#__User`, `#__Property_User` WHERE `#__Property_User`.`property_id` = ? AND `#__Property_User`.`user_id` = `#__User`.`id` AND `#__User`.`status` = 1 ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
		$this->G->db->executeQuery($sql, $propertyId);
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$return[$result['id']] = $result;
			}
		}
		if (user_is('Super User')) {
			$sql = 'SELECT `#__User`.* FROM `#__User`, `#__User_Role`, `#__Acl_Roles` WHERE `#__User_Role`.`user_id` = `#__User`.`id` AND `#__User_Role`.`role_id` = `#__Acl_Roles`.`id` AND `#__User`.`status` = 1 and `#__Acl_Roles`.`name` = ? ORDER BY `#__User`.`lastname`, `#__User`.`firstname`';
			$this->G->db->executeQuery($sql, 'Super User');
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
		}
		return $return;
	}

	public function getDivisions($propertyId = NULL) {
		$return = array();
		if (NULL === $propertyId) {
			$propertyId = session('property');
		}
		// Get all default divisions.
		$sql = 'SELECT `#__Division`.* FROM `#__Division` WHERE `#__Division`.`status` = 1 AND `#__Division`.`default` = 1';
		$default = index_to_associative($this->execute($sql));

		// Get all divisions assigned directly to the property.
		$sql = 'SELECT `#__Division`.* FROM `#__Division` LEFT JOIN `#__Property_Division` ON `#__Property_Division`.`division_id` = `#__Division`.`id` WHERE `#__Property_Division`.`property_id` = ?';
		$property = index_to_associative($this->execute($sql, session('property')));

		$return = array_merge($default, $property);

		// Find all exclusions.
		if (count($return) > 0) {
			$sql = 'SELECT `#__Property_Exclusions`.* FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` IN ("' . implode('","', array_keys($return)) . '")';
			$remove = index_to_associative($this->execute($sql));

			foreach ($remove as $key => $value) {
				if (array_key_exists($key, $return)) {
					unset($return[$key]);
				}
			}
		}

		return $return;
	}

	public function getReviews($propertyId = null) {
		if (NULL === $propertyId) {
			$propertyId = session('property');
		}
		$sql = 'SELECT `#__Reviewcycle`.* FROM `#__Reviewcycle` LEFT JOIN `#__Property_Reviewcycle` ON `#__Property_Reviewcycle`.`reviewcycle_id` = `#__Reviewcycle`.`id` WHERE `#__Property_Reviewcycle`.`property_id` = ?';
		return index_to_associative($this->execute($sql, $propertyId));
	}

	public function addObjective($propertyId, $objectiveId) {
		$this->delete($objectiveId, 'objective_id', '#__Property_Objective');
		$sql = "INSERT INTO `#__Property_Objective` (`property_id`, `objective_id`) VALUES (?, ?)";
		$params = array($propertyId, $objectiveId);
		$this->execute($sql, $params);
	}

	public function addStrategy($propertyId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Property_Strategy');
		$sql = "INSERT INTO `#__Property_Strategy` (`property_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($propertyId, $strategyId);
		$this->execute($sql, $params);
	}

	public function addReviewcycle($propertyId, $reviewcycleId) {
		$this->delete($reviewcycleId, 'reviewcycle_id', '#__Property_Reviewcycle');
		$sql = "INSERT INTO `#__Property_Reviewcycle` (`property_id`, `reviewcycle_id`) VALUES (?, ?)";
		$params = array($propertyId, $reviewcycleId);
		$this->execute($sql, $params);
	}
}
