<?php

function checkUserCredentials($email, $pass) {

	$sql = "SELECT * "
			 ."FROM users "
			 ."WHERE email = '".$email."' "
			 ."AND password = '".$pass."'";

	$result = dbQuery($sql);
	if(is_array($result)) return $result;
	else return false;
}


function usersGetCurrent() {

	$userId = sessionGetVar('currentUserId');
	if($userId == false) return false;
	$user = usersGetOne($userId);
	if($user === null) return false;
	return $user;
}


function usersNewModel() {

	return array(
		'id' => 0,
		'name' => '',
		'logo' => 'default.jpg',
		'deleted' => 0
	);
}


function usersUpdateLastLogin($userId, $lastLoginTime) {
	//die('Last Login: '.$lastLoginTime);
	$sql = "UPDATE users "
			 ."SET lastlogin = ".$lastLoginTime." "
			 ."WHERE id = ".$userId;
			 
	$result = dbCommand($sql);
	return $result;
}


function usersGetAllForDepartment($departmentId) {

	$sql = "SELECT * "
			 ."FROM users "
			 ."WHERE propertydepartments_id = ".$departmentId." "
			 ."AND deleted = 0 "
			 ."ORDER BY lastname, firstname";

	$users = dbArray($sql);
	return $users;
}


function usersGetOne($userId) {

	$sql = "SELECT * "
			 ."FROM users "
			 ."WHERE id = ".$userId." "
			 ."AND deleted = 0";
			 
	$user = dbQuery($sql);
	return $user;
}


function usersAddRecord(array $property) {

	$sql = "INSERT INTO properties "
			 ."VALUES (0,"
			 ."'".$property['name']."',"
			 ."'".$property['logo']."',"
			 ."0)";
			 
	$result = dbCommand($sql);
	return $result;
}


function usersUpdateRecord(array $property) {
	
	$sql = "UPDATE properties "
			 ."SET name = '".$property['name']."',"
			 ."logo = '".$property['logo']."' "
			 ."WHERE id = ".$property['id'];
			 
	$result = dbCommand($sql);
	return $result;
}


function usersSoftDelete($propertyId) {

	$sql = "UPDATE properties "
			 ."SET deleted = 1 "
			 ."WHERE id = ".$propertyId;
			 
	$result = dbCommand($sql);
	return $result;
}