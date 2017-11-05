<?php

function accessLevelsGetAll() {

	$sql = "SELECT * "
			 ."FROM accesslevels "
			 ."ORDER BY description";

	$accessLevels = dbArray($sql);
	return $accessLevels;
}

function accessLevelsGetDescription($accessLevelId) {

	$sql = "SELECT description "
			 ."FROM accesslevels "
			 ."WHERE id = ".$accessLevelId;

	$description = dbQuery($sql);
	return $description;
}