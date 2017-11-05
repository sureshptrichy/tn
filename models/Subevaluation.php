<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Subevaluation model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */

final class Model_Subevaluation extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'name' => NULL,
			'description' => NULL,
			'active' => 1,
			'evaltype' => NULL,
			'self' => 0,
			'manager' => 0,
			'peer' => 0,
			'cummulation' => NULL,
			'locked' => 0,
			'cid' => NULL
		);
	}

	/**
	 * Return an array of Field arrays.
	 *
	 * @param string $subevaluation_id
	 * @return array
	 */
	public function field($field_id) {
		$sql = 'SELECT `#__Field`.* FROM `#__Field` LEFT JOIN `#__Subevaluation_Field` ON `#__Subevaluation_Field`.`Field_id` = `#__Field`.`id` WHERE `#__Field`.`status` = 1 AND `#__Subevaluation_Field`.`Field_id` = ?';
		$result = $this->execute($sql, $field_id);
		return $result;
	}
	
	public function fields($subevaluation_id) {
		$return = array();
		$sql = 'SELECT `#__Field`.* FROM `#__Field` LEFT JOIN `#__Subevaluation_Field` ON `#__Subevaluation_Field`.`Field_id` = `#__Field`.`id` WHERE `#__Field`.`status` = 1 AND `#__Subevaluation_Field`.`subevaluation_id` = ? ORDER BY `#__Subevaluation_Field`.`aid` ASC' ;
		$result = $this->execute($sql, $subevaluation_id);
		foreach ($result as $fields){
			$return[$fields['id']] = $fields;
		}
		return $return;
	}
	
	public function OLD_fields($subevaluation_id, $getAnswer = NULL, $propertyId = NULL, $divisionId = NULL, $departmentId = NULL, $reviewcycleId = NULL, $compiledformId = NULL, $subevaluationId = NULL, $userForId = NULL, $userById = NULL, $donotsave = NULL, $discrete = null) {
		$return = array();
		$override = null;
		$managerId = get_model('user')->getManager($userForId);
		$sql = 'SELECT `#__Field`.* FROM `#__Field` LEFT JOIN `#__Subevaluation_Field` ON `#__Subevaluation_Field`.`Field_id` = `#__Field`.`id` WHERE `#__Field`.`status` = 1 AND `#__Subevaluation_Field`.`subevaluation_id` = ? ORDER BY `#__Subevaluation_Field`.`aid` ASC' ;
		$result = $this->execute($sql, $subevaluation_id);
		foreach ($result as $fields){
			$return[$fields['id']] = $fields;
			$return[$fields['id']]['value'] = '';
			$return[$fields['id']]['donotsave'] = '';
			if ($getAnswer != null){
				$answer = get_model('answer')->getAnswer($propertyId, $divisionId, $departmentId, $reviewcycleId, $compiledformId, $subevaluationId, $fields['id'], $userForId, $userById, $discrete);
				//$override = get_model('answer')->getAnswer($propertyId, $reviewcycleId, $compiledformId, $subevaluationId, $fields['id'], $userForId, $userById, $discrete = false);
			}			
			if (!empty($answer)){
				if (array_key_exists('answer', $answer[0])){
					$return[$fields['id']]['value'] = $answer[0]['answer'];
				} elseif (array_key_exists('summary', $answer[0])){
					$return[$fields['id']]['value'] = $answer[0]['summary'];
					if($managerId == session('user')){
						$return[$fields['id']]['rating_avg'] = $answer[0]['summary'];
					}
				}
				if (array_key_exists('override', $answer) && $answer[0]['override'] > 0){
					$return[$fields['id']]['rating_avg'] = $answer[0]['override'];
				}
			}
			if($donotsave != null){
				$return[$fields['id']]['donotsave'] = 'displayonly';
			}
			//$return[$fields['id']]['override'] = 0;
		}
		
		/*
		$cycleTblName = $reviewcycleId;
		if ($propertyId != NULL){$propertyId = '`#__'.$cycleTblName.'`.`property_id` = "'.$propertyId.'" ';}
		if ($divisionId != NULL){$divisionId = 'AND `#__'.$cycleTblName.'`.`division_id` = "'.$divisionId.'" ';}
		if ($departmentId != NULL){$departmentId = 'AND `#__'.$cycleTblName.'`.`department_id` = "'.$departmentId.'" ';}
		if ($reviewcycleId != NULL){$reviewcycleId = 'AND `#__'.$cycleTblName.'`.`reviewcycle_id` = "'.$reviewcycleId.'" ';}
		//if ($reviewcycleId != NULL){$reviewcycleId = 'AND `reviewcycle_id` = "revrevrevrev2013" ';}
		if ($compiledformId != NULL){$compiledformId = 'AND `#__'.$cycleTblName.'`.`compiledform_id` = "'.$compiledformId.'" ';}
		if ($subevaluationId != NULL){$subevaluationId = 'AND `#__'.$cycleTblName.'`.`subevaluation_id` = "'.$subevaluationId.'" ';}
		if ($userForId != NULL){$userForId = 'AND `#__'.$cycleTblName.'`.`user_for_id` = "'.$userForId.'" ';}
		if ($userById != NULL){$userById = 'AND `#__'.$cycleTblName.'`.`user_by_id` = "'.$userById.'" ';}
		if ($getAnswer == true){
			//$leftJoin = 'LEFT JOIN `#__'.$cycleTblName.'_summary` ON `#__'.$cycleTblName.'_summary`.`answer_id` = `#__'.$cycleTblName.'`.`aid`';
			$sql = 'SELECT `#__'.$cycleTblName.'`.`answer`, `#__'.$cycleTblName.'`.`field_id`, `#__'.$cycleTblName.'`.`aid` FROM `#__'.$cycleTblName.'` WHERE '.$propertyId.$divisionId.$departmentId.$reviewcycleId.$compiledformId.$subevaluationId.$userForId.$userById;
			$result = $this->execute($sql);
			foreach ($result as $item){
				if (array_key_exists($item['field_id'], $return)){
					$rating_avg = $this->ratingAvg($cycleTblName, $item['aid']);
					$override = $this->ratingOverride($cycleTblName, $item['aid']);
					$return[$item['field_id']]['value'] = $item['answer'];
					$return[$item['field_id']]['answer_id'] = $item['aid'];
					$return[$item['field_id']]['rating_avg'] = $rating_avg;
					$return[$item['field_id']]['override'] = $override;
				}
			}
			$result = $this->execute($sql);
		}
		*/
		return $return;
	}
	
	public function ratingOverride($reviewcycleId, $answerId){
		$sql = 'SELECT `override` FROM `#__'.$reviewcycleId.'_summary` WHERE `answer_id` = "'.$answerId.'"';
		$result = $this->execute($sql);
		if (!empty($result)){
			return $result[0]['override'];
		}
	}
	
	public function ratingAvg($reviewcycleId, $answerId){
		$sql = 'SELECT `summary` FROM `#__'.$reviewcycleId.'_summary` WHERE `answer_id` = "'.$answerId.'"';
		$result = $this->execute($sql);
		if (!empty($result)){
			return $result[0]['summary'];
		}
	}
	
	public function ratings ($subevaluation_id, $getAnswer = NULL, $propertyId = NULL, $divisionId = NULL, $departmentId = NULL, $reviewcycleId = NULL, $compiledformId = NULL, $subevaluationId = NULL, $fieldId = NULL, $userForId = NULL, $userById = NULL){
		$return = array();
		$leftJoin = null;
		$cycleTblName = $reviewcycleId;
		$field_id = $fieldId;
		if ($propertyId != NULL){$propertyId = '`#__'.$cycleTblName.'`.`property_id` = "'.$propertyId.'" ';}
		if ($divisionId != NULL){$divisionId = 'AND `#__'.$cycleTblName.'`.`division_id` = "'.$divisionId.'" ';}
		if ($departmentId != NULL){$departmentId = 'AND `#__'.$cycleTblName.'`.`department_id` = "'.$departmentId.'" ';}
		if ($reviewcycleId != NULL){$reviewcycleId = 'AND `#__'.$cycleTblName.'`.`reviewcycle_id` = "'.$reviewcycleId.'" ';}
		//if ($reviewcycleId != NULL){$reviewcycleId = 'AND `reviewcycle_id` = "revrevrevrev2013" ';}
		if ($compiledformId != NULL){$compiledformId = 'AND `#__'.$cycleTblName.'`.`compiledform_id` = "'.$compiledformId.'" ';}
		if ($subevaluationId != NULL){$subevaluationId = 'AND `#__'.$cycleTblName.'`.`subevaluation_id` = "'.$subevaluationId.'" ';}
		if ($fieldId != NULL){$fieldId = 'AND `#__'.$cycleTblName.'`.`field_id` = "'.$fieldId.'" ';}
		if ($userForId != NULL){$userForId = 'AND `#__'.$cycleTblName.'`.`user_for_id` = "'.$userForId.'" ';}
		if ($getAnswer == true){
			$leftJoin = 'LEFT JOIN `#__Field` ON `#__Field`.`id` = `#__'.$cycleTblName.'`.`field_id`';
			$leftJoin .= ' LEFT JOIN `#__Subevaluation_Field` ON `#__Subevaluation_Field`.`Field_id` = `#__Field`.`id`';
			$leftJoin .= ' LEFT JOIN `#__Subevaluation` ON `#__Subevaluation`.`id` = `#__Subevaluation_Field`.`Subevaluation_id`';
			$sql = 'SELECT `#__'.$cycleTblName.'`.`user_by_id`, `#__'.$cycleTblName.'`.`aid`, `#__'.$cycleTblName.'`.`answer`, `#__'.$cycleTblName.'`.`field_id`, `#__Field`.`type`, `#__Subevaluation`.`cummulation` FROM `#__'.$cycleTblName.'` '.$leftJoin.' WHERE '.$propertyId.$divisionId.$departmentId.$reviewcycleId.$compiledformId.$subevaluationId.$userForId;
			$result = $this->execute($sql);
			if (!empty($result)){
				foreach ($result as $item){
					if ($item['type'] == 'rating'){
						$data = array();
						$user = get_model('user');
						$user->loadUser($item['user_by_id']);
						$userName = $user->firstname.' '.$user->lastname;
						$data['field_id'] = $item['field_id'];
						$data['user_by_id'] = $item['user_by_id'];
						$data['type'] = $item['type'];
						$data['cummulation'] = $item['cummulation'];
						$data['answer'] = $item['answer'];
						$data['user_name'] = $userName;
						$return[$item['aid']] = $data;
					}
					//$return .= $item;
				}
			}
		}
		return $return;
	}
	
	public function getAllWithFields(){
		$return = array();
		// Subevaluations
		$sql = 'SELECT `#__Subevaluation`.* FROM `#__Subevaluation` WHERE `#__Subevaluation`.`status` = 1 ORDER BY `#__Subevaluation`.`aid` ASC';
		$result = $this->execute($sql);
		foreach($result as $subevaluation){
			$return[$subevaluation['id']] = $subevaluation;
			// Subevaluation Fields
			$sql = 'SELECT `#__Subevaluation_Field`.`Field_id` FROM `#__Subevaluation_Field` WHERE `#__Subevaluation_Field`.`Subevaluation_id` = ?';
			$result = $this->execute($sql, $subevaluation['id']);
			foreach ($result as $fields){
				//Fields
				$sql = 'SELECT `#__Field`.* FROM `#__Field` WHERE `#__Field`.`id` = ?';
				$result = $this->execute($sql, $fields['Field_id']);
				foreach ($result as $field){
					$return[$subevaluation['id']]['fields'][$field['id']] = $field;
				} 
			}
		}
		return $return;
	}

	public function removeFields($subevaluation_id) {
		$this->delete($subevaluation_id, 'Subevaluation_id', '#__Subevaluation_Field');
	}

	public function removeField($field_id) {
		$this->delete($field_id, 'id', '#__Field');
	}
	
	public function addField($subevaluation_id, $field_id) {
		$sql = "INSERT INTO `#__Subevaluation_Field` (`Subevaluation_id`, `Field_id`) VALUES (?, ?)";
		$params = array($subevaluation_id, $field_id);
		$this->execute($sql, $params);
	}	
}
