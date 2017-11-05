<?php

function actionSetCurrentProperty() {

	if(userIsLoggedIn()) {
		utilityLoadModel('divisions');
		utilityLoadModel('departments');
		$propertyId = requestGetParameter(1);
		sessionSetVar('currentPropertyId', $propertyId);
		$division = divisionsGetFirstForProperty($propertyId);
		sessionSetVar('currentDivisionId', $division === null ? 0 : $division['id']);
		$department = departmentsGetFirstForDivision(sessionGetVar('currentDivisionId'));
		sessionSetVar('currentDepartmentId', $department === null ? 0 : $department['id']);
		return true;
	}
}

function actionSetCurrentDivision() {

	if(userIsLoggedIn()) {
		utilityLoadModel('departments');
		$divisionId = requestGetParameter(1);
		sessionSetVar('currentDivisionId', $divisionId);
		$department = departmentsGetFirstForDivision($divisionId);
		sessionSetVar('currentDepartmentId', $department === null ? 0 : $department['id']);
		return true;
	}
}

function actionSetCurrentDepartment () {

	if(userIsLoggedIn()) {
		$departmentId = requestGetParameter(1);
		sessionSetVar('currentDepartmentId', $departmentId);
		return true;
	}
}

$remoteRequest = requestGetNextVar();
switch($remoteRequest) {
	case 'currentproperty':
		$response = actionSetCurrentProperty();
		break;
	case 'currentdivision':
		$response = actionSetCurrentDivision();
		break;
	case 'currentdepartment':
		$response = actionSetCurrentDepartment();
		break;
}