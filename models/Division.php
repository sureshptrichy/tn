<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Division model.
 *
 * @package    truenorthng
 * @subpackage Division
 */

final class Model_Division extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'name' => NULL,
			'default' => NULL,
			'cid' => NULL
		);
	}

	public function getDepartments($divisionId = NULL) {
		$return = array();
		if (NULL === $divisionId) {
			$divisionId = session('division');
		}

		if ($divisionId != 'all') {
			// Get all default departments.
			$sql = 'SELECT `#__Department`.*, `#__Division_Department`.`division_id` FROM `#__Department` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id` WHERE `#__Department`.`status` = 1 AND `#__Department`.`default` = 1';
			$result = index_to_associative($this->execute($sql));
			$default = array();
			foreach ($result as $key => $value) {
				if ($value['division_id'] == $divisionId) {
					$default[$key] = $value;
				}
			}

			// Get all departments assigned directly to the division.
			$sql = 'SELECT `#__Department`.*, `#__Division_Department`.`division_id` FROM `#__Department` LEFT JOIN `#__Division_Department` ON `#__Division_Department`.`department_id` = `#__Department`.`id` WHERE `#__Department`.`status` = 1 AND `#__Division_Department`.`division_id` = ?';
			$property = index_to_associative($this->execute($sql, $divisionId));

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
		}

		return $return;
	}
	
	public function getDivisions($propertyId = 0, $super = FALSE) {
		$return = array();
		$sql = NULL;
		$params = array();
		$default = array();
		
		if ($super) {
			$sql = 'SELECT `#__Division`.* FROM `#__Division` WHERE `#__Division`.`status` = 1 ORDER BY `#__Division`.`name` ASC';
			$this->G->db->executeQuery($sql);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					//$return[$result['id']] = $result;
				}
			}
		} //else {
			// Determine the current user
			if (!session('user_filter')){
				$currentUser = $this->G->user->id;
			} else {
				$currentUser = session('user_filter');
			}
			
			/* 
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
			}); */
			
			
			// Get property-specific divisions.
			$sql = 'SELECT `#__Division`.*, `#__Property`.`name` AS `property_name` FROM `#__Division`, `#__Property`, `#__Property_Division` WHERE ((`#__Division`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ?) OR (`#__Division`.`default` = 1 AND `#__Division`.`status` = 1)) AND `#__Property_Division`.`property_id` = `#__Property`.`id` AND `#__Division`.`id` = `#__Property_Division`.`division_id` GROUP BY `#__Division`.`name` ORDER BY `property_name`, `#__Division`.`name`';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
			//Remove all divisions not matching user's assigned division
			if (user_is(ASSOCIATE)){
				$sql = 'SELECT `#__Division_User`.* FROM `#__Division_User` WHERE `#__Division_User`.`user_id` = "'.$currentUser.'"';
				$division_id = null;
				$this->G->db->executeQuery($sql, $propertyId);
				if ($this->G->db->numRows() > 0) {
					while ($result = $this->G->db->getRows()) {
						$division_id = $result['division_id'];
						foreach($return as $item=>$key){
							if ($item != $result['division_id']){
								unset($return[$item]);
							}		
						}		
					}
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
			
			// Remove divisions which are deleted for the specific property
			if($propertyId) {
				$sql = 'SELECT `#__Division`.name FROM `#__Division`, `#__Property_Division`  WHERE `#__Division`.`status` = 0 AND `#__Division`.`id` = `#__Property_Division`.`division_id` AND `#__Property_Division`.`property_id` = ?';
				$division_id = null;
				
				//print_r($return);
				$this->G->db->executeQuery($sql, $propertyId);
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
		//}
		uasort($return, function ($a, $b) {
			return strcmp(trim($a['name']), trim($b['name']));
		});
		return $return;
	}

	/**
	 * Find all users attached to a division.
	 *
	 * @param string $divisionId
	 *
	 * @return array
	 */
	public function getUsers($divisionId) {
		die('models/Division->getUsers() is DEPRECATED!');
		$return = array();

		// First, users belonging to default divisions.
		$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division` ON `#__Division`.`id` = `#__Division_User`.`division_id` WHERE `#__User`.`status` = 1 AND `#__Division`.`default` = 1 AND `#__Division`.`status` = 1 AND `#__Division_User`.`division_id` = ?';
		$result = $this->execute($sql, $divisionId);
		foreach ($result as $user) {
			$return[$user['id']] = $user;
		}

		// Second, users belonging to property-specific divisions.
		$sql = 'SELECT `#__User`.* FROM `#__User` LEFT JOIN `#__Property_User` ON `#__Property_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Division_User` ON `#__Division_User`.`user_id` = `#__User`.`id` LEFT JOIN `#__Property_Division` ON `#__Property_Division`.`division_id` = `#__Division_User`.`division_id` WHERE `#__User`.`status` = 1 AND `#__Property_Division`.`property_id` = ? AND `#__Division_User`.`division_id` = ?';
		$result = $this->execute($sql, array(session('property'), $divisionId));
		foreach ($result as $user) {
			$return[$user['id']] = $user;
		}

		return $return;
	}

	public function addToProperty($propertyId, $divisionId) {
		$sql = "INSERT INTO `#__Property_Division` (`property_id`, `division_id`) VALUES (?, ?)";
		$params = array($propertyId, $divisionId);
		$this->execute($sql, $params);
	}

	public function addObjective($divisionId, $objectiveId) {
		$this->delete($objectiveId, 'objective_id', '#__Division_Objective');
		$sql = "INSERT INTO `#__Division_Objective` (`division_id`, `objective_id`) VALUES (?, ?)";
		$params = array($divisionId, $objectiveId);
		$this->execute($sql, $params);
	}

	public function addStrategy($divisionId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Division_Strategy');
		$sql = "INSERT INTO `#__Division_Strategy` (`division_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($divisionId, $strategyId);
		$this->execute($sql, $params);
	}
}
