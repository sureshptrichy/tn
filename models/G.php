<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Registry model.
 *
 * @package    truenorthng
 * @subpackage Model
 */

class Model_G extends Model {
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
}
