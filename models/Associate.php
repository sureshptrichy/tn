<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Hourly Associate Field model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Associate extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'aid' => NULL,
			'id' => 0,
			'comp' => NULL,
			'emp_no' => NULL,
			'name' => NULL,
			'home_loc' => NULL,
			'home_loc_desc' => NULL
		);
	}
}
