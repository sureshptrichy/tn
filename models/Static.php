<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Compiled Forms Static model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Static extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'name' => NULL,
			'content' => NULL,
			'active' => 1,
			'locked' => 0,
			'cid' => NULL
		);
	}
}
