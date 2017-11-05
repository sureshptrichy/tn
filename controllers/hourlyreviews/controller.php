<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Performance Review controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Hourlyreviews extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Hourly Reviews'),
			'view' => 'hourlyreviews',
			'main_order' => 41
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
		
		$myForms = get_model('hourlyreviewform')->currentForms($userId, session("property"));
		
		//print_r($myForms);exit;

		tpl_set('myForms', $myForms);
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
		//$reviewCycle = array_shift($params);
	
	
		// CHECK IF MANAGER OR HIGHER
		$myself = get_model('user');
		$myself->loaduser(session('user'));
		if ($myself->acl->role['level'] != '20' && ($myself->acl->role['level'] >= DEPARTMENT_MANAGER)){
			$managerClearance = true;
		}
		
		//print_r($params);exit;
		
		// 
		$hourlyform = get_model('hourlyreviewform')->getOne($params[0], 'id');
		
		$sectionAnswers = array();
		if($hourlyform["answer"]) {
			$managerAnswers = json_decode($hourlyform["answer"], true);
			$sectionAnswers = $managerAnswers["sections"];
		}
		// COMPILED FORM
		$preload = get_model('Compiledform')->getOne($hourlyform['reviewform_id'], 'id');
		$formtype = 'Review';
		$subevaluations = get_model('Compiledform')->sections($hourlyform['reviewform_id']);
		
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
		
		// Compile Form
		$form = $this->compile_form('review', array_merge($preload, $hourlyform));
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
				$model = get_model("hourlyreviewform");
				$model->setAll($hourlyform);
				$model->id = $params[0];
				$model->answer = $answers;
				$model->status = 1;
				$model->completed_on = time();
				$model->save();
				flash(_('Review Form Completed.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			} else {
				flash(_('Incomplete review. Please answer all questions.'), 'danger');
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
			'hourly_name' => $preload['hourly_name'],
			'property_id' => $preload['property_id'],
			'property_name' => $preload['property_name'],
			'review_cycle' => $preload['review_cycle'],
			'manager_name' => $preload['manager_name'],
			'hourly_position' => $preload['hourly_position'], 
			'reviewform_name' => $preload['reviewform_name'],
			'last_review_date' => $preload['last_review_date'],
			'current_rate' => $preload['current_rate'],
			'hire_date' => $preload['hire_date'],
			'position_date' => $preload['position_date'],
			'seniority_date' => $preload['seniority_date'],
			'hourly_department' => $preload['hourly_department'],
			'hourly_division' => $preload['hourly_division'],
		));
		$form->reviewFormRatingKey(array(
			'name' => 'ratingkey'
		));		
		
		/* $form->addHiddenReviewData(array(
			'name' => 'hiddenReviewData',
			'values' => array(
				'reviewcycle_id' => $preload['target_user']['reviewcycle_id'],
				'property_id' => $preload['target_user']['property']['id'],
				'division_id' => $preload['target_user']['division']['id'],
				'department_id' => $preload['target_user']['department']['id'],
				'user_for_id' => $preload['target_user']['id'],
				'user_by_id' => session('user')
			)
		)); */
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
