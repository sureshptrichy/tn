<?php

require_once('library/database.php');


function departmentsGetNewModel() {

	return array(
		'id' => 0,
		'propertydivisions_id' => 0,
		'name' => '',
		'deleted' => 0
	);
}


function departmentsGetCurrent() {

	$departmentId = sessionGetVar('currentDepartmentId');
	if($departmentId == false) return false;
	$department = departmentsGetOne($departmentId);
	if($department === null) return false;
	return $department;
}


function departmentsGetFirstForDivision($divisionId) {

	$sql = "SELECT * "
			 ."FROM propertydepartments "
			 ."WHERE propertydivisions_id = ".$divisionId." " 
			 ."AND deleted = 0 "
			 ."ORDER BY name "
			 ."LIMIT 1";
			 
	$department = dbQuery($sql);
	return $department;
}


function departmentsGetAllForDivision($divisionId) {

	$sql = "SELECT * "
			 ."FROM propertydepartments "
			 ."WHERE propertydivisions_id = ".$divisionId." "
			 ."AND deleted = 0 "
			 ."ORDER BY name";

	$divisions = dbArray($sql);
	return $divisions;
}


function departmentsGetOne($departmentId) {

	$sql = "SELECT * "
			 ."FROM propertydepartments "
			 ."WHERE id = ".$departmentId." "
			 ."AND deleted = 0";
			 
	$department = dbQuery($sql);
	return $department;
}


function departmentsAddRecord(array $department) {

	$sql = "INSERT INTO propertydepartments "
			 ."VALUES (0,"
			 .$department['propertydivisions_id'].","
			 ."'".$department['name']."',"
			 ."0)";
			 
	$result = dbCommand($sql);
	return $result;
}


function departmentsUpdateRecord(array $department) {

	$sql = "UPDATE propertydepartments "
			 ."SET name = '".$department['name']."' "
			 ."WHERE id = ".$department['id'];
			 
	$result = dbCommand($sql);
	return $result;
}


function departmentsSoftDelete($departmentId) {

	$sql = "UPDATE propertydepartments "
			 ."SET deleted = 1 "
			 ."WHERE id = ".$departmentId;
			 
	$result = dbCommand($sql);
	return $result;
}