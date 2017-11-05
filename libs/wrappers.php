<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Wrapper convenience functions for class methods.
 *
 * @package    truenorthng
 * @subpackage Library
 */

/**
 * Checks if a User has a specific Permission or all of an array of Permissions.
 *
 * @global G     $G
 *
 * @param string $permission
 *
 * @return bool
 */
function user_has($permission = NULL, $userId = NULL) {
	global $G;
	return $G->user->acl->has($permission, $userId);
}

/**
 * Checks if a User belongs to a specific Role or any of an array of Roles.
 *
 * @global G     $G
 *
 * @param string $role
 *
 * @return bool
 */
function user_is($role = NULL, $userId = NULL) {
	global $G;
	return $G->user->acl->is($role, $userId);
}

/**
 * Adds a variable that will be available to the requested View file.
 *
 * @global G     $G
 *
 * @param string $var
 * @param mixed  $val
 */
function tpl_set($var, $val) {
	global $G;
	$local = $G->viewVariables;
	$local[$var] = $val;
	$G->viewVariables = $local;
}

/**
 * Sets a message to be seen during the next page view for the current user.
 *
 * @param string $content
 * @param string $type
 */
function flash($content, $type = 'warning') {
	$local = session('flash');
	if (!isset($local[$type]) || !is_array($local[$type])) {
		$local[$type] = array();
	}
	if (!in_array($content, $local[$type])) {
		$local[$type][] = $content;
	}
	session('flash', $local);
}

/**
 * Instantiate and return the requested model.
 *
 * @global G     $G
 *
 * @param string $model The name of the model to get.
 *
 * @return Model
 */
function get_model($model) {
	global $G;
	return $G->getModel($model);
}

/**
 * Parse a string through the Markdown filter.
 *
 * @param string $content
 *
 * @return string
 */
function parse($content = NULL) {
	return Parsedown::instance()->parse($content);
}

function tz($time) {
	$return = $time;
	$tz = cookie('tntz');
	if (!empty($tz)) {

	}
	return $return;
}

function getUsers($userId = NULL, $restrictDepth = 100, $forDisplay = FALSE, $propertyId = NULL, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $currentUserId = NULL) {
	return get_model('user')->getValidUsers($userId, $restrictDepth, $forDisplay, $propertyId, $divisionId, $departmentId, $filterId, $currentUserId);
}
