<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Peer model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Peer extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'aid' => NULL,
			'id' => 0,
			'token' => NULL,
			'email' => NULL
		);
	}
}
