<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Tactic model.
 *
 * @package    truenorthng
 * @subpackage Strategy
 */

final class Model_Tactic extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'user_id' => NULL,
			'due' => NULL,
			'past_due' => NULL,
			'complete' => NULL,
			'description' => NULL,
			'comment' => NULL,
			'cid' => NULL
		);
	}

	public function getStrategy($tacticId) {
		$return = NULL;
		$sql = 'SELECT * FROM `#__Strategy_Tactic` WHERE `tactic_id` = ?';
		$result = $this->execute($sql, $tacticId);
		if (count($result) > 0) {
			$return = $result[0]['strategy_id'];
		}
		return $return;
	}
}
