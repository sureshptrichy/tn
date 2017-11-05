<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Strategy controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Strategy extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Strategy'),
			'view' => 'strategy'
		);
		$this->permission = array(
			'authenticated',
			'viewStrategy'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		parent::display();
	}

	public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addStrategy';
	}

	public function call_new($params) {
		$parentId = $params[0];
		$parent = NULL;
		$type = NULL;
		$objective_user = NULL;
		if ($parentId != '') {
			$type = strtolower($this->G->ids->type($parentId));
			$pModel = get_model($type);
			$parent = $pModel->getOne($parentId, 'id');
			if (isset($parent['description'])) {
				$parent = parse($parent['description']);
			} else {
				$parent = NULL;
			}
		}
		$showObjective = FALSE;
		if ($type == 'objective') {
			$obj = get_model('objective')->getOne($parentId, 'id');
			
			//print_r($obj);
			$objective_user = $obj["user_id"];
			$comp_id = get_model('objective')->getCompetency($parentId);
			$showObjective = TRUE;
		} else {
			if ($parentId != '') {
				$type = 'competency';
			}
			$comp_id = $parentId;
		}
		
		$users = getUsers($this->G->user->id, 100);
		// $users = array_index_sort($users, 'lastname');

		$users = user_sort_by_name($users);	
		
		$userModel = get_model('user');
		
		if (session('user_filter')){
			$strategy_user = session('user_filter');
			$userId = session('user_filter');
		} else {
			$strategy_user = session('user');
			$userId = session('user');
		}
		
		$user = $userModel->loadUser($strategy_user);
		$division_id = 'all';
		$department_id = 'all';
		if($user['division'] != NULL){		
			foreach($user['division'] as $item){
				$division_id = $item['id'];
			}
		}
		if($user['department'] != NULL){		
			foreach($user['department'] as $item){
				$department_id = $item['id'];
			}
		}
		
		$actionURL = URL . 'strategy/new/' . $parentId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		$strategyForm = $this->build_strategy_form('new', array(
			'user' => $users,
			'user_id' => $userId,
			'show_objective' => $showObjective,
			'objective_user' => $objective_user,
			'parent_type' => $type,
			$type.'_id' => $parentId,
			$type => $parent,
			'action' => $actionURL,
			'competency' => get_model('competency')->getCompetencies(session('property'), FALSE, TRUE),
			'competency_id' => $comp_id,
			'property_id' => session('property'),
			'division_id' => $division_id,
			'department_id' => $department_id
		));
		if (FALSE === $strategyForm->valid()) {
			tpl_set('strategyForm', $strategyForm);
			if(isset($obj)) {
				tpl_set('objective', $obj);	
			}
		} else {

			$strategy = $strategyForm->valid();
			if (isset($strategy['start'])) {
				$strategy['start'] = strtotime($strategy['start']);
			}
			if (isset($strategy['due'])) {
				$strategy['due'] = strtotime($strategy['due']);
			}
			if (isset($strategy['private'])) {
				$strategy['private'] = 1;
			} else {
				$strategy['private'] = 0;
			}

			if (isset($strategy['unassigned_strategy'])) {
				$strategy['unassigned_strategy'] = 1;
			} else {
				$strategy['unassigned_strategy'] = 0;
			}
			
			$strategy['cid'] = session('user');
			$userModel = get_model('user');
			

			//echo "<pre>".print_r($strategy, TRUE)."</pre>";die();
			
			$strategies_list = array("description", "description2", "description3", "description4", "description5");
			
			foreach($strategies_list as $strategy_text) {
								
				if($strategy[$strategy_text]) {
					
					if(isset($objective_user) && $objective_user != NULL) {
						$assigned_users = array($objective_user);
					} else {
						$assigned_users = $strategy['user_id'];
					}
					
					foreach($assigned_users as $assigned_to) {
						
						$user = $userModel->loadUser($assigned_to);
						$division_id = null;
						$department_id = null;
						if($user['division'] != NULL){		
							foreach($user['division'] as $item){
								$division_id = $item['id'];
							}
						}
						if($user['department'] != NULL){		
							foreach($user['department'] as $item){
								$department_id = $item['id'];
							}
						}						
						
						$model = get_model('strategy');
						$model->setAll($strategy);
						$model->description = $strategy[$strategy_text];
						$model->status = 1;
						$model->cid = $this->G->user->id;
						$model->save();
						$parent_reference = 'clp_' . $params[0];
						if ($type == 'objective') {
							$parentModel = get_model('objective');
							$parentModel->addStrategy($params[0], $model->id);
							$parent_reference = 'obj_' . $params[0];
						}
						$parentModel = get_model('competency');
						$parentModel->addStrategy($strategy['competency_id'], $model->id);
						$parentModel = get_model('user');
						$parentModel->addStrategy($assigned_to, $model->id);
						$parentModel = get_model('property');
						$parentModel->addStrategy(session('property'), $model->id);
						if ($division_id != NULL) {
							$parentModel = get_model('division');
							$parentModel->addStrategy($division_id, $model->id);
						}
						if ($department_id != NULL) {
							$parentModel = get_model('department');
							$parentModel->addStrategy($department_id, $model->id);
						}
					}
				}				
			}
		
			//echo "<pre>".print_r($model, TRUE)."</pre>";die();
			flash(_('The strategy has been created.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#' . $parent_reference);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editStrategy';
	}

	public function call_edit($params) {
		$model = get_model('strategy');
		$strategyId = $params[0];
		$preload = $model->getOne($strategyId, 'id');
		$parentId = '';
		$parent = NULL;
		$parentId = $model->getObjective($strategyId);
		$type = NULL;
		if ($parentId != '') {
			$type = strtolower($this->G->ids->type($parentId));
			$pModel = get_model($type);
			$parent = $pModel->getOne($parentId, 'id');
			if (isset($parent['description'])) {
				$parent = parse($parent['description']);
			} else {
				$parent = NULL;
			}
		}
		$users = getUsers($this->G->user->id, 100);
		//$users = array_index_sort($users, 'lastname');
		$users = user_sort_by_name($users);
				
		$userId = $model->getUser($strategyId);
		$showObjective = FALSE;
		
		$obj = array();
		
		if ($type == 'objective') {
			$obj = get_model('objective')->getOne($parentId, 'id');
			$comp_id = $model->getCompetency($strategyId);
			$showObjective = TRUE;
		} else {
			if ($parentId == '' || $parentId == null) {
				$type = 'competency';
			}
			//$comp_id = $parentId;
			$comp_id = $model->getCompetency($strategyId);
		}
		
		$actionURL = URL . 'strategy/edit/' . $strategyId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$strategyForm = $this->build_strategy_form('edit', array_merge(array(
			'user' => $users,
			'user_id' => $userId,
			'show_objective' => $showObjective,
			'parent_type' => $type,
			$type.'_id' => $parentId,
			$type => $parent,
			'action' => $actionURL,
			'competency' => get_model('competency')->getCompetencies(session('property'), FALSE, TRUE),
			'competency_id' => $comp_id,
			'property_id' => session('property')
		), $preload));
		if (FALSE === $strategyForm->valid()) {
			tpl_set('strategyForm', $strategyForm);
			tpl_set('objective', $obj);
		} else {
			$strategy = $strategyForm->valid();
			if (isset($strategy['start'])) {
				$strategy['start'] = strtotime($strategy['start']);
			}
			
			if (isset($strategy['due'])) {
				$strategy['due'] = strtotime($strategy['due']);

				if(isset($preload['due']) && $preload['due'] != $strategy['due']) {
					$strategy['past_due'] = $preload['due'];
				}				
			}
			
			
			if (isset($strategy['private'])) {
				$strategy['private'] = 1;
			} else {
				$strategy['private'] = 0;
			}		

			if (isset($strategy['unassigned_strategy'])) {
				$strategy['unassigned_strategy'] = 1;
			} else {
				$strategy['unassigned_strategy'] = 0;
			}
			
			$strategy['cid'] = session('user');
			/*
			$userModel = get_model('user');
			$user = $userModel->loadUser($strategy['user_id']);
			$division_id = null;
			$department_id = null;
			if($user['division'] != NULL){		
				foreach($user['division'] as $item){
					$division_id = $item['id'];
				}
			}
			if($user['department'] != NULL){		
				foreach($user['department'] as $item){
					$department_id = $item['id'];
				}
			}
			*/
			$division_id = $strategy['division_id'];
			$department_id = $strategy['department_id'];
			//echo "<pre>".print_r($strategy, TRUE)."</pre>";die();
			$model = get_model('strategy');
			$model->setAll($strategy, TRUE);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			$model->removeFromLocations($model->id);
			$parent_reference = 'clp_' . $strategy['competency_id'];
			if ($type == 'objective') {
				$parentModel = get_model('objective');
				$parentModel->addStrategy($parentId, $model->id);
				$parent_reference = ($this->G->url->getQuerystringBit('rf') == URL) ? 'sty_' . $model->id : 'obj_' . $parentId;
			}
			
			$parentModel = get_model('competency');
			$parentModel->addStrategy($strategy['competency_id'], $model->id);
			$parentModel = get_model('user');
			$parentModel->addStrategy($strategy['user_id'], $model->id);
			$parentModel = get_model('property');
			$parentModel->addStrategy(session('property'), $model->id);
			if ($division_id != NULL) {
				$parentModel = get_model('division');
				$parentModel->addStrategy($division_id, $model->id);
			}
			if ($department_id != NULL) {
				$parentModel = get_model('department');
				$parentModel->addStrategy($department_id, $model->id);
			}
			flash(_('The strategy has been updated.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf')  . '#' . $parent_reference);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_complete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_complete';
		$this->permission[] = 'editStrategy';
	}

	public function call_complete($params) {
		$model = get_model('strategy');
		$preload = NULL;
		if (isset($params[0])) {
			$strategyId = $params[0];
			$preload = $model->getOne($params[0], 'id');
		}
		$parentId = '';
		$parent = NULL;
		$parentTest = $model->getObjective($params[0]);
		if (isset($parentTest)) {
			$parentId = $parentTest;
		}
		$type = NULL;
		if ($parentId != '') {
			$type = strtolower($this->G->ids->type($parentId));
			$pModel = get_model($type);
			$parent = $pModel->getOne($parentId, 'id');
			if (isset($parent['description'])) {
				$parent = Parsedown::instance()->parse($parent['description']);
			} else {
				$parent = NULL;
			}
		}
		$showObjective = FALSE;
		$parent_reference = 'clp_' . $parentId;
		if ($type == 'objective') {
			$showObjective = TRUE;
			$parent_reference = 'obj_' . $parentId;
		}
		$competencyModel = get_model('competency');
		$propertyModel = get_model('property');
		$userId = $model->getUser($strategyId);

		$actionURL = URL . 'strategy/complete/' . $strategyId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}

		
		$strategyForm = $this->build_strategy_form('complete', array_merge(array(
			'user' => $propertyModel->getUsers(session('property')),
			'show_objective' => $showObjective,
			'user_id' => $userId,
			'parent_type' => $type,
			$type.'_id' => $parentId,
			$type => $parent,
			'action' => $actionURL,
			'competency' => $competencyModel->getCompetencies(session('property'), FALSE, TRUE),
			'competency_id' => $parentId,
			'property_id' => session('property')
		), $preload));
		if (FALSE === $strategyForm->valid()) {
			tpl_set('strategyForm', $strategyForm);
		} else {
			$strategy = $strategyForm->valid();
			if (isset($strategy['complete'])) {
				$strategy['complete'] = strtotime($strategy['complete']);
			}
			//echo "<pre>".print_r($strategy, TRUE)."</pre>";die();
			$model = get_model('strategy');
			$model->setAll($model->getOne($strategy['id'], 'id'), TRUE);
			$model->comment = $strategy['comment'];
			$model->complete = $strategy['complete'];
			$model->save();
			flash(_('The strategy has been completed.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#' . $parent_reference);
			}
			locate(URL);
		}
		parent::display();
	}

	
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteStrategy';
	}

	public function call_delete($params) {
		$model = get_model('strategy');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));
				
			$model->id = $params[0];
			$model->status = 0;
			$model->save();				
				
			flash(_('The Strategy has been deleted.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf'));
			}			
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}	
	
	private function build_strategy_form($type = 'new', $preload = array()) {
		//pr($preload);
		$titleuser = get_model('user')->loadUser($preload['user_id']);
		if (session('user_filter')){
			$title = sprintf(_('%1$s Strategy for '.$titleuser['firstname'].' '.$titleuser['lastname']), ucfirst($type));
		} else {
			$title = sprintf(_('%1$s Strategy'), ucfirst($type));
		}
		
		$preload["action"] = (isset($preload["action"])) ? $preload["action"] : '';
		
		if (isset($preload['show_objective']) && $preload['show_objective'] && isset($preload['objective_user']) && $preload["objective_user"] != NULL) {
			$preload["user_id"] = $preload["objective_user"];
		}
		
		$form = new Form($this->G, array(
			'name' => $type.'-strategy',
			'class' => 'form form-strategy',
			'id' => 'strategy-form',
			'action' => $preload["action"], 
			'header' => array(
				'text' => $title,
				'class' => 'form-strategy-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		if (isset($preload['show_objective']) && $preload['show_objective']) {
			$form->addHidden(array(
				'name' => 'objective_id'
			));
			$form->addStatic(array(
				'name' => 'objective',
				'class' => '',
				'label' => _('Objective')
			));
			$form->addHidden(array(
				'name' => 'competency_id',
				'class' => 'form-control',
				'label' => _('Competency'),
				'values' => $preload['competency_id']
			));
		} else {
			$form->addHidden(array(
				'name' => 'property_id'
			));
			if (isset($preload['parent_type']) && $preload['parent_type'] != '') {
				$form->addHidden(array(
					'name' => $preload['parent_type'].'_id'
				));
			}
			$values = array();
			foreach ($preload['competency'] as $id => $item) {
				$values[$id] = $item['name'];
			}
			$form->addSelect(array(
				'name' => 'competency_id',
				'class' => 'form-control',
				'label' => _('Competency'),
				'values' => $values,
				'default' => $preload['competency_id']
			));
		}
		/* $form->addHidden(array(
			'name' => 'user_id'
		)); */
		$description = array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Strategy'),
			'default' => TRUE
		);
		if ($type == 'complete') {
			$description['disabled'] = TRUE;
		}
		$form->addTextArea($description);
		
		
		if($type == 'new') {	
		
			$description2 = array(
				'name' => 'description2',
				'class' => 'form-control',
				'label' => _('Strategy (2)'),
				'default' => TRUE
			);
			$form->addTextArea($description2);	
			
			$description3 = array(
				'name' => 'description3',
				'class' => 'form-control',
				'label' => _('Strategy (3)'),
				'default' => TRUE
			);
			$form->addTextArea($description3);	
			
			$description4 = array(
				'name' => 'description4',
				'class' => 'form-control',
				'label' => _('Strategy (4)'),
				'default' => TRUE
			);
			$form->addTextArea($description4);
			
			$description5 = array(
				'name' => 'description5',
				'class' => 'form-control',
				'label' => _('Strategy (5)'),
				'default' => TRUE
			);
			$form->addTextArea($description5);			
		}

		$form->addHidden(array(
			'name' => 'division_id'
		));
		$form->addHidden(array(
			'name' => 'department_id'
		));
		/*
		// Display available department depending on the current user's role level
		// Unless if Super User
		$model = get_model('division');
		$divisions = $model->getDivisions(session('property'));
		$values = array();
		$division_disabled = '';
		foreach ($divisions as $division=>$key){
			$values[$key['id']] = $key['name'];
		}
		if (count($values) <= 1) {
			 $division_disabled = 'disabled';
		}
		if (isset($preload['division_id']) AND $preload['division_id'] != null) {
			$defaultDivision = $preload['division_id'];
		} else {
			$defaultDivision = session('division');
		}
		$divisions = array(
			'name' => 'division',
			'class' => 'form-control',
			'label' => _('Division'),
			'values' => $values,
			'default' => $defaultDivision
		);
		if ($type == 'complete') {
			$divisions['disabled'] = TRUE;
		}
		$form->addSelect($divisions);	
		
		// Display available department depending on the current user's role level
		// Unless if Super User
		if(!isset($preload['division_id'])){
			if (strtolower($type) == 'new') {
				$division = session('division');
			}
		} else {
			$division = $preload['division_id'];
		}
		$model = get_model('department');
		$defaultDepartment = NULL;
		$departments = $model->getDepartments($division);
		$values = array();
		foreach ($departments as $department=>$key){
			$values[$key['id']] = $key['name'];
		}
		if (strtolower($type) == 'new') {
			$defaultDepartment = session('department');	
		} elseif (strtolower($type) == 'edit') {
			if (isset($preload['department_id']) AND $preload['department_id'] != NULL){
				$defaultDepartment = $preload['department_id'];
			}
		}
		$departments = array(
			'name' => 'department',
			'class' => 'form-control',
			'label' => _('Department'),
			'values' => $values,
			'default' => $defaultDepartment
		);
		if ($type == 'complete') {
			$departments['disabled'] = TRUE;
		}
		$form->addSelect($departments);			
		*/
		
		
		if (isset($preload['show_objective']) && $preload['show_objective'] && isset($preload['objective_user']) && $preload["objective_user"] != NULL) {
			$form->addHidden(array(
				'name' => 'user_id',
			));
			
		} else {
				
			$values = array();
			foreach ($preload['user'] as $id => $item) {
				$values[$id] = $item['lastname'].', '.$item['firstname'];
			}
			
			if (strtolower($type) == 'new') {
				$user_id = array(
					'name' => 'user_id[]',
					'required' => true,
					'class' => 'form-control',
					'label' => _('Assigned To'),
					'values' => $values,
					'multiple' => true,
				);
			} else {
				$user_id = array(
					'name' => 'user_id',
					'required' => true,
					'class' => 'form-control',
					'label' => _('Assigned To'),
					'values' => $values,
				);
			}
			
			if (strtolower($type) == 'new') {
				if(session('user') != 'all'){
					$user_id['default'] = session('user');
				}
			}
			if ($type == 'complete') {
				$user_id['disabled'] = TRUE;
			}
			$form->addSelect($user_id);
		}
		
		/* 
		$priority = array(
			'name' => 'priority',
			'class' => 'form-control',
			'label' => _('Priority'),
			'values' => array(
				'A' => 'A',
				'B' => 'B',
				'C' => 'C'
			),
			'default' => 'A'
		);
		if ($type == 'complete') {
			$priority['disabled'] = TRUE;
		}
		$form->addSelect($priority);
		 */
		
		/* $private = array(
			'name' => 'private',
			'value' => 'private',
			'class' => 'checkbox',
			'label' => _('Private')
		);
		if ($type == 'complete') {
			$private['disabled'] = TRUE;
		}
		$form->addCheckbox($private); */
		
		/* $form->addCheckbox(array(
			'name' => 'unassigned_strategy',
			'value' => '1',
			'class' => 'checkbox',
			'label' => _('Unassigned Strategy')
		));	 */	
		
		
		
		$start = array(
			'required' => true,
			'name' => 'start',
			'class' => 'form-control',
			'label' => _('Start Date')
		);
		if ($type == 'complete') {
			$start['disabled'] = TRUE;
		}
		$form->addDate($start);
		$due = array(
			'required' => true,
			'name' => 'due',
			'class' => 'form-control',
			'label' => _('Due Date')
		);
		if ($type == 'complete') {
			$due['disabled'] = TRUE;
		}
		$form->addDate($due);
		
		
		
		if ($type == 'complete') {
			$form->addDate(array(
				'name' => 'complete',
				'class' => 'form-control',
				'label' => _('Completion Date'),
				'default' => TRUE
			));
		}

		if (strtolower($type) == 'edit' || $type == 'complete') {
			$comment = array(
				'name' => 'comment',
				'class' => 'form-control',
				'label' => _('Progress Notes')
			);
/* 			if ($type == 'complete') {
				$comment['disabled'] = TRUE;
			} */
			$form->addTextArea($comment);
		}
		
		
		$name = 'create';
		$label = _('Create');
		if (strtolower($type) == 'edit') {
			$name = 'update';
			$label = _('Update');
		}
		if (strtolower($type) == 'complete') {
			$name = 'completed';
			$label = _('Complete');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}
}
