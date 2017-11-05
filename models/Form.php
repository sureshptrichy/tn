<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Form model.
 *
 * @package    truenorthng
 * @subpackage Form
 */

final class Model_Form extends Model {
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
}
