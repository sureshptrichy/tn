<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Compiled Forms Matrix model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Matrix extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'active' => 1,
			'locked' => 0,
			'cid' => NULL
		);
	}
}
