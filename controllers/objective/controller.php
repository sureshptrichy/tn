<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Objective controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Objective extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Objective'),
			'view' => 'objective'
		);
		$this->permission = array(
			'authenticated',
			'viewObjective'
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
		$this->permission[] = 'addObjective';
	}

	public function call_new($params) {
		$competencyModel = get_model('competency');
		$competencyId = $params[0];
		
		// Get property users
		$usersModel = get_model('user');
		$users = getUsers($this->G->user->id, 100);
		//$users = array_index_sort($users, 'lastname');
		$users = user_sort_by_name($users);
				
		if (session('user_filter')){
			$objective_user = session('user_filter');
			$userId = session('user_filter');
		} else {
			$objective_user = session('user');
			$userId = session('user');
		}
		
		$actionURL = URL . 'objective/new/' . $competencyId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$objectiveForm = $this->build_objective_form('new', array(
			'competency_id' => $competencyId,
			'competency' => $competencyModel->getCompetencies(session('property'), FALSE, TRUE),
			'users' => $users,
			'action' => $actionURL,
			//'user_id' => $userId,
			'cid' => session('user'),
			
		));
		
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
			if (isset($objective['private'])) {
				$objective['private'] = 1;
			} else {
				$objective['private'] = 0;
			}

			if (isset($objective['unassigned_obj'])) {
				$objective['unassigned_obj'] = 1;
			} else {
				$objective['unassigned_obj'] = 0;
			}			
			
			$model = get_model('objective');
			$model->setAll($objective);
			$model->status = 1;
			$model->tn_objective = 0;
			$model->cid = $this->G->user->id;
			
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
				locate($this->G->url->getQuerystringBit('rf') . '#obj_' . $model->id);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editObjective';
	}

	public function call_edit($params) {
		$model = get_model('objective');
		$objectiveId = $params[0];
		$preload = $model->getOne($objectiveId, 'id');
		$preload['competency_id'] = $model->getCompetency($objectiveId);

		// Get property users
		$usersModel = get_model('user');				
		$users = getUsers($this->G->user->id, 100);
		//$users = array_index_sort($users, 'lastname');
		$users = user_sort_by_name($users);
		
		$competencyModel = get_model('competency');
		
		$actionURL = URL . 'objective/edit/' . $preload['competency_id'];
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$objectiveForm = $this->build_objective_form('edit', array_merge(array(
			'competency_id' => $preload['competency_id'],
			'competency' => $competencyModel->getCompetencies(session('property')), 
			'users' => $users,
			'action' => $actionURL,
			'cid' => session('user'),			
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
			if (isset($objective['private'])) {
				$objective['private'] = 1;
			} else {
				$objective['private'] = 0;
			}
			
			if (isset($objective['unassigned_obj'])) {
				$objective['unassigned_obj'] = 1;
			} else {
				$objective['unassigned_obj'] = 0;
			}
			
			//echo "<pre>OBJ: ".print_r($objective, TRUE)."</pre>";
			$model = get_model('objective');
			$model->setAll($objective, TRUE);
			$model->status = 1;
			$model->tn_objective = 0;
			$model->cid = $this->G->user->id;			

			$model->save();
			
			$competencyModel->addObjective($objective['competency_id'], $model->id);
			
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
			}
			flash(_('The objective has been updated.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf')  . '#obj_' . $model->id);
			}
			locate(URL);
		}
		parent::display();
	}
	
	public function config_delete($params = NULL) {
		//$this->route['view'] = $this->route['view'].'_edit';
		//$this->permission[] = 'deleteDepartment';
	}

	public function call_delete($params) {
		$model = get_model('objective');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));
				
			$model->id = $params[0];
			$model->status = 0;
			$model->save();				
				
			flash(_('The Objective has been deleted.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf'));
			}			
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
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
		$form->addTextArea(array(
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Objective'),
			'default' => TRUE
		));
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

		$values = array("" => "Please select");
		foreach ($preload['users'] as $id => $item) {
			$values[$id] = $item['lastname'].', '.$item['firstname'];
		}		
		$user_id = array(
			'name' => 'user_id',
			'class' => 'form-control',
			'label' => _('Assign to User'),
			'values' => $values
		);
		
		/* if (strtolower($type) == 'new') {
			if(session('user') != 'all'){
				//$user_id['default'] = session('user');
			}
		}	 */	

		$form->addSelect($user_id);

		
		
/* 		$form->addSelect(array(
			'name' => 'priority',
			'class' => 'form-control',
			'label' => _('Priority'),
			'values' => array(
				'A' => 'A',
				'B' => 'B',
				'C' => 'C'
			),
			'default' => 'A'
		)); */
		
		/* $form->addCheckbox(array(
			'name' => 'private',
			'value' => 'private',
			'class' => 'checkbox',
			'label' => _('Private')
		)); */
		
		/* $form->addCheckbox(array(
			'name' => 'unassigned_obj',
			'value' => '1',
			'class' => 'checkbox',
			'label' => _('Unassigned Objective')
		)); */
		
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
		
		if (strtolower($type) == 'edit') {		
			$form->addTextArea(array(
				'name' => 'comment',
				'class' => 'form-control',
				'label' => _('Progress Notes')
			));
		}	
		
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
