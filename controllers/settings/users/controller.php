<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * User Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Users extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Users'),
			'view' => 'settings/users',
			'main_order' => 110
			
		);
		$this->permission = array(
			'authenticated'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('user');
		$userlist = $model->getValidUsers();
		$users = array();
		$role_level = $this->G->user->role_level;
		foreach ($userlist as $user) {
			$user_object = get_model('user');
			$user_object->loadUser($user['id']);
			$property = $user_object->property;
			$division = $user_object->division;
			if (isset($property)){
				foreach ($property as $item){
					$propertyMatch = $item['id'];
				}
			}
			if (isset($division)){
				foreach ($division as $item){
					$divisionMatch = $item['id'];
				}
			}
			if (!user_is('Super User')){
				if (($user_object->role_level <= $role_level) AND ($propertyMatch == session('property'))){
						$users[$user['id']] = $user_object;
					
				}
			} else {
				if (($user_object->role == 'Super User') || ($propertyMatch == session('property'))){
					$users[$user['id']] = $user_object;
				}
			}
		}
		tpl_set('role_level', $role_level);
		tpl_set('users', $users);
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addUser';
	}
	
	public function call_add($params) {
		$model = get_model('user');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id');
		}

		//echo "<pre>".print_r(session('department'), TRUE)."</pre>";die();
		//echo "<pre>".print_r($this->G->user->created, TRUE)."</pre>";
		//echo "<pre>".print_r($this->G->user->password, TRUE)."</pre>";die();
		$userForm = $this->build_user_form('new', $preload);
		if (FALSE === $userForm->valid()) {
			tpl_set('userForm', $userForm);
		} else {
			$user = $userForm->valid();
			$role_model = get_model('acl');
			$roles = $role_model->loadRoles(TRUE);
			$check = $roles[$user['role']]['level'];
			if ($user['division'] == 'all' AND $check <=1) {
				flash(_('This user must have a division selected'), 'danger');
				tpl_set('userForm', $userForm);
				locate($this->G->url->getUrl() . '?' . http_build_query($this->G->url->getPost(), '', '&'));
			}
			if ($user['department'] == 'all' AND $check <=1) {
				flash(_('This user must have a department selected'), 'danger');
				tpl_set('userForm', $userForm);
				locate($this->G->url->getUrl() . '?' . http_build_query($this->G->url->getPost(), '', '&'));
			}
			if (isset($user['password'])) {
				$user['password'] = Crypt::hashString($user['password']);
			}
			if (isset($user['status'])) {
				$user['status'] = 1;
			} else {
				$user['status'] = 0;
			}
                        
			$oldUser = get_model('user')->getOne(array($user['username'],1), array('username','status'));
			//var_dump($oldUser); exit;
			if(!empty($oldUser)){                        
				flash(_('This username already exists.'), 'danger');
				tpl_set('userForm', $userForm);
				locate($this->G->url->getUrl() . '?' . http_build_query($this->G->url->getPost(), '', '&'));
			}

			if(!isset($user['competencies'])) {
				$user['competencies'] = array();
			}			
                        
			$model = get_model('user');
			$model->setAll($user, TRUE);
			$model->status = 1;
			$model->competencies = serialize($user['competencies']);
			$model->key = $this->G->ids->createId(16, TRUE);
			$model->cid = $this->G->user->id;
			$model->save();
			$model->addRole($model->id, $user['role']);
			$model->removeFromLocations($model->id);
			
			// Dirty hackjob to assign divisions/departments.
			// Need to clean up
			
			if($check < 100) {
				$model->addProperty($model->id, session('property'));
			}
			
			if ($check == 4){
				if(isset($user['division']) && $user['division'])
					$model->addDivision($model->id, $user['division']);
			} elseif ($check <= 3){
				if(isset($user['division']) && $user['division'])
					$model->addDivision($model->id, $user['division']);
				if(isset($user['department']) && $user['department'])
					$model->addDepartment($model->id, $user['department']);
			}
			
			flash(_('The user has been added.'), 'success');
			if ($this->G->url->parentUrl(1)) {
				locate('/'.$this->G->url->parentUrl(1));	
			} else {
				locate('/'.$this->G->url->parentUrl());	
			}
			locate(URL);
		}
		parent::display();
	}
	
	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editUser';
	}

	public function call_edit($params) {
		$model = get_model('user');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->loadUser($params[0]);
			// Fix 'role' index for forms.
			$preload['role'] = $preload['role_id'];
			
			//print_r($preload['supervisor']);
			$preload['competencies'] = unserialize($preload['competencies']);
		}
		$created = $this->G->user->created;
		$password = $this->G->user->password;
		//echo "<pre>".print_r($this->G->user->created, TRUE)."</pre>";
		//echo "<pre>".print_r($this->G->user, TRUE)."</pre>";die();
		$userForm = $this->build_user_form('edit', array_merge(array(
			'created' => $created,
			'password' => $password,
		), $preload));
		if (FALSE === $userForm->valid()) {
			tpl_set('userForm', $userForm);
		} else {
			$user = $userForm->valid();
			$oldUser = get_model('user')->getOne($user['id'], 'id');
			/* if ((isset($user['password']) && Crypt::checkHashedString($user['password'], $oldUser['password'])) || $this->G->user->role_level == SUPER_USER) { */
				// Password is correct!
				$role_model = get_model('acl');
				$roles = $role_model->loadRoles(TRUE);
				$check = $roles[$user['role']]['level'];
				if ($user['division'] == 'all' AND $check <= 1) {
					flash(_('This user must have a division selected'), 'danger');
					tpl_set('userForm', $userForm);
					locate($this->G->url->getUrl() . '?' . http_build_query($this->G->url->getPost(), '', '&'));
				}
				if (isset($user['department']) && $user['department'] == 'all' AND $check <= 1) {
					flash(_('This user must have a department selected'), 'danger');
					tpl_set('userForm', $userForm);
					locate($this->G->url->getUrl() . '?' . http_build_query($this->G->url->getPost(), '', '&'));
				}
				
				if (!isset($user['department'])) {
					$user['department'] = 'all';
				}
				if (isset($user['status'])) {
					$user['status'] = 1;
				} else {
					$user['status'] = 0;
				}
				if (isset($user['pass']) && isset($user['pass_confirmation']) && $user['pass_confirmation'] != '' && $user['pass_confirmation'] == $user['pass']) {
					// New password.
					$user['password'] = $user['pass'];
				}
				if (isset($user['password']) && $user['password'] != '') {
					$user['password'] = Crypt::hashString($user['password']);
				} else {
					$user['password'] = $oldUser['password'];
				}
				
				//print_r(unserialize($user['competencies']));exit;
				
				$oldUser['competencies'] = (!isset($oldUser['competencies']))  ? array() : unserialize($oldUser['competencies']);


				if(!isset($user['competencies'])) {
					$user['competencies'] = array();
				}

				$user_competencies = array_merge($oldUser['competencies'], $user['competencies']);				
				
				$model = get_model('user');
				$model->setAll($user, TRUE);
				$model->competencies = serialize($user_competencies);
				$model->status = 1;
				$model->cid = $this->G->user->id;
				$model->save();
				$model->addRole($model->id, $user['role']);
				$model->removeFromLocations($model->id);

				// Dirty hackjob to assign divisions/departments.
				// Need to clean up
				$role_model = get_model('acl');
				$roles = $role_model->loadRoles(TRUE);
				$check = $roles[$user['role']]['level'];
				
				if($check < 100) {
					$model->addProperty($model->id, session('property'));
				}				
				if ($check == 4) {
					$model->addDivision($model->id, $user['division']);
				} elseif ($check <= 3) {
					$model->addDivision($model->id, $user['division']);
					$model->addDepartment($model->id, $user['department']);
				}

				flash(_('The user has been updated.'), 'success');
				if ($this->G->url->parentUrl(2)) {
					locate(URL . $this->G->url->parentUrl(2));
				} else {
					locate(URL . $this->G->url->parentUrl());
				}
				locate(URL);
			/* } else {
				flash(_('Incorrect password. Please try again.'), 'danger');
				locate($this->G->url->getUrl());
			} */
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteUser';
	}
	
	public function call_delete($params) {
		$model = get_model('user');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('This user has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}
	
	private function build_user_form($type, $preload = array()) {
		if ($type == 'new'){
			$headerText = 'User';
		} else {
			$headerText = $preload['firstname'].' '.$preload['lastname'];
		}
		$form = new Form($this->G, array(
			'name' => $type.'-user',
			'class' => 'form form-user',
			'header' => array(
				'text' => sprintf(_('%1$s '.$headerText), ucfirst($type)),
				'class' => 'form-user-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addEmail(array(
			'required' => true,
			'name' => 'username',
			'class' => 'form-control',
			'label' => _('Email Address'),
			'default' => TRUE
		));
		$form->addText(array(
			'required' => true,
			'name' => 'firstname',
			'class' => 'form-control',
			'label' => _('First Name')
		));
		$form->addText(array(
			'required' => true,
			'name' => 'lastname',
			'class' => 'form-control',
			'label' => _('Last Name')
		));
		
		$required = true;
		$validation_optional = 'false';
		/* if ($this->G->user->role_level == SUPER_USER) {
			$required = true;
			$validation_optional = 'true';
			if (array_key_exists('id', $preload) && $this->G->user->id == $preload['id']) {
				$required = true;
				$validation_optional = 'true';
			}
		} */
		if ($type == 'new') {
			$form->addPassword(array(
				'name' => 'password',
				'class' => 'form-control',
				'label' => _('Password'),
				'required' => $required,
				'validation' => array(
					'data-validation' => 'length',
					'data-validation-length' => 'min5',
					'data-validation-optional' => $validation_optional
				)
			));
		}
		
		if ($type == 'edit') {
			$form->addPassword(array(
				'name' => 'pass_confirmation',
				'class' => 'form-control',
				'label' => _('New Password'),
				'validation' => array(
					'data-validation' => 'length',
					'data-validation-length' => 'min5',
					'data-validation-optional' => 'true'
				)
			));
			$form->addPassword(array(
				'name' => 'pass',
				'class' => 'form-control',
				'label' => _('Confirm New Password'),
				'validation' => array(
					'data-validation' => 'confirmation',
					'data-validation-length' => 'min5'
				)
			));
		}
		$status = array(
			'name' => 'status',
			'class' => 'form-control',
			'label' => _('Status'),
			'values' => array(
				'1' => 'Active',
				'0' => 'Inactive',
			),
			'default' => '1'
		);
		$form->addSelect($status);		
		if ($type == 'new') {
			$role_default = '';
		} elseif ($type == 'edit') {
			$role_default = $preload['role_id'];
		}
		
		// Display available roles depending on the current user's role level
		// Unless if Super User
		$model = get_model('acl');
		$roles = $model->loadRoles(TRUE);
		$role = array();
		$values = array();
		$role_level = $this->G->user->role_level;
		foreach ($roles as $r){
			if ($role_level != SUPER_USER){
				if (strtolower($type) == 'new') {
					if ($r['level'] != $role_level AND $r['level'] < $role_level){
						$values[$r['id']] = $r['name'];
					}
				} elseif (strtolower($type) == 'edit') {
					if ($r['level'] != $role_level AND $r['level'] < $role_level){
						$values[$r['id']] = $r['name'];
					}
					/* if ($r['level'] < $preload['role_level'] || $preload['role_level'] == $r['level']){
						$values[$r['id']] = $r['name'];
					} */
				}
			} else {
				$values[$r['id']] = $r['name'];
			}
		}
		$select = array(
			'name' => 'role',
			'class' => 'form-control',
			'label' => _('Role'),
			'values' => $values,
			'default' => $role_default
		);
		$form->addSelect($select);
		
		// Display available department depending on the current user's role level
		// Unless if Super User
		$model = get_model('division');
		$divisions = $model->getDivisions(session('property'));
		$values = array();
		// Dirty hack to either show or hide the All Divisions
		if (user_is('Super User') || user_is('Property Super User') || user_is('Administration')) {
			$values = array('all' => 'All Divisions');
		}
		$division_disabled = '';
		foreach ($divisions as $division=>$key){
			$values[$key['id']] = $key['name'];
		}
		if (count($values) <= 1) {
			 $division_disabled = 'disabled';
		}
		$select = array(
			'name' => 'division',
			'class' => 'form-control',
			'label' => _('Division'),
			'values' => $values,
			'default' => session('division')
		);
		$form->addSelect($select);
		
		// Display available department depending on the current user's role level
		// Unless if Super User
		if(!isset($preload['division'])){
			if (strtolower($type) == 'new') {
				$division = session('division');
			}
		} else {
			foreach ($preload['division'] as $item){
				$division = $item['id'];
			}
		}
		//$model = get_model('department');
		$defaultDepartment = NULL;
		//$departments = $model->getDepartments($division);
		$divisionModel = get_model('division');
		//echo $division;
		$departments = $divisionModel->getDepartments($division);
		//print_r($departments);exit;
		$values = array();
		if (user_is('Super User') || user_is('Property Super User') || user_is('Administration') || user_is('Division Director')) {
			$values = array('all' => 'All Departments');
		}
		
		if (isset($preload['division']) && $preload['division'] != NULL){		
			foreach ($departments as $department=>$key){
				$values[$key['id']] = $key['name'];
			}
		}
		
		if (strtolower($type) == 'new') {
			$defaultDepartment = session('department');	
		} elseif (strtolower($type) == 'edit') {
			if (isset($preload['department']) && $preload['department'] != NULL){
				foreach ($preload['department'] as $item){
					$defaultDepartment = $item['id'];
				}
			}
		}
		$select = array(
			'name' => 'department',
			'class' => 'form-control',
			'label' => _('Department'),
			'values' => $values,
			'default' => $defaultDepartment
		);
		$form->addSelect($select);
		
		$defaultCompetency = array();
		//$departments = $model->getDepartments($division);
		$competencyModel = get_model('competency');
		$competencies = $competencyModel->getCompetencies(session('property'));
		
		$values = array();

		foreach ($competencies as $competency=>$key){
			$values[$key['id']] = $key['name'];
		}
		
		if (strtolower($type) == 'edit') {
			if ($preload['competencies'] != NULL){
				$defaultCompetency = $preload['competencies'];
			}
		}
		$select = array(
			'name' => 'competencies[]',
			'class' => 'form-control',
			'label' => _('Competencies'),
			'values' => $values,
			'multiple' => true, 
			'default' => $defaultCompetency,
			'required' => true
		);
		$form->addSelect($select);	

	
		// Get property users
		$usersModel = get_model('user');
		$users = getUsers($this->G->user->id, 100);
		//$users = array_index_sort($users, 'lastname');
		$users = user_sort_by_name($users);		


		$values = array("" => "Please select");
		foreach ($users as $id => $item) {
			if (strtolower($type) == 'edit' && $id == $preload['id']) continue;
			$values[$id] = $item['lastname'].', '.$item['firstname'];
		}

		if ($type == 'new') {
			$supervisor_default = '';
		} elseif ($type == 'edit') {
			$supervisor_default = $preload['supervisor'];
		}
		
		$select = array(
			'name' => 'supervisor',
			'class' => 'form-control',
			'label' => _('Supervisor'),
			'values' => $values,
			'default' => $supervisor_default
		);
		$form->addSelect($select);	
		
		
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
	
	public function call_switch($ids) {
		if (count($ids) > 0) {
			session('user_filter', $ids[0]);
			if ($ids[0] == 'all') {
				session('user_filter', 'all');
			}
			//session_del('property');
			session_del('division');
			session_del('department');
		}
		if (NULL != $this->G->url->getQuerystringBit('rf')) {
			locate($this->G->url->getQuerystringBit('rf'));
		} else {
			locate(URL);
		}
	}
}
