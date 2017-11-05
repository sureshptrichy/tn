<?php
/**
 * True North
 *
 * @version 1.0.0
 * @package truenorthng
 */

// Set the default timezone to avoid TZ confusion.
date_default_timezone_set('UTC');

/**
 * Shortcut for the platform-specific directory separator.
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Path to the True North application.
 */
define('SYSTEM_PATH', dirname($_SERVER["SCRIPT_FILENAME"]) . DS);

// Load needed system constants.
require(SYSTEM_PATH . 'constants.php');

// Load handlers.
require(HANDLER_PATH . 'errors.php');
require(HANDLER_PATH . 'log.php');

// Load interfaces.
require(INTERFACE_PATH . 'database.php');

// Load libraries.
require(LIB_PATH . 'multibyte.php');
require(LIB_PATH . 'functions.php');
require(LIB_PATH . 'filters.php');
require(LIB_PATH . 'security.php');
require(LIB_PATH . 'crypt.php');
require(LIB_PATH . 'database.php');
require(LIB_PATH . 'g.php');
require(LIB_PATH . 'calendar/calendar.php');
require(LIB_PATH . 'parsedown.php');
require(LIB_PATH . 'wrappers.php');

// Load Classes.
require(CLASS_PATH . 'Object.php');
require(CLASS_PATH . 'Controller.php');
require(CLASS_PATH . 'Form.php');
require(CLASS_PATH . 'Model.php');

// Setup the error and exception handlers.
set_error_handler('error_handler');
set_exception_handler('exception_handler');
	
// Load configuration information that might change occasionally.
require(SYSTEM_PATH . DS. 'environments' . DS. getEnvironment() . DS . 'config.php');

// Make sure errors are displayed on-screen during development.
if (DEBUG) {
	ini_set('display_errors', 1);
}

// The only global we should use! It's a naive registry!
$G = new G();

// The UNIX timestamp when page execution began.
$G->timerStart = microtime(TRUE);

// Instantiate the database class.
$G->db = Database::create($G, DBTYPE);

/**
 * Database connection ID for read-only access.
 */
define('DB1', $G->db->newConnection(
	$dbconfig['host'],
	$dbconfig['user'],
	$dbconfig['pass'],
	$dbconfig['name'],
	$dbconfig['port'])
);

// Set the current database connection to read-only.
$G->db->setActiveConnection(DB1);

// Load the site-wide settings and options and store them in the Registry.
$G->bootstrap();

// Set the headers.
setHeader('Server: ');
setHeader('X-Powered-By: TrueNorthNG v' . VERSION . '.' . (int)$G->revision);
//setHeader('X-UA-Compatible: IE=edge,chrome=1');

//echo URL;exit;
/**
 * Basic URL class.
 */
$G->setObject('url', URL);

// Blast the request early if it's for one of the reserved folders.
if (substr($G->url->getUrl(), 0, strlen(VIEW_URL)) == VIEW_URL || substr($G->url->getUrl(), 0, strlen(UPLOAD_URL)) == UPLOAD_URL) {
	// Show a 404.
	//Log::write('FAILED', 'access');
	setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	echo '<p>' . _('404 Not Found') . '</p>';
	exit();
}

/**
 * System path to the current theme.
 */
define('THEME_PATH', VIEW_PATH . $G->theme . DS);

/**
 * URL to the current theme.
 */
define('THEME_URL', VIEW_URL . $G->theme . '/');

/**
 * Revision number used mainly for cache-busting.
 */
define('REV', '.' . (int)$G->revision);

/**
 * The default application language.
 */
define('DEFAULTLANG', $G->defaultLanguage);

// Compare IP address against whitelist/blacklist.
if (strtolower($G->url->getUrlBit(0)) != 'forbidden' && !Security::ipAllowed($G->ipAddressesAllowed, $G->ipAddressesBanned)) {
	locate(HOST . URL . 'forbidden', array('er' => 1));
}

// Check for potential CSRF attacks.
if (strtolower($G->url->getUrlBit(0)) != 'forbidden' && !Security::hostMatched()) {
	locate(HOST . URL . 'forbidden', array('er' => 2));
}

// Start the session so we have a valid session ID.
session_start();

//echo session('year') . 'test';exit;
// Set Year
if (!session('year')){
	session('year', date("Y"));
}

// Set Month
if (!session('month')){
	session('month', date("n"));
}

// Add the User class.
$G->user = get_model('user');

// Load the user, if any.
$G->user->findRememberedUser();

// The language used if available. Falls back to DEFAULTLANG if necessary.
define('LANG', getLanguage($G));

// The user's timezone if available. Falls back to UTC.
define('TZ', getTimezone($G));

// Set the language header.
setHeader('Content-Language: ' . LANG);

// Set the default property.
$G->defaultProperty = getCurrentProperty($G);

// Set the default division.
$G->defaultDivision = getCurrentDivision($G);

// Set the default department.
$G->defaultDepartment = getCurrentDepartment($G);

// Load all controllers and populate navigation and routing systems.
$G->controllerList = populateControllers($G);
//echo '<pre>'.print_r($G->controllerList, TRUE).'</pre>';

if ((!session('property') || session('property') == '') && $G->user->loggedin) {
	if (user_is('Super User')) {
		flash('There are either no properties created yet, or you have not assigned one to yourself.', 'danger');
	} else {
		flash('You have not been assigned to a property yet. Please see your application administrator.', 'danger');
	}
	$propertyPage = URL.'settings/properties';
	if (substr($G->url, 0, strlen($propertyPage)) != $propertyPage) {
		// Only relocate to Settings/Property if we're not already there.
		locate($propertyPage);
	}
}
//echo "working 1 ";exit;
// Find and start the controller
loadController($G);
//echo "working 2";exit;
// Display the page.
showContent($G);
//echo "working";exit;
//$hash = Crypt::hashString('tempo1234');
//$checked = Crypt::checkHashedString('tempo1234', $hash);
//echo "<pre>$hash (".strlen($hash).") === $checked</pre>";

$G = NULL;
