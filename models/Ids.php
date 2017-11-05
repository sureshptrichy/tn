<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * ID manager model.
 *
 * @package    truenorthng
 * @subpackage ID
 */

final class Model_Ids extends Model {
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	/**
	 * Creates a new unique identifier. Uses Fisher-Yates shuffle for better randomizing.
	 *
	 * @param int     $length Number of characters to return.
	 * @param boolean $alpha  Restrict character to A-Z, a-z, 0-9 only if TRUE.
	 *
	 * @return string Randomly generated unique identifier.
	 */
	public function createID($length = 16, $alpha = TRUE) {
		$return = '';
		$success = FALSE;
		$valid = array_merge(range('A', 'Z'), range('A', 'Z'), range('a', 'z'), range('a', 'z'), range(0, 9), range(0, 9), array('/', ':', '_', '-'), array('/', ':', '_', '-'));
		if ($alpha) {
			$valid = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
		}
		while (!$success) {
			$valid = $this->fyshuffle($valid);
			for ($i = 0; $i < (int)$length; $i++) {
				$return .= $valid[mt_rand(0, count($valid) - 1)];
			}
			$return = implode('', $this->fyshuffle(str_split($return, 1)));
			$success = !$this->findID($return);
		}
		return $return;
	}

	public function findID($id) {
		$return = FALSE;
		$test = $this->getOne($id, 'id');
		//echo "<pre>ID TEST $id: ".print_r($test, TRUE)."</pre>";
		if (count($test) > 0) {
			$return = TRUE;
		}
		return $return;
	}

	public function addID($id, $type) {
		$return = FALSE;
		if (!$this->findID($id)) {
			$created = time();
			$expires = $created + $this->G->formExpiry;
			$sql = 'INSERT INTO ' . $this->table . ' (`id`, `type`, `created`, `expires`) VALUES (?, ?, ?, ?)';
			$params = array($id, str_replace(PREFIX, '', $type), $created, $expires);
			$this->G->db->executeQuery($sql, $params);
			
			$return = TRUE;
		}
		return $return;
	}

	public function type($id) {
		$return = NULL;
		$test = $this->getOne($id, 'id');
		if (count($test) > 0) {
			$return = $test['type'];
		}
		return $return;
	}

	/**
	 * Performs a Fisher-Yates shuffle on input array. Does not affect original.
	 *
	 * @param mixed $array Array of values to shuffle.
	 *
	 * @return array Shuffled array.
	 */
	private function fyshuffle($array) {
		if (!is_array($array)) {
			$array = array($array);
		}
		$i = count($array);
		$j = 0;
		$tmp = '';
		while (--$i) {
			$j = mt_rand(0, $i);
			if ($i != $j) {
				$tmp = $array[$j];
				$array[$j] = $array[$i];
				$array[$i] = $tmp;
			}
		}
		return $array;
	}

}
