<?php


// Include required libraries
require_once('library/validation.php');
require_once('model/users.php');


// Set page variables
$pageViewTemplate = 'login';
$templateVars['pageTitle'] = 'Login';


// Login form was submitted
if(!empty($_POST) && isset($_POST['loginForm'])) {

	// Populate form data
	$loginFormEmail = $_POST['email'];
	$loginFormPassword = $_POST['password'];

	// Validate form data
	$loginFormValid = true;
	if(isValidEmailAddress($loginFormEmail) == false) {
		$loginFormEmailError = 'Please enter a valid email address';
		$loginFormValid = false;
	}
	if(empty($loginFormPassword)) {
		$loginFormPasswordError = "Please enter a password";
		$loginFormValid = false;
	}

	// Validate user credentials
	// Login if valid
	if($loginFormValid == true) {
		$validUser = checkUserCredentials($loginFormEmail, md5($loginFormPassword));
		if($validUser != false)
		{
			sessionSetVar('loggedIn', 1);
			sessionSetVar('userId', $validUser['id']);
			sessionSetVar('currentUserId', $validUser['id']);
			sessionSetVar('currentPropertyId', $validUser['properties_id']);
			$division = divisionsGetFirstForProperty(sessionGetVar('currentPropertyId'));
			sessionSetVar('currentDivisionId', $division === null ? 0 : $division['id']);
			$department = departmentsGetFirstForDivision(sessionGetVar('currentDivisionId'));
			sessionSetVar('currentDepartmentId', $department === null ? 0 : $department['id']);
			usersUpdateLastLogin($validUser['id'], time());
			jumpToPage($homePage);
		} 
		else 
		{
			$loginFormError = 'Please enter a valid email address and password to login';
		}
	}
}
