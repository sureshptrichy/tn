<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Template model.
 *
 * @package    truenorthng
 */

final class Model_Templates extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'name' => NULL,
			'description' => NULL,
			'path' => NULL,
			'mime' => NULL,
			'cid' => NULL
		);
	}
	
	public function getNorthviewTemplates(){
		$return = array();
		$sql = 'SELECT * FROM `#__Templates` LEFT JOIN `#__Northview_Templates` ON `#__Northview_Templates`.`template_id` = `#__Templates`.`id` WHERE `#__Templates`.`status` = 1 AND `#__Northview_Templates`.`template_id` = `#__Templates`.`id` ORDER BY `#__Templates`.`aid` ASC' ;
		$result = $this->execute($sql);
		foreach ($result as $templates){
			$return[$templates['id']] = $templates;
		}
		return $return;
	}
	
	public function getPropertyTemplates($propertyId = NULL){
		$return = array();
		$sql = 'SELECT * FROM `#__Templates` LEFT JOIN `#__Property_Templates` ON `#__Property_Templates`.`template_id` = `#__Templates`.`id` WHERE `#__Templates`.`status` = 1 AND `#__Property_Templates`.`property_id` = ? ORDER BY `#__Templates`.`aid` ASC' ;
		$result = $this->execute($sql, $propertyId);
		foreach ($result as $templates){
			$return[$templates['id']] = $templates;
		}
		return $return;
	}
	
	public function getDivisionTemplates($divisionId = NULL){
		$return = array();
		$sql = 'SELECT * FROM `#__Templates` LEFT JOIN `#__Division_Templates` ON `#__Division_Templates`.`template_id` = `#__Templates`.`id` WHERE `#__Templates`.`status` = 1 AND `#__Division_Templates`.`division_id` = ? ORDER BY `#__Templates`.`aid` ASC' ;
		$result = $this->execute($sql, $divisionId);
		foreach ($result as $templates){
			$return[$templates['id']] = $templates;
		}
		return $return;
	}
	
	public function getDepartmentTemplates($departmentId = NULL){
		$return = array();
		$sql = 'SELECT * FROM `#__Templates` LEFT JOIN `#__Department_Templates` ON `#__Department_Templates`.`template_id` = `#__Templates`.`id` WHERE `#__Templates`.`status` = 1 AND `#__Department_Templates`.`department_id` = ? ORDER BY `#__Templates`.`aid` ASC' ;
		$result = $this->execute($sql, $departmentId);
		foreach ($result as $templates){
			$return[$templates['id']] = $templates;
		}
		return $return;
	}
	
	public function getScope ($template_id){
		$sql = 'SELECT * FROM `#__Templates` LEFT JOIN `#__Property_Templates` ON `#__Property_Templates`.`template_id` = `#__Templates`.`id` LEFT JOIN `#__Division_Templates` ON `#__Division_Templates`.`template_id` = `#__Templates`.`id` LEFT JOIN `#__Department_Templates` ON `#__Department_Templates`.`template_id` = `#__Templates`.`id` WHERE `#__Templates`.`status` = 1 AND `#__Templates`.`id` = ? ORDER BY `#__Templates`.`aid` ASC' ;
		$result = $this->execute($sql, $template_id);
		if (!empty($result)){
			if ($result[0]['property_id'] != '') {
				return 'property';
			} elseif ($result[0]['division_id'] != '') {
				return 'division';
			} elseif ($result[0]['department_id'] != '') {
				return 'department';
			} else {
				return 'northview';
			}
		}
	}

	public function removeScope($template_id) {
		$this->delete($template_id, 'template_id', '#__Northview_Templates');
		$this->delete($template_id, 'template_id', '#__Property_Templates');
		$this->delete($template_id, 'template_id', '#__Division_Templates');
		$this->delete($template_id, 'template_id', '#__Department_Templates');
	}
	
	public function addScope($template_id, $scope, $scope_id = NULL) {
		if ($scope == 'northview'){
			$sql = "INSERT INTO `#__Northview_Templates` (`template_id`) VALUES (?)";
		} elseif ($scope == 'property'){
			$sql = "INSERT INTO `#__Property_Templates` (`template_id`, `property_id`) VALUES (?, ?)";
		} elseif ($scope == 'division'){
			$sql = "INSERT INTO `#__Division_Templates` (`template_id`, `division_id`) VALUES (?, ?)";
		} elseif ($scope == 'department'){
			$sql = "INSERT INTO `#__Department_Templates` (`template_id`, `department_id`) VALUES (?, ?)";
		}
		if ($scope == 'northview'){
			$params = array($template_id);
		} else {
			$params = array($template_id, $scope_id);
		}
		$this->execute($sql, $params);
	}	
}
