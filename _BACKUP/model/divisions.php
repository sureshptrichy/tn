<?php

require_once('library/database.php');


function divisionsGetNewModel() {

	return array(
		'id' => 0,
		'properties_id' => 0,
		'name' => '',
		'deleted' => 0
	);
}


function divisionsGetCurrent() {

	$divisionId = sessionGetVar('currentDivisionId');
	if($divisionId === FALSE) return false;
	$division = divisionsGetOne($divisionId);
	if($division === FALSE) return false;
	return $division;
}


function divisionsGetFirstForProperty($propertyId) {

	$sql = "SELECT * "
			 ."FROM propertydivisions "
			 ."WHERE properties_id = ".$propertyId." " 
			 ."AND deleted = 0 "
			 ."ORDER BY name "
			 ."LIMIT 1";
			 
	$property = dbQuery($sql);
	return $property;
}


function divisionsGetAllForProperty($propertyId) {

	$sql = "SELECT * "
			 ."FROM propertydivisions "
			 ."WHERE properties_id = ".$propertyId." "
			 ."AND deleted = 0 "
			 ."ORDER BY name";

	$divisions = dbArray($sql);
	return $divisions;
}


function divisionsGetOne($divisionId) {

	$sql = "SELECT * "
			 ."FROM propertydivisions "
			 ."WHERE id = ".$divisionId." "
			 ."AND deleted = 0";
			 
	$property = dbQuery($sql);
	return $property;
}


function divisionsAddRecord(array $division) {

	$sql = "INSERT INTO propertydivisions "
			 ."VALUES (0,"
			 .$division['properties_id'].","
			 ."'".$division['name']."',"
			 ."0)";
			 
	$result = dbCommand($sql);
	return $result;
}


function divisionsUpdateRecord(array $division) {
	
	$sql = "UPDATE propertydivisions "
			 ."SET name = '".$division['name']."' "
			 ."WHERE id = ".$division['id'];
			 
	$result = dbCommand($sql);
	return $result;
}


function divisionsSoftDelete($divisionId) {

	$sql = "UPDATE propertydivisions "
			 ."SET deleted = 1 "
			 ."WHERE id = ".$divisionId;
			 
	$result = dbCommand($sql);
	return $result;
}