<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Compiled Form Answer model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Answer extends Model {
	public $cycleName;

	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'property_id' => 0,
			'division_id' => 0,
			'department_id' => 0,
			'reviewcycle_id' => 0,
			'compiledform_id' => 0,
			'subevaluation_id' => 0,
			'field_id' => 0,
			'user_for_id' => 0,
			'user_by_id' => 0,
			'answer_date' => 0,
			'answer' => null
		);
	}

	public function createHourliesTable($name) {
		$this->cycleName = $name;
		// Create table for hourly associates.
		$sql = <<<CREATETABLE
DROP TABLE IF EXISTS `#__{$name}_associates`;
CREATE TABLE IF NOT EXISTS `#__{$name}_associates` (
	`aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`id` char(16) NOT NULL,
	`comp` char(8) NOT NULL,
	`emp_no` char(8) NOT NULL,
	`name` varchar(256) NOT NULL,
	`home_loc` int unsigned NOT NULL,
	`home_loc_desc` varchar(256) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `aid` (`aid`),
	KEY `employee_id` (`comp`, `emp_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Hourly Associates Table.';
CREATETABLE;
		$this->execute($sql);
	}

	public function createEmailsTable($name) {
		$this->cycleName = $name;
		// Create table for peer emails.
		$sql = <<<CREATETABLE
DROP TABLE IF EXISTS `#__{$name}_emails`;
CREATE TABLE IF NOT EXISTS `#__{$name}_emails` (
	`aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`id` char(16) NOT NULL,
	`token` char(24) NOT NULL,
	`email` varchar(256) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `aid` (`aid`),
	KEY `token` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Peer Emails Table.';
CREATETABLE;
		$this->execute($sql);
	}

	public function createTable($name) {
		$this->cycleName = $name;
		// Create the Answers table.
		$sql = <<<CREATETABLE
DROP TABLE IF EXISTS `#__$name`;
CREATE TABLE IF NOT EXISTS `#__$name` (
	`aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` char(16) NOT NULL,
	`division_id` char(16) NOT NULL,
	`department_id` char(16) NOT NULL,
	`reviewcycle_id` char(22) NOT NULL,
	`compiledform_id` char(16) NOT NULL,
	`subevaluation_id` char(16) NOT NULL,
	`field_id` char(16) NOT NULL,
	`user_for_id` char(16) NULL,
	`user_by_id` char(16) NOT NULL,
	`answer_date` int(10) unsigned NOT NULL,
	`answer` varchar(2048) NOT NULL,
	PRIMARY KEY (`compiledform_id`, `subevaluation_id`, `field_id`, `user_for_id`, `user_by_id`),
	UNIQUE KEY `aid` (`aid`),
	KEY `compiledform_id` (`compiledform_id`),
	KEY `user_for_id` (`user_for_id`),
	KEY `user_by_id` (`user_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Answer Table.';
CREATETABLE;
		$this->execute($sql);


		// Create the Summary table.
		$sql = <<<CREATETABLE
DROP TABLE IF EXISTS `#__{$name}_summary`;
CREATE TABLE IF NOT EXISTS `#__{$name}_summary` (
	`aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` char(16) NOT NULL,
	`division_id` char(16) NOT NULL,
	`department_id` char(16) NOT NULL,
	`compiledform_id` char(16) NOT NULL,
	`subevaluation_id` char(16) NOT NULL,
	`field_id` char(16) NOT NULL,
	`user_for_id` char(16) NOT NULL,
	`summary` varchar(2048),
	`cummulation` varchar(256) DEFAULT NULL,
	`override` tinyint(3) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`property_id`, `compiledform_id`, `subevaluation_id`, `field_id`, `user_for_id`),
	UNIQUE KEY `aid` (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Answer Summary Table.';
CREATETABLE;
		$this->execute($sql);
	}

	public function createRecord($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $userForId, $userById) {
		$sql = <<<ADDRECORD
INSERT INTO `#__{$this->cycleName}` (
	`property_id`,
	`division_id`,
	`department_id`,
	`reviewcycle_id`,
	`compiledform_id`,
	`user_for_id`,
	`user_by_id`
) VALUES (
	'$propertyId',
	'$divisionId',
	'$departmentId',
	'$reviewcycleId',
	'$compiledformId',
	'$userForId',
	'$userById'
);
ADDRECORD;
		$this->execute($sql);
	}

	public function addAnswer($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $subevaluationId, $fieldId, $userForId, $userById, $answer) {
		$cycleTable = '';
		$override = 0;
		$summary = null;
		if ($reviewcycleId != '' || $reviewcycleId != NULL){
			$cycleTable = $reviewcycleId;
		} else {
			$cycleTable = $this->cycleName;
		}
		$time = time();
		$sql = <<<UPDATERECORD
UPDATE `#__{$cycleTable}`
SET `answer_date` = $time,
	`answer` = ?
WHERE `property_id` = '$propertyId'
	AND `division_id` = '$divisionId'
	AND `department_id` = '$departmentId'
	AND `reviewcycle_id` = '$reviewcycleId'
	AND `compiledform_id` = '$compiledformId'
	AND `subevaluation_id` = '$subevaluationId'
	AND `field_id` = '$fieldId'
	AND `user_for_id` = '$userForId'
	AND `user_by_id` = '$userById'
LIMIT 1;
UPDATERECORD;
		$result = $this->execute($sql, $answer);

		// Check if the answer was numeric, manager-override, or text.
		$fieldModel = get_model('field');
		$field = $fieldModel->getOne($fieldId, 'id');
		$forUser = get_model('user');
		$byUser = get_model('user');
		$forUser->loadUser($userForId);
		$byUser->loadUser($userById);
		$isManager = ($byUser->acl->role['level'] != '20' && ($byUser->acl->role['level'] > $forUser->acl->role['level']));
		$scoreAvg = null;
		
		// GET CUMMULATION		
		$subevaluation = get_model('subevaluation')->getOne($subevaluationId, 'id');
		$cummulation = $subevaluation['cummulation'];
		if ($field['type'] == 'rating' && is_numeric($answer)) {
			if (false === $isManager) {
				// Numeric! Get the current average of the answers.
				$sql = <<<SELECTANSWERS
SELECT `answer`
FROM `#__{$cycleTable}`
WHERE `property_id` = '$propertyId'
	AND `division_id` = '$divisionId'
	AND `department_id` = '$departmentId'
	AND `reviewcycle_id` = '$reviewcycleId'
	AND `compiledform_id` = '$compiledformId'
	AND `subevaluation_id` = '$subevaluationId'
	AND `field_id` = '$fieldId'
	AND `user_for_id` = '$userForId'
SELECTANSWERS;
				$result = $this->execute($sql);
				$scoreSum = 0;
				$count = 0;
				foreach ($result as $score) {
					if (is_numeric($score['answer'])) {
						$count = $count+1;
						$scoreSum += $score['answer'];
					}
				}
				if ($count > 0){
					$scoreAvg = $scoreSum / $count;
				} else {
					$scoreAvg = $answer;
				}
			} else {
				$override = $answer;
			}
			
			if ($scoreAvg !== null) {
				$summary = $scoreAvg;
			}
			// CHECK OVERRIDE (MANAGER'S ANSWER)
			$sql = <<<CHECKSUMMARY
SELECT `summary`, `override`
FROM `#__{$cycleTable}_summary`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
	AND `subevaluation_id` = ?
	AND `field_id` = ?
CHECKSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$subevaluationId,
				$fieldId
			);
			if (null !== $userForId) {
				$sql .= ' AND `user_for_id` = ?';
				$params[] = $userForId;
			}
			$sql .= ';';
			$result = $this->execute($sql, $params);
			if (!empty($result[0]['override'])){
				if (false === $isManager) {
					$override = $result[0]['override'];
				}
			}
			//pr($summary, "SUMMARY BEFORE ");
			if (!empty($result[0]['summary'])){
				if ($result[0]['summary'] == 0 || $result[0]['summary'] == null){
					$summary = $answer;
				} else {
					if (false !== $isManager) {
						$summary = $result[0]['summary'];
					}
				}
			}
			//pr($summary, "SUMMARY OVERRIDE ");
			// Check to see if this subevaluation is self
			if (false === $isManager) {
				if ($subevaluation['self'] == 1 && $subevaluation['manager'] == 1){
					$summary = $answer;
				}
			}
			//pr($summary, "SUMMARY FINAL ");
			$sql = <<<INSERTSUMMARY
INSERT INTO `#__{$cycleTable}_summary` (
	`property_id`,
	`division_id`,
	`department_id`,
	`compiledform_id`,
	`subevaluation_id`,
	`field_id`,
	`user_for_id`,
	`summary`,
	`cummulation`,
	`override`
) VALUES (
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?
)
ON DUPLICATE KEY UPDATE
	`summary` = ?,
	`cummulation` = ?,
	`override` = ?;
INSERTSUMMARY;
$params = array($propertyId, $divisionId, $departmentId, $compiledformId, $subevaluationId, $fieldId, $userForId, $summary, $cummulation, $override, $summary, $cummulation, $override);
			$this->execute($sql, $params);
		}
	}

	public function OLD_addAnswer($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $subevaluationId, $fieldId, $userForId, $userById, $answer) {
		/*
		$cycleTable = '';
		if ($reviewcycleId != '' || $reviewcycleId != NULL){
			$cycleTable = $reviewcycleId;
		} else {
			$cycleTable = $this->cycleName;
		}
		$time = time();
		$sql = <<<UPDATERECORD
UPDATE `#__{$cycleTable}`
SET `answer_date` = $time,
	`answer` = ?
WHERE `property_id` = '$propertyId'
	AND `division_id` = '$divisionId'
	AND `department_id` = '$departmentId'
	AND `reviewcycle_id` = '$reviewcycleId'
	AND `compiledform_id` = '$compiledformId'
	AND `subevaluation_id` = '$subevaluationId'
	AND `field_id` = '$fieldId'
	AND `user_for_id` = '$userForId'
	AND `user_by_id` = '$userById'
LIMIT 1;
UPDATERECORD;
		$result = $this->execute($sql, $answer);
		// Check if the answer was numeric, manager-override, or text.
		$fieldModel = get_model('field');
		$field = $fieldModel->getOne($fieldId, 'id');
		$forUser = get_model('user');
		$byUser = get_model('user');
		$forUser->loadUser($userForId);
		$byUser->loadUser($userById);
		$isManager = ($byUser->acl->role['level'] > $forUser->acl->role['level']);
		$scoreAvg = null;
		if ($field['type'] == 'rating' && is_numeric($answer)) {
			if (false === $isManager) {
				// Numeric! Get the current average of the answers.
				$sql = <<<SELECTANSWERS
	SELECT `answer`
	FROM `#__{$cycleTable}`
	WHERE `property_id` = '$propertyId'
		AND `division_id` = '$divisionId'
		AND `department_id` = '$departmentId'
		AND `reviewcycle_id` = '$reviewcycleId'
		AND `compiledform_id` = '$compiledformId'
		AND `subevaluation_id` = '$subevaluationId'
		AND `field_id` = '$fieldId'
		AND `user_for_id` = '$userForId'
SELECTANSWERS;
				$result = $this->execute($sql);
				$scoreSum = 0;
				$count = 0;
				foreach ($result as $score) {
					if (is_numeric($score['answer'])) {
						$count = $count+1;
						$scoreSum += $score['answer'];
					}
				}
				if ($count > 0){
					$scoreAvg = $scoreSum / $count;
				} else {
					$scoreAvg = $answer;
				}
			} else {
				$scoreAvg = $answer;
			}
		} else {
			$answer = null;
		}
		// Store the summary field.
		if ($scoreAvg !== null) {
			$sql = <<<CHECKSUMMARY
SELECT `override`
FROM `#__{$cycleTable}_summary`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
	AND `subevaluation_id` = ?
	AND `field_id` = ?
CHECKSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$subevaluationId,
				$fieldId
			);
			if (null !== $userForId) {
				$sql .= ' AND `user_for_id` = ?';
				$params[] = $userForId;
			}
			$sql .= ';';
			$result = $this->execute($sql, $params);
			if (count($result) == 0 || (count($result) > 0 && $result[0]['override'] == 0)) {
				if (false === $isManager) {
					$cummulation = get_model('subevaluation')->getOne($subevaluationId, 'id');
					$cummulation = $cummulation['cummulation'];
					$sql = <<<INSERTSUMMARY
INSERT INTO `#__{$cycleTable}_summary` (
	`property_id`,
	`division_id`,
	`department_id`,
	`compiledform_id`,
	`subevaluation_id`,
	`field_id`,
	`user_for_id`,
	`summary`,
	`cummulation`,
	`override`
) VALUES (
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?,
	?
)
ON DUPLICATE KEY UPDATE
	`summary` = ?,
	`cummulation` = ?,
	`override` = ?;
INSERTSUMMARY;
					$this->execute($sql, array($propertyId, $divisionId, $departmentId, $compiledformId, $subevaluationId, $fieldId, $userForId, $scoreAvg, $cummulation, $isManager, $scoreAvg, $cummulation, $isManager));
				}
			}
		}
	*/
	}
	
	public function getAnswer($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $subevaluationId, $fieldId, $userForId, $userById, $discrete = null, $raters = null) {
		$cycleTable = '';
		$return = array();
		if ($reviewcycleId != '' || $reviewcycleId != NULL){
			$cycleTable = $reviewcycleId;
		} else {
			$cycleTable = $this->cycleName;
		}

		$field = get_model('field')->getOne($fieldId, 'id');
		if ($field['type'] == 'rating' && $discrete != null) {
			// Get from Summary table.
			$sql = <<<SELECTSUMMARY
SELECT * FROM `#__{$cycleTable}_summary`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
	AND `subevaluation_id` = ?
	AND `field_id` = ?
	AND `user_for_id` = ?;
SELECTSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$subevaluationId,
				$fieldId,
				$userForId
			);
		} else {
			// Get from Answer table.
			$sql = <<<SELECTSUMMARY
SELECT * FROM `#__{$cycleTable}`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
	AND `subevaluation_id` = ?
	AND `field_id` = ?
	AND `user_for_id` = ?
SELECTSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$subevaluationId,
				$fieldId,
				$userForId
			);
			if (null !== $userById) {
				$sql .= ' AND `user_by_id` = ?';
				$params[] = $userById;
			}
			$sql .= ';';
		}
		$results = $this->execute($sql, $params);
		foreach ($results as $result){
			if ($raters != null){
				$return[$result['user_by_id']] = $result;
			} elseif ($field['type'] == 'text' && $discrete != null) {
				$return[$result['field_id']][$result['user_by_id']] = $result;
			} else {
				$return[$result['field_id']] = $result;
			}
			
		}
		return $return;
	}
	
	public function getAvg($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $subevaluationId, $fieldId, $userForId) {
		//SELECT `property_id`, `division_id` AVG (summary) as `avg` FROM `tnng_RC_KLdeuBrR4j4SN23a_summary` WHERE 1 GROUP BY `property_id`, `compiledform_id`, `cummulation`
		$cycleTable = '';
		$return = array();
		if ($reviewcycleId != '' || $reviewcycleId != NULL){
			$cycleTable = $reviewcycleId;
		} else {
			$cycleTable = $this->cycleName;
		}
		// Get from Summary table.
		if (null !== $userForId) {
			$sql = <<<SELECTSUMMARY
SELECT `cummulation`, `override`, AVG (
IF(`override` > 0, `override`, `summary`)
) as `avg` FROM `#__{$cycleTable}_summary`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
	AND `user_for_id` = ?
GROUP BY `property_id`, `division_id`, `department_id`, `compiledform_id`, `cummulation`;
SELECTSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$userForId
			);
		} else {
		$sql = <<<SELECTSUMMARY
SELECT AVG (summary) as `avg` FROM `#__{$cycleTable}_summary`
WHERE `property_id` = ?
	AND `division_id` = ?
	AND `department_id` = ?
	AND `compiledform_id` = ?
GROUP BY `property_id`, `division_id`, `department_id`, `compiledform_id`, `cummulation`;
SELECTSUMMARY;
			$params = array(
				$propertyId,
				$divisionId,
				$departmentId,
				$compiledformId,
				$fieldId
			);
		}
		$results = $this->execute($sql, $params);
		foreach ($results as $result){
			$return[$result['cummulation']] = $result;
		}
		return $return;
	}
}
