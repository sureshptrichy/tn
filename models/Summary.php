<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Competency model.
 *
 * @package    truenorthng
 * @subpackage Competency
 */

final class Model_Summary extends Model {
	public function __construct(G $G) {
		parent::__construct($G);
		
		$this->setTable(PREFIX . 'Truenorth_Summary');

		// Set immutable $data keys
		$this->data = array(
			'id' => 0,
			'user_id' => NULL,
			'supervisor' => NULL, 
			'property_id' => NULL,
			'submitted' => NULL,
			'approved' => NULL
		);
	}
	public function getSummary($propertyId = 0) {
		$return = array();
		$sql = NULL;
		$params = array();
		$default = array();
		
		if (empty($propertyId)) {
			$propertyId = session('property');
		}		
		
		$userModel = get_model("user");
		$usersList = $userModel->getValidUsers();
		
		$currentYear = session('year');
		
		if(!$currentYear) {
			$currentYear = date("Y");
		}
		
		if ($usersList) {
			
			foreach($usersList as $user) {
				
				//print_r($user);
				$summaryData = array();

				$sql = 'SELECT DATE_FORMAT(created, "%c") AS month, DATE_FORMAT(submitted, "%m/%d/%y") AS submitted, DATE_FORMAT(approved, "%m/%d/%y") AS approved FROM #__Truenorth_Summary 
						WHERE property_id = "'.$propertyId.'" 
						AND user_id = "'.$user["id"].'" 
						AND DATE_FORMAT(created, "%Y") = '.$currentYear.' 
						ORDER BY created ASC';
				$this->G->db->executeQuery($sql);
				
				if ($this->G->db->numRows() > 0) {					
					while ($result = $this->G->db->getRows()) {
						$summaryData[$result['month']] = array($result['submitted'], $result['approved']);
					}
				}
				
				//print_r($summaryData);exit;
				$userName = $user['firstname'] . ' ' . $user['lastname'];
				$return[$user['id']] = array($userName, $summaryData);
			
			}
			
			//print_r($return);exit;
			
		}

		return $return;	
	}
	
}
