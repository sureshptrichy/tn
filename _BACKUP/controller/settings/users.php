<?php


utilityLoadModel('users');
utilityLoadModel('accesslevels');


/**
  * View details of an existing user
  */
function actionViewUser($templateVars) {

	$currentUser = usersGetCurrent();
	$currentUser['accessLevelDescription'] = accessLevelsGetDescription($currentUser['accesslevels_id']);
	$templateVars['currentUser'] = $currentUser;

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
  * Add a new user
  */
function actionAddUser($templateVars) {

	$property = propertiesNewModel();

	if(!empty($_POST) && isset($_POST['newPropertyForm'])) {

		$validForm = true;

		$property['name'] = $_POST['name'];
		if(empty($property['name'])) {
			$templateVars['nameError'] = 'Please enter a name for this property';
			$validForm = false;
		}

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
			redirectToPage('settings/properties/listing');
		}

	}

	$templateVars['property'] = $property;

	return $templateVars;
}


/**
  * Edit details of an existing user
  */
function actionEditUser($templateVars) {

	$currentProperty = propertiesGetCurrent();
	$currentDivision = divisionsGetCurrent();
	$currentDepartment = departmentsGetCurrent();
	$currentUser = usersGetCurrent();
	
	if(!empty($_POST) && isset($_POST['editPropertyForm'])) {
		
		$validForm = true;

		$currentUser['firstname'] = $_POST['firstname'];
		if(empty($currentUser['firstname'])) {
			$templateVars['userFirstnameError'] = 'Please enter a first name for this user';
			$validForm = false;
		}

		$currentUser['lastname'] = $_POST['lastname'];
		if(empty($currentUser['lastname'])) {
			$templateVars['userLastnameError'] = 'Please enter a last name for this user';
			$validForm = false;
		}

		$currentUser['email'] = $_POST['emailname'];
		if(empty($currentUser['email'])) {
			$templateVars['userEmailError'] = 'Please enter an email for this user';
			$validForm = false;
		}

		if($validForm == true) {
			$property['name'] = $newPropertyName;
			propertiesUpdateRecord($property);
			redirectToPage('settings/properties/listing');
		}
	}

	$templateVars['accessLevels'] = accessLevelsGetAll();
	$templateVars['currentProperty'] = $currentProperty;
	$templateVars['currentDivision'] = $currentDivision;
	$templateVars['currentDepartment'] = $currentDepartment;
	$templateVars['currentUser'] = $currentUser;

	return $templateVars;
}


/**
  * Soft delete an existing user
  */
function actionDeleteUser($templateVars) {

	$currentUser = usersGetCurrent();
	$currentUser['accessLevelDescription'] = accessLevelsGetDescription($currentUser['accesslevels_id']);
	$templateVars['currentUser'] = $currentUser;

	$currentProperty = propertiesGetCurrent();
	$templateVars['currentProperty'] = $currentProperty;

	$currentDivision = divisionsGetCurrent();
	if($currentDivision == false) $templateVars['currentDivision'] = false;
	else $templateVars['currentDivision'] = $currentDivision;

	$currentDepartment = departmentsGetCurrent();
	if($currentDepartment == false) $templateVars['currentDepartment'] = false; 
	else $templateVars['currentDepartment'] = $currentDepartment;

	if($currentUser['id'] == sessionGetVar('loggedIn')) $templateVars['formError'] = 'Cannot delete the currently logged in user.';
	else {
		if(!empty($_POST) && isset($_POST['deleteUserForm'])) {
			usersSoftDelete($currentUser['id']);
			redirectToPage('settings/users/view');
		}
	}

	return $templateVars;
}


/**
  * Branch based on requested page action
  */
$pageAction = requestGetNextVar();

switch($pageAction) {

	case 'delete':
		$templateVars = actionDeleteUser($templateVars);
		$templateVars['pageTitle'] = 'Delete User';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/userdelete';
		break;

	case 'edit':
		$templateVars = actionEditUser($templateVars);
		$templateVars['pageTitle'] = 'Edit User';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/useredit';
		break;

	case 'new':
		$templateVars = actionAddUser($templateVars);
		$templateVars['pageTitle'] = 'New User';
		$sidebarTemplate = 'blank';
		$pageViewTemplate = 'settings/usernew';
		break;

	case 'view':
		$templateVars = actionViewUser($templateVars);
		$templateVars['pageTitle'] = 'View User';
		$sidebarTemplate = 'newuser';
		$pageViewTemplate = 'settings/userview';
		break;

	default:
		jumpToPage('settings/users/view');

}
