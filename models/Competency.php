<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Competency model.
 *
 * @package    truenorthng
 * @subpackage Competency
 */

final class Model_Competency extends Model {
	
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'sort_order' => NULL,
			'name' => NULL,
			'default' => NULL,
			'cid' => NULL
		);
	}
	
	
	public function getCompetencies($propertyId = 0, $super = FALSE, $stripHidden = TRUE) {
		$return = array();
		$sql = NULL;
		$params = array();
		$default = array();
		
		if ($super) {
			$sql = 'SELECT `#__Competency`.* FROM `#__Competency` WHERE `#__Competency`.`status` = 1 ORDER BY `#__Competency`.`sort_order` ASC';
			$this->G->db->executeQuery($sql);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					//$return[$result['id']] = $result;
				}
			}
		} //else {
			// Determine the current user
			//echo $this->cid;
			
			if($this->cid == '') {
				if (!session('user_filter')){
					$currentUser = $this->G->user->id;
				} else {
					$currentUser = session('user_filter');
				}				
			} else {
				$currentUser = $this->cid;
			}
			
			//echo $currentUser;
			
			/* 
			// Get all default competencies.
			$sql = 'SELECT `#__Competency`.* FROM `#__Competency` WHERE `default` = 1 AND `status` = 1';
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
			
			*/
			 
			// Get property-specific competencies.
			$sql = 'SELECT `#__Competency`.*, `#__Property`.`name` AS `property_name` FROM `#__Competency`, `#__Property`, `#__Property_Competency` WHERE ((`#__Competency`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ?) OR (`#__Competency`.`default` = 1 AND `#__Competency`.`status` = 1)) AND `#__Property_Competency`.`property_id` = `#__Property`.`id` AND `#__Competency`.`id` = `#__Property_Competency`.`competency_id` GROUP BY `#__Competency`.`name` ORDER BY `property_name`, `#__Competency`.`sort_order`';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
			if (count($default) > 0) {
				// Remove excluded competencies.
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
		//}
		
		//print_r($return);
		
		/* show only competencies selected for the current user */
		if ((!user_is('Super User') AND !user_is('Property Super User') AND !user_is('Administration'))){
			
			if($this->cid == '') {
				$model = get_model('user');
				$userInfo = $model->loadUser($currentUser);
				$competenciesList = array();
				if(count($return) > 0) {
					
					if($userInfo["competencies"])
						$competenciesList = unserialize($userInfo["competencies"]);

					foreach($return as $key => $comp) {
						if (!in_array($key, $competenciesList)) {
							unset($return[$key]);
						}				
					}
				}
			}
		}
		//print_r($userInfo["competencies"]);
		
//print_r($return);
		
		uasort($return, function ($a, $b) {
			return strcmp(trim($a['sort_order']), trim($b['sort_order']));
		});
		return $return;	
	}
	
	public function getCompetencies_old($propertyId = 0, $super = FALSE, $stripHidden = TRUE) {
		$return = array();
		$sql = NULL;
		$params = array();
		if ($super) {
			$sql = 'SELECT `#__Competency`.* FROM `#__Competency` WHERE `#__Competency`.`status` = 1 ORDER BY `#__Competency`.`sort_order` ASC';
			$this->G->db->executeQuery($sql);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
			$sql = 'SELECT `#__Competency`.*, `#__Property`.`name` AS `property_name` FROM `#__Competency`, `#__Property`, `#__Property_Competency` WHERE `#__Competency`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ? AND `#__Property_Competency`.`property_id` = `#__Property`.`id` AND `#__Competency`.`id` = `#__Property_Competency`.`competency_id` GROUP BY `#__Competency`.`name` ORDER BY `property_name`, `#__Competency`.`sort_order`';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
		} else {
			$sql = 'SELECT `#__Competency`.* FROM `#__Competency` WHERE `default` = 1 AND `status` = 1';
			$this->G->db->executeQuery($sql);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
					$return[$result['id']]['property_name'] = 'Default';
					$return[$result['id']]['hidden'] = FALSE;
				}
			}
			$default = array_keys($return);
			array_walk($default, function (&$item, $key) {
				$item = "'$item'";
			});
			$sql = 'SELECT `#__Property_Exclusions`.* FROM `#__Property_Exclusions` WHERE `property_id` = ? AND `exclusion_id` IN (' . implode(',', $default) . ')';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					if (isset($return[$result['exclusion_id']])) {
						if ($stripHidden) {
							unset($return[$result['exclusion_id']]);
						} else {
							$return[$result['exclusion_id']]['hidden'] = TRUE;
						}
					}
				}
			}
			//echo "<pre>".print_r($return, TRUE)."</pre>";
			$sql = 'SELECT `#__Competency`.*, `#__Property`.`name` AS `property_name` FROM `#__Competency`, `#__Property`, `#__Property_Competency` WHERE `#__Competency`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ? AND `#__Property_Competency`.`property_id` = `#__Property`.`id` AND `#__Competency`.`id` = `#__Property_Competency`.`competency_id` GROUP BY `#__Competency`.`name` ORDER BY `property_name`, `#__Competency`.`sort_order`';
			$this->G->db->executeQuery($sql, $propertyId);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
					$return[$result['id']]['hidden'] = FALSE;
				}
			}
		}
		uasort($return, function ($a, $b) {
			return strcmp(trim($a['name']), trim($b['name']));
		});
		return $return;
	}

	public function addToProperty($propertyId, $divisionId) {
		$sql = "INSERT INTO `#__Property_Competency` (`property_id`, `competency_id`) VALUES (?, ?)";
		$params = array($propertyId, $divisionId);
		$this->execute($sql, $params);
	}

	public function addObjective($competencyId, $objectiveId) {
		$this->delete($objectiveId, 'objective_id', '#__Competency_Objective');
		$sql = "INSERT INTO `#__Competency_Objective` (`competency_id`, `objective_id`) VALUES (?, ?)";
		$params = array($competencyId, $objectiveId);
		$this->execute($sql, $params);
	}

	public function addStrategy($competencyId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Competency_Strategy');
		$sql = "INSERT INTO `#__Competency_Strategy` (`competency_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($competencyId, $strategyId);
		$this->execute($sql, $params);
	}

	public function getFilteredObjectives($competencyId, $propertyId, $start, $end, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $userId = NULL) {
		$return = array();

		// Get all Objectives assigned to this Competency and Property, and optionally the selected Division and Department.
		$params = array(
			$propertyId
		);
		$sqlDate = array();
		$sql = 'SELECT `#__Objective`.* FROM `#__Objective` LEFT JOIN `#__Property_Objective` ON `#__Property_Objective`.`objective_id` = `#__Objective`.`id`';
		//if ($divisionId != 'all') {
			$sql .= ' LEFT JOIN `#__Division_Objective` ON `#__Division_Objective`.`objective_id` = `#__Objective`.`id`';
		//}
		//if ($departmentId != 'all') {
			$sql .= ' LEFT JOIN `#__Department_Objective` ON `#__Department_Objective`.`objective_id` = `#__Objective`.`id`';
		//}
		$sql .= ' LEFT JOIN `#__Competency_Objective` ON `#__Competency_Objective`.`objective_id` = `#__Objective`.`id` WHERE `#__Property_Objective`.`property_id` = ?';
		//if ($divisionId != 'all') {
			//$sql .= ' AND `#__Division_Objective`.`division_id` = ?';
			//$params[] = $divisionId;
		//}
		//if ($departmentId != 'all') {
			//$sql .= ' AND `#__Department_Objective`.`department_id` = ?';
			//$params[] = $departmentId;
		//}
		$sql .= ' AND `#__Competency_Objective`.`competency_id` = ? AND `#__Objective`.`status` = 1';
		$params[] = $competencyId;
		$objectList = objectList();
		foreach ($objectList['Objective']['dates'] as $dateType) {
			if ($dateType == 'due') {
				if ($end == END_OF_TIME) {
					$sqlDate[] = '(`#__Objective`.`'.$dateType.'` <= ?)';
					$params[] = $end;
				} else {
					$sqlDate[] = '(`#__Objective`.`'.$dateType.'` >= ?)';
					$params[] = $start;
				}
			} else {
				$sqlDate[] = '(`#__Objective`.`'.$dateType.'` >= ? AND `#__Objective`.`'.$dateType.'` <= ?)';
				$params[] = $start;
				$params[] = $end;
			}

			if ($end == END_OF_TIME) {
				//$sqlDate[] = '(`#__Objective`.`'.$dateType.'` <= ?)';
				//$params[] = $end;
			} else {
				//$sqlDate[] = '(`#__Objective`.`'.$dateType.'` >= ? AND `#__Objective`.`'.$dateType.'` <= ?)';
				//$params[] = $start;
				//$params[] = $end;
			}
		}
		if (count($sqlDate) > 0) {
			$sql .= ' AND ('.implode(' OR ', $sqlDate).')';
			$sql .= ' AND ((`#__Objective`.`start` <= '.$start.' AND `#__Objective`.`due` >= '.$start.')
			
			OR
			
			(`#__Objective`.`start` >= '.$start.' AND `#__Objective`.`start` <= '.$end.')
			)';
		}
		$sql .= ' ORDER BY `#__Objective`.`priority`, `#__Objective`.`start`, `#__Objective`.`due`';
		//pr($sql, 'FILTERED OBJECTIVES ');
		//pr($params, 'FILTERED OBJECTIVES ');

		$result = $this->execute($sql, $params);
		
		//print_r($result);

		foreach ($result as $objective) {
			if ($objective['private'] == 0 || ($objective['private'] == 1 && $objective['cid'] == $userId)) {
				$return[$objective['id']] = $objective;
			}
		}
		//print_r($return);
		//pr($sql);
		return $return;
	}

	public function getFilteredStrategies($competencyId, $propertyId, $start, $end, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $userId = NULL, $forDisplay = FALSE) {
		$return = array();
		if (empty($divisionId)) {
			$divisionId = session('division');
		}
		if (empty($departmentId)) {
			$departmentId = session('department');
		}
		if (empty($filterId)) {
			$filterId = session('user_filter');
		}
		if (empty($userId)) {
			$userId = session('user');
		}
		$user = $filterId;
		if (empty($user)) {
			$user = $userId;
		}
		$property = get_model('property')->getOne($propertyId, 'id');

		// Get all Strategies assigned to this Objective and Property, and optionally the selected Division and Department.
		$params = array(
			$propertyId
		);
		$sql = 'SELECT `#__Strategy`.*, `#__User_Strategy`.`user_id` FROM `#__Strategy` LEFT JOIN `#__Property_Strategy` ON `#__Property_Strategy`.`strategy_id` = `#__Strategy`.`id`';
		/* if ($divisionId != 'all') {
			$sql .= ' LEFT JOIN `#__Division_Strategy` ON `#__Division_Strategy`.`strategy_id` = `#__Strategy`.`id`';
		}
		if ($departmentId != 'all') {
			$sql .= ' LEFT JOIN `#__Department_Strategy` ON `#__Department_Strategy`.`strategy_id` = `#__Strategy`.`id`';
		} */
		$sql .=' LEFT JOIN `#__Competency_Strategy` ON `#__Competency_Strategy`.`strategy_id` = `#__Strategy`.`id` LEFT JOIN `#__User_Strategy` ON `#__User_Strategy`.`strategy_id` = `#__Strategy`.`id` WHERE `#__Property_Strategy`.`property_id` = ?';
		/* if ($divisionId != 'all') {
			$sql .= ' AND `#__Division_Strategy`.`division_id` = ?';
			$params[] = $divisionId;
		}
		if ($departmentId != 'all') {
			$sql .= ' AND `#__Department_Strategy`.`department_id` = ?';
			$params[] = $departmentId;
		} */
		$sql .= ' AND `#__Competency_Strategy`.`competency_id` = ? AND `#__Strategy`.`status` = 1';
		$params[] = $competencyId;
		$objectList = objectList();
		
		foreach ($objectList['Strategy']['dates'] as $dateType) {
			if ($dateType == 'due') {
				if ($end == END_OF_TIME) {
					$sqlDate[] = '(`#__Strategy`.`'.$dateType.'` <= ?)';
					$params[] = $end;
				} else {
					$sqlDate[] = '(`#__Strategy`.`'.$dateType.'` >= ?)';
					$params[] = $start;
				}
			} else {
				$sqlDate[] = '(`#__Strategy`.`'.$dateType.'` >= ? AND `#__Strategy`.`'.$dateType.'` <= ?)';
				$params[] = $start;
				$params[] = $end;
			}
		}
		if (count($sqlDate) > 0) {
			$sql .= ' AND ('.implode(' OR ', $sqlDate).')';
			$sql .= ' AND ((`#__Strategy`.`start` <= '.$start.' AND `#__Strategy`.`due` >= '.$start.')
			
			OR
			
			(`#__Strategy`.`start` >= '.$start.' AND `#__Strategy`.`start` <= '.$end.')
			)';
		}
		$restrict = 100;
		if ((isset($property['openUserView']) AND $property['openUserView']) || $filterId == 'all') {
			$restrict = 100;
		}
		//$userList = getUsers($user, $restrict, $forDisplay, $propertyId, $divisionId, $departmentId, $filterId, $userId);
		
		//$userList = get_model("user")->getAllUsers($propertyId);
		
		//pr($userList);
		//$sql .= ' AND `#__User_Strategy`.`user_id` IN ("'.implode('","', array_keys($userList)).'")';
		$sql .= ' ORDER BY `#__Strategy`.`priority`, `#__Strategy`.`start`, `#__Strategy`.`due`, `#__Strategy`.`aid`';
		//pr($sql, 'FILTERED C STRATEGIES ');
		//pr($params, 'FILTERED C STRATEGIES ');

		$result = $this->execute($sql, $params);
		
		//print_r($result);

		foreach ($result as $strategy) {
			//if ($strategy['private'] == 0 || ($strategy['private'] == 1 && $strategy['cid'] == $userId) || ($strategy['private'] == 1 && $strategy['user_id'] == $userId)) {
				$return[$strategy['id']] = $strategy;
			//}
		}
		
		//print_r($return);

		// Now assign the parent Objective, if any, to each Strategy.
		if (count($return) > 0) {
			$sql = 'SELECT * FROM `#__Objective_Strategy` WHERE `strategy_id` IN ("'. implode('", "', array_keys($return)) .'")';
			$result = $this->execute($sql);
			foreach ($result as $join) {
				if (array_key_exists($join['strategy_id'], $return)) {
					$return[$join['strategy_id']]['_objective'] = $join['objective_id'];
				}
			}
		}
		
		//print_r($return);

		return $return;
	}
}
