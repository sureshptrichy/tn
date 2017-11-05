<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Review cycle model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Hourlyreviewform extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'property_id' => NULL, 
			'property_name' => NULL, 
			'created_on' => NULL,
			'status' => 1,
			'hourly_name' => NULL,
			'hourly_department' => NULL,
			'hourly_division' => NULL,
			'hourly_position' => NULL,
			'manager_id' => NULL,
			'manager_name' => NULL, 
			'reviewform_id' => NULL,
			'reviewform_name' => NULL,
			'reviewform_code' => NULL,
			'review_cycle' => NULL,
			'last_review_date' => NULL,
			'current_rate' => NULL,
			'hourly_cycle_id' => NULL, 
			'property_id' => NULL,
			'hire_date' => NULL,
			'position_date' => NULL,
			'seniority_date' => NULL,
			'status' => NULL,
			'answer' => NULL,
			'created' => NULL,
			'completed_on' => 0,
			'cid' => NULL
		);
	}

	public function get($value = NULL, $key = 'id', $limit = -1, $propertyId = null) {
		$type = substr(get_class($this), 6);
		$table = PREFIX . $type;
		$vals = array();
		$sql = 'SELECT * FROM `' . $table . '` WHERE property_id = "' . $propertyId . '"';
		
		if (NULL !== $key) {
			$sql .= ' ORDER BY `' . $key.'`';
		}
		if ($limit >= 0) {
			$sql .= ' LIMIT 0, ' . $limit;
		}
		//echo $sql; exit;
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
	
	public function getFormsofHourlyCycle($hourly_cycle_id = null) {
		$type = substr(get_class($this), 6);
		$table = PREFIX . $type;
		$vals = array();
		$sql = 'SELECT * FROM `' . $table . '` WHERE hourly_cycle_id = "' . $hourly_cycle_id . '"';
		
		//echo $sql; exit;
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
	
	public function currentForms($userId = null, $propertyId = null) {
		$type = substr(get_class($this), 6);
		$table = PREFIX . $type;
		$vals = array();
		$sql = 'SELECT * FROM `' . $table . '` WHERE manager_id = "' . $userId . '" AND property_id = "' . $propertyId . '" AND  status != 2 ORDER BY aid ASC';
		
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
	
	public function removeForms($cycle_id) {
		if(!$cycle_id) return;
		
		$type = substr(get_class($this), 6);
		$table = PREFIX . $type;
		$vals = array();
		$sql = 'DELETE FROM `' . $table . '` WHERE hourly_cycle_id = "' . $cycle_id . '"';
		
		//echo $sql; exit;
		$result = $this->execute($sql, $vals);
		
	}
}
