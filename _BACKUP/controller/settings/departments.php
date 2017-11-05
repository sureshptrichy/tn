<?php

utilityLoadModel('properties');
utilityLoadModel('divisions');
utilityLoadModel('departments');

/**
  * View details of a department
  */
function actionViewDepartment($templateVars) {
	
	$currentProperty = propertiesGetCurrent();
	$templateVars['currentProperty'] = $currentProperty;
	$currentDivision = divisionsGetCurrent();
	if($currentDivision == false) $templateVars['currentDivision'] = false;
	else $templateVars['currentDivision'] = $currentDivision;
	$currentDepartment = departmentsGetCurrent();
	if($currentDepartment == false) $templateVars['currentDepartment'] = false; 
	else $templateVars['currentDepartment'] = $currentDepartment;
	return $templateVars;
}


/**
  * Add a new department
  */
function actionAddDepartment($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	$newDepartment = departmentsGetNewModel();
	if(!empty($_POST) && isset($_POST['newDepartmentForm'])) {
		$validForm = true;
		$newDepartment['name'] = $_POST['name'];
		if(empty($newDepartment['name'])) {
			$templateVars['departmentNameError'] = 'Please enter a name for this department';
			$validForm = false;
		}
		if($validForm == true) {
			$newDepartment['propertydivisions_id'] = $currentDivision['id'];
			departmentsAddRecord($newDepartment);
			$newDepartment['id'] = dbLastId();
			sessionSetVar('currentDepartmentId', $newDepartment['id']);
			jumpToPage('settings/departments/view');
		}
	}
	$templateVars['currentProperty'] = $currentProperty;
	$templateVars['currentDivision'] = $currentDivision;
	return $templateVars;
}


/**
  * Edit details of an existing department
  */
function actionEditDepartment($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	$currentDepartment = departmentsGetCurrent();

	if(!empty($_POST) && isset($_POST['editDepartmentForm'])) {
		$validForm = true;
		$currentDepartment['name'] = $_POST['name'];
		if(empty($currentDepartment['name'])) {
			$templateVars['departmentNameError'] = 'Please enter a name for this department';
			$validForm = false;
		}
		if($validForm == true) {
			departmentsUpdateRecord($currentDepartment);
			jumpToPage('settings/departments/view');
		}
	}
	$templateVars['currentProperty'] = $currentProperty;
	$templateVars['currentDivision'] = $currentDivision;
	$templateVars['currentDepartment'] = $currentDepartment;
	return $templateVars;
}


/**
  * Soft delete an existing department
  */
function actionDeleteDepartment($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	$currentDepartment = departmentsGetCurrent();
	
	if(!empty($_POST) && isset($_POST['deleteDepartmentForm'])) {
		departmentsSoftDelete($currentDepartment['id']);
		$department = departmentsGetFirstForDivision($currentDivision['id']);
		sessionSetVar('currentDepartmentId', $department['id']);
		jumpToPage('settings/departments/view');
	}
	$templateVars['currentDivision'] = $currentDivision;
	$templateVars['currentProperty'] = $currentProperty;
	$templateVars['currentDepartment'] = $currentDepartment;
	return $templateVars;
}


/**
  * Branch based on requested page action
  */
$pageAction = requestGetNextVar();
switch($pageAction) {
	case 'delete':
		$templateVars = actionDeleteDepartment($templateVars);
		$templateVars['pageTitle'] = 'Delete Department';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/departmentdelete';
		break;
	case 'edit':
		$templateVars = actionEditDepartment($templateVars);
		$templateVars['pageTitle'] = 'Edit Department';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/departmentedit';
		break;
	case 'new':
		$templateVars = actionAddDepartment($templateVars);
		$templateVars['pageTitle'] = 'New Department';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/departmentnew';
		break;
	case 'view':
		$templateVars = actionViewDepartment($templateVars);
		$templateVars['pageTitle'] = 'View Department';
		$sidebarTemplate = 'newdepartment';
		$pageViewTemplate = 'settings/departmentview';
		break;
	default:
		jumpToPage('settings/departments/view');
}
