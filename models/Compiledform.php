<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');

/**
 * Compiled Form model.
 *
 * @package    truenorthng
 * @subpackage Reviews
 */
final class Model_Compiledform extends Model {
	public function __construct(G $G) {
		parent::__construct($G);

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'created' => NULL,
			'status' => 1,
			'name' => NULL,
			'code' => NULL,
			'description' => NULL,
			'active' => 1,
			'evaltype' => NULL,
			'locked' => 0,
			'cid' => NULL
		);
	}

	/**
	 * Return an array of Subevaluation arrays.
	 *
	 * @param string $compiledform_id
	 * @return array
	 */
	public function compiledforms() {
		$return = array();
		if (user_is(SUPER_USER) || user_is(PROPERTY_MANAGER)) {
			//$sql = 'SELECT `#__Compiledform`.* FROM `#__Compiledform` LEFT JOIN `#__Compiledform_Property` ON `#__Compiledform_Property`.`compiledform_id` = `#__Compiledform`.`id` WHERE `#__Compiledform`.`status` = 1 AND `#__Compiledform_Property`.`property_id` = ?';
			$sql = 'SELECT `#__Compiledform`.* FROM `#__Compiledform` LEFT JOIN `#__Compiledform_Property` ON `#__Compiledform_Property`.`compiledform_id` = `#__Compiledform`.`id` WHERE `#__Compiledform`.`status` = 1';
			$result = $this->execute($sql, session('property'));
		} else {
			//$sql = 'SELECT `#__Compiledform`.* FROM `#__Compiledform` LEFT JOIN `#__Compiledform_Property` ON `#__Compiledform_Property`.`compiledform_id` = `#__Compiledform`.`id` WHERE `#__Compiledform`.`status` = 1 AND `#__Compiledform_Property`.`property_id` = ?';
			$sql = 'SELECT `#__Compiledform`.* FROM `#__Compiledform` LEFT JOIN `#__Compiledform_Property` ON `#__Compiledform_Property`.`compiledform_id` = `#__Compiledform`.`id` WHERE `#__Compiledform`.`status` = 1';
			$result = $this->execute($sql, session('property'));
		}
		foreach ($result as $compiledform){
			$return[$compiledform['id']] = $compiledform;
		}
		return $return;
	}	 
	
	public function allsubevaluations($type, $compiledform_id = NULL, $exclude = NULL) {
		$return = array();
		$sql = 'SELECT `#__Subevaluation`.* FROM `#__Subevaluation` WHERE `#__Subevaluation`.`status` = 1 AND `#__Subevaluation`.`evaltype` = "'.$type.'"';
		$result = $this->execute($sql, $compiledform_id);
		foreach ($result as $subevaluation){
			$return[$subevaluation['id']] = $subevaluation;
		}
		if ($exclude){
			$subevaluations = $this->subevaluations($compiledform_id);
			foreach ($subevaluations as $exclude) {
				if (array_key_exists($exclude['id'], $return)) {
					unset($return[$exclude['id']]);
				}
			}
		}
		return $return;
	}
	
	public function subevaluations($compiledform_id) {
		$return = array();
		$sql = 'SELECT `#__Subevaluation`.* FROM `#__Subevaluation` LEFT JOIN `#__Compiledform_Sections` ON `#__Compiledform_Sections`.`join_id` = `#__Subevaluation`.`id` WHERE `#__Subevaluation`.`status` = 1 AND `#__Compiledform_Sections`.`compiledform_id` = ?';
		$result = $this->execute($sql, $compiledform_id);
		
		foreach ($result as $subevaluation){
			$return[$subevaluation['id']] = $subevaluation;
		}
		return $return;
	}
	
	public function sections($compiledform_id) {
		$return = array();
		//$sql = 'SELECT `#__Compiledform_Sections`.*, `#__Subevaluation`.*, `#__Static`.* FROM `#__Compiledform_Sections` LEFT JOIN `#__Subevaluation` ON `#__Subevaluation`.`id` = `#__Compiledform_Sections`.`join_id` LEFT JOIN `#__Static` ON `#__Static`.`id` = `#__Compiledform_Sections`.`join_id` WHERE `#__Compiledform_Sections`.`compiledform_id` = ? ORDER BY `#__Compiledform_Sections`.`aid`';
		//$sql = 'SELECT `#__Compiledform_Sections`.*, `#__Subevaluation`.*, `#__Static`.* FROM `#__Compiledform_Sections` LEFT JOIN `#__Subevaluation` ON `#__Subevaluation`.`id` = `#__Compiledform_Sections`.`join_id` INNER JOIN `#__Static` ON `#__Static`.`id` = `#__Compiledform_Sections`.`join_id` WHERE `#__Compiledform_Sections`.`compiledform_id` = ? ORDER BY `#__Compiledform_Sections`.`aid`';
		//$sql = 'SELECT `#__Compiledform_Sections`.*, `#__Subevaluation`.*, `#__Static`.* FROM `#__Compiledform_Sections` INNER JOIN `#__Subevaluation` INNER JOIN `#__Static` WHERE `#__Compiledform_Sections`.`compiledform_id` = ? ORDER BY `#__Compiledform_Sections`.`aid`';
		
		//$sql = 'SELECT `#__Compiledform_Sections`.* FROM `#__Compiledform_Sections` INNER JOIN `#__Subevaluation` ON `#__Subevaluation`.`id` = `#__Compiledform_Sections`.`join_id` INNER JOIN `#__Static` ON `#__Static`.`id` = `#__Compiledform_Sections`.`join_id` WHERE `#__Compiledform_Sections`.`compiledform_id` = ?';
		
		//$sql = 'SELECT * FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ?';
		
		$sql = 'SELECT a.*, b.`id`, c.`id` FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ? ORDER BY a.`aid` ASC';
		$sql  = 'SELECT a.*, b.*, c.*, ';
		
		// Column values being ovewritten by column c;
		$sql .= 'IFNULL(b.`aid`, c.`aid`) AS `aid`, ';
		$sql .= 'IFNULL(b.`id`, c.`id`) AS `id`, ';
		$sql .= 'IFNULL(b.`created`, c.`created`) AS `created`, ';
		$sql .= 'IFNULL(b.`status`, c.`status`) AS `status`, ';
		$sql .= 'IFNULL(b.`name`, c.`name`) AS `name`, ';
		$sql .= 'IFNULL(b.`locked`, c.`locked`) AS `locked`, ';
		$sql .= 'IFNULL(b.`cid`, c.`cid`) AS `cid` ';
		
		$sql .= 'FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ? ORDER BY a.`aid` ASC';
		
		//$sql = 'SELECT a.*, b.*, b.`name` as name, c.*, c.`name` as name FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ? AND b.`id` = a.`join_id` OR c.`id` = a.`join_id`';
		
		//$sql = 'SELECT a.`join_id`, b.`name` as name, c.`name` as name  FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ?';
		
		//$sql = 'SELECT a.*, b.*, c.* FROM `#__Compiledform_Sections` AS `a` LEFT JOIN (SELECT * FROM `#__Subevaluation`) AS `b` ON `b`.`id` = `a`.`join_id` LEFT JOIN (SELECT * FROM `#__Static`) AS `c` ON `c`.`id` = `a`.`join_id` WHERE a.`compiledform_id` = ?';
		
		//$sql = 'SELECT a.*, b.*, c.* FROM `#__Compiledform_Sections` AS `a` UNION ALL SELECT b.* FROM `#__Subevaluation` AS `b` UNION SELECT c.* FROM `#__Static` AS `c` WHERE a.`compiledform_id` = ?';
		
		//$sql = 'SELECT a.`compiledform_id` AS z, b.`id` AS y, c.`id` AS x FROM `#__Compiledform_Sections` AS a LEFT JOIN `#__Subevaluation` AS b ON b.`id` = a.`join_id` LEFT JOIN `#__Static` AS c ON c.`id` = a.`join_id` WHERE a.`compiledform_id` = ? ORDER BY a.`aid` ASC';
		//$sql = '(SELECT a.* FROM `#__Compiledform_Sections` AS a WHERE a.`compiledform_id` = ?) UNION ALL (SELECT b.*, a.* FROM `#__Subevaluation` AS b, `#__Compiledform_Sections` AS a WHERE b.`id` = a.`join_id`)';
		
		//$sql = 'SELECT `#__Compiledform_Sections`.* FROM `#__Compiledform_Sections` (SELECT `#__Subevaluation`.* FROM `#__Subevaluation`) WHERE `#__Compiledform_Sections`.`compiledform_id` = ?';
		
		$result = $this->execute($sql, $compiledform_id);
		foreach ($result as $section){
			if ($section['aid'] == ''){
				
				if(substr($section['join_id'], 0, 4) == 'SIGN') {
					$section['name'] = _('Signature');
				} else {
					$section['name'] = _('Results/Culture Matrix');
				}
				$section['join_id'] = $section['join_id'];
				$section['id'] = $section['join_id'];
			}
			$return[$section['join_id']] = $section;
		}
		return $return;
	}
	
	public function matrixes ($compiledform_id){
		$sql = 'SELECT `#__Compiledform_Sections`.* FROM `#__Compiledform_Sections` WHERE `#__Compiledform_Sections`.`compiledform_id` = ?';
		$result = $this->execute($sql, $compiledform_id);
		foreach ($result as $section){
			$return[$section['join_id']] = $section;
		}
		return $return;
	}
	
	public function staticsection($static_id) {
		$return = array();
		$sql = 'SELECT `#__Static`.* FROM `#__Static` WHERE `#__Static`.`status` = 1 AND `#__Static`.`id` = ?';
		$result = $this->execute($sql, $static_id);
		foreach($result as $static){
			$return = $static;
		}
		return $return;
	}
	
	public function removeSections($compiledform_id) {
		$this->delete($compiledform_id, 'compiledform_id', '#__Compiledform_Sections');
	}

	public function removeSection($compiledform_id, $join_id) {
		$this->delete($compiledform_id, 'compiledform_id', '#__Compiledform_Sections');
	}	
	
	public function addSection($compiledform_id, $join_id) {
		$sql = "INSERT INTO `#__Compiledform_Sections` (`compiledform_id`, `join_id`) VALUES (?, ?)";
		$params = array($compiledform_id, $join_id);
		$this->execute($sql, $params);
	}

	public function removeProperties($compiledform_id) {
		$this->delete($compiledform_id, 'compiledform_id', '#__Compiledform_Property');
	}

	public function addProperty($compiledform_id, $property_id) {
		$sql = "INSERT INTO `#__Compiledform_Property` (`compiledform_id`, `property_id`) VALUES (?, ?)";
		$params = array($compiledform_id, $property_id);
		$this->execute($sql, $params);
	}
}
