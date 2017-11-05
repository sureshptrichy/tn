<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Main global registry class.
 *
 * @package    truenorthng
 * @subpackage Registry
 */

class G {
	private $data = array();
	private $model;
	public $ids;

	public function __construct() {
		$this->model = $this->getModel('g');
		$this->ids = $this->getModel('ids');
		removeMagicQuotes();
	}

	public function bootstrap() {
		$this->data = array_merge($this->data, $this->model->getMeta());
		//echo "<pre>G: ".print_r($this->data, TRUE)."</pre>";
	}

	public function __set($name, $value) {
		//pr($name, 'G ');
		//pr($value, 'G ');
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

	public function __toString() {
		return json_encode($this->data);
	}

	/**
	 * Loads and instantiates an object within G. The first argument must be the name of the object. All extra
	 * arguments are passed to the object as an array.
	 */
	public function setObject() {
		$args = func_get_args();
		$name = array_shift($args);
		$this->data[$name] = $this->getObject($name, FALSE, $args);
	}

	/**
	 * Loads and instantiates an object within the Registry *without* the new object having an internal copy of G.
	 * Usually used with 3rd party libraries like the Facebook SDK. The first argument must be the name of the
	 * object. All extra arguments are passed to the object as an array.
	 */
	public function setRawObject() {
		$args = func_get_args();
		$name = array_shift($args);
		$this->data[$name] = $this->getObject($name, TRUE, $args);
	}

	/**
	 * Loads, instantiates and returns an object. If $raw is TRUE, the new object does not contain a copy of G. All
	 * extra arguments are passed to the object as an array or single value.
	 *
	 * @return Object
	 * @throws Exception
	 */
	public function getObject() {
		$return = NULL;
		$args = func_get_args();
		$properName = ucfirst(array_shift($args));
		$raw = array_shift($args);
		if (count($args) == 1 && is_array($args)) {
			$args = $args[0];
			if (count($args) == 1 && is_array($args)) {
				$args = $args[0];
			}
		}
		if (defined('THEME_PATH') && file_exists(THEME_PATH . 'classes' . DS . $properName . '.php')) {
			require_once(THEME_PATH . 'classes' . DS . $properName . '.php');
		} elseif (file_exists(CLASS_PATH . $properName . '.php')) {
			require_once(CLASS_PATH . $properName . '.php');
		} else {
			throw new Exception('Invalid object declared.' . $properName, 100);
		}
		if ($raw) {
			$return = new $properName($args);
		} else {
			$return = new $properName($this, $args);
		}
		return $return;
	}

	/**
	 * Loads, instantiates and returns a model object.
	 *
	 * @param string $model
	 *
	 * @throws Exception
	 */
	public function getModel($model) {
		$return = NULL;
		$properName = ucfirst($model);
		if (defined('THEME_PATH') && file_exists(THEME_PATH . 'models' . DS . $properName . '.php')) {
			require_once(THEME_PATH . 'models' . DS . $properName . '.php');
		} elseif (file_exists(MODEL_PATH . $properName . '.php')) {
			require_once(MODEL_PATH . $properName . '.php');
		} else {
			throw new Exception('Invalid model declared.', 101);
		}
		$properName = 'Model_' . $model;
		$return = new $properName($this);
		return $return;
	}
}
