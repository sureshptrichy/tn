<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Logging functions.
 *
 * @package    truenorthng
 * @subpackage Log
 */

/**
 * Class Log
 *
 * @see        Log::write() Append a log entry to the log file(s).
 * @package    truenorthng
 * @subpackage Log
 */
class Log {
	/**
	 * Appends a log entry to LOG_PATH.'log_'.$type.'.txt'. Includes the
	 * current UNIX timestamp.
	 *
	 * @param string $log
	 * @param string $type
	 */
	public static function write($log = NULL, $type = 'index') {
		if (DEBUG || strtolower($type) == 'error') {
			$logfile = LOG_PATH . 'log_' . strtolower($type) . '.log';
			$referer = '';
			if (isset($_SERVER['HTTP_REFERER'])) {
				$referer = $_SERVER['HTTP_REFERER'];
			}
			file_put_contents($logfile, microtime(TRUE) . ': ' . $referer . ': ' . $log . "\n", FILE_APPEND | LOCK_EX);
		}
	}
}
