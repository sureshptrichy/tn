<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Interface required for all helper database classes.
 *
 * @package    truenorthng
 * @subpackage Database
 */

interface iDatabase {
	public function newConnection($host, $user, $pass, $db);

	public function setActiveConnection($new);

	public function executeQuery($query = NULL, $data = NULL, $args = NULL);

	public function numRows();

	public function getRows();

	public function deleteRecords($table, array $condition, $limit = NULL);

	public function updateRecords($table, array $changes, array $condition);

	public function insertRecords($table, array $data);

	public function registerDestructor($class);
}
