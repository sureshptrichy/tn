<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Folder model.
 *
 * @package    truenorthng
 */

final class Model_Folder extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'property_id' => NULL,
			'division_id' => NULL,
			'status' => 1,
			'name' => NULL,
			'path' => NULL,
			'mime' => NULL,
			'cid' => NULL
		);
	}

	public function getFiles($propertyId = NULL, $divisionId = NULL){
		$params = array();
		$return = array();
		$sql = 'SELECT * FROM `#__Toolbox` LEFT JOIN `#__Folder` ON `#__Folder`.`template_id` = `#__Toolbox`.`id` WHERE `#__Toolbox`.`status` = 1 ';
		if ($divisionId != ''){
			$sql .= 'AND `#__Folder`.`property_id` = ? AND `#__Folder`.`division_id` = ?';
			$params = array($propertyId, $divisionId);
		} elseif ($divisionId == '' && $propertyId != ''){
			$sql .= 'AND `#__Folder`.`property_id` = ? AND `#__Folder`.`division_id` = ""';
			$params = array($propertyId);
		}
		$sql .= ' ORDER BY `#__Toolbox`.`aid` ASC' ;
		$result = $this->execute($sql, $params);
		foreach ($result as $templates){
			$return[$templates['id']] = $templates;
		}
		return $return;
	}
	
	public function getPropertyName($propertyId) {
		$return = NULL;
		$sql = 'SELECT `#__Property`.`id`,`#__Property`.`name` FROM `#__Property` WHERE `#__Property`.`id` = ?';
		$result = $this->execute($sql, $propertyId);
		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}
	public function getDivisionName($divisionId) {
		$return = NULL;
		$sql = 'SELECT `#__Division`.`id`,`#__Division`.`name` FROM `#__Division` WHERE `#__Division`.`id` = ?';
		$result = $this->execute($sql, $divisionId);
		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}
	public function getDepartmentName($departmentId) {
		$return = NULL;
		$sql = 'SELECT `#__Department`.`id`,`#__Department`.`name` FROM `#__Department` WHERE `#__Department`.`id` = ?';
		$result = $this->execute($sql, $departmentId);
		if (count($result) > 0) {
			$return[$result[0]['id']] = $result[0];
		}
		return $return;
	}

	public function getDivisions($propertyId = 0) {
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
		$sql = 'SELECT `#__Division`.*, `#__Property`.`name` AS `property_name` FROM `#__Division`, `#__Property`, `#__Property_Division` WHERE ((`#__Division`.`status` = 1 AND `#__Property`.`status` = 1 AND `#__Property`.`id` = ?) OR (`#__Division`.`default` = 1)) AND `#__Property_Division`.`property_id` = `#__Property`.`id` AND `#__Division`.`id` = `#__Property_Division`.`division_id` GROUP BY `#__Division`.`name` ORDER BY `property_name`, `#__Division`.`name`';
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
	public function getDepartments($divisionId = 0, $propertyId = 0) {
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
}
