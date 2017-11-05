<?php

// Enable sessions support
session_start();

// Define application root directory
define('APPLICATION_ROOT', __DIR__);

// Load application configuration
$siteConfig = require_once('config.php');

// Load require libraries
require_once(APPLICATION_ROOT.'/library/debug.php');
require_once(APPLICATION_ROOT.'/library/utility.php');
require_once(APPLICATION_ROOT.'/library/http.php');
require_once(APPLICATION_ROOT.'/library/database.php');
require_once(APPLICATION_ROOT.'/library/request.php');
require_once(APPLICATION_ROOT.'/library/security.php');
require_once(APPLICATION_ROOT.'/library/session.php');
require_once(APPLICATION_ROOT.'/library/crypt.php');

// Load common models
utilityLoadModel('users');
utilityLoadModel('properties');
utilityLoadModel('divisions');
utilityLoadModel('departments');

// Bootstrap the application
$dbConn = dbConnect($siteConfig['db']);
$pageController = requestGetNextVar();
$templateVars = array();

// Configure common template variables
$templateVars['siteTitle'] = $siteConfig['site']['title'];
$templateVars['siteLogo'] = propertiesGetCurrentLogo();
if(userIsLoggedIn()) {
	$templateVars['loggedInUser'] = usersGetOne(sessionGetVar('userId'));
	$templateVars['currentPropertyId'] = sessionGetVar('currentPropertyId');
	$templateVars['currentDivisionId'] = sessionGetVar('currentDivisionId');
	$templateVars['currentDepartmentId'] = sessionGetVar('currentDepartmentId');
	$templateVars['currentUserId'] = sessionGetVar('currentUserId');
	$templateVars['properties'] = propertiesGetAll();
	$templateVars['divisions'] = divisionsGetAllForProperty(sessionGetVar('currentPropertyId'));
	$templateVars['departments'] = departmentsGetAllForDivision(sessionGetVar('currentDivisionId'));
	$templateVars['users'] = usersGetAllForDepartment(sessionGetVar('currentDepartmentId'));
}

// Debug output
dump($_SESSION, 'Session');
//echo 'Logo = '.$templateVars['siteLogo'];
dump($requestStack, 'RequestStack');
//dump($templateVars['currentProperty'], 'Current Property');
//echo md5('Fun4Gl0b1');
$hash = Crypt::hashString('Fun4Gl0b1');
$checked = Crypt::checkHashedString('Fun4Gl0b1', $hash);
echo "<pre>$hash (".strlen($hash).") === $checked</pre>";

// Load requested controller
if(securityControllerCheck($pageController, $siteConfig['site']['home']) == true) {
	// Load and execute requested controller
	include(APPLICATION_ROOT.'/controller/'.$pageController.'.php');
	// Load and compile site template
	include(APPLICATION_ROOT.'/template/'.$siteConfig['site']['template'].'.php');
}
