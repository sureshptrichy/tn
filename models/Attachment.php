<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Attachment model.
 *
 * @package    truenorthng
 * @subpackage Attachment
 */

final class Model_Attachment extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => NULL,
			'parent_id' => 0,
			'name' => NULL,
			'path' => NULL,
			'mime' => NULL,
			'description' => NULL,
			'cid' => NULL
		);
	}

	public function getAttachments($pid = 0) {
		$return = array();
		if (!is_array($pid)) {
			$pid = array($pid);
		}
		$placeholders = array_fill(0, count($pid), '?');
		$placeholders = implode(',', $placeholders);
		for ($i = 0, $c = count($pid); $i < $c; $i++) {
			//$pid[$i] = "'".$pid[$i]."'";
		}
		$sql = 'SELECT * FROM `#__Attachment` WHERE `status` = 1 AND `parent_id` IN (' . $placeholders . ') ORDER BY `created`';
		$attachments = $this->execute($sql, $pid);
		foreach ($attachments as $attachment) {
			$return[$attachment['id']] = $attachment;
		}
		return $return;
	}
}
