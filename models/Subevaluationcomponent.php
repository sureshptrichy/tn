<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Subevaluation Component model.
 *
 * @package    truenorthng
 * @subpackage Department
 */

final class Model_Subevaluationcomponent extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'subevaluation_id' => 0,
			'name' => NULL,
			'title' => NULL,
			'description' => NULL,
			'type' => NULL,
			'cid' => NULL
		);
	}

	public function getAllByEvaluation($id = 0, $status = 1, $orderBy = NULL, $filtered = TRUE) {
		$return = array();
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE `status` = ? AND `subevaluation_id` = ?';
		if ($orderBy !== NULL && $orderBy != '') {
			$sql .= ' ORDER BY ' . $orderBy . ' ';
		}
		$this->G->db->executeQuery($sql, array($status, $id));
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$return[$result['id']] = $result;
			}
		}
		return $return;
	}
}
