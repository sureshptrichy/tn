<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Strategies & Tactics controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Strategiestactics extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('True North (TNOs)'),
			'view' => 'strategiestactics',
			'main_order' => 10
		);
		$this->permission = array(
			'authenticated'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		$this->ignoreDatesFor = array(
			'Competency',
			'Objective'
		);
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		//pr('S&T');
		$items = getFiltered($this->G, 0, 0, NULL, NULL, NULL, NULL, NULL, TRUE);
		//pr($items);
		tpl_set('items', $items);
		parent::display();
	}
	
	public function config_send($params = NULL) {
		//$this->route['view'] = $this->route['view'].'_edit';
		//$this->permission[] = 'deleteCompetency';
	}

	public function call_send($params) {

		$propertyId = session('property');
		$userModel = get_model("user");
		
		/* save the submitted data */
		$summaryModel = get_model("summary");
		$currentMonth = date("m/y");
		
		$sql = 'SELECT id FROM #__Truenorth_Summary 
						WHERE property_id = "'.$propertyId.'" 
						AND user_id = "'.$this->G->user->id.'" 
						AND DATE_FORMAT(created, "%m/%y") = "'.$currentMonth.'" LIMIT 1';
						
						//exit;
		$this->G->db->executeQuery($sql);
		
		if ($this->G->db->numRows() > 0) {
			while ($result = $this->G->db->getRows()) {
				$summary_id = $result['id'];
			}

			$preload = $summaryModel->getOne($summary_id, 'id');

			$summaryModel->setAll($preload, TRUE);
			//print_r($summaryModel);exit;
		}		
		$summaryModel->submitted = date("Y-m-d H:i:s");
		$summaryModel->user_id = $this->G->user->id;
		$summaryModel->supervisor = $this->G->user->supervisor;
		$summaryModel->property_id = $propertyId;
		$summaryModel->save();

		
		$subject = 'True North submitted';
		$submitted_on = date("M d, Y h:i A");
		$submitted_by = $this->G->user->firstname . ' ' . $this->G->user->lastname;		
		$approval_link = HOST . URL . 'strategiestactics/approve/' . $summaryModel->id;		
		
 		$body = <<<EMAILBODY
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>True North submitted</title>
	</head>
	<body>
		<p><strong>True North Submission Details:</strong></p>
		<p><strong>Name:</strong> {$submitted_by}</p>
		<p><strong>Submitted On: {$submitted_on}</strong></p>
		<p>&nbsp;</p>
		<p>Once you have reviewed and finalized this True North submission, please click on the link below to approve it. <br/>
		<a href="{$approval_link}">{$approval_link}</a>
		</p>
		<p>&nbsp;</p>
		<p>If you believe this email has been sent in error, please ignore it - no further action is necessary</p>
	</body>
</html>
EMAILBODY;
		$headers = array(
			'MIME-Version: 1.0',
			'Content-type: text/html; charset=utf-8',
			'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
			'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
			'From: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
			'Reply-To: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
			'Return-Path: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
			'X-Mailer: PHP/' . phpversion(),
			'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']
		);
				
		$success = false;
		//echo $body;exit;
		if($this->G->user->supervisor) {
			$supervisor = $userModel->getOne($this->G->user->supervisor, "id");
			if(isset($supervisor['username']) && $supervisor['username'] != "") {
				$success = mail($supervisor['username'], $subject, $body, implode("\r\n", $headers));				
			}
		} else {

			$supervisors = array_reverse($userModel->getAllUsers($propertyId));
				
			foreach ($supervisors as $uId => $supervisor) {
				if ($supervisor['role_level'] == SUPERVISOR) {
					//$success = true; 
					$success = mail($supervisor['username'], $subject, $body, implode("\r\n", $headers));
				}
			}
		}

				

		//mail('nick@globi.ca','Test','This is a test', implode("\r\n", $headers));
		if (true === $success) {
			flash('An email has been sent to your supervisor.', 'success');
		} else {
			flash('We had a problem sending the email. Please try again, or contact your administrator for support.', 'danger');
		}
		
		if ($this->G->url->getQuerystringBit('rf')) {
			locate($this->G->url->getQuerystringBit('rf'));
		}
		locate(URL);
		parent::display();
	}


	public function call_approve($params) {
		$model = get_model('summary');

		$summaryData = $model->getOne($params[0], 'id');
		
		//print_r($summaryData);exit;
		
		if(isset($summaryData["supervisor"]) && $summaryData["supervisor"] == session("user")) {
			$model->setAll($summaryData, TRUE);
			$model->approved = date("Y-m-d H:i:s");
			$model->save();
			
			$userModel = get_model("user");
			$summaryUser = $userModel->getOne($summaryData["user_id"], 'id');

			flash('You have successfuly approved ' . $summaryUser["firstname"] . ' ' . $summaryUser["lastname"] . '\'s TN!', 'success');
		} else {
			flash('You are not authorized to approve this TN!', 'danger');			
		}
		locate(URL);
		parent::display();
	}
	
	public function config_newobjective($params = NULL) {
		$this->route['view'] = 'objective_new';
		//$this->permission[] = 'addObjective';
	}

	public function call_newobjective($params) {
		$competencyModel = get_model('competency');
		$competencyId = $params[0];
		
		$actionURL = URL . 'strategiestactics/newobjective/' . $competencyId;
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$objectiveForm = $this->build_objective_form('new', array(
			'competency_id' => $competencyId,
			//'user_id' => session('user'),
			'cid' => session('user'),
			'action' => $actionURL,
			
		));
		//echo "valid";exit;
		if (FALSE === $objectiveForm->valid()) {
			//echo "invalid";exit;
			tpl_set('objectiveForm', $objectiveForm);
		} else {
			//echo "yes valid";exit;
			$objective = $objectiveForm->valid();		
			if (isset($objective['start'])) {
				$objective['start'] = strtotime($objective['start']);
			}
			if (isset($objective['due'])) {
				$objective['due'] = strtotime($objective['due']);
			}
			
			$model = get_model('objective');
			$model->setAll($objective);
			$model->status = 1;
			$model->tn_objective = 1;
			$model->cid = $this->G->user->id;
			$model->user_id = $this->G->user->id;
			
			$model->save();
			
			$competencyModel->addObjective($objective['competency_id'], $model->id);
			$parentModel = get_model('property');
			$parentModel->addObjective(session('property'), $model->id);

			if (session('division') != NULL) {
				$parentModel = get_model('division');
				$parentModel->addObjective(session('division'), $model->id);
			}
			if (session('department') != NULL) {
				$parentModel = get_model('department');
				$parentModel->addObjective(session('department'), $model->id);
			}
			
			flash(_('The objective has been created.'), 'success');
			
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#clp_' . $competencyId);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_editobjective($params = NULL) {
		$this->route['view'] = 'objective_edit';
		//$this->permission[] = 'editObjective';
	}

	public function call_editobjective($params) {
		$model = get_model('objective');
		$objectiveId = $params[0];
		$preload = $model->getOne($objectiveId, 'id');
		$preload['competency_id'] = $model->getCompetency($objectiveId);

		$actionURL = URL . 'strategiestactics/editobjective/' . $preload['competency_id'];
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$objectiveForm = $this->build_objective_form('edit', array_merge(array(
			'competency_id' => $preload['competency_id'],
			'cid' => session('user'),			
			'action' => $actionURL,
		), $preload));
		
		if (FALSE === $objectiveForm->valid()) {
			tpl_set('objectiveForm', $objectiveForm);
		} else {
			$objective = $objectiveForm->valid();
			if (isset($objective['start'])) {
				$objective['start'] = strtotime($objective['start']);
			}
			if (isset($objective['due'])) {
				$objective['due'] = strtotime($objective['due']);
			}

			$model = get_model('objective');
			$model->setAll($objective, TRUE);
			$model->status = 1;
			$model->user_id = $this->G->user->id;
			$model->cid = $this->G->user->id;			

			$model->save();
			
/* 			$competencyModel->addObjective($objective['competency_id'], $model->id);
			
			$strategies = $model->getStrategies($model->id);
			
			if(count($strategies) > 0) {
				foreach($strategies as $strategy) {
					$competencyModel->addStrategy($objective['competency_id'], $strategy['strategy_id']);
				}
			}
			
			$parentModel = get_model('property');
			$parentModel->addObjective(session('property'), $model->id);
			if (session('division') != NULL) {
				$parentModel = get_model('division');
				$parentModel->addObjective(session('division'), $model->id);
			}
			if (session('department') != NULL) {
				$parentModel = get_model('department');
				$parentModel->addObjective(session('department'), $model->id);
			} */
			flash(_('The objective has been updated.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf')  . '#clp_' . $preload['competency_id']);
			}
			locate(URL);
		}
		parent::display();
	}
	
	private function build_objective_form($type = 'new', $preload = array()) {
		
		$preload["action"] = (isset($preload["action"])) ? $preload["action"] : '';
		
		$form = new Form($this->G, array(
			'name' => $type.'-objective',
			'class' => 'form form-objective',
			'id' => 'objective-form', 
			'action' => $preload["action"], 
			'header' => array(
				'text' => sprintf(_('%1$s Objective'), ucfirst($type)),
				'class' => 'form-objective-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addHidden(array(
			'name' => 'competency_id'
		));		
		$form->addTextArea(array(
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Objective'),
			'default' => TRUE
		));
		$form->addDate(array(
			'name' => 'start',
			'class' => 'form-control',
			'label' => _('Start Date')
		));
		$form->addDate(array(
			'name' => 'due',
			'class' => 'form-control',
			'label' => _('Due Date')
		));		
		$name = 'create';
		$label = _('Create');
		if (strtolower($type) == 'edit') {
			$name = 'update';
			$label = _('Update');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}	
	
}
