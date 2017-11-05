<?php

require_once('library/database.php');


function propertiesGetNewModel() {

	return array(
		'id' => 0,
		'name' => '',
		'logo' => 'default.jpg',
		'deleted' => 0
	);
}


function propertiesGetCurrent() {

	$propertyId = sessionGetVar('currentPropertyId');
	if($propertyId === false) return false;
	$property = propertiesGetOne($propertyId);
	if($property === null) return false;
	return $property;
}


function propertiesGetCurrentLogo() {

	$propertyId = sessionGetVar('currentPropertyId');
	if($propertyId === false) $propertyId = 0;
	$property = propertiesGetOne($propertyId);
	return $property['logo'];
}


function propertiesGetFirst() {

	$sql = "SELECT * "
			 ."FROM properties "
			 ."WHERE deleted = 0 "
			 ."ORDER BY name "
			 ."LIMIT 1";
			 
	$property = dbQuery($sql);
	return $property;
}


function propertiesGetAll() {

	$sql = "SELECT * "
			 ."FROM properties "
			 ."WHERE deleted = 0 "
			 ."ORDER BY name";

	$properties = dbArray($sql);
	return $properties;
}


function propertiesGetOne($propertyId) {

	$sql = "SELECT * "
			 ."FROM properties "
			 ."WHERE id = ".$propertyId." "
			 ."AND deleted = 0";
			 
	$property = dbQuery($sql);
	return $property;
}


function propertiesAddRecord(array $property) {

	$sql = "INSERT INTO properties "
			 ."VALUES (0,"
			 ."'".$property['name']."',"
			 ."'".$property['logo']."',"
			 ."0)";
			 
	$result = dbCommand($sql);
	return $result;
}


function propertiesUpdateRecord(array $property) {
	
	$sql = "UPDATE properties "
			 ."SET name = '".$property['name']."',"
			 ."logo = '".$property['logo']."' "
			 ."WHERE id = ".$property['id'];
			 
	$result = dbCommand($sql);
	return $result;
}


function propertiesSoftDelete($propertyId) {

	$sql = "UPDATE properties "
			 ."SET deleted = 1 "
			 ."WHERE id = ".$propertyId;
			 
	$result = dbCommand($sql);
	return $result;
}