<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Subevaluation Field model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Field extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'subevaluation_id' => NULL,
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'name' => NULL,
			'title' => NULL,
			'subcategory' => NULL,
			'description' => NULL,
			'type' => NULL,
			'fields[]' => NULL,
			'active' => 1,
			'locked' => 0,
			'rating' => 0,
			'cid' => NULL
		);
	}

	public function getSubevaluationId($field_id = null) {
		$sql = 'SELECT `#__Subevaluation_Field`.`Subevaluation_id` FROM `#__Subevaluation_Field` WHERE `#__Subevaluation_Field`.`Field_id` = ? LIMIT 1';
		$result = $this->execute($sql, $field_id);
		return $result[0]['Subevaluation_id'];
	}
}