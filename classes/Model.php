<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Extendable Model class.
 *
 * @package    truenorthng
 * @subpackage Model
 */

class Model extends Object {
	protected $data = array();
	protected $G;
	protected $table;
	protected $dbname;

	public function __construct(G $G) {
		parent::__construct($G);
		$this->table = PREFIX . substr(get_class($this), 6);
		$this->dbname = DBNAME;
		//echo $this->table."<br>";
	}

	public function setTable($name) {
		$this->table = $name;
	}

	public function __set($name, $value) {
		if (array_key_exists($name, $this->data)) {
			//if (is_array($value)) {
				//$value = json_encode($value);
			//}
			$this->data[$name] = $value;
		}
	}

	public function __get($name) {
		$return = NULL;
		if (array_key_exists($name, $this->data)) {
			if (isJson($this->data[$name])) {
				$return = json_decode($this->data[$name], TRUE);
			} else {
				$return = $this->data[$name];
			}
		}
		return $return;
	}

	public function toArray() {
		return $this->data;
	}

	public function execute($sql, $params = NULL, $cache = true) {
		$return = array();
		$cached = $this->G->db->getCached($sql, $params);
		if (!$cached || false === $cache) {
			$this->G->db->executeQuery($sql, $params);
			if ($this->G->db->numRows() > 0) {
				while ($row = $this->G->db->getRows()) {
					$return[] = $row;
				}
			}
			$this->G->db->cacheQuery($sql, $params, $return);
		} else {
			$return = $cached;
		}
		return $return;
	}

	public function getMeta($id = NULL, $field = 'key', $value = 'value') {
		$return = array();
		$sql = 'SELECT * FROM ' . $this->table;
		$params = array();
		if (NULL !== $id && NULL !== $field) {
			$sql .= ' WHERE ' . $field . ' = ?';
			$params[] = $id;
		}
		$cached = $this->G->db->getCached($sql, $params);
		if (!$cached) {
			$this->G->db->executeQuery($sql, $params);
			if ($this->G->db->numRows() > 0) {
				while ($setting = $this->G->db->getRows()) {
					$return[$setting[$field]] = $setting[$value];
				}
			}
			$this->G->db->cacheQuery($sql, $params, $return);
		} else {
			$return = $cached;
		}
		return $return;
	}

	public function getOne($val = NULL, $field = "key", $orderBy = NULL, $tableNameExtra = NULL) {
		$return = array();
		if (is_array($val) && is_array($field)) {
			$sql = 'SELECT * FROM ' . $this->table . $tableNameExtra . ' WHERE 1=1 ';
			foreach ($field as $key) {
				$sql .= ' AND `' . $key . '` = ? ';
			}
			if ($orderBy !== NULL && $orderBy != '') {
				$sql .= ' ORDER BY ' . $orderBy . ' ';
			}
			$sql .= ' LIMIT 0, 1';
		} else {
			$sql = 'SELECT * FROM ' . $this->table . $tableNameExtra . ' WHERE 1=1 AND `' . $field . '` = ? LIMIT 0, 1';
		}
		//echo $sql."<br>";
		$cached = $this->G->db->getCached($sql, $val);
		if (!$cached) {
			$this->G->db->executeQuery($sql, $val);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return = $result;
				}
			}
			$this->G->db->cacheQuery($sql, $val, $return);
		} else {
			$return = $cached;
		}
		return $return;
	}

	public function getAll($status = 1, $orderBy = NULL, $filtered = TRUE) {
		$return = array();
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE `status` = ?';
		if ($orderBy !== NULL && $orderBy != '') {
			$sql .= ' ORDER BY ' . $orderBy . ' ';
		}
		$cached = $this->G->db->getCached($sql, $status);
		if (!$cached) {
			$this->G->db->executeQuery($sql, $status);
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$return[$result['id']] = $result;
				}
			}
			$this->G->db->cacheQuery($sql, $status, $return);
		} else {
			$return = $cached;
		}
		//echo "PROPERTY: ".session('property').'<br>';
		return $return;
	}

	public function setAll($vals, $update = FALSE) {
		if (!is_array($vals)) {
			$vals = array($vals);
		}
		foreach ($vals as $key => $val) {
			if (strtolower($key) != 'id' || (strtolower($key) == 'id' && $update)) {
				$this->$key = $val;
			}
		}
	}

	public function save($table = NULL) {
		//echo "<pre>MODEL.".$this->table.": ".print_r(get_class($this), TRUE)."</pre>";
		//echo "<pre>MODEL.".print_r($this->data, TRUE)."</pre>";
		// First get the fields from the database.
		if (NULL == $table) {
			$table = $this->table;
		}
		$sql = 'SHOW COLUMNS FROM `' . $table . '`';
		$this->G->db->executeQuery($sql);
		$schema = array();
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$schema[$result['Field']] = $result;
			}
		}

		// Now only grab items from $this->data that have the same name.
		$data = array();
		foreach ($this->data as $key => $val) {
			if (isset($schema[$key])) {
				$data[$key] = $val;
			}
		}
		if (array_key_exists('last', $data)) {
			$data['last'] = time();
		}
		//echo "<pre>MODEL.".print_r($data, TRUE)."</pre>";

		if (!isset($data['id']) || $data['id'] == '' || $data['id'] == '0' || !$this->G->ids->findID($data['id'])) {
			// This is a new record.
			if (array_key_exists('created', $data)) {
				$data['created'] = time();
			}
			$id = $this->G->db->insertRecords($table, $data);
			$this->data['id'] = $id;
		} else {
			// Update an existing record.
			$msg = $this->G->db->updateRecords($table, $data, array('id' => $data['id']));
		}
	}

	public function delete($val, $key = 'id', $table = NULL) {
		if (NULL == $table) {
			$table = $this->table;
		}
		$this->G->db->deleteRecords($table, array($key => $val));
	}

	public function test() {
		echo "<pre>MODEL DATA:" . print_r($this->data, TRUE) . "</pre>";
	}
}
