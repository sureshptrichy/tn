<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Objective model.
 *
 * @package    truenorthng
 * @subpackage Objective
 */

final class Model_Objective extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'tn_objective' => NULL,
			'description' => NULL,
			'priority' => NULL,
			'private' => NULL,
			'unassigned_obj' => NULL,
			'start' => NULL,
			'due' => NULL,
			'comment' => NULL,
			'user_id' => NULL,
			'cid' => NULL
		);
	}

	public function addStrategy($objectiveId, $strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Objective_Strategy');
		$sql = "INSERT INTO `#__Objective_Strategy` (`objective_id`, `strategy_id`) VALUES (?, ?)";
		$params = array($objectiveId, $strategyId);
		$this->execute($sql, $params);
	}

	public function getCompetency($objectiveId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Competency_Objective` WHERE `objective_id` = ?';
		$result = $this->execute($sql, $objectiveId);
		if (count($result) > 0) {
			$return = $result[0]['competency_id'];
		}
		return $return;
	}
	
	public function getStrategies($objectiveId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Objective_Strategy` WHERE `objective_id` = ?';
		$result = $this->execute($sql, $objectiveId);
		if (count($result) > 0) {
			$return = $result;
		}
		return $return;
	}	
	
	public function getFilteredStrategies($objectiveId, $propertyId, $start, $end, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $userId = NULL, $forDisplay = FALSE) {
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

		// Get all Strategies assigned to this Objective and Property.
		$params = array(
			$propertyId,
			$objectiveId
		);
		$sql = 'SELECT `#__Strategy`.*, `#__User_Strategy`.`user_id` FROM `#__Strategy` LEFT JOIN `#__Property_Strategy` ON `#__Property_Strategy`.`strategy_id` = `#__Strategy`.`id` LEFT JOIN `#__Objective_Strategy` ON `#__Objective_Strategy`.`strategy_id` = `#__Strategy`.`id` LEFT JOIN `#__User_Strategy` ON `#__User_Strategy`.`strategy_id` = `#__Strategy`.`id` WHERE `#__Property_Strategy`.`property_id` = ? AND `#__Objective_Strategy`.`objective_id` = ? AND `#__Strategy`.`status` = 1';
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
		}
		$restrict = 1;
		if ((isset($property['openUserView']) AND $property['openUserView']) || $filterId == 'all') {
			$restrict = 100;
		}
		$userList = getUsers($user, $restrict, $forDisplay, $propertyId, $divisionId, $departmentId, $filterId, $userId);
		//pr($userList);
		$sql .= ' AND `#__User_Strategy`.`user_id` IN ("'.implode('","', array_keys($userList)).'")';
		$sql .= ' ORDER BY `#__Strategy`.`priority`, `#__Strategy`.`start`, `#__Strategy`.`due`';
		//pr($sql, 'FILTERED STRATEGIES ');
		//pr($params, 'FILTERED STRATEGIES ');

		$result = $this->execute($sql, $params);

		foreach ($result as $strategy) {
			if ($strategy['private'] == 0 || ($strategy['private'] == 1 && $strategy['cid'] == $userId) || $strategy['user_id'] == $userId) {
				$return[$strategy['id']] = $strategy;
			}
		}

		return $return;
	}
}
