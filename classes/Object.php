<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Extendable Generic class. Contains a protected $data array and magic functions.
 *
 * @package    truenorthng
 * @subpackage Object
 */

class Object {
	protected $data;
	protected $G;

	public function __construct(G $G, $args = NULL) {
		$this->G = $G;
		if (!is_array($args)) {
			$args = array($args);
		}
		$this->data = $args;
	}

	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	public function __get($name) {
		$return = NULL;
		if (array_key_exists($name, $this->data)) {
			$return = $this->data[$name];
		}
		return $return;
	}

	public function __isset($name) {
		$return = FALSE;
		if (isset($this->data[$name])) {
			$return = TRUE;
		}
		return $return;
	}

	public function __unset($name) {
		if (isset($this->data[$name])) {
			unset($this->data[$name]);
		}
	}
}
