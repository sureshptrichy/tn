<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Performance Review controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Performancereviews extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Leadership Reviews'),
			'view' => 'performancereviews',
			'main_order' => 40
		);
		$this->permission = array(
			'authenticated'
		);
		if (session('reviewcycle')) {
			$this->permission = array(
				'peerReview'
			);
		}
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		if ('all' == session('user_filter')) {
			$userId = session('user');
		} else {
			$userId = session('user_filter');
		}
		$myForms = array();
		$userReviewForms = array();
		$userAverages = array();
		$matrixes = array();
		$ratings = array();
		
		$selfReviewForms = get_model('Reviewcycle')->selfReviewForms($userId);
		$managerReviewForms = get_model('Reviewcycle')->managerReviewForms($userId);
		
		//print_r($selfReviewForms);exit;
		
/* 		$getForms = get_model('Reviewcycle')->currentForms($userId);
		foreach($getForms as $item => $form){
			$targetUser = get_model('user');
			$userType = $this->G->ids->type($form['user_for_id']);
			$targetUser->loadUser($form['user_for_id']);
			$targetUserName = $targetUser->firstname.' '.$targetUser->lastname;
			$compiledForm = get_model('Compiledform')->getOne($form['compiledform_id'], 'id');
			$myForms[$form['user_for_id'].$form['compiledform_id']]['reviewcycle_id'] = $form['reviewcycle_id'];
			$myForms[$form['user_for_id'].$form['compiledform_id']]['compiledform_id'] = $form['compiledform_id'];
			$myForms[$form['user_for_id'].$form['compiledform_id']]['compiledform_name'] = $compiledForm['name'];
			$myForms[$form['user_for_id'].$form['compiledform_id']]['user_for_id'] = $form['user_for_id'];
			$myForms[$form['user_for_id'].$form['compiledform_id']]['user_for_name'] = $targetUserName;
			if ($form['answer'] == '' || $form['answer_date'] == null){
				$myForms[$form['user_for_id'].$form['compiledform_id']]['answer_date'] = 0;
			} else {
				$myForms[$form['user_for_id'].$form['compiledform_id']]['answer_date'] = $form['answer_date'];
			}
		}
		$userList = get_model('user')->getValidUsers();
		foreach ($userList as $user) {
			if ($user['id'] != $userId){
				$userForms = array();
				$getForms = get_model('Reviewcycle')->currentUserForms($user['id']);
				if (!empty($getForms)){
					foreach($getForms as $form => $key){
						$targetUser = get_model('user');
						$targetUser->loadUser($key['user_for_id']);
						$targetUserName = $targetUser->firstname.' '.$targetUser->lastname;
						$compiledForm = get_model('Compiledform')->getOne($key['compiledform_id'], 'id');
						$userForms[$key['user_for_id'].$key['compiledform_id']]['reviewcycle_id'] = $key['reviewcycle_id'];
						$userForms[$key['user_for_id'].$key['compiledform_id']]['compiledform_id'] = $key['compiledform_id'];
						$userForms[$key['user_for_id'].$key['compiledform_id']]['compiledform_name'] = $compiledForm['name'];
						$userForms[$key['user_for_id'].$key['compiledform_id']]['user_for_id'] = $key['user_for_id'];
						$userForms[$key['user_for_id'].$key['compiledform_id']]['user_for_name'] = $targetUserName;
						$userForms[$key['user_for_id'].$key['compiledform_id']]['answer_date'] = $key['answer_date'];
					}
					$userReviewForms[$user['id']] = $userForms;
				}
			}
		}
		$currentPropertyCycles = get_model('Reviewcycle')->allCurrent(session('property'));
		foreach ($currentPropertyCycles as $cycle){
			$reviewCycleId = 'RC_'.$cycle['id'];
			foreach ($userList as $user) {
				$userFormAvg = array();
				$getForms = get_model('Reviewcycle')->currentForms($user['id']);
				if (!empty($getForms)){
					foreach($getForms as $form => $key){
						$property = null;
						$division = null;
						$department = null;
						$resultAvg = null;
						$cultureAvg = null;
						// LOAD USER DATA
						$targetUser = get_model('user');
						$targetUser->loadUser($user['id'], null);
						if (empty($targetUser->property)) {
							$targetUserProperty['all']['id'] = session('property');
						} else {
							$targetUserProperty = $targetUser->property;
						}
						if (empty($targetUser->division)) {
							$targetUserDivision['all']['id'] = session('division');
						} else {
							$targetUserDivision = $targetUser->division;
						}
						if (empty($targetUser->department)) {
							$targetUserDepartment['all']['id'] = session('department');
						} else {
							$targetUserDepartment = $targetUser->department;
						}
						foreach($targetUserProperty as $item => $value){
							$property = $value['id'];
						}
						foreach($targetUserDivision as $item => $value){
							$division = $value['id'];
						}
						foreach($targetUserDepartment as $item => $value){
							$department = $value['id'];
						}
						// LOAD MATRIX DATA
						$answerModel = get_model('answer');
						$averages = $answerModel->getAvg($property, $division, $department, $reviewCycleId, $key['compiledform_id'], null, null, $user['id']);
						if (!empty($averages)){
							if (array_key_exists('results', $averages)){
								$resultAvg = $averages['results']['avg'];
							}
							if (array_key_exists('culture', $averages)){
								$cultureAvg = $averages['culture']['avg'];
							}
							if ($resultAvg > 0){
								$userFormAvg[$key['compiledform_id']]['results'] = $resultAvg;
							} else {
								$userFormAvg[$key['compiledform_id']]['results'] = 0;
							}
							if ($cultureAvg > 0){
								$userFormAvg[$key['compiledform_id']]['culture'] = $cultureAvg;
							} else {
								$userFormAvg[$key['compiledform_id']]['culture'] = 0;
							}
						}
					}
				}
				if (!empty($userFormAvg)){
					foreach ($userFormAvg as $matrix => $matrixKey){
						$userAverages[$reviewCycleId][$user['id']][$matrix] = $matrixKey;
					}
				}
			}
			foreach($userAverages as $key => $userAverage){
				$ratings = array();
				if($key == $reviewCycleId) {
					foreach ($userAverage as $d => $data){
						$n1 = $d;
						foreach ($data as $i => $item){
							$n2 = $i;
							$ratings[$key.'_'.$n1.'_'.$n2] = $item;
						}
					}
				}
			}
			$matrixes[$cycle['id']] = rcMatrix(NULL, NULL, NULL, NULL, $ratings);
		}
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] > 2)){
			tpl_set('matrixes', $matrixes);
		} */
		tpl_set('selfReviewForms', $selfReviewForms);
		tpl_set('managerReviewForms', $managerReviewForms);
		parent::display();
	}

	public function config_peer($params = null) {
		$this->permission = array(
			'viewLogin'
		);
		// INSERT INTO `tn2db`.`tnng_Acl` (`aid`, `role_id`, `perm_id`) VALUES (NULL, 'rrrrrrrrrrrrrrrh', 'pppppppppppppppb'), (NULL, 'rrrrrrrrrrrrrrrh', 'ppppppppppppppre');
	}

	public function call_peer($params) {
		$peerToken = null;
		$propertyId = null;
		$reviewId = null;

		if (isset($params[0])) {
			$peerToken = trim($params[0]);
		}
		if (null !== $this->G->url->getQuerystringBit('pid')) {
			$propertyId = $this->G->url->getQuerystringBit('pid');
		}
		if (null !== $this->G->url->getQuerystringBit('rid')) {
			$reviewId = $this->G->url->getQuerystringBit('rid');
		}
		if ((null === $peerToken || '' === $peerToken) || (null === $propertyId || '' === $propertyId) || (null === $reviewId || '' === $reviewId)) {
			flash('Invalid review URL specified.', 'danger');
			locate(URL.$this->G->url->parentUrl(2));
		}

		$reviews = get_model('property')->getReviews($propertyId);
		if (!array_key_exists($reviewId, $reviews)) {
			flash('Invalid review URL specified.', 'danger');
			locate(URL.$this->G->url->parentUrl(2));
		}

		$review = $reviews[$reviewId];
		$peerModel = get_model('peer');
		$peerModel->setTable('#__RC_' . $reviewId . '_emails');
		$peer = $peerModel->getOne($peerToken, 'token');
		if (count($peer) == 0) {
			flash('Invalid review URL specified.', 'danger');
			locate(URL.$this->G->url->parentUrl(2));
		}
		$user = get_model('user');
		$user->loadUser($peer['id']);
		$user->property = get_model('property')->getOne($propertyId, 'id');
		session('reviewcycle', $reviewId);
		session('user', $user->id);
		session('current_user', $user->id);
		session('property', $propertyId);
		//pr(URL.$this->G->url->parentUrl(2));
		locate(URL.$this->G->url->parentUrl(2));
	}

	public function config_test($params = null) {
		$this->route['view'] = $this->route['view'] . '_test';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_test($params) {
		$page = $params[0];
		$content = '<div id="rcTestLog"></div>';
		$step = 0;
		if ($page == 'begin') {
			if (isset($params[1])) {
				$step = $params[1];
			}
		}
		tpl_set('page', $page);
		tpl_set('step', $step);
		tpl_set('content', $content);
		parent::display();
	}
	
	public function config_selfreview($params = NULL) {
		$this->route['view'] = $this->route['view'].'_view';
		$this->permission[] = 'viewCompiledform';
	}


	public function call_selfreview ($params){

		$preload = array();
		$property = array();
		$division = array();
		$department = array();
		$ratings = array();
		$matrix = array();
		$averages = array();
		$peerAnswers = array();
		$resultAvg = 0;
		$cultureAvg = 0;
		$managerClearance = null;
		$arbirtary = null;
		//$reviewCycle = get_model('Reviewcycle')->current();
		//$reviewCycle = array_shift($params);
	
	
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] >= DEPARTMENT_MANAGER)){
			$managerClearance = true;
		}
		
		//print_r($params);exit;
		
		// 
		$reviewForm = get_model('answer')->getReviewAnswer($params[0], 'id');
		
		$sectionAnswers = array();
		if($reviewForm["answer"]) {
			$managerAnswers = json_decode($reviewForm["answer"], true);
			$sectionAnswers = $managerAnswers["sections"];
		}
		
		// COMPILED FORM
		$preload = get_model('Compiledform')->getOne($reviewForm['reviewform_id'], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($reviewForm['reviewform_id']);
		
		// CHECK USER
		$userId = session('user_filter');
		if ($userId == '' || $userId == null || $userId == 'all'){
			$userId = session('user');
		}
		
		// SUB EVALUATION
		foreach ($subevaluations as $subevaluation){
			$subevaluationModel = get_model('subevaluation');
			$loadSubEval = true;
			$donotsave = null;
			$allowOverride = null;
			$rateable = true;
			$discrete = true;
			
			// LOAD SUB EVALUATION
			if ($loadSubEval != null){
				//$preload['sections'][$subevaluation['id']] = $subevaluation;
				
				// LOAD FIELDS
				$subevaluation['fields'] = $subevaluationModel->fields($subevaluation['id']);
				foreach ($subevaluation['fields'] as $field){
					
					$subevaluation['fields'][$field['id']]['value'] = '';
					if ($rateable != null) {
						$subevaluation['fields'][$field['id']]['rateable'] = true;
					}
					
					if(array_key_exists($subevaluation['id'], $sectionAnswers)) {
						$section_id = $subevaluation['id'];
						$field_id = $field['id'];
						$sectionAnswer = $sectionAnswers[$subevaluation['id']]['fields'];
						if(array_key_exists($field_id, $sectionAnswer)) {
							$subevaluation['fields'][$field['id']]['value'] = $sectionAnswer[$field['id']];
						}
					}
					
					/*
					// LOAD MATRIX DATA
					if($subevaluation['name'] == 'Results/Culture Matrix') {
						$answers = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], NULL, NULL, TRUE);
					}
					*/
				}
				
				
				$preload['sections'][$subevaluation['id']] = $subevaluation;
			}			
			
			// MATRIX SUB EVALUATION
			if($subevaluation['name'] == 'Results/Culture Matrix') {
				//pr("THE MATRIX HAS YOU...");
				$preload['sections'][$subevaluation['id']] = $subevaluation;	
				$preload['sections'][$subevaluation['id']]['fields'] = array();
			}
		}
		//pr($preload['sections']);
		// RETRIEVE POSTED DATA AND ADD TO PRELOAD
		if ($this->G->url->getPostBit('tnngtoken') != null){
			$posted = $this->G->url->getPost();
			foreach ($preload['sections'] as $psection){
				if (array_key_exists('sections', $posted)){
					if (array_key_exists($psection['id'], $posted['sections'])){
						foreach ($psection['fields'] as $field){
							foreach($posted['sections'] as $section){
								if (array_key_exists($field['id'], $section['fields'])){
									$preload['sections'][$psection['id']]['fields'][$field['id']]['value'] = $section['fields'][$field['id']];
								}
							}
						}
					}
				}
			}
		}
		
		
		$preload['results_avg'] = $resultAvg;
		$preload['culture_avg'] = $cultureAvg;
		
		$model = get_model('user');
		$loadManager = $model->loadUser($myself->supervisor);
		$manager = $loadManager['firstname'].' '.$loadManager['lastname'];
		
		$targetUser = $myself;

		$targetUserName = $targetUser->firstname.' '.$targetUser->lastname;	
		if (empty($targetUser->property)) {
			$targetUserProperty['all']['id'] = session('property');
			$targetUserProperty['all']['name'] = 'All Properties';
		} else {
			$targetUserProperty = $targetUser->property;
		}
		if (empty($targetUser->division)) {
			$targetUserDivision['all']['id'] = session('division');
			$targetUserDivision['all']['name'] = 'All Divisions';
		} else {
			$targetUserDivision = $targetUser->division;
		}
		if (empty($targetUser->department)) {
			$targetUserDepartment['all']['id'] = session('department');
			$targetUserDepartment['all']['name'] = 'All Departments';
		} else {
			$targetUserDepartment = $targetUser->department;
		}
		foreach($targetUserProperty as $item => $value){
			$property['id'] = $value['id'];
			$property['name'] = $value['name'];
		}
		foreach($targetUserDivision as $item => $value){
			$division['id'] = $value['id'];
			$division['name'] = $value['name'];
		}
		foreach($targetUserDepartment as $item => $value){
			$department['id'] = $value['id'];
			$department['name'] = $value['name'];
		}		
		
		$targetUserData['target_user']['id'] = $myself->id;		
		$targetUserData['target_user']['reviewcycle_id'] = $reviewForm["review_name"];
		$targetUserData['target_user']['name'] = $myself->firstname . ' '. $myself->lastname;				
		$targetUserData['target_user']['manager'] = $manager;			
		$targetUserData['target_user']['manager_id'] = $myself->supervisor;		
		$targetUserData['target_user']['property'] = $property;
		$targetUserData['target_user']['division'] = $division;
		$targetUserData['target_user']['department'] = $department;	
		
		
		// Compile Form
		$form = $this->compile_form('review', array_merge($preload, $targetUserData));
		if (FALSE === $form->valid()) {
			tpl_set('form', $form);
		} else {
			tpl_set('form', $form);
			$form = $form->valid();
			$failed = null;
			$anwsers = array();
			
			foreach ($preload['sections'] as $section){
				if(array_key_exists('sections', $form)){
					if (array_key_exists($section['id'], $form['sections'])){
						if (array_key_exists('fields', $section)){
							foreach ($section['fields'] as $field){
								foreach ($form['sections'] as $formSection => $sectionId){
									//pr($formSection);
									if ($section['id'] == $formSection) {
										if (array_key_exists($field['id'], $sectionId['fields'])){
											foreach ($sectionId as $key){
												$answers[$formSection] = $sectionId;
											}
										} else {
											//$failed = true;
										}
									}
								}
							}
						}
					}
				} else {
					//$failed = true;
				}
			}

//print_r($answers);		
			
			foreach ($preload['sections'] as $section){
				foreach ($section['fields'] as $field){
					if (!empty($answers)) {
						if (array_key_exists($field['id'], $answers)){
						pr($field['id']);
							pr($field['id'].' '.$answers[$field['id']]);
							if ($answers[$field['id']] == '' || $answers[$field['id']] == null){
								pr($answers[$field['id']].' = '.$answers[$field['id']]);
								pr("FAILED");
								$failed = true;
							}
						} 
					} else {
						$failed = true;	
					}
				}
			}				
			
			
			if ($failed == null && !empty($answers)){
				$answers = json_encode($form);
				get_model('answer')->addReviewAnswer($answers, $params[0]);
				
				flash(_('You have successfully submitted your Leadership Review Form.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			} else {
				flash(_('Incomplete review. Please answer all questions.'), 'danger');
			}
			//locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	public function config_mgrreview($params = NULL) {
		$this->route['view'] = $this->route['view'].'_view';
		$this->permission[] = 'viewCompiledform';
	}


	public function call_mgrreview ($params){

		$preload = array();
		$property = array();
		$division = array();
		$department = array();
		$ratings = array();
		$matrix = array();
		$averages = array();
		$peerAnswers = array();
		$resultAvg = 0;
		$cultureAvg = 0;
		$managerClearance = null;
		$arbirtary = null;
		//$reviewCycle = get_model('Reviewcycle')->current();
		//$reviewCycle = array_shift($params);
	
	
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] >= DEPARTMENT_MANAGER)){
			$managerClearance = true;
		}
		
		//print_r($params);exit;
		
		// 
		$reviewForm = get_model('answer')->getReviewAnswer($params[0], 'id');
		
		$sectionAnswers = array();
		if($reviewForm["answer"]) {
			$selfAnswers = json_decode($reviewForm["answer"], true);
			$sectionAnswers = $selfAnswers["sections"];
		}

		if($reviewForm["answer"]) {
			$managerAnswers = json_decode($reviewForm["manager_answer"], true);
			$managerAnswers = $managerAnswers["sections"];
		}
		
		// COMPILED FORM
		$preload = get_model('Compiledform')->getOne($reviewForm['reviewform_id'], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($reviewForm['reviewform_id']);
		
		// CHECK USER
		$userId = session('user_filter');
		if ($userId == '' || $userId == null || $userId == 'all'){
			$userId = session('user');
		}
		
		// SUB EVALUATION
		foreach ($subevaluations as $subevaluation){
			$subevaluationModel = get_model('subevaluation');
			$loadSubEval = true;
			$donotsave = null;
			$allowOverride = null;
			$rateable = true;
			$discrete = true;
			
			// LOAD SUB EVALUATION
			if ($loadSubEval != null){
				//$preload['sections'][$subevaluation['id']] = $subevaluation;
				
				// LOAD FIELDS
				$subevaluation['fields'] = $subevaluationModel->fields($subevaluation['id']);
				foreach ($subevaluation['fields'] as $field){
					
					$subevaluation['fields'][$field['id']]['value'] = '';
					if ($rateable != null) {
						$subevaluation['fields'][$field['id']]['rateable'] = true;
					}
					
					if(array_key_exists($subevaluation['id'], $sectionAnswers)) {
						$section_id = $subevaluation['id'];
						$field_id = $field['id'];
						$sectionAnswer = $sectionAnswers[$subevaluation['id']]['fields'];
						$managerAnswer = $managerAnswers[$subevaluation['id']]['fields'];
						if(array_key_exists($field_id, $sectionAnswer)) {
							$subevaluation['fields'][$field['id']]['answer'] = $sectionAnswer[$field['id']];
						}
						if(array_key_exists($field_id, $managerAnswer)) {
							$subevaluation['fields'][$field['id']]['value'] = $managerAnswer[$field['id']];
						}
					}
					
					/*
					// LOAD MATRIX DATA
					if($subevaluation['name'] == 'Results/Culture Matrix') {
						$answers = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], NULL, NULL, TRUE);
					}
					*/
				}
				
				
				$preload['sections'][$subevaluation['id']] = $subevaluation;
			}			
			
			// MATRIX SUB EVALUATION
			if($subevaluation['name'] == 'Results/Culture Matrix') {
				//pr("THE MATRIX HAS YOU...");
				$preload['sections'][$subevaluation['id']] = $subevaluation;	
				$preload['sections'][$subevaluation['id']]['fields'] = array();
			}
		}
		//pr($preload['sections']);
		// RETRIEVE POSTED DATA AND ADD TO PRELOAD
		if ($this->G->url->getPostBit('tnngtoken') != null){
			$posted = $this->G->url->getPost();
			foreach ($preload['sections'] as $psection){
				if (array_key_exists('sections', $posted)){
					if (array_key_exists($psection['id'], $posted['sections'])){
						foreach ($psection['fields'] as $field){
							foreach($posted['sections'] as $section){
								if (array_key_exists($field['id'], $section['fields'])){
									$preload['sections'][$psection['id']]['fields'][$field['id']]['value'] = $section['fields'][$field['id']];
								}
							}
						}
					}
				}
			}
		}
		
		
		$preload['results_avg'] = $resultAvg;
		$preload['culture_avg'] = $cultureAvg;
		
		$model = get_model('user');
		$loadManager = $model->loadUser($reviewForm["user_for_id"]);
		$manager = $loadManager['firstname'].' '.$loadManager['lastname'];
		
		$targetUserModel = get_model('user');
		//echo $reviewForm["user_for_id"];exit;
		$targetUser = $targetUserModel->loadUser($reviewForm["user_for_id"]);

		$targetUserName = $targetUser['firstname'].' '.$targetUser['lastname'];
		
		if (empty($targetUser->property)) {
			$targetUserProperty['all']['id'] = session('property');
			$targetUserProperty['all']['name'] = 'All Properties';
		} else {
			$targetUserProperty = $targetUser->property;
		}
		if (empty($targetUser->division)) {
			$targetUserDivision['all']['id'] = session('division');
			$targetUserDivision['all']['name'] = 'All Divisions';
		} else {
			$targetUserDivision = $targetUser->division;
		}
		if (empty($targetUser->department)) {
			$targetUserDepartment['all']['id'] = session('department');
			$targetUserDepartment['all']['name'] = 'All Departments';
		} else {
			$targetUserDepartment = $targetUser->department;
		}
		foreach($targetUserProperty as $item => $value){
			$property['id'] = $value['id'];
			$property['name'] = $value['name'];
		}
		foreach($targetUserDivision as $item => $value){
			$division['id'] = $value['id'];
			$division['name'] = $value['name'];
		}
		foreach($targetUserDepartment as $item => $value){
			$department['id'] = $value['id'];
			$department['name'] = $value['name'];
		}		
		
		$targetUserData['target_user']['id'] = $reviewForm["user_for_id"];		
		$targetUserData['target_user']['reviewcycle_id'] = $reviewForm["review_name"];
		$targetUserData['target_user']['name'] = $targetUserName;				
		$targetUserData['target_user']['manager'] = $manager;			
		$targetUserData['target_user']['manager_id'] = $myself->supervisor;		
		$targetUserData['target_user']['property'] = $property;
		$targetUserData['target_user']['division'] = $division;
		$targetUserData['target_user']['department'] = $department;	
		
		
		// Compile Form
		$form = $this->compile_form('review', array_merge($preload, $targetUserData));
		if (FALSE === $form->valid()) {
			tpl_set('form', $form);
		} else {
			tpl_set('form', $form);
			$form = $form->valid();
			$failed = null;
			$anwsers = array();
			
			foreach ($preload['sections'] as $section){
				if(array_key_exists('sections', $form)){
					if (array_key_exists($section['id'], $form['sections'])){
						if (array_key_exists('fields', $section)){
							foreach ($section['fields'] as $field){
								foreach ($form['sections'] as $formSection => $sectionId){
									//pr($formSection);
									if ($section['id'] == $formSection) {
										if (array_key_exists($field['id'], $sectionId['fields'])){
											foreach ($sectionId as $key){
												$answers[$formSection] = $sectionId;
											}
										} else {
											//$failed = true;
										}
									}
								}
							}
						}
					}
				} else {
					//$failed = true;
				}
			}

//print_r($answers);		
			
			foreach ($preload['sections'] as $section){
				foreach ($section['fields'] as $field){
					if (!empty($answers)) {
						if (array_key_exists($field['id'], $answers)){
						pr($field['id']);
							pr($field['id'].' '.$answers[$field['id']]);
							if ($answers[$field['id']] == '' || $answers[$field['id']] == null){
								pr($answers[$field['id']].' = '.$answers[$field['id']]);
								pr("FAILED");
								$failed = true;
							}
						} 
					} else {
						$failed = true;	
					}
				}
			}				
			
			
			if ($failed == null && !empty($answers)){
				$answers = json_encode($form);
				get_model('answer')->addManagerReviewAnswer($answers, $params[0]);
				
				flash(_('You have successfully reviewed the Leadership Review Form.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			} else {
				flash(_('Incomplete review. Please answer all questions.'), 'danger');
			}
			//locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}
	
	public function config_review($params = NULL) {
		$this->route['view'] = $this->route['view'].'_view';
		$this->permission[] = 'viewCompiledform';
	}
	
	public function call_review ($params){

		$preload = array();
		$property = array();
		$division = array();
		$department = array();
		$ratings = array();
		$matrix = array();
		$averages = array();
		$peerAnswers = array();
		$resultAvg = 0;
		$cultureAvg = 0;
		$managerClearance = null;
		$arbirtary = null;
		//$reviewCycle = get_model('Reviewcycle')->current();
		$reviewCycle = array_shift($params);
	
		// USER FOR ELEMENTS
	
		$targetUser = get_model('user');
		$targetUser->loadUser($params[1]);
		$targetUserName = $targetUser->firstname.' '.$targetUser->lastname;	
		if (empty($targetUser->property)) {
			$targetUserProperty['all']['id'] = session('property');
			$targetUserProperty['all']['name'] = 'All Properties';
		} else {
			$targetUserProperty = $targetUser->property;
		}
		if (empty($targetUser->division)) {
			$targetUserDivision['all']['id'] = session('division');
			$targetUserDivision['all']['name'] = 'All Divisions';
		} else {
			$targetUserDivision = $targetUser->division;
		}
		if (empty($targetUser->department)) {
			$targetUserDepartment['all']['id'] = session('department');
			$targetUserDepartment['all']['name'] = 'All Departments';
		} else {
			$targetUserDepartment = $targetUser->department;
		}
		foreach($targetUserProperty as $item => $value){
			$property['id'] = $value['id'];
			$property['name'] = $value['name'];
		}
		foreach($targetUserDivision as $item => $value){
			$division['id'] = $value['id'];
			$division['name'] = $value['name'];
		}
		foreach($targetUserDepartment as $item => $value){
			$department['id'] = $value['id'];
			$department['name'] = $value['name'];
		}
		
		// MANAGER ELEMENTS
		
		$userList = getAllValidUsers();
		$model = get_model('user');
		$managerId = $model->getManager($params[1]);
		if (session('user_filter')){
			$userId = session('user_filter');
		} else {
			$userId = session('user');
		}
		$loadManager = $model->loadUser($managerId);
		$manager = $loadManager['firstname'].' '.$loadManager['lastname'];
	
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] > $targetUser->acl->role['level'])){
			$managerClearance = true;
		}

		// LOAD ELEMENTS
		
		$targetUserData['target_user']['id'] = $params[1];		
		$targetUserData['target_user']['reviewcycle_id'] = $reviewCycle;
		$targetUserData['target_user']['name'] = $targetUserName;				
		$targetUserData['target_user']['manager'] = $manager;			
		$targetUserData['target_user']['manager_id'] = $managerId;		
		$targetUserData['target_user']['property'] = $property;
		$targetUserData['target_user']['division'] = $division;
		$targetUserData['target_user']['department'] = $department;	

		
		// COMPILED FORM
		$preload = get_model('Compiledform')->getOne($params[0], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($params[0]);
		
		// CHECK USER
		$userId = session('user_filter');
		if ($userId == '' || $userId == null || $userId == 'all'){
			$userId = session('user');
		}
		
		// SUB EVALUATION
		foreach ($subevaluations as $subevaluation){
			$subevaluationModel = get_model('subevaluation');
			$loadSubEval = null;
			$donotsave = null;
			$allowOverride = null;
			$rateable = null;
			$discrete = true;
			


			if ($subevaluation['self'] == 1 && $subevaluation['manager'] == 1) {
				
				// SELF
				if ($userId == $params[1]) {
					//pr("I AM MYSELF LOOKING AT MY OWN REVIEW ");
					$discrete = NULL;
					$loadSubEval = true;
					$rateable = true;
				} elseif ($managerClearance != null) {
					if($managerId == session('user')){
						//pr("I AM REVIEWING A PEER BUT I'M THE MANAGER ");
						$rateable = true;
					} else {
						//pr("I AM A MANAGER OR HIGHER WHO CAN'T MAKE ANY CHANGES HERE ");
					}
					$userId = $params[1];
					$loadSubEval = true;
				}
			} elseif ($subevaluation['peer'] == 1) {
				// PEER
				if ($userId != $params[1] && $managerClearance == null) {
					//pr("I AM REVIEWING A PEER ".$subevaluation['name']);
					$discrete = NULL;
					$loadSubEval = true;
					$rateable = true;
				} elseif ($managerClearance != null) {
					//pr("I AM A MANAGER OR HIGHER ".$subevaluation['name']);
					$loadSubEval = true;
					$userId = null;
				}
			} elseif ($subevaluation['manager'] == 1 && $subevaluation['self'] != 1) {
				// MANAGER
				if ($managerClearance != null) {
					if($managerId == session('user')){
						//pr("I THE MANAGER WHO HAS TO FILL THIS OUT ");
						$rateable = true;
					} else {
						//pr("I AM A MANAGER OR HIGHER ".$subevaluation['name']);
					}
					$loadSubEval = true;
				}
			}
			
			// LOAD SUB EVALUATION
			if ($loadSubEval != null){
				//$preload['sections'][$subevaluation['id']] = $subevaluation;
				
				// LOAD FIELDS
				$subevaluation['fields'] = $subevaluationModel->fields($subevaluation['id']);
				foreach ($subevaluation['fields'] as $field){
					
					$subevaluation['fields'][$field['id']]['value'] = '';
					if ($rateable != null) {
						$subevaluation['fields'][$field['id']]['rateable'] = true;
					}
					
					// LOAD ANSWER
					$answerModel = get_model('answer');
					$answer = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], $userId, $discrete, NULL);		
					if (!empty($answer)){
						if (array_key_exists('summary', $answer[$field['id']])){
							$subevaluation['fields'][$field['id']]['value'] = $answer[$field['id']]['summary'];
							if ($managerClearance != null) {
								$managerAnswer = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], $managerId, NULL, NULL);
								// PASS AVERAGE RATING
								if ($subevaluation['peer'] == 1){
									$subevaluation['fields'][$field['id']]['rating_avg'] = $answer[$field['id']]['summary'];
								}
								if (($subevaluation['self'] == 1 && $subevaluation['manager'] == 1)){
									if (!empty($managerAnswer)){
										$subevaluation['fields'][$field['id']]['answer'] = $answer[$field['id']]['summary'];
										if ($managerId != session('user')) {
											$subevaluation['fields'][$field['id']]['value'] = $managerAnswer[$field['id']]['answer'];
											$subevaluation['fields'][$field['id']]['managerAnswer'] = $managerAnswer[$field['id']]['answer'];
										} else {
											$subevaluation['fields'][$field['id']]['value'] = $managerAnswer[$field['id']]['answer'];
										}
									} else {
										$subevaluation['fields'][$field['id']]['answer'] = $answer[$field['id']]['summary'];
										$subevaluation['fields'][$field['id']]['value'] = '';
									}
								}
								if (($subevaluation['manager'] == 1 && $subevaluation['self'] != 1) && $managerId == session('user')){
									if (!empty($managerAnswer)){
										$subevaluation['fields'][$field['id']]['value'] = $managerAnswer[$field['id']]['answer'];
									}
								}
								if (($subevaluation['manager'] == 1 && $subevaluation['self'] != 1) && $managerId != session('user')){
									$subevaluation['fields'][$field['id']]['answer'] = $answer[$field['id']]['override'];
								}
							}
						} elseif (array_key_exists('answer', $answer[$field['id']]) && ($answer[$field['id']]['answer'] != 0 || $answer[$field['id']]['answer'] != null)){
							$subevaluation['fields'][$field['id']]['value'] = $answer[$field['id']]['answer'];
							if ($managerClearance != null) {
								$subevaluation['fields'][$field['id']]['answer'] = $answer[$field['id']]['answer'];
							}
						} else {
							if ($field['type'] == 'text' && $discrete != null && $managerClearance != null) {
								foreach ($answer as $peer) {
									foreach ($peer as $item){
										if ($item['answer'] != null){
											$model = get_model('user');
											$model->loadUser($item['user_by_id']);
											$peerName = $model->firstname.' '.$model->lastname;	
											$peerAnswers[$item['user_by_id']]['answer'] = $item['answer'];
											$peerAnswers[$item['user_by_id']]['name'] = $peerName;
										}
									}
									$subevaluation['fields'][$field['id']]['peerAnswers'] = $peerAnswers;
								}
							}
						}
					}
					// LOAD PEER RATINGS
					if ($managerClearance != null && $subevaluation['peer'] == 1) {
						$raters = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], NULL, NULL, TRUE);
						if (!empty($raters)){
							foreach ($raters as $rater){
								if ($rater['field_id'] == $field['id']) {
									$user = get_model('user');
									if (session('reviewcycle')) {
										$arbirtary = true;
									}
									$user->loadUser($rater['user_by_id']);
									$userName = $user->firstname.' '.$user->lastname;
									//pr($rater['user_by_id'].' : '.$rater['answer'], "User's Answer ");
									$ratings[$rater['user_by_id']]['field_id'] = $rater['field_id'];
									$ratings[$rater['user_by_id']]['user_by_id'] = $rater['user_by_id'];
									$ratings[$rater['user_by_id']]['answer'] = $rater['answer'];
									$ratings[$rater['user_by_id']]['user_name'] = $userName;
								}
							}
						}
						$subevaluation['fields'][$field['id']]['ratings'] = $ratings;
					}
					/*
					// LOAD MATRIX DATA
					if($subevaluation['name'] == 'Results/Culture Matrix') {
						$answers = $answerModel->getAnswer($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], $subevaluation['id'], $field['id'], $params[1], NULL, NULL, TRUE);
					}
					*/
				}
				$preload['sections'][$subevaluation['id']] = $subevaluation;
			}			
			
			// MATRIX SUB EVALUATION
			if($subevaluation['name'] == 'Results/Culture Matrix' && (($subevaluation['self'] == 1 && $userId == $params[1]) || $managerClearance != null)) {
				//pr("THE MATRIX HAS YOU...");
				$preload['sections'][$subevaluation['id']] = $subevaluation;	
				$preload['sections'][$subevaluation['id']]['fields'] = array();
			}
		}
		//pr($preload['sections']);
		// RETRIEVE POSTED DATA AND ADD TO PRELOAD
		if ($this->G->url->getPostBit('tnngtoken') != null){
			$posted = $this->G->url->getPost();
			foreach ($preload['sections'] as $psection){
				if (array_key_exists('sections', $posted)){
					if (array_key_exists($psection['id'], $posted['sections'])){
						foreach ($psection['fields'] as $field){
							foreach($posted['sections'] as $section){
								if (array_key_exists($field['id'], $section['fields'])){
									$preload['sections'][$psection['id']]['fields'][$field['id']]['value'] = $section['fields'][$field['id']];
								}
							}
						}
					}
				}
			}
		}
		
		// LOAD MATRIX DATA
		$answerModel = get_model('answer');
		$averages = $answerModel->getAvg($property['id'], $division['id'], $department['id'], $reviewCycle, $params[0], NULL, NULL, $params[1]);
		if (!empty($averages)){
			if (array_key_exists('results', $averages)){
				$resultAvg = $averages['results']['avg'];
			}
			if (array_key_exists('culture', $averages)){
				$cultureAvg = $averages['culture']['avg'];
			}
		}
		$preload['results_avg'] = $resultAvg;
		$preload['culture_avg'] = $cultureAvg;
		
		// Compile Form
		$form = $this->compile_form('review', array_merge($preload, $targetUserData));
		if (FALSE === $form->valid()) {
			tpl_set('form', $form);
		} else {
			tpl_set('form', $form);
			$form = $form->valid();
			if ($form['locked'] == 1){
				flash(_('This review has been locked. No further changes can be made.'), 'danger');
			} else {
				$failed = null;
				$anwsers = array();
				/*
				foreach ($form as $key => $value){
					$search = substr($key, 0, 9);
					if ($search == "answer___"){
						$a = str_replace($search, "", $key);
						$answers[$a] = $value; 
					}
				}
				*/
				
				
				foreach ($preload['sections'] as $section){
					if(array_key_exists('sections', $form)){
						if (array_key_exists($section['id'], $form['sections'])){
							if (array_key_exists('fields', $section)){
								foreach ($section['fields'] as $field){
									foreach ($form['sections'] as $formSection => $sectionId){
										//pr($formSection);
										if ($section['id'] == $formSection) {
											if (array_key_exists($field['id'], $sectionId['fields'])){
												foreach ($sectionId as $key){
													$answers[$formSection] = $sectionId;
												}
											} else {
												//$failed = true;
											}
										}
									}
								}
							}
						}
					} else {
						//$failed = true;
					}
				}
				
				
				/*
				foreach ($preload['sections'] as $section){
					$rateable = null;
					if ($section['self'] == 1 && $section['manager'] == 1) {
						// SELF
						if ($userId == $params[1]) {
							$rateable = true;
						} elseif ($managerClearance != null) {
							if($managerId == session('user')){
								$rateable = true;
							}
						}
					} elseif ($subevaluation['peer'] == 1) {
						// PEER
						if ($userId != $params[1] && $managerClearance == null) {
							$rateable = true;
						}
					} elseif ($subevaluation['manager'] == 1 && $subevaluation['self'] != 1) {
						// MANAGER
						if ($managerClearance != null) {
							if($managerId == session('user')){
								$rateable = true;
							}
						}
					}
					if(array_key_exists('sections', $form) ){
						if (!array_key_exists($section['id'], $form['sections'])){
							if (array_key_exists('fields', $section)){
								if (!empty($section['fields'])){
									if ($rateable != null){
										$failed = true;
									}
								}
							}
						} else {
							if (array_key_exists('fields', $section)){
								if (!empty($section['fields'])){
									foreach ($section['fields'] as $field){
										foreach ($form['sections'] as $formSection => $sectionId){
											//pr($formSection);
											if ($section['id'] == $formSection) {
												if (array_key_exists($field['id'], $sectionId['fields'])){
													foreach ($sectionId as $key){
														$answers[$formSection] = $sectionId;
													}
												} else {
													$failed = true;
												}
											}
										}
									}
								}
							}
						}
					}
				}
				*/
				
				
				/*
				foreach ($preload['sections'] as $section){
					foreach ($section['fields'] as $field){
						if (!empty($answers)) {
							if (array_key_exists($field['id'], $answers)){
							pr($field['id']);
								pr($field['id'].' '.$answers[$field['id']]);
								if ($answers[$field['id']] == '' || $answers[$field['id']] == null){
									pr($answers[$field['id']].' = '.$answers[$field['id']]);
									pr("FAILED");
									$failed = true;
								}
							}
						} else {
							$failed = true;	
						}
					}
				}
				*/
				if ($failed == null && !empty($answers)){
					$answerModel = get_model('Answer');
					foreach ($answers as $sectionId => $sections){
						foreach ($sections as $section){
							foreach ($section as $fieldId => $answer){
								//$subevaluationId = get_model('field')->getSubevaluationId($fieldId);
								$answerModel->addAnswer($form['property_id'], $form['division_id'], $form['department_id'], $form['reviewcycle_id'], $form['id'], $sectionId, $fieldId, $form['user_for_id'], $form['user_by_id'], $answer);
							}
						}
					}
					flash(_('Review Form Completed.'), 'success');
					locate('/'.$this->G->url->parentUrl(0));
				} else {
					flash(_('Incomplete review. Please answer all questions.'), 'danger');
				}
			}
			//locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}
	
	// View List of 


	private function randomTagId(){
		return md5(rand().time().rand());
	}	

	private function compile_form($type, $preload = array()) {
		$disabled = null;
		$rating_value = null;
		$ratings_avg = null;
		$ratings = array();
		if(array_key_exists('locked', $preload) AND $preload['locked'] == 1){
			$disabled = true;
		}
		$form = new Form($this->G, array(
			'name' => 'compiledform',
			'class' => 'form compiled-form',
			'header' => array(
				'text' => sprintf(_($preload['name']), ucfirst($type)),
				'class' => 'form-subeval-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		
		$form->addHidden(array(
			'name' => 'locked'
		));
		$form->reviewFormInfo(array(
			'name' => 'Employee Info',
			'target_user' => $preload['target_user']['name'],
			'property' => $preload['target_user']['property']['name'],
			'review_cycle' => $preload['target_user']['reviewcycle_id'],
			'manager' => $preload['target_user']['manager'],
			'department' => $preload['target_user']['department']['name']
		));
		$form->reviewFormRatingKey(array(
			'name' => 'ratingkey'
		));		
		
		$form->addHiddenReviewData(array(
			'name' => 'hiddenReviewData',
			'values' => array(
				'reviewcycle_id' => $preload['target_user']['reviewcycle_id'],
				'property_id' => $preload['target_user']['property']['id'],
				'division_id' => $preload['target_user']['division']['id'],
				'department_id' => $preload['target_user']['department']['id'],
				'user_for_id' => $preload['target_user']['id'],
				'user_by_id' => session('user')
			)
		));

		if(array_key_exists('sections', $preload)){
			//echo "<pre>";
			//print_r($preload['sections']);exit;
			foreach ($preload['sections'] as $section){
				if (array_key_exists('cummulation', $section) AND $section['cummulation'] != 'none' AND $section['cummulation'] != ''){
					$form->openTag(array(
						'name' => $this->randomTagId(),
						'tag' => 'h2',
						'class' => 'cummulation',
						'nowrapper' => true
					));
					$form->addStatic(array(
						'name' => $this->randomTagId(),
						'class' => '',
						'label' => ucwords($section['name']),
						'nowrapper' => true
					));
					$form->closeTag(array(
						'name' => $this->randomTagId(),
						'tag' => 'h2',
						'nowrapper' => true
					));
				}
				if (array_key_exists('content', $section) AND $section['content'] != 'none' AND $section['content'] != ''){
					$form->reviewFormStaticSection(array(
						'name' => $section["id"],
						'class' => '',
						'nowrapper' => true,
						'sectionName' => $section['name'],
						'sectionContent' => $section["content"]
					));
				}
				if (array_key_exists('fields', $section) && count($section['fields']) > 0){
					foreach($section['fields'] as $field){
						if (!empty($field)){
							//pr($field, $field['id'].' ');
							$rating_avg = null;
							$rateable = null;
							$answer = null;
							$peerAnswers = null;
							$managerAnswer = null;
							$rating_value = 0;
							if (array_key_exists('value', $field)){
								$rating_value = $field['value'];
							}
							if (array_key_exists('answer', $field) && $field['answer'] != null){
								$answer = $field['answer'];
							}
							if (array_key_exists('managerAnswer', $field) && $field['managerAnswer'] != null){
								$managerAnswer = $field['managerAnswer'];
							}
							if (array_key_exists('rateable', $field)){
								$rateable = $field['rateable'];
							}
							if (array_key_exists('rating_avg', $field)){
								$rating_avg = $field['rating_avg'];
							}
							if (array_key_exists('ratings', $field)){
								$ratings = $field['ratings'];
							}
							if (array_key_exists('peerAnswers', $field)){
								$peerAnswers = $field['peerAnswers'];
							}
							//$rating = '3.3';
							//pr($rating_value, $section["id"].' ');
							$form->reviewFormSection(array(
								'name' => 'sections['.$section["id"].'][fields]['.$field["id"].']',
								'class' => '',
								'nowrapper' => true,
								'sectionName' => $field['name'],
								'sectionId' => $field['id'],
								'sectionType' => $field["type"],
								'sectionDescription' => $field['description'],
								'value' => $rating_value,
								'answer' => $answer,
								'peerAnswers' => $peerAnswers,
								'managerAnswer' => $managerAnswer,
								'rateable' => $rateable,
								'rating_avg' => $rating_avg,
								'ratings' => $ratings
							));
						}
					}
				}
				//pr($section['name']);
				if ($section['name'] == 'Results/Culture Matrix'){
					$rating_avg = mt_rand (1*10, 5*10) / 10;
					$result_avg = mt_rand (1*10, 5*10) / 10;
					$culture_avg = mt_rand (1*10, 5*10) / 10;
					$form->matrix(array(
						'name' => $this->randomTagId(),
						'result_avg' => $preload['results_avg'],
						'culture_avg' => $preload['culture_avg'],
						'rating_avg' => $rating_avg
					));
				}
				if ($section['name'] == 'Signature'){
					$form->signature(array('name' => $this->randomTagId()));
				}				
			}
		}

		$form->addSubmit(array(
			'name' => 'save',
			'class' => 'btn-primary',
			'label' => 'Save Form'
		));
		
		return $form;
	}

}
