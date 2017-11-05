<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Strategy model.
 *
 * @package    truenorthng
 * @subpackage Strategy
 */

final class Model_Strategy extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'priority' => NULL,
			'private' => NULL,
			'unassigned_strategy' => NULL,
			'start' => NULL,
			'due' => NULL,
			'past_due' => NULL,
			'complete' => NULL,
			'description' => NULL,
			'comment' => NULL,
			'cid' => NULL
		);
	}

	public function getCompetency($strategyId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Competency_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $strategyId);
		if (count($result) > 0) {
			$return = $result[0]['competency_id'];
		}
		return $return;
	}

	public function getObjective($strategyId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Objective_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $strategyId);
		if (count($result) > 0) {
			$return = $result[0]['objective_id'];
		}
		return $return;
	}
	
	public function getProperty($strategyId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Property_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $strategyId);
		if (count($result) > 0) {
			$return = $result[0]['property_id'];
		}
		return $return;
	}
	
	public function getDivision($strategyId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Division_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $strategyId);
		if (count($result) > 0) {
			$return = $result[0]['division_id'];
		}
		return $return;
	}
	
	public function getDepartment($strategyId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Department_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $strategyId);
		if (count($result) > 0) {
			$return = $result[0]['department_id'];
		}
		return $return;
	}

	public function getUser($id) {
		$return = NULL;
		$sql = 'SELECT `user_id` FROM `#__User_Strategy` WHERE `strategy_id` = ?';
		$result = $this->execute($sql, $id);
		if (count($result) > 0) {
			if (array_key_exists('user_id', $result[0])) {
				$return = $result[0]['user_id'];
			}
		}
		return $return;
	}
	public function getOne($val = NULL, $field = "key", $orderBy = NULL, $tableNameExtra = NULL) {
		$strategy = parent::getOne($val, $field, $orderBy, $tableNameExtra);
		$strategy['property_id'] = $this->getProperty($strategy['id']);
		$strategy['division_id'] = $this->getDivision($strategy['id']);
		$strategy['department_id'] = $this->getDepartment($strategy['id']);
		return $strategy;
	}

	public function removeFromLocations($strategyId) {
		$this->delete($strategyId, 'strategy_id', '#__Property_Strategy');
		$this->delete($strategyId, 'strategy_id', '#__Division_Strategy');
		$this->delete($strategyId, 'strategy_id', '#__Department_Strategy');
	}

	public function getFilteredTactics($strategyId, $start, $end) {
		$return = array();

		// Get all Tactics assigned to this Strategy.
		$params = array(
			$strategyId
		);
		$sql = 'SELECT `#__Tactic`.* FROM `#__Tactic` LEFT JOIN `#__Strategy_Tactic` ON `#__Strategy_Tactic`.`tactic_id` = `#__Tactic`.`id` WHERE `#__Strategy_Tactic`.`strategy_id` = ? AND `#__Tactic`.`status` = 1';
		$objectList = objectList();
		/* foreach ($objectList['Strategy']['dates'] as $dateType) {
			if ($dateType == 'due') {
				if ($end == END_OF_TIME) {
					$sqlDate[] = '(`#__Tactic`.`'.$dateType.'` <= ?)';
					$params[] = $end;
				} else {
					$sqlDate[] = '(`#__Tactic`.`'.$dateType.'` >= ?)';
					$params[] = $start;
				}
			} else {
				$sqlDate[] = '(`#__Tactic`.`'.$dateType.'` <= ?)';
				$params[] = $end;
			}
		}
		if (count($sqlDate) > 0) {
			$sql .= ' AND ('.implode(' OR ', $sqlDate).')';
		} */
		$sql .= ' ORDER BY `#__Tactic`.`due`, `#__Tactic`.`aid`';
		//pr($sql, 'FILTERED TACTICS ');
		//pr($params, 'FILTERED TACTICS ');

		$result = $this->execute($sql, $params);

		foreach ($result as $strategy) {
			$return[$strategy['id']] = $strategy;
		}

		return $return;
	}
}
