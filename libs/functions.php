<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Helper functions.
 *
 * @package    truenorthng
 * @subpackage Library
 */

/**
 * Sends a redirect to the specified URL. If headers have not been sent,
 * this is done server-side. If headers have already been sent, this is
 * done via client-side Javascript. If $force is TRUE, a Javascript
 * redirect is sent targeting "top". In all cases, a link is also
 * displayed as a backup measure.
 *
 * @param string $url   The URL to redirect the browser to.
 * @param array  $query Associative array of querystring params to include.
 * @param bool   $force Forces a Javascript redirect to the "top" of the browser.
 *
 * @throws Exception
 */
function locate($url, $query = NULL, $force = FALSE) {
	if (isset($url) && $url != '') {

		/*** COMMERX UPDATE -- STARTS HERE ***/		
		if(URL != "" && strpos($url, URL) === false) {
			if(substr($url, 0, 1) == "/" && substr(URL, -1) == "/") 
				$url = substr($url, 1);
			$url = URL . $url;
		}
		/*** COMMERX UPDATE -- ENDS HERE ***/
		
		$querystring = '';
		if (isset($query) && is_array($query)) {
			$querystring = '?' . http_build_query($query, '', '&');
		}
		if ($force) {
			echo '<script type="text/javascript">top.location.href="' . $url . $querystring . '";</script>';
		} else if (!headers_sent()) {
			setHeader('Location: ' . $url . $querystring);
		} else {
			echo '<script type="text/javascript">location.href="' . $url . $querystring . '";</script>';
		}
		die('<a href="' . $url . $querystring . '">' . $url . $querystring . '</a>');
	} else {
		if ($url != URL) {
			locate(URL);
		}
		throw new Exception(_('Invalid or missing redirection target.'));
	}
}

/**
 * Returns a prettified elapsed time string in seconds.
 *
 * @param float $from
 * @param bool  $usems
 *
 * @return string
 */
function showTimer($from = NULL, $usems = FALSE) {
	$return = 0;
	if ($from) {
		$now = gettimeofday();
		$now = $now['sec'] . '.' . $now['usec'];
		$return = ($now - $from);
		if ($usems) {
			$return = $return * 100;
			$return = sprintf('%01.2f', $return);
		} else {
			$return = sprintf('%01.5f', $return);
		}
	}
	return $return;
}

/**
 * Undoes the damage potential of "magic quotes".
 */
function removeMagicQuotes() {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
			unset($process[$key][$k]);
			if (is_array($v)) {
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
			} else {
				$process[$key][stripslashes($k)] = stripslashes($v);
			}
		}
	}
	unset($process);
}

/**
 * Performs a string replacement of the first occurrence of $needle.
 *
 * @param string $needle
 * @param string $replace
 * @param string $haystack
 *
 * @return string
 */
function str_replace_once($needle, $replace, $haystack) {
	$return = FALSE;
	$pos = strpos($haystack, $needle);
	if ($pos !== FALSE) {
		$return = substr_replace($haystack, $replace, $pos, strlen($needle));
	}
	return $return;
}

/**
 * Sets an HTTP header if they have not already been sent to the browser.
 *
 * @param      $header
 * @param bool $throwException
 *
 * @throws Exception
 */
function setHeader($header, $throwException = FALSE) {
	if (!headers_sent()) {
		header($header);
	} else {
		if ($throwException) {
			throw new Exception(_('Could not send new headers.'));
		}
	}
}

/**
 * Creates a numerically indexed array from a comma-delimited string.
 *
 * @param string $bunch Comma-delimited string of array values.
 *
 * @return array A new array built from the input string.
 */
function makeArray($bunch) {
	if (!is_array($bunch)) {
		$bunch = explode(',', $bunch);
	}
	// Remove blank members of the array.
	for ($i = 0, $c = count($bunch); $i < $c; $i++) {
		if (trim($bunch[$i]) == '') {
			unset($bunch[$i]);
		}
	}
	// Re-index the array so keys are sequential, starting at zero.
	if (is_array($bunch)) {
		$bunch = array_values($bunch);
	}
	// If, for some reason, the final is not an array, force it.
	if (!is_array($bunch)) {
		$bunch = array($bunch);
	}
	return $bunch;
}

/**
 * Returns the best-choice language for the current request. The "lang" querystring parameter takes precedence,
 * followed by the user's preference. If the language file cannot be found, defaults to the default language specified
 * by DEFAULTLANG constant.
 *
 * @param G $G
 *
 * @return string
 */
function getLanguage(G $G) {
	$return = NULL;
	$languages = array();
	$languagelist = scandir(LANGUAGE_PATH);

	// Find all installed languages.
	for ($i = 0, $c = count($languagelist); $i < $c; $i++) {
		if ($languagelist[$i] != '.' && $languagelist[$i] != '..') {
			$languages[strtolower($languagelist[$i])] = $languagelist[$i];
		}
	}

	// Check if querystring "lang" is available.
	if (!$return && $G->url->getQuerystringBit('lang')) {
		if (array_key_exists(strtolower($G->url->getQuerystringBit('lang')), $languages)) {
			$return = $languages[strtolower($G->url->getQuerystringBit('lang'))];
		}
	}

	// Check if User->lang is available.
	if (!$return && isset($G->user->lang)) {
		if (array_key_exists(strtolower($G->user->lang), $languages)) {
			$return = $languages[strtolower($G->user->lang)];
		}
	}

	// Check if the browser has a preference and it's available.
	if (!$return && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) > 1) {
		$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$lang = array();
		foreach ($langs as $val) {
			$matches = array();
			if (preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i", $val, $matches)) {
				$lang[$matches[1]] = (float)$matches[2];
			} else {
				$lang[$val] = 1.0;
			}
		}
		$qval = 0.0;
		$pref = NULL;
		foreach ($lang as $key => $value) {
			if ($value > $qval) {
				$qval = (float)$value;
				$pref = $key;
			}
		}
		if (isset($pref)) {
			$pref = explode('-', $pref);
			if (!is_array($pref)) {
				$pref = explode('_', $pref);
			}
			if (isset($pref[1])) {
				$pref[1] = strtoupper($pref[1]);
			}
			$pref = implode('_', $pref);
			if (array_key_exists(strtolower($pref), $languages)) {
				$return = $languages[strtolower($pref)];
			}
		}
	}

	// If nothing matched, use the default language.
	if (!$return) {
		$return = DEFAULTLANG;
	}
	putenv('LC_ALL=' . $return);
	setlocale(LC_ALL, $return . '.utf8', $return, 'en_US.utf8', 'en_US', 'en');
	bindtextdomain('TrueNorthNG', LANGUAGE_PATH);
	textdomain('TrueNorthNG');
	bind_textdomain_codeset('TrueNorthNG', 'UTF-8');
	return str_replace('_', '-', $return);
}

function getTimezone(G $G) {
	$tz = cookie('tntz');
	if ($tz == '') {
		$tz = 'UTC';
	}
	date_default_timezone_set($tz);
}

/**
 * Basic session storage and retrieval. If $val is blank, a session key is returned (FALSE if it doesn't exist). If $val
 * is specified and is not NULL, a session key is stored.
 *
 * @param string      $key
 * @param string|NULL $val
 *
 * @return string|bool
 */
function session($key, $val = NULL) {
	if (NULL === $val) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
	} else {
		$_SESSION[$key] = $val;
	}
	return FALSE;
}

/**
 * Deletes a key from the session store.
 *
 * @param string $key
 */
function session_del($key) {
	unset($_SESSION[$key]);
}

/**
 * Using the first passed array as a "defaults" list, combine all other arrays into it. No extra keys will be added.
 *
 * @return array
 */
function array_default() {
	$arrays = func_get_args();
	$default = array_shift($arrays);
	foreach ($arrays as $array) {
		foreach ($array as $key => $value) {
			if (isset($default[$key])) {
				$default[$key] = $value;
			}
		}
	}
	return $default;
}

function populateControllers(G $G) {
	$return = array(
		'allowed' => array(),
		'blocked' => array()
	);
	$controllers = array();

	// Check for app controllers first, so they can be overridden by theme controllers.
	if (file_exists(CONTROLLER_PATH)) {
		//$folders = array_values(array_diff(scandir(CONTROLLER_PATH), array('..', '.')));
		$folders = getFolderList(CONTROLLER_PATH);
		foreach ($folders as $controller_folder) {
			if (file_exists(CONTROLLER_PATH . $controller_folder . DS . 'controller.php')) {
				$controllers[$controller_folder] = CONTROLLER_PATH . $controller_folder . DS . 'controller.php';
			}
		}
	}
	if (file_exists(THEME_PATH . 'controllers' . DS)) {
		//$folders = array_values(array_diff(scandir(THEME_PATH.'controllers'.DS), array('..', '.')));
		$folders = getFolderList(THEME_PATH);
		foreach ($folders as $controller_folder) {
			if (file_exists(THEME_PATH . 'controllers' . DS . $controller_folder . DS . 'controller.php')) {
				$controllers[$controller_folder] = THEME_PATH . 'controllers' . DS . $controller_folder . DS . 'controller.php';
			}
		}
	}
	//echo "<pre>".print_r($controllers, TRUE)."</pre>";die();

	// Instantiate each controller and check for a "config()" method and execute it, passing the method name too.
	foreach ($controllers as $name => $file) {
		//$method = $G->url->getUrlBit(substr_count($name, '/') + 1);
		$method = $G->url->getUrlBit(substr_count($name, DS) + 1);
		require($file);
		$controllerName = "Controller_" . str_replace(DS, '_', ucController($name));
		$controller = new $controllerName($G);
		// Get the method list and find callable endpoints.
		$methodList = get_class_methods($controllerName);
		$methods = array();
		//echo '<pre>'.$controllerName.', '.$method.', '.print_r($methodList, TRUE).'</pre>';
		foreach ($methodList as $methodName) {
			if (substr($methodName, 0, 5) == 'call_') {
				$methods[$methodName] = str_replace_once('call_', 'config_', $methodName);
				if ($methodName == 'call_index') {
					$methods[$methodName] = 'config';
				}
			}
		}
		//echo '<pre>'.$controllerName.', '.$method.', '.print_r($methods, TRUE).'</pre>';
		if (method_exists($controller, 'config')) {
			$name = str_replace(DS, '/', $name);
			if ($controller->config($method)) {
				$return['allowed'][strtolower($name)] = $controller;
			} else {
				$return['blocked'][strtolower($name)] = $controller;
			}
		}
	}
	return $return;
}

function ucController($name, $sep = DS) {
	if (FALSE === strpos($name, DS)) {
		return ucfirst($name);
	}
	$pieces = explode($sep, $name);
	for ($i = 0, $c = count($pieces); $i < $c; $i++) {
		$pieces[$i] = ucfirst($pieces[$i]);
	}
	return implode($sep, $pieces);
}

function getFolderList($dir, $recursive = TRUE, $parent = NULL) {
	$return = array();
	$list = array_values(array_diff(scandir($dir), array('..', '.')));
	//echo "<pre>CHE: ".print_r($list, TRUE)."</pre>";
	foreach ($list as $folder) {
		if (is_dir($dir . $folder)) {
			$return[] = $parent . $folder;
			if ($recursive) {
				$subs = getFolderList($dir . $folder . DS, $recursive, $folder . DS);
				if (count($subs) > 0) {
					for ($i = 0, $c = count($subs); $i < $c; $i++) {
						$subs[$i] = $parent . $subs[$i];
					}
					$return = array_merge($return, $subs);
				}
			}
		}
	}
	return $return;
}

/**
 * Checks for the existence of a requested controller. First in the THEME_PATH folder and then in CONTROLLER_PATH.
 * Returns either FALSE if the controller doesn't exist, or the full system path to the file.
 *
 * @param string $file
 *
 * @return mixed
 */
function checkControllerFile($file) {
	$return = FALSE;
	if (file_exists(THEME_PATH . 'controllers' . DS . $file . DS . 'controller.php')) {
		$return = THEME_PATH . 'controllers' . DS . $file . DS . 'controller.php';
	} elseif (file_exists(CONTROLLER_PATH . $file . DS . 'controller.php')) {
		$return = CONTROLLER_PATH . $file . DS . 'controller.php';
	}
	return $return;
}

function loadController(G $G) {
	$controller = NULL;
	$method = NULL;
	$params = array();
	$redirect = NULL;
	$show404 = FALSE;
	//$url = $G->url->getUrl(TRUE);
	$url = $G->url->getUrl(FALSE);
	$url = substr($url, strlen($G->url->basepath)-1);
	$url = explode("/", trim($url, "/"));
	
	//echo "<pre>URL: ".print_r($url, TRUE)."</pre>";
	$controllers = array_keys($G->controllerList['allowed']);
	usort($controllers, function ($a, $b) {
		return substr_count($b, '/') - substr_count($a, '/');
	});
	//echo "<pre>CONTROLLERS: ".print_r($controllers, TRUE)."</pre>";
	$blocked = array_keys($G->controllerList['blocked']);
	usort($blocked, function ($a, $b) {
		return substr_count($b, '/') - substr_count($a, '/');
	});
	//echo "<pre>BLOCKED: ".print_r($blocked, TRUE)."</pre>";
	if ($url[0] == '') {
		$url[0] = strtolower($G->defaultController);
	}
	for ($i = 0, $c = count($url); $i < $c; $i++) {
		if ($i < $c - 1) {
			$url[$i + 1] = $url[$i] . '/' . $url[$i + 1];
		}
	}
	$url = array_reverse($url);
	//echo "<pre>URL: ".print_r($url, TRUE)."</pre>";
	for ($i = 0, $c = count($url); $i < $c; $i++) {
		if (in_array($url[$i], $controllers)) {
			$controller = $i;
			$show404 = FALSE;
			break;
		} else {
			if (in_array($url[$i], $blocked)) {
				if ($G->user->loggedin) {
					$redirect = 'forbidden';
				} else {
					$redirect = 'login';
					session('togglenav', 'Show Navigation');
				}
			} else {
				$show404 = TRUE;
			}
		}
	}
	//echo "<pre>CONTROLLER: $controller, $show404, $redirect</pre>";

	if (NULL !== $controller && $controller > 0) {
		$method = trim(str_replace_once($url[$controller], '', $url[$controller - 1]), '/');
	}
	if (NULL === $method) {
		$method = strtolower($G->defaultMethod);
	}
	//echo "<pre>METHOD: $method</pre>";

	if (NULL !== $method && $controller > 0) {
		$params = trim(str_replace_once($url[$controller - 1], '', $url[0]), '/');
		$params = explode('/', $params);
	}
	//echo "<pre>PARAMS: ".print_r($params, TRUE)."</pre>";

	if (NULL !== $controller) {
		$G->controller = $url[$controller];
		$G->controllerName = 'Controller_' . ucController($G->controller, '/');
		$method = 'call_' . $method;
		if (method_exists($G->controllerList['allowed'][$G->controller], $method)) {
			$G->controllerList['allowed'][$G->controller]->$method($params);
		} else {
			$show404 = TRUE;
		}
	}

	if (NULL === $controller || NULL === $method) {
		$show404 = TRUE;
		if ($url[0] == 'login'){
			$redirect = 'strategiestactics';
		}
	}

	if ($redirect) {
		if ($redirect != 'forbidden') {
			locate(URL . $redirect . '/', array('rf' => $G->url->getUrl()));
		}
		
		if ($redirect == 'forbidden' && $G->user->loggedin) {
			$redirect = 'strategiestactics';
			locate(URL . $redirect . '/');
		}		
	}
	if ($show404) {
		// Controller or method didn't exist, throw the 404.
		setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		echo '<p>' . _('404 Not Found') . '</p>';
		exit();
	}
}

/**
 * Displays the page content.
 *
 * @param G $G
 */
function showContent(G $G) {
	if (isset($G->viewVariables)) {
		$local = $G->viewVariables;
		foreach ($local as &$val) {
			if (!is_array($val)) {
				//$val = rawurldecode($val);
			}
		}
		extract($local);
	}
	unset($local, $val);
	// Set the runtime header.
	setHeader('X-Runtime: ' . showTimer($G->timerStart, FALSE) . 's');
	if (is_array($G->content)) {
		foreach ($G->content as $file) {
			if (file_exists($file)) {
				include($file);
			}
		}
	}
}

/**
 * Sets a cookie in the user's browser. If an array or comma-delimited string of names is passed in, the $value and
 * $expiry are set identically for all of them.
 *
 * @param mixed  $name   Array or comma-delimited string of cookie names.
 * @param string $value  The value of the cookie(s).
 * @param string $expiry The expiry date of the cookie(s).
 */
function bake($name, $value, $expiry) {
	$names = array();
	if (!is_array($name)) {
		$names = makeArray($name);
	}
	for ($i = 0, $c = count($names); $i < $c; $i++) {
		if (isset($names[$i]) && $names[$i] != '') {
			setcookie($names[$i], $value, $expiry, '/', HTTP_HOST);
			//echo 'Baking: '.$names[$i].' = '.$value.' : '.$expiry.', '.URL.', '.HTTP_HOST.PORT.'<br>';
		}
	}
}

/**
 * Returns the value of the requested cookie(s), or FALSE.
 *
 * @param mixed $bunch Array or comma-delimited string of cookie names.
 *
 * @return mixed Array (multiple) or string (single) with cookie value(s).
 */
function cookie($bunch) {
	$return = FALSE;
	$cookies = makeArray($bunch);
	for ($i = 0, $c = count($cookies); $i < $c; $i++) {
		if ($cookies[$i] != '') {
			if (cookieRequired($cookies[$i])) {
				$return[] = $_COOKIE[$cookies[$i]];
			}
		}
	}
	if (count($return) == 1) {
		$return = $return[0];
	}
	return $return;
}

/**
 * Checks to see if the cookie(s) exist(s).
 *
 * @param mixed $bunch Array or comma-delimited string of cookie names.
 *
 * @return bool TRUE if all cookies exist.
 */
function cookieRequired($bunch) {
	$return = FALSE;
	$bunch = makeArray($bunch);
	$found = 0;
	for ($i = 0, $c = count($bunch); $i < $c; $i++) {
		if (array_key_exists($bunch[$i], $_COOKIE)) {
			$found++;
		}
	}
	if ($found == count($bunch)) {
		$return = TRUE;
	}
	return $return;
}

function breadcrumbSelector(G $G, $view = 'breadcrumb') {
	$user = get_model('user');
	if ('all' == session('user_filter')) {
		$user->loadUser(session('user'));
	} else {
		$user->loadUser(session('user_filter'));
	}

	// Property list.
	if (empty($user->property)) {
		$properties = $user->getProperties();
	} else {
		$properties = $user->property;
	}
	$properties = array_index_sort($properties);
	$propertyList = array();
	$currentProperty = array();
	if (count($properties) > 0) {
		foreach ($properties as $property) {
			if ($property['id'] != session('property')) {
				$propertyList[$property['id']] = $property;
			} else {
				$propertyList[$property['id']] = $property;
				$currentProperty = $property;
			}
		}
	}

	// Division list.
	$divisionListDisplay = array();
	if (empty($user->division)) {
		$divisions = $user->getDivisions();
	} else {
		$divisions = $user->division;
	}
	$divisions = array_index_sort($divisions);
	$divisionList = array();
	$currentDivision = array(
		'id' => 'all', 
		'name' => _('All Divisions')
	);
	if (count($divisions) > 0){
		$divisionListDisplay = $user->getDivisionsNav(session('property'));
	}
	if (count($divisions) > 0) {
		foreach ($divisions as $division) {
			if ($division['id'] != session('division')) {
				$divisionList[$division['id']] = $division;
			} else {
				$divisionList[$division['id']] = $division;
				$currentDivision = $division;
			}
		}
	}

	// Department list.
	$departmentListDisplay = array();
	if (empty($user->department)) {
		$departmentModel = get_model('department');
		$departments = $departmentModel->getDepartments(session('division'), false);
		if(array_key_exists('0', $departments)){
			unset($departments['0']);
		}
	} else {
		$departments = $user->department;
	}
	$departments = array_index_sort($departments);
	$departmentList = array();
	$currentDepartment = array(
		'id' => 'all',
		'name' => _('All Departments')
	);
	if (count($departments) > 1 || count($departments) == 1){
		$departmentListDisplay = $user->getDepartmentsNav(session('division'), session('property'));
	}
	if (count($departments) > 0) {
		foreach ($departments as $department) {
			if ($department['id'] != session('department')) { 
				$departmentList[$department['id']] = $department;
			} else {
				$departmentList[$department['id']] = $department;
				$currentDepartment = $department;
			}
		}
	}
	//pr($departmentListDisplay);

	// User list.
	$user = session('user_filter');
	if (empty($user)) {
		$user = session('user');
	}
	$restrict = 100;
	if ($G->defaultProperty['openUserView']) {
		$restrict = 100;
	}
	$users = getUsers($user, $restrict, false, NULL, $currentDivision['id'], $currentDepartment['id']);
	//$users = array_index_sort($users, 'lastname');
	$userList = array();
	$currentUser = array();
	if (count($users) > 0) {
		foreach ($users as $value) {
			if ($value['id'] == session('user_filter')) {

				$currentUser = $value;
			}
			$userList[$value['id']] = $value;
		}
	}
	if (count($currentUser) == 0) {
		if (session('reviewcycle')) {
			$currentUser = get_model('user');
			$currentUser->setTable('#__RC_' . session('reviewcycle') . '_emails');
			$currentUser->loadUser(session('user_filter'));
			$currentUser = $currentUser->toArray();
		} else {
			$currentUser = get_model('user')->getOne(session('user_filter'), 'id');
		}
	}

	// Break user list into Role sub-arrays.
	$sortedUserList = array();
	foreach ($userList as $id => $user) {
		$sortedUserList[$id] = $user;
	}
	array_index_sort($sortedUserList, 'role_level');
	/*
	foreach ($userList as $id => $user) {
		if (!array_key_exists($user['role'], $sortedUserList) || !is_array($sortedUserList[$user['role']])) {
			$sortedUserList[$user['role']] = array();
		}
		$sortedUserList[$user['role']][$id] = $user;
	}

	// Sort by last name within each Role.
	foreach ($sortedUserList as $role => $users) {
		$sortedUserList[$role] = array_index_sort($users, 'lastname');
	}

	if (!empty($sortedUserList)){
		if (session('user_filter') == 'all') {
			$currentUser = array(
				'id' => 'all',
				'firstname' => _('All Users'),
				'lastname' => ''
			);
		} else {
			$sortedUserList = array_merge(
				array(
					'all' => array(
						'id' => 'all',
						'firstname' => _('All Users'),
						'lastname' => ''
					)
				),
				$sortedUserList
			);
		}
	}
	*/
	$type = 'main';
	$menu = array();
	foreach ($G->controllerList['allowed'] as $name => $controls) {
		if (isset($controls->route[$type . '_order'])) {
			$menu[$name] = $controls->route;
		}
	}
	uasort($menu, function ($a, $b) use ($type) {
		return $a[$type . '_order'] > $b[$type . '_order'];
	});
	$menu = nestMenu($menu);
	ob_start();
	include(THEME_PATH . 'blocks' . DS . $view . 'Selector.php');
	return ob_get_clean();
}

function rangeSelector(G $G, $view = 'range') {
	$type = 'main';
	$menu = array();
	foreach ($G->controllerList['allowed'] as $name => $controls) {
		if (isset($controls->route[$type . '_order'])) {
			$menu[$name] = $controls->route;
		}
	}
	uasort($menu, function ($a, $b) use ($type) {
		return $a[$type . '_order'] > $b[$type . '_order'];
	});
	$menu = nestMenu($menu);
	ob_start();
	include(THEME_PATH . 'blocks' . DS . $view . 'Selector.php');
	return ob_get_clean();
}

function array_index_sort($array, $key = 'name') {
	uasort($array, function ($a, $b) use ($key) {
		return strcmp(trim($a[$key]), trim($b[$key]));
	});
	return $array;
}

function user_sort_by_name($users) {
	uasort($users, function($a, $b) {
				  return strcasecmp($a["lastname"], $b["lastname"]);
				});
	return $users;				
}


function breadcrumbSelector2(G $G, $view = 'breadcrumb') {
	// First the current and available properties.
	$propertyModel = get_model('property');
	$currentProperty = $propertyModel->getOne(session('property'), 'id');
	$properties = $G->user->getProperties();
	$propertyList = array();
	if (count($properties) > 0) {
		foreach ($properties as $id => $property) {
			if ($property['id'] != $currentProperty['id']) {
				$propertyList[$property['id']] = $property;
			} else{
				//$propertyList[$property['id']] = $currentProperty;
			}
		}
	}
	unset($propertyModel, $properties);

	// Next the current and available divisions.
	$allDivisions = array(
		'id' => 'all',
		'name' => _('All Divisions')
	);
	$divisionModel = get_model('division');
	$currentDivision = $divisionModel->getOne(session('division'), 'id');
	if (count($currentDivision) == 0) {
		$currentDivision = $allDivisions;
	}
	// Get user specific divisions	
	$divisions = $divisionModel->getDivisions(session('property'));
	if (session('division') != 'all') {
		$divisions = array_merge(array('all' => $allDivisions), $divisions);
	}
	$divisionList = array();
	if (count($divisions) > 0) {
		foreach ($divisions as $id => $division) {
			if ($division['id'] != $currentDivision['id']) {
				$divisionList[$division['id']] = $division;
			}
		}
	}
	unset($divisionModel, $divisions, $allDivisions);

	// Finally the departments.
	$allDepartments = array(
		'id' => 'all',
		'name' => _('All Departments')
	);
	$departmentModel = get_model('department');
	$currentDepartment = $departmentModel->getOne(session('department'), 'id');
	if (count($currentDepartment) == 0) {
		$currentDepartment = $allDepartments;
	}

	// Get user specific divisions	
	$departments = $departmentModel->getDepartments(session('division'));
	if (session('department') != 'all') {
		$departments = array_merge(array('all' => $allDepartments), $departments);
	}
	$departmentList = array();
	if (count($departments) > 0) {
		foreach ($departments as $id => $department) {
			if ($department['id'] != $currentDepartment['id']) {
				$departmentList[$department['id']] = $department;
			}
		}
	}
	unset($departmentModel, $departments, $allDepartments);
	
	// Get Property Specific Users
	$allUsers = array(
		'id' => 'all',
		'firstname' => _('All'),
		'lastname' => _('Users')
	);
	$defaultUser = array(
		'id' => session('user'),
		'firstname' => $G->user->firstname,
		'lastname' => $G->user->lastname
	);
	$userModel = get_model('user');
	$user_filtered = $userModel->getOne(session('user_filter'), 'id');
	if (count($user_filtered) == 0 AND session('user_filter') != 'all') {
		$currentUser = $defaultUser;
	} elseif (count($user_filtered) == 0 AND session('user_filter') == 'all'){
		$currentUser = $allUsers;
	} else {
		$currentUser = $user_filtered;
	}

	// Get all users
	$usersModel = get_model('property');
	$users = $usersModel->getUsers(session('property'));
	$users = array_merge(array($defaultUser), $users);
	$users = array_merge(array('all' => $allUsers), $users);
	$userList = array();
	if (count($users) > 0) {
		foreach ($users as $id => $user) {
			if ($user['id'] != $currentUser['id']) {
				$userList[$user['id']] = $user;
			}
		}
	}
	unset($usersModel, $users, $allUsers);

	ob_start();
	include(THEME_PATH . 'blocks' . DS . $view . 'Selector.php');
	return ob_get_clean();
}

function menu(G $G, $type = 'main') {
	$menu = array();
	foreach ($G->controllerList['allowed'] as $name => $controls) {
		if (isset($controls->route[$type . '_order'])) {
			$menu[$name] = $controls->route;
		}
	}
	uasort($menu, function ($a, $b) use ($type) {
		return $a[$type . '_order'] > $b[$type . '_order'];
	});
	$menu = nestMenu($menu);
	$currentUser = $G->user;
	//echo "<pre>MENU: ".print_r($menu, TRUE).'</pre>';
	ob_start();
	include(THEME_PATH . 'blocks' . DS . $type . 'Menu.php');
	return ob_get_clean();
}

function nestMenu($items) {
	//echo "<pre>NEST: ".print_r($items, TRUE).'</pre>';
	if (!is_array($items) || count($items) < 1) {
		return array();
	}
	$return = array();
	foreach ($items as $url => $route) {
		if (FALSE !== strpos($url, '/')) {
			$name = explode('/', $url);
			if (isset($items[$name[0]])) {
				$titems = array();
				foreach ($items as $turl => $troute) {
					if (substr($turl, 0, strlen($name[0]) + 1) == $name[0] . '/') {
						$titems[substr($turl, strpos($turl, '/') + 1)] = $troute;
					}
				}
				if (!isset($return[$name[0]])) {
					$return[$name[0]] = $route;
				}
				if (!isset($return[$name[0]]['_children'])) {
					$return[$name[0]]['_children'] = nestMenu($titems);
				} else {
					$return[$name[0]]['_children'] = array_merge($return[$name[0]]['_children'], nestMenu($titems));
				}
			}
		} else {
			if (!isset($return[$url])) {
				$return[$url] = $route;
			} else {
				$return[$url] = array_merge($return[$url], $route);
			}
		}
	}
	return $return;
}

function getCurrentProperty(G $G) {
	if (!session('user_filter')) {
		session('user_filter', session('user'));
	}
	$user = get_model('user');
	if ('all' == session('user_filter')) {
		$user->loadUser(session('user'));
	} else {
		$user->loadUser(session('user_filter'));
	}
	if (empty($user->property)) {
		$userProperties = $user->getProperties();
	} else {
		$userProperties = $user->property;
	}
	$currentProperty = session('property');
	$defaultProperty = NULL;

	foreach ($userProperties as $property) {
		if ($currentProperty == $property['id']) {
			$defaultProperty = $property;
		}
	}
	if (NULL === $defaultProperty) {
		// Couldn't find a match between the current session('property') and the properties assigned to the user.
		if (count($userProperties) > 0) {
			// Just assign the first property to the session.
			$defaultProperty = array_shift($userProperties);
		}
	}

	if (NULL !== $defaultProperty) {
		session('property', $defaultProperty['id']);
		return $defaultProperty;
	}
	return NULL;
}

function getCurrentDivision(G $G) {
	$user = get_model('user');
	if ('all' == session('user_filter')) {
		$user->loadUser(session('user'));
	} else {
		$user->loadUser(session('user_filter'));
	}
	if (empty($user->division)) {
		$userDivisions = $user->getDivisions();
	} else {
		$userDivisions = $user->division;
	}
	$currentDivision = session('division');
	$defaultDivision = NULL;

	foreach ($userDivisions as $division) {
		if ($currentDivision == $division['id']) {
			$defaultDivision = $division;
		}
	}
	if (NULL === $defaultDivision) {
		// Couldn't find a match between the current session('division') and the divisions assigned to the user.
		if (count($userDivisions) > 0) {
			if (count($userDivisions) > 1) {
				// Assume that since a division ID wasn't matched, 'all' should be the default.
				$defaultDivision = array(
					'id' => 'all',
					'name' => _('All Divisions')
				);
			} else {
				// Just assign the first division to the session.
				$defaultDivision = array_shift($userDivisions);
			}
		}
	}

	if (NULL !== $defaultDivision) {
		session('division', $defaultDivision['id']);
		return $defaultDivision;
	}
	return NULL;
}

function getCurrentDepartment(G $G) {
	$user = get_model('user');
	if ('all' == session('user_filter')) {
		$user->loadUser(session('user'));
	} else {
		$user->loadUser(session('user_filter'));
	}
	if (empty($user->department)) {
		$userDepartments = $user->getDepartments();
	} else {
		$userDepartments = $user->department;
	}
	$currentDepartment = session('department');
	$defaultDepartment = NULL;

	foreach ($userDepartments as $department) {
		if ($currentDepartment == $department['id']) {
			$defaultDepartment = $department;
		}
	}
	if (NULL === $defaultDepartment) {
		// Couldn't find a match between the current session('division') and the divisions assigned to the user.
		if (count($userDepartments) > 0) {
			if (count($userDepartments) > 1) {
				// Assume that since a division ID wasn't matched, 'all' should be the default.
				$defaultDepartment = array(
					'id' => 'all',
					'name' => _('All Departments')
				);
			} else {
				// Just assign the first division to the session.
				$defaultDepartment = array_shift($userDepartments);
			}
		}
	}
	if (NULL === $defaultDepartment) {
		$defaultDepartment = array(
			'id' => 'all',
			'name' => _('All Departments')
		);
	}

	if (NULL !== $defaultDepartment) {
		session('department', $defaultDepartment['id']);
		return $defaultDepartment;
	}
	return NULL;
}

function rcMatrix($resultAvg = NULL, $cultureAvg = NULL, $avg = NULL, $total = NULL, $ratings = array(), $G = null){
	$bottom  = (($resultAvg -1)/4)*100;
	$left  = (($cultureAvg -1)/4)*100;
	$return = '<div class="clearfix">';
	$return .= '<div class="pull-left rcMatrix">';

	if($G && $G->controller != 'settings/compiledforms') {
		$return .= '<div class="plots">';
		if($resultAvg != NULL AND $cultureAvg != NULL){
			$return .= '<div class="point" style="left:'.$left.'%;bottom:'.$bottom.'%;"><span></span></div>';
		}
		if (!empty($ratings)){
			foreach ($ratings as $rater => $key) {
				$results = $key['results'];
				$culture = $key['culture'];
				$bottom  = (($results -1)/4)*100;
				$left  = (($culture -1)/4)*100;
				$tooltip = '{"rater":"'.$rater.'", "results":"'.$results.'", "culture":"'.$culture.'"}';
				$return .= '<div class="point" style="left:'.$left.'%;bottom:'.$bottom.'%;"><span></span></div>';
			}
		}

		$return .= '</div>';
	}
	$return .= '<img src="'.THEME_URL.'images/resultsGraph.png" />';
	$return .= '</div>';
	
	if($G && $G->controller != 'settings/compiledforms') { 
		$return .= '<div class="pull-left rcMatrix-rating-stars">';
			if ($resultAvg != null) {
				$resultRight  = ($resultAvg * 100)/5;
				$return .= '<div class="rcStars" >';
				$return .= '<h3>Result - '.$resultAvg.'</h3>';
				$return .= '<div class="rcStars-stars">';
				$return .= '<img src="'.THEME_URL.'images/stars-filled.png"/>';
				$return .= '<img src="'.THEME_URL.'images/fill.png" class="stars-print-bg" style="right:-'.$resultRight.'%;"/>';
				$return .= '</div>';
				$return .= '</div>';
			}
			if ($cultureAvg != null) {
				$cultureRight  = ($cultureAvg * 100)/5;
				$return .= '<div class="rcStars" >';
				$return .= '<h3>Culture - '.$cultureAvg.'</h3>';
				$return .= '<div class="rcStars-stars">';
				$return .= '<img src="'.THEME_URL.'images/stars-filled.png"/>';
				$return .= '<img src="'.THEME_URL.'images/fill.png" class="stars-print-bg" style="right:-'.$cultureRight.'%;"/>';
				$return .= '</div>';
				$return .= '</div>';
			}
		$return .= '</div>';
	}
	$return .= '</div>';
	return $return;
}

function getAllValidUsers() {
	$userlist = get_model('user')->getValidUsers();
	$users = array();
	foreach ($userlist as $id => $user) {
		$users[$id] = get_model('user');
		$users[$id]->loadUser($id);
	}
	return $users;
}

/**
 * Test if a string is a valid JSON string.
 *
 * @param string $string
 *
 * @return bool
 */
function isJson($string = NULL) {
	if (is_string($string)) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	} else {
		return FALSE;
	}
}

function index_to_associative($array, $key = 'id') {
	$return = array();
	foreach ($array as $value) {
		$return[$value[$key]] = $value;
	}
	return $return;
}

function array_pattern_explode($array, $pattern, $keyStrip = NULL) {
	$return = array();
	foreach ($array as $key => $val) {
		if (strpos($key, $pattern) > 0) {
			$id = (int)substr($key, strpos($key, $pattern) + strlen($pattern));
			$field = substr($key, 0, strpos($key, $pattern));
			if ($keyStrip !== NULL) {
				$field = str_replace_once($keyStrip, '', $field);
			}
			if (!isset($return[$id]) || !is_array($return[$id])) {
				$return[$id] = array();
			}
			$return[$id][$field] = $val;
		}
	}
	return $return;
}


function loadHourlyCSV($file) {
	if(!is_file($file)) return array();
	$csv = file_get_contents($file);
	$csvRows = explode("\r\n", $csv);
	if (count($csvRows) < 2) {
		$csvRows = explode("\r", $csv);
	}
	if (count($csvRows) < 2) {
		$csvRows = explode("\n", $csv);
	}
	$csv = null;
	unset($csv);
	$csv = array();
	$columns = array('Name', 'Position', 'Department', 'Division', 'Manager/Evaluator Name', 'Manager/Evaluator Email', 'Review Cycle', 'Review Form Code', 'Last Review Date', 'Current Rate', 'Date of Hire', 'Date of Current Position', 'Seniorty Date');
	for ($i = 1, $c = count($csvRows); $i < $c; $i++) {
		if (trim($csvRows[$i]) != '') {
			$row = str_getcsv(trim($csvRows[$i]));
			
			//$row = getInfoFromCSVData($row);
						
			if (count($row) == count($columns)) {
				$combo = array_combine($columns, $row);
				
				$csv[] = $combo;
			} else {
				pr($row, 'FAILED! ');
				die();
			}
		}
	}
	return $csv;
}


function loadCsv($file) {
	if(!is_file($file)) return array();
	$csv = file_get_contents($file);
	$csvRows = explode("\r\n", $csv);
	if (count($csvRows) < 2) {
		$csvRows = explode("\r", $csv);
	}
	if (count($csvRows) < 2) {
		$csvRows = explode("\n", $csv);
	}
	$csv = null;
	unset($csv);
	$csv = array();
	$columns = array('Comp', 'Emp No', 'Name', 'Home Loc', 'Home Loc Desc');
	for ($i = 1, $c = count($csvRows); $i < $c; $i++) {
		if (trim($csvRows[$i]) != '') {
			$row = str_getcsv(trim($csvRows[$i]));
			
			$row = getInfoFromCSVData($row);
						
			if (count($row) == count($columns)) {
				$combo = array_combine($columns, $row);
				$vals = array(
					'Comp' => $combo['Comp'],
					'Emp No' => $combo['Emp No'],
					'Name' => $combo['Name'],
					'Home Loc' => $combo['Home Loc'],
					'Home Loc Desc' => $combo['Home Loc Desc']
				);
				if ($vals['Comp'] != '' && $vals['Emp No'] != '' && $vals['Name'] != '' && $vals['Home Loc'] != '' && $vals['Home Loc Desc'] != '') {
					/* if (strlen($vals['Home Loc']) == 3) {
						$csv[] = $vals;
					} */
					$csv[] = $vals;
				}
			} else {
				pr($row, 'FAILED! ');
				die();
			}
		}
	}
	return $csv;
}

function pr($thing, $type = NULL) {
	if ($type != NULL){
		$type = '<strong>'.$type.'</strong><br>';
	}
	echo '<pre style="text-align: left;border: 1px #c00 dashed;padding:10px;margin:5px;max-height:400px;overflow-y: auto;clear: both;">'.$type.print_r($thing, TRUE).'</pre>';
}



function getInfoFromCSVData($data) {
	
	//print_r($data);
	
	$user = get_model('user')->getOne($data[0], 'username');
	$dept = get_model('department')->getOne($data[1], 'name');
	
	
	$currentProperty = get_model('property')->getOne(session('property'), 'id');
	//print_r($currentProperty);
	$row = array();
	$row[0] = $currentProperty["name"];
	$row[1] = (isset($user["id"])) ? $user["id"] : '';
	$row[2] = (isset($user["id"])) ? $user["firstname"] . ' ' . $user["lastname"] : '';
	$row[3] = (isset($dept["code"])) ? $dept["code"] : '';
	$row[4] = $data[1];
	return $row;
}

/**
 * Get environment info
 */
 
function getEnvironment()
{
	$env = '';
	
	//print_r($_SERVER);exit;
	if(isset($_SERVER["APP_ENV"]))
	{
		$env = $_SERVER["APP_ENV"];
	}
	else
	{
		$env = 'default';
	}

	return $env;
}

function generateCodeFromTitle($title)
{

	$unique = false;
	$duplicate = 0;
			
	while($unique == false) {
		$code = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
		if($duplicate) {
			$code .= '-' . $duplicate;
		}
		$codeExists = get_model('Compiledform')->getOne($code, 'code');
		if(!$codeExists) {
			$unique = true;
		}
		$duplicate++;
	}
	return strtoupper($code);
}
