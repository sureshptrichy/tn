<?php

utilityLoadModel('properties');
utilityLoadModel('divisions');


/**
  * View details of a division
  */
function actionViewDivision($templateVars) {
	
	$currentProperty = propertiesGetCurrent();
	$templateVars['currentProperty'] = $currentProperty;
	$currentDivision = divisionsGetCurrent();
	if($currentDivision === false) $templateVars['pageError'] = 'No divisions currently exist for: '.$currentProperty['name'].'.'; 
	else $templateVars['currentDivision'] = $currentDivision;
	return $templateVars;
}


/**
  * Add a new division
  */
function actionAddDivision($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$newDivision = divisionsGetNewModel();
	if(!empty($_POST) && isset($_POST['newDivisionForm'])) {
		$validForm = true;
		$newDivision['name'] = $_POST['name'];
		if(empty($newDivision['name'])) {
			$templateVars['divisionNameError'] = 'Please enter a name for this division';
			$validForm = false;
		}
		if($validForm == true) {
			$newDivision['properties_id'] = $currentProperty['id'];
			divisionsAddRecord($newDivision);
			$newDivision['id'] = dbLastId();
			sessionSetVar('currentDivisionId', $newDivision['id']);
			jumpToPage('settings/divisions/view');
		}
	}
	$templateVars['currentProperty'] = $currentProperty;
	return $templateVars;
}


/**
  * Edit details of an existing division
  */
function actionEditDivision($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	if(!empty($_POST) && isset($_POST['editDivisionForm'])) {
		$validForm = true;
		$currentDivision['name'] = $_POST['name'];
		if(empty($currentDivision['name'])) {
			$templateVars['divisionNameError'] = 'Please enter a name for this property';
			$validForm = false;
		}
		if($validForm == true) {
			divisionsUpdateRecord($currentDivision);
			jumpToPage('settings/divisions/view');
		}
	}
	$templateVars['currentProperty'] = $currentProperty;
	$templateVars['currentDivision'] = $currentDivision;
	return $templateVars;
}


/**
  * Soft delete an existing division
  */
function actionDeleteDivision($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	if(!empty($_POST) && isset($_POST['deleteDivisionForm'])) {
		divisionsSoftDelete($currentDivision['id']);
		$division = divisionsGetFirstForProperty($currentProperty['id']);
		sessionSetVar('currentDivisionId', $division['id']);
		jumpToPage('settings/divisions/view');
	}
	$templateVars['currentDivision'] = $currentDivision;
	$templateVars['currentProperty'] = $currentProperty;
	return $templateVars;
}


/**
  * Branch based on requested page action
  */
$pageAction = requestGetNextVar();
switch($pageAction) {
	case 'delete':
		$templateVars = actionDeleteDivision($templateVars);
		$templateVars['pageTitle'] = 'Delete Division';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/divisiondelete';
		break;
	case 'edit':
		$templateVars = actionEditDivision($templateVars);
		$templateVars['pageTitle'] = 'Edit Division';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/divisionedit';
		break;
	case 'new':
		$templateVars = actionAddDivision($templateVars);
		$templateVars['pageTitle'] = 'New Division';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/divisionnew';
		break;
	case 'view':
		$templateVars = actionViewDivision($templateVars);
		$templateVars['pageTitle'] = 'View Division';
		$sidebarTemplate = 'newdivision';
		$pageViewTemplate = 'settings/divisionview';
		break;
	default:
		jumpToPage('settings/divisions/view');
}
