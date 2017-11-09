<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Review cycle model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Reviewcycle extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'locked' => 0,
			'name' => NULL,
			'description' => NULL,
			'setup' => NULL,
			'hourlies' => NULL,
			'start' => NULL,
			'due' => NULL,
			'cid' => NULL
		);
	}

	public function current($reviewCycleId = NULL) {
		$return = array();
		$sql = 'SELECT `id` FROM `#__Reviewcycle` WHERE `start` IS NOT NULL AND `start` < ? AND (`due` IS NULL OR `due` > ?) ORDER BY `start`;';
		$results = $this->execute($sql, array(time(), time()));
		if (!empty($results)){
			if ($results > 1){
				foreach ($results as $result){
					$return[$result['id']] = $result;
				}
			}
			return 'RC_'.$results[0]['id'];
		}
	}

	public function allCurrent($propertyId = null) {
		$return = array();
		if (null == $propertyId) {
			$propertyId = session('property');
		}
		$sql = 'SELECT `#__Reviewcycle`.* FROM `#__Reviewcycle` LEFT JOIN `#__Property_Reviewcycle` on `#__Property_Reviewcycle`.`reviewcycle_id` = `#__Reviewcycle`.`id` WHERE `#__Reviewcycle`.`status` = 1 AND `#__Property_Reviewcycle`.`property_id` = ? AND `#__Reviewcycle`.`start` IS NOT NULL AND `#__Reviewcycle`.`start` < ? AND (`#__Reviewcycle`.`due` IS NULL OR `#__Reviewcycle`.`due` > ?) ORDER BY `#__Reviewcycle`.`start`';
		$params = array(
			$propertyId,
			time(),
			time()
		);
		$results = $this->execute($sql, $params);
		foreach ($results as $result) {
			$return[$result['id']] = $result;
		}
		return $return;
	}

	public function currentForms($userId = null) {
		$reviewCycle = array();
		$incomplete = null;
		$return = array();
		$currentCycles = $this->current();
		$currentPropertyCycles = $this->allCurrent(session('property'));
		foreach ($currentPropertyCycles as $cycle){
			//$sql = 'SHOW TABLES FROM `tn2db` LIKE "tnng_'.$this->current().'"';	
			$sql = 'SHOW TABLES FROM '.$this->dbname.' LIKE "tnng_RC_'.$cycle['id'].'"';
			$result = $this->execute($sql);
			if (!empty($result)){
				if ($userId == null || $userId == '0' || $userId == '') {
					$userId = session('user_filter');
					if ($userId == null || $userId == '0' || $userId == '') {
						$userId = session('user');
					}
				}
				$sql = 'SELECT DISTINCT reviewcycle_id, compiledform_id, user_for_id, answer_date, answer FROM #__RC_'.$cycle['id'] . ' WHERE `user_by_id` = ? ';
				$results = $this->execute($sql, $userId, false);
				if (!empty($return)){
					foreach($results as $result){
						array_push($return, $result);
					}
				} else {
					$return = $results;
				}
			}
		}
		return $return;
	}
	
	public function selfReviewForms($userId = null) {
		$reviewCycle = array();
		$incomplete = null;

		$sql = "SELECT a.name AS review_name, a.due, b.reviewcycle_id, b.aid AS review_id, b.compiledform_id, b.answer, b.answer_date FROM #__Reviewcycle AS a LEFT JOIN #__Reviewcycle_Answers AS b  ON (a.id = b.reviewcycle_id) WHERE b.user_for_id = '$userId' AND b.manager_answer_date = 0 GROUP BY a.id ORDER BY a.start DESC";
		
		$results = $this->execute($sql);
		
		//print_r($results);
		
		return $results;
	}	
	
	public function managerReviewForms($userId = null) {
		$reviewCycle = array();
		$incomplete = null;

		$sql = "SELECT a.name AS review_name, a.due, b.reviewcycle_id, b.aid AS review_id, b.compiledform_id, b.answer, b.manager_answer_date, 
				CONCAT(c.firstname, ' ', c.lastname) AS review_for 
				FROM #__Reviewcycle AS a 
				LEFT JOIN #__Reviewcycle_Answers AS b  ON (a.id = b.reviewcycle_id)
				LEFT JOIN #__user AS c ON (b.user_for_id = c.id)
				WHERE b.user_by_id = '$userId'  AND b.answer_date > 0 GROUP BY a.id ORDER BY a.start DESC";
		
		$results = $this->execute($sql);
		
		//print_r($results);
		
		return $results;
	}	

	public function currentUserForms($userId = null) {
		$reviewCycle = array();
		$return = array();
		$currentCycles = $this->current();
		$currentPropertyCycles = $this->allCurrent(session('property'));
		foreach ($currentPropertyCycles as $cycle){
			//$sql = 'SHOW TABLES FROM `tn2db` LIKE "tnng_'.$this->current().'"';	
			$sql = 'SHOW TABLES FROM '.$this->dbname.' LIKE "tnng_'.$cycle["id"].'"';
			$result = $this->execute($sql);
			if (!empty($result)){
				if ($userId == null || $userId == '0' || $userId == '') {
					$userId = session('user_filter');
					if ($userId == null || $userId == '0' || $userId == '') {
						$userId = session('user');
					}
				}
				$sql = 'SELECT DISTINCT reviewcycle_id, compiledform_id, user_by_id, user_for_id, answer_date FROM #__RC_'.$cycle['id'] . ' WHERE `user_for_id` = ?';
				$results = $this->execute($sql, $userId, false);
				if (!empty($return)){
					foreach($results as $result){
						array_push($return, $result);
					}
				} else {
					$return = $results;
				}
			}
		}
		return $return;
	}

	public function get($value = NULL, $key = 'id', $limit = -1, $propertyId = null) {
		$type = substr(get_class($this), 6);
		$table = PREFIX . $type;
		$vals = array();
		$sql = 'SELECT * FROM `' . $table . '`';
		if (null !== $propertyId) {
			$sql .= 'LEFT JOIN `#__Property_' . $type . '` ON `#__Property_' . $type . '`.`' . strtolower($type) . '_id` = `' . $table . '`.`id`';
		}
		if (NULL !== $key) {
			$sql .= ' WHERE `' . $key.'` = ?';
			$vals[] = $value;
		}
		if (null !== $propertyId) {
			if (null !== $key) {
				$sql .= ' AND';
			} else {
				$sql .= ' WHERE '.$table.'.status = 1 AND';
			}
			$sql .= ' `#__Property_' . $type . '`.`property_id` = ?';
			$vals[] = $propertyId;
		}
		if (NULL !== $key) {
			$sql .= ' ORDER BY `' . $key.'`';
		}
		if ($limit >= 0) {
			$sql .= ' LIMIT 0, ' . $limit;
		}
		//echo $sql;exit;
		$result = $this->execute($sql, $vals);
		$return = array();
		foreach ($result as $item) {
			$newModel = get_model($type);
			$newModel->setAll($item);
			$newModel->id = $item['id'];
			$return[$item['id']] = $newModel;
		}
		return $return;
	}
}
