<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Constants definitions.
 *
 * @package truenorthng
 */

/**
 * The root URL path of the platform.
 */
define('URL', str_replace(DS, '/', substr(SYSTEM_PATH, strlen($_SERVER["DOCUMENT_ROOT"]))));

/**
 * Set the initial protocol and port values for the site.
 */
if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
	define('HTTP', 'https://');
} else {
	define('HTTP', 'http://');
}
if ((HTTP == 'http://' && $_SERVER["SERVER_PORT"] != 80) || (HTTP == 'https://' && $_SERVER["SERVER_PORT"] != 443)) {
	define('PORT', ':' . $_SERVER["SERVER_PORT"]);
} else {
	define('PORT', '');
}
if (isset($_SERVER["HTTP_HOST"]) && strrpos($_SERVER["HTTP_HOST"], ":")) {
	define('HTTP_HOST', substr($_SERVER["HTTP_HOST"], 0, strrpos($_SERVER["HTTP_HOST"], ":")));
} else {
	define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
}

/**
 * The hostname of the platform.
 */
define('HOST', HTTP . HTTP_HOST . PORT);

/**
 * Path to the controllers.
 */
define('CONTROLLER_PATH', SYSTEM_PATH . 'controllers' . DS);

/**
 * Path to the handlers.
 */
define('HANDLER_PATH', SYSTEM_PATH . 'handlers' . DS);

/**
 * Path to the classes.
 */
define('CLASS_PATH', SYSTEM_PATH . 'classes' . DS);

/**
 * Path to the logs.
 */
define('LOG_PATH', SYSTEM_PATH . 'logs' . DS);

/**
 * Path to the interfaces.
 */
define('INTERFACE_PATH', SYSTEM_PATH . 'interfaces' . DS);

/**
 * System path to the language files.
 */
define('LANGUAGE_PATH', SYSTEM_PATH . 'languages' . DS);

/**
 * Path to the models.
 */
define('MODEL_PATH', SYSTEM_PATH . 'models' . DS);

/**
 * Path to the libraries.
 */
define('LIB_PATH', SYSTEM_PATH . 'libs' . DS);

/**
 * Path to the uploads folder.
 */
define('UPLOAD_PATH', SYSTEM_PATH . 'uploads' . DS);

/**
 * Path to the uploads folder.
 */
define('UPLOAD_URL', URL . 'uploads/');

/**
 * Path to the front-end views.
 */
define('VIEW_PATH', SYSTEM_PATH . 'views' . DS);

/**
 * URI to the front-end views.
 */
define('VIEW_URL', URL . 'views/');

/**
 * Version information.
 */
define('VERSION', '1.0.0');

/**
 * The highest UNIX timestamp.
 */
define('END_OF_TIME', 2147483648);

/**
 * Salt used for encryption.
 */
define('SYSTEM_SALT', '34pf9bqwnv3po4i2bg439uifqb34tu9h34qbg49th345q;h4gfo;hnpqgiw4gu5');

// Role Constants. These numbers must match the `level` field of the `Acl_Roles` table.
define('SUPER_USER', 100);
define('PROPERTY_MANAGER', 5);
define('DIVISION_DIRECTOR', 4);
define('DEPARTMENT_MANAGER', 3);
define('SUPERVISOR', 2);
define('ASSOCIATE', 1);
define('ANONYMOUS', 0);
define('REVIEWER', 20);
