<?php

utilityLoadModel('properties');


/**
  * View details of a property
  */
function actionViewProperty($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$templateVars['currentProperty'] = $currentProperty;
	return $templateVars;
}


/**
  * Add a new property
  */
function actionAddProperty($templateVars) {

	$property = propertiesGetNewModel();
	if(!empty($_POST) && isset($_POST['newPropertyForm'])) {
		$validForm = true;
		$property['name'] = $_POST['name'];
		if(empty($property['name'])) {
			$templateVars['nameError'] = 'Please enter a name for this property';
			$validForm = false;
		}
		dump($_FILES, 'Files');
		if(empty($_FILES['logo']['name'])) {
			$templateVars['logoError'] = 'Please include a logo for for this property';
			$validForm = false;
		}
		else {
			$newLogo = $_FILES['logo']['name'];
			$newLogoTemp = $_FILES['logo']['tmp_name'];
			$newLogoType = $_FILES['logo']['type'];
			if(!in_array($newLogoType, $siteConfig['validLogoTypes'])) {
				$templateVars['logoError'] = 'Supported logo types are JPEG, GIF or PNG';
				$validForm = false;
			}
		}
		if($validForm == true) {
			propertiesAddRecord($property);
			$property['id'] = dbLastId();
			$property['logo'] = generateLogoFilename($property['id'], $newLogo);
			//move_uploaded_file($newLogoTemp, APPLICATION_DIR.'/images/logos/'.$property['logo']);
			propertiesUpdateRecord($property);
			sessionSetVar('currentPropertyId', $property['id']);
			jumpToPage('settings/properties/listing');
		}
	}
	$templateVars['property'] = $property;
	return $templateVars;
}


/**
  * Edit details of an existing property
  */
function actionEditProperty($templateVars) {

	$propertyId = sessionGetVar('currentPropertyId');
	$property = propertiesGetOne($propertyId);
	if($property == null) 	$templateVars['formError'] = 'Unknown Property Id: '.$propertyId;
	else {
		if(!empty($_POST) && isset($_POST['editPropertyForm'])) {
			$validForm = true;
			$newPropertyName = $_POST['name'];
			if(empty($newPropertyName)) {
				$templateVars['nameError'] = 'Please enter a name for this property';
				$validForm = false;
			}
			if(!empty($_FILES['logo']['name'])) {
				$newLogo = $_FILES['logo']['name'];
				$newLogoTemp = $_FILES['logo']['tmp_name'];
				$newLogoType = $_FILES['logo']['type'];
				if(!in_array($newLogoType, $siteConfig['validLogoTypes'])) {
					$templateVars['logoError'] = 'Supported logo types are JPEG, GIF or PNG';
					$validForm = false;
				}
			}
			if($validForm == true) {
				if(!empty($_FILES['logo']['name'])) { 
					$property['logo'] = generateLogoFilename($property['id'], $newLogo);
					//move_uploaded_file($newLogoTemp, APPLICATION_DIR.'/images/logos/'.$property['logo']);
				}
				$property['name'] = $newPropertyName;
				propertiesUpdateRecord($property);
				jumpToPage('settings/properties/view');
			}
		}
		$templateVars['property'] = $property;
	}
	return $templateVars;
}


/**
  * Soft delete an existing property
  */
function actionDeleteProperty($templateVars) {

	$propertyId = sessionGetVar('currentPropertyId');
	$property = propertiesGetOne($propertyId);
	if($property == null) 	$templateVars['formError'] = 'Unknown Property Id: '.$propertyId;
	else {
		if(!empty($_POST) && isset($_POST['deletePropertyId'])) {
			if($property['id'] == $_POST['deletePropertyId']) {
				propertiesSoftDelete($property['id']);
				$property = propertiesGetFirst();
				sessionSetVar('currentPropertyId', $property['id']);
				jumpToPage('settings/properties/view');
			}
		}
		$templateVars['property'] = $property;
	}
	return $templateVars;
}


/**
  * Generate logo filename using property id and uploaded file extension
  */
function generateLogoFilename($id, $filename) {

	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	$logoFilename = $id.'.'.$extension;
	return $logoFilename;
}


/**
  * Branch based on requested page action
  */
$pageAction = requestGetNextVar();
switch($pageAction) {
	case 'delete':
		$templateVars = actionDeleteProperty($templateVars);
		$templateVars['pageTitle'] = 'Delete Property';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/propertydelete';
		break;
	case 'edit':
		$templateVars = actionEditProperty($templateVars);
		$templateVars['pageTitle'] = 'Edit Property';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/propertyedit';
		break;
	case 'new':
		$templateVars = actionAddProperty($templateVars);
		$templateVars['pageTitle'] = 'New Property';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/propertynew';
		break;
	case 'view':
		$templateVars = actionViewProperty($templateVars);
		$templateVars['pageTitle'] = 'View Property';
		$sidebarTemplate = 'newproperty';
		$pageViewTemplate = 'settings/propertyview';
		break;
	default:
		jumpToPage('settings/properties/view');
}
