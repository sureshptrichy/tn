<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Factory Database class.
 *
 * @package    truenorthng
 * @subpackage Database
 */

/**
 * Class Database
 *
 * @see Database::create() Instantiate a database class and return it.
 */
class Database {
	/**
	 * If the file "DB".$dbtype.".php" exists, load it up and instantiate the class.
	 *
	 * @param G $g
	 * @param   $dbtype
	 *
	 * @return iDatabase
	 * @throws Exception
	 */
	public static function create(G $g, $dbtype) {
		$return = NULL;
		if (isset($dbtype)) {
			$type = 'DB' . strtolower($dbtype);
			$file = CLASS_PATH . $type . '.php';
			if (file_exists($file)) {
				require($file);
				$return = new $type($g);
				if (!($return instanceof iDatabase)) {
					$return = NULL;
					throw new Exception('Database class ' . $file . ' is not a proper database instance.');
				}
			} else {
				throw new Exception('Database class ' . $file . ' does not exist.');
			}
		} else {
			throw new Exception('Database type has not been defined.');
		}
		return $return;
	}
}
