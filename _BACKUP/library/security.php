<?php

/**
 * Function checks session to see if current
 * user is validly logged in to the site
 */
function userIsLoggedIn() {
	
	if(sessionGetVar('loggedIn') === 1) return true;
	else false;
}

/**
 * Function checks is logged in user has read
 * access to the currently requested page.
 */
function userHasAccessToPage($page) {

	//if($page == 'dashboard') return true;
	return true;
	
	return false;	
}

/**
 * Function checks to make sure that the
 * file for the requested page actually 
 * exists to ensure a valid page it being
 * requested.
 */
function pageExists($page) {

	// Does requested page's .php file exist in the pages directory
	if(file_exists('controller/'.$page.'.php')) return true;
	else return false;	
}

/**
 * Function checks the sanity and security of the currently requested
 * page. If prevents people from accessing pages that do not exist or
 * they do not have access to or do not need to have access to based 
 * on the current state of the application (ie. Logged in or Logged 
 * out). If all sanity and security checks pass function will 
 * return true.
 */
function securityControllerCheck($controller, $homePage) {

	// User already logged in
	if(userIsLoggedIn()) {
		
		// User tries to access the login page and is
		// automatically redirected to the home page
		if($controller == 'login') jumpToPage($homePage);

		// User tries to access with just a / or nothing at all
		// and is automatically redirected to the home page
		if($controller == null) jumpToPage($homePage);

		// User tries to access a page that does not exist and
		// is automatically redirected back to the home page
		if(pageExists($controller) == false) jumpToPage($homePage);
		
		// User tries to access a page they do not have read access
		// to and is automatically redirected back to the home page
		if(userHasAccessToPage($controller) == false) jumpToPage($homePage);  
	}
	
	// User is not logged in
	else {

		// User tries to access any page other than login page 
		// and is automatically redirected back to login page
		if($controller != 'login')	jumpToPage('login');
	}
	
	// Request is ok
	return true;
}
