<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Tactic controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Tactic extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Tactic'),
			'view' => 'tactic'
		);
		$this->permission = array(
			'authenticated',
			'viewTactic'
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
		$this->permission[] = 'addTactic';
	}

	public function call_new($params) {
		$strategyId = $params[0];
		$strategy = NULL;
		if ($strategyId != '') {
			$strategyModel = get_model('strategy');
			$strategy = $strategyModel->getOne($strategyId, 'id');
			tpl_set('strategyData', $strategy);
			if (isset($strategy['description'])) {
				$strategy = Parsedown::instance()->parse($strategy['description']);
			} else {
				$strategy = NULL;
			}
		}
		
		$actionURL = URL . 'tactic/new/' . $strategyId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$users = getUsers($this->G->user->id, 100);
		// $users = array_index_sort($users, 'lastname');

		$users = user_sort_by_name($users);	

		
		
		$tacticForm = $this->build_tactic_form('new', array(
			'action' => $actionURL,
			'strategy_id' => $strategyId,
			'strategy' => $strategy,
			'user' => $users,
		));
		if (FALSE === $tacticForm->valid()) {
			tpl_set('tacticForm', $tacticForm);
		} else {
			$tactic = $tacticForm->valid();
			if (isset($tactic['due'])) {
				$tactic['due'] = strtotime($tactic['due']);
			}
			$tactic['cid'] = session('user');
			//echo "<pre>".print_r($tactic, TRUE)."</pre>";die();
			
			$tactics_list = array("description", "description2", "description3", "description4", "description5");
			
			foreach($tactics_list as $tactic_text) {
				
				if($tactic[$tactic_text]) {
						
					$model = get_model('tactic');
					$model->setAll($tactic);
					$model->description = $tactic[$tactic_text];
					$model->status = 1;
					$model->cid = $this->G->user->id;					
					$model->save();
					$this->G->db->insertRecords('#__Strategy_Tactic', array(
						'strategy_id' => $params[0],
						'tactic_id' => $model->id
					));					
				}				
			}
					
			//echo "<pre>".print_r($model, TRUE)."</pre>";die();
			flash(_('The tactic has been created.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#sty_' . $strategyId);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editTactic';
	}

	public function call_edit($params) {
		$model = get_model('tactic');
		$tacticId = $params[0];
		$preload = NULL;
		if ($tacticId != '') {
			$preload = $model->getOne($tacticId, 'id');
		}
		$strategy = get_model('strategy')->getOne($model->getStrategy($tacticId), 'id');
		tpl_set('strategyData', $strategy);
		$actionURL = URL . 'tactic/edit/' . $tacticId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		$users = getUsers($this->G->user->id, 100);
		//$users = array_index_sort($users, 'lastname');
		$users = user_sort_by_name($users);		
				
		$tacticForm = $this->build_tactic_form('edit', array_merge(array(
			'action' => $actionURL,
			'strategy_id' => $strategy['id'],
			'strategy' => Parsedown::instance()->parse($strategy['description']),
			'user' => $users,
		), $preload, array("comment" => '', 'existing_comments' => $preload['comment'])));
		if (FALSE === $tacticForm->valid()) {
			tpl_set('tacticForm', $tacticForm);
		} else {
			$tactic = $tacticForm->valid();
			if (isset($tactic['due'])) {
				$tactic['due'] = strtotime($tactic['due']);
				if(isset($preload['due']) && $preload['due'] != $tactic['due']) {
					$tactic['past_due'] = $preload['due'];
				}				
			}
			//echo "<pre>".print_r($strategy, TRUE)."</pre>";die();
			$model = get_model('tactic');
			$model->setAll($tactic, TRUE);
			
			$progress_notes = array();
			if(isset($tactic["existing_comments"]) && count($tactic["existing_comments"]) > 0) {
				
				//print_r($tactic["existing_comments"]);
				//exit;
				foreach($tactic["existing_comments"] as $existing_comment) {
					$progress_notes[] = unserialize(base64_decode($existing_comment));
				}
				//print_r($progress_notes);exit;
				$model->comment = base64_encode(serialize($progress_notes));
				$tactic["existing_comments"] = '';
				unset($tactic["existing_comments"]);
			}		
			
			if($tactic["comment"] != "") {			
				$progress_notes[] = array("dt" => time(), "notes" => $tactic["comment"]);
				$model->comment = base64_encode(serialize($progress_notes));
			}
			
			$model->status = 1;
			$model->cid = $this->G->user->id;
			
			$model->save();
			flash(_('The tactic has been updated.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#sty_' . $strategy['id']);
			}
			locate(URL);
		}
		parent::display();
	}

	public function config_complete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_complete';
		$this->permission[] = 'editTactic';
	}

	public function call_complete($params) {
		$model = get_model('tactic');
		$tacticId = $params[0];
		$preload = NULL;
		if ($tacticId != '') {
			$preload = $model->getOne($tacticId, 'id');
		}
		$strategy = get_model('strategy')->getOne($model->getStrategy($tacticId), 'id');

		$actionURL = URL . 'tactic/complete/' . $tacticId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}

		
		$tacticForm = $this->build_tactic_form('complete', array_merge(array(
			'action' => $actionURL,
			'strategy_id' => $strategy['id'],
			'strategy' => Parsedown::instance()->parse($strategy['description'])
		), $preload, array("comment" => '')));
		if (FALSE === $tacticForm->valid()) {
			tpl_set('tacticForm', $tacticForm);
		} else {
			$tactic = $tacticForm->valid();
			if (isset($tactic['complete'])) {
				$tactic['complete'] = strtotime($tactic['complete']);
			}
			//echo "<pre>".print_r($strategy, TRUE)."</pre>";die();
			$model = get_model('tactic');
			$model->setAll($model->getOne($tactic['id'], 'id'), TRUE);
			$model->complete = $tactic['complete'];

			$progress_notes = array();
			if($preload["comment"] != "") {
				$progress_notes = unserialize(base64_decode($preload["comment"]));
				$model->comment = $preload["comment"];
			}			
			
			if($tactic["comment"] != "") {			
				$progress_notes[] = array("dt" => time(), "notes" => $tactic["comment"]);
				$model->comment = base64_encode(serialize($progress_notes));
			}
			
			
			$model->save();
			flash(_('The tactic has been completed.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#sty_' . $strategy['id']);
			}
			locate(URL);
		}
		parent::display();
	}
	
	public function config_notes($params = NULL) {
		$this->route['view'] = $this->route['view'].'_notes';
		$this->permission[] = 'editTactic';
	}

	public function call_notes($params) {
		$model = get_model('tactic');
		$tacticId = $params[0];
		$preload = NULL;
		if ($tacticId != '') {
			$preload = $model->getOne($tacticId, 'id');
		}
		$strategy = get_model('strategy')->getOne($model->getStrategy($tacticId), 'id');

		$actionURL = URL . 'tactic/notes/' . $tacticId;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}

		
		$tacticForm = $this->build_tactic_notes_form('notes', array_merge(array(
			'action' => $actionURL,
			), $preload, array("comment" => '')));
		if (FALSE === $tacticForm->valid()) {
			tpl_set('tacticForm', $tacticForm);
		} else {
			$tactic = $tacticForm->valid();

			$model = get_model('tactic');
			$model->setAll($model->getOne($tactic['id'], 'id'), TRUE);

			$progress_notes = array();
			if($preload["comment"] != "") {
				$progress_notes = unserialize(base64_decode($preload["comment"]));
				$model->comment = $preload["comment"];
			}			
			
			if($tactic["comment"] != "") {			
				$progress_notes[] = array("dt" => time(), "notes" => $tactic["comment"]);
				$model->comment = base64_encode(serialize($progress_notes));
			}			
			
			$model->save();
			flash(_('The Notes has been added.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf') . '#sty_' . $strategy['id']);
			}
			locate(URL);
		}
		parent::display();
	}	
	
	public function config_reopen($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editTactic';
	}

	public function call_reopen($params) {

		$model = get_model('tactic');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));				
			$model->id = $params[0];
			$model->complete = NULL;
			$model->save();				
				
			flash(_('The Tactic has been reopened.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf'));
			}			
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}	
	
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteTactic';
	}

	public function call_delete($params) {
		$model = get_model('tactic');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));
				
			$model->id = $params[0];
			$model->status = 0;
			$model->save();				
				
			flash(_('The Tactic has been deleted.'), 'success');
			if ($this->G->url->getQuerystringBit('rf')) {
				locate($this->G->url->getQuerystringBit('rf'));
			}			
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}	

	private function build_tactic_form($type = 'new', $preload = array()) {

		$preload["action"] = (isset($preload["action"])) ? $preload["action"] : '';
	
		$form = new Form($this->G, array(
			'name' => $type.'-tactic',
			'class' => 'form form-tactic',
			'id' => 'tactic-form',
			'action' => $preload["action"], 
			'header' => array(
				'text' => sprintf(_('%1$s Tactic'), ucfirst($type)),
				'class' => 'form-tactic-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addHidden(array(
			'name' => 'strategy_id'
		));
		$form->addStatic(array(
			'name' => 'strategy',
			'class' => '',
			'label' => _('Strategy')
		));
		$description = array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Tactic'),
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
				'label' => _('Tactic (2)'),
				'default' => TRUE
			);
			$form->addTextArea($description2);	
			
			$description3 = array(
				'name' => 'description3',
				'class' => 'form-control',
				'label' => _('Tactic (3)'),
				'default' => TRUE
			);
			$form->addTextArea($description3);	
			
			$description4 = array(
				'name' => 'description4',
				'class' => 'form-control',
				'label' => _('Tactic (4)'),
				'default' => TRUE
			);
			$form->addTextArea($description4);
			
			$description5 = array(
				'name' => 'description5',
				'class' => 'form-control',
				'label' => _('Tactic (5)'),
				'default' => TRUE
			);
			$form->addTextArea($description5);			
		}
		
		if($type != 'complete') {
			
			$values = array();
			foreach ($preload['user'] as $id => $item) {
				$values[$id] = $item['lastname'].', '.$item['firstname'];
			}		
			$user_id = array(
				'name' => 'user_id',
				'class' => 'form-control',
				'label' => _('Assigned To'),
				'values' => $values
			);
			if (strtolower($type) == 'new') {
				if(session('user') != 'all'){
					$user_id['default'] = session('user');
				}
			}		

			$form->addSelect($user_id);
		}
		
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
		
		if (strtolower($type) == 'edit' || strtolower($type) == 'complete') {

			$comment = array(
				'name' => 'comment',
				'class' => 'form-control',
				'label' => _('Progress Notes'),
			);
			/* if ($type == 'complete') {
				$comment['disabled'] = TRUE;
			} */
			$form->addTextArea($comment);
		}
		
		if ($type == 'complete') {
			$form->addDate(array(
				'name' => 'complete',
				'class' => 'form-control',
				'label' => _('Completion Date'),
				'default' => TRUE
			));
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
	
	private function build_tactic_notes_form($type = 'notes', $preload = array()) {

		$preload["action"] = (isset($preload["action"])) ? $preload["action"] : '';
	
		$form = new Form($this->G, array(
			'name' => $type.'-tactic',
			'class' => 'form form-tactic',
			'id' => 'tactic-form',
			'action' => $preload["action"], 
			'header' => array(
				'text' => 'Add Notes',
				'class' => 'form-tactic-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));

		$comment = array(
			'name' => 'comment',
			'class' => 'form-control',
			'label' => _('Progress Notes'),
		);

		$form->addTextArea($comment);

		$name = 'create';
		$label = _('Add');

		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}	
}
