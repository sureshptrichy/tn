<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * MySQL Database class.
 *
 * @package    truenorthng
 * @subpackage Database
 */

class DBmysql implements iDatabase {
	/**
	 * Holds a local reference to the Registry object.
	 */
	private $G;

	/**
	 * Tracks IDs of all active database connections.
	 */
	private $connections = array();

	/**
	 * The unique ID of the currently active database connection.
	 */
	private $activeConnection;

	/**
	 * The most recent resultset as an associative array.
	 */
	private $last;

	/**
	 * The number of queries on all connections.
	 */
	public $queryCounter = 0;

	private $cachedQueries = array();
	private $cachedResults = array();
	public $queryCacheCounter = 0;

	/**
	 * Holds a list of destructor methods that need to execute before the
	 * database class is destroyed.
	 */
	private $destructors = array();

	/**
	 * Stores the Global object for later use.
	 *
	 * @param G $G The G object.
	 */
	public function __construct(G $G) {
		$this->G = $G;
	}

	/**
	 * Executes registered destructors and then removes all connections to
	 * the database(s).
	 */
	public function __destruct() {
		for ($i = 0, $c = count($this->destructors); $i < $c; $i++) {
			if (isset($this->destructors[$i])) {
				$class = $this->destructors[$i];
				$class->destruct();
			}
		}
		for ($i = 0, $c = count($this->connections); $i < $c; $i++) {
			$this->connections[$i] = NULL;
		}
	}

	/**
	 * Creates a new connection to the database and returns a connection ID.
	 *
	 * @param string $host The hostname of the database server.
	 * @param string $user The username of the database.
	 * @param string $pass The password for the user.
	 * @param string $db   The database to connect to.
	 *
	 * @return int A unique connection ID.
	 * @throws Exception
	 */
	public function newConnection($host, $user, $pass, $db, $port = 3306) {
		try {
			//$this->connections[] = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass, array(PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
			$this->connections[] = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $db, $user, $pass, array(PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch (PDOException $e) {
			echo $e->getCode();
			switch ($e->getCode()) {
				case 1045:
					throw new Exception('Cannot connect to database.', 400);
					break;
			}
			exit;
		}
		$connectionId = count($this->connections) - 1;
		return $connectionId;
	}

	/**
	 * Sets the currently active database connection.
	 *
	 * @param int $new The connection ID to use for future queries.
	 */
	public function setActiveConnection($new) {
		$this->activeConnection = (int)$new;
	}

	/**
	 * Prepares and executes a query against the currently active connection. This function accepts prepared
	 * statements or regular queries. In the case of a prepared statement, the number of items in $data must be
	 * the same as the number of "?" characters in $query. If there is only a single $data item, it does not need
	 * to be an array. $args is an array of option arguments - int start, int rows
	 *
	 * @param string $query The query to be executed.
	 * @param mixed  $data
	 * @param array  $args
	 *
	 * @throws exception
	 */
	public function executeQuery($query = NULL, $data = NULL, $args = NULL) {
		/**
		 * The query object.
		 */
		$db = NULL;

		/**
		 * Array of errors, if any.
		 */
		$dberror = NULL;

		if (isset($query)) {
			if (!is_array($data)) {
				$data = array($data);
			}
			if (!is_array($args)) {
				$args = array($args);
			}
			if (isset($args['start']) && isset($args['rows'])) {
				if ((int)$args['start'] >= 0 && (int)$args['rows'] >= 1) {
					$query .= ' limit ' . (int)$args['start'] . ', ' . (int)$args['rows'];
				}
			}
			$query = str_replace('#__', PREFIX, $query);
			if (strtolower(substr($query, 0, 7)) != 'select ') {
				$this->cachedQueries = array();
				$this->cachedResults = array();
			}
			//echo "<br/>";
			//echo $query;
			//LOG::write($query . '::' . print_r($data, TRUE), 'db');
			$this->queryCounter++;
			$db = $this->connections[$this->activeConnection]->prepare($query . '; ');
			$db->execute(array_values($data));
			$dberror = $db->errorInfo();
			if ($dberror[0] == '42S02') {
				throw new exception('Table could not be found.', 401);
			}
			$this->last = $db;
			if ($dberror[0] == '23000' && isset($dberror[1]) && $dberror[1] == '1062') {
				return $dberror;
			}
		}
	}

	/**
	 * Returns the number of rows affected by the most recent query.
	 *
	 * @return int Rows affected.
	 */
	public function numRows() {
		return $this->last->rowCount();
	}

	/**
	 * Returns a row from the last query as long as rows exist. Return FALSE
	 * if there are no more rows in the resultset.
	 *
	 * @return mixed Associative array of row values, or FALSE if empty.
	 */
	public function getRows() {
		try {
			return $this->last->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return array();
		}
	}

	/**
	 * Deletes records from a table.
	 *
	 * @param string $table     The table to remove records from.
	 * @param array  $condition An associative array of conditions.
	 * @param int    $limit     (Optional) The maximum number of deleted rows.
	 *
	 * @return int Number of records deleted by the query.
	 */
	public function deleteRecords($table, array $condition, $limit = NULL) {
		$query = 'delete from ' . $table . ' where';
		$data = NULL;
		foreach ($condition as $field => $value) {
			$query .= ' `' . $field . '` = ? and';
			$data[] = $value;
		}
		$query = substr($query, 0, strlen($query) - 4);
		$this->executeQuery($query, $data, array(0, (int)$limit));
		return $this->last->rowCount();
	}

	/**
	 * Updates records in a table.
	 *
	 * @param string $table     The table to update records in.
	 * @param array  $changes   An associative array of changes to be made.
	 * @param array  $condition An associative array of conditions.
	 *
	 * @return int Number of records updated by the query.
	 */
	public function updateRecords($table, array $changes, array $condition) {
		$query = 'UPDATE ' . $table . ' SET';
		$data = NULL;
		foreach ($changes as $field => $value) {
			$query .= ' `' . $field . '` = ?,';
			$data[] = $value;
		}
		$query = substr($query, 0, strlen($query) - 1);
		$query .= ' WHERE';
		foreach ($condition as $field => $value) {
			$query .= ' `' . $field . '` = ? AND';
			$data[] = $value;
		}
		$query = substr($query, 0, strlen($query) - 4);
		//echo "<pre>UPDATE $table: ".print_r($changes, TRUE)."</pre>";
		$this->executeQuery($query, $data);
		return $this->last->rowCount();
	}

	/**
	 * Adds new records to a table.
	 *
	 * @param string $table The table that records will be added to.
	 * @param array  $data  Associative array of new records.
	 *
	 * @return int The ID of this record, if the database engine supports it.
	 */
	public function insertRecords($table, array $data) {
		$query = 'INSERT INTO ' . $table . ' (';
		$vals = '(';
		$newdata = NULL;
		if (array_key_exists('id', $data)) {
			// Always create a new ID here if an ID is required.
			if ($table != PREFIX . 'ids') {
				// Except the ID table itself.
				$data['id'] = $this->G->ids->createID();
			}
			$this->G->ids->addID($data['id'], $table);
		}
		foreach ($data as $field => $value) {
			$query .= '`' . $field . '`,';
			$vals .= '?,';
			$newdata[] = $value;
		}
		$query = substr($query, 0, -1);
		$vals = substr($vals, 0, -1);
		$query .= ') VALUES ';
		$vals .= ')';
		$this->executeQuery($query . $vals, $newdata);
		if (array_key_exists('id', $data)) {
			return $data['id'];
		} else {
			return $this->connections[$this->activeConnection]->lastInsertId();
		}
	}

	/**
	 * Registers a class that needs to have its destruct() method called
	 * before the database connections are released.
	 *
	 * @param Object $class
	 */
	public function registerDestructor($class) {
		$this->destructors[] = $class;
	}

	public function cacheQuery($sql, $params = NULL, $result = NULL) {
		$hash = sha1($sql . json_encode($params));
		$this->cachedQueries[$hash] = $result;
		$this->queryCacheCounter++;
		//pr($hash, 'CACHE ');
		//pr($sql, 'CACHE ');
		//pr($params, 'CACHE ');
		//pr($result, 'CACHE ');
	}

	public function isCached($hash) {
		if (array_key_exists($hash, $this->cachedQueries)) {
			return TRUE;
		}
		return FALSE;
	}

	public function getCached($sql, $params = NULL) {
		$return = FALSE;
		$hash = sha1($sql . json_encode($params));
		if ($this->isCached($hash)) {
			$return = $this->cachedQueries[$hash];
			//pr($hash, 'READ  ');
			//pr($sql, 'READ  ');
			//pr($params, 'READ  ');
			//pr($return, 'READ  ');
		}
		return $return;
	}
}
