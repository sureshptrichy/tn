<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Custom error handling functions.
 *
 * @package    truenorthng
 * @subpackage Errors
 */

/**
 * Custom error handler so we can do fancy things when problems appear.
 *
 * @param int    $errno
 * @param string $errstr
 * @param string $errfile
 * @param int    $errline
 * @param array  $errcontext
 *
 * @return bool TRUE so PHP's built-in error handler won't kick in.
 * @throws ErrorException
 */
function error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
	$output = '<div class="debug">CODE: ' . $errno . ' -> line #<strong>' . $errline . '</strong> in <strong>' . $errfile . '</strong><br /><em>' . $errstr . "</em></div>\n";
	if (DEBUG) {
		echo $output;
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		exit();
	}
	return TRUE;
}

/**
 * Custom exception handler so we can do fancy things when problems appear.
 *
 * @param $e
 */
function exception_handler($e) {
	try {
		$msg = $e->getMessage();
		$line = $e->getLine();
		$file = str_replace(SYSTEM_PATH, '', $e->getFile());
		$code = (float)$e->getCode();
		//Log::write('Line ' . $line . ', code ' . $code . ': <em><strong>' . $file . '</strong></em>: ' . $msg, 'error');
		switch ($code) {
			case 400:
				echo '<div class="debug">ERROR: Cannot connect to the database.</div>';
				exit();
				break;
			case 401:
				echo '<div class="debug">ERROR: A table is missing.</div><pre>' . print_r($e, TRUE) . '</pre>';
				exit();
				break;
			default:
				echo '<div class="debug">Line ' . $line . ', code ' . $code . ': <em><strong>' . $file . '</strong></em>: ' . $msg;
				exit();
				break;
		}
	} catch (Exception $e) {
		//Log::write('SEVERE: ' . get_class($e) . ' thrown within the exception handler. Message: ' . $e->getMessage() . ' on line ' . $e->getLine(), 'error');
		print get_class($e) . ' thrown within the exception handler. Message: ' . $e->getMessage() . ' on line ' . $e->getLine();
		exit();
	}
}
