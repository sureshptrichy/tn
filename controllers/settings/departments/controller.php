<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Department Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Departments extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Departments'),
			'view' => 'settings/departments',
			'main_order' => 50
		);
		$this->permission = array(
			'authenticated',
			'viewDepartment'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		tpl_set('departments', get_model('department')->getDepartments(session('division'), array(user_is(SUPER_USER), user_is(PROPERTY_MANAGER))));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addDepartment';
	}

	public function call_add($params) {
		$model = get_model('department');
		$departmentForm = $this->build_department_form('new', array('code'=> rand()));
		if (FALSE === $departmentForm->valid()) {
			tpl_set('departmentForm', $departmentForm);
		} else {
			$success = TRUE;
			$department = $departmentForm->valid();
			
			// removed default option from the system
			$department['default'] = 0;
			
			if (!isset($department['code']) || !is_numeric($department['code'])){
				//$success = FALSE;
				$department['code'] = rand();
			}
			$model->setAll($department);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			if (!$success) {
				tpl_set('departmentForm', $departmentForm);
				flash(_('Sorry, invalid department code. Please try again.'), 'warning');
			} else {
				$model->save();
				/*
				if ($department['default'] == 1) {
					$model->addToAllDivisions($model->id);
				} else {
					$model->addToDivision($department['division'], $model->id);
				}
				*/
				/*
				if ($department['default'] == 0) {
					$model->addToProperty(session('property'), $model->id);
				}
				*/
				$model->addToProperty(session('property'), $model->id);
				$model->addToDivision($department['division'], $model->id);
				flash(_('The department has been created.'), 'success');
				locate('/'.$this->G->url->parentUrl());
			}
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editDepartment';
	}

	public function call_edit($params) {
		$model = get_model('department');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id');
		}
		$departmentForm = $this->build_department_form('edit', $preload);
		if (FALSE === $departmentForm->valid()) {
			tpl_set('departmentForm', $departmentForm);
		} else {
			$success = TRUE;
			$department = $departmentForm->valid();

			// removed default option from the system
			$department['default'] = 0;
			
			if (!isset($department['code']) || !is_numeric($department['code'])){
				//$success = FALSE;
				$department['code'] = rand();
			}
			$model->setAll($department, TRUE);
			$model->status = 1;
			$model->cid = $this->G->user->id;			
			if (!$success) {
				tpl_set('departmentForm', $departmentForm);
				flash(_('Sorry, invalid department code. Please try again.'), 'warning');
			} else {
				$model->save();
				$model->removeFromDivision($model->id);
				/*
				if ($department['default'] == 1) {
					$model->addToAllDivisions($model->id);
				} else {
					$model->addToDivision($department['division'], $model->id);
				}
				*/
				$model->addToDivision($department['division'], $model->id);
				flash(_('The department has been updated.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			}
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteDepartment';
	}

	public function call_delete($params) {
		$model = get_model('department');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));
			
			$division = session('division');

			if($model->default == 1 && $division) {
				$model->status = 0;
				$model->default = 0;
				$model->save();
				$model->addToDivision($division, $model->id);
			}
			else {				
				$model->id = $params[0];
				$model->status = 0;
				$model->save();				
			}

			flash(_('The department has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	public function config_departmentswitch($params = NULL) {
		$this->route['view'] = $this->route['view'].'_switch';
		$this->permission[] = 'editUser';
	}

	public function call_departmentswitch($url) {
		$departments = get_model('division')->getDepartments($url[0]);
		$return = array();
		$data = array();
		$allData = array();
		foreach ($departments as $department=>$key){
			//$return[$key['id']] = $key['name'];
			//$data['id'] = $key['id'];
			//$data['name'] = $key['name'];
			$data = array('id' => $key['id'], 'name' => $key['name']);
			array_push($return, $data);
			unset($data);
		}
		if (user_is('Super User') || user_is('Administration') || user_is('Division Director')) {
			$allData = array('id' => 'all', 'name' => 'All Departments');
			array_unshift($return, $allData);
		}
		tpl_set('departments', $return);
		parent::display();
	}

	private function build_department_form($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-department',
			'class' => 'form form-department',
			'header' => array(
				'text' => sprintf(_('%1$s Department'), ucfirst($type)),
				'class' => 'form-department-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Department Name'),
			'default' => TRUE
		));
		$form->addHidden(array(
			'required' => true,
			'name' => 'code',
			'class' => 'form-control',
			'label' => _('Department Code'),
			'readonly' => true
		));
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
		if (strtolower($type) == 'edit') {
			$department_model = get_model('department');
			$division = $department_model->getDivision($preload['id']);
			$division_default = $division['division_id'];
		} else {
			$division_default = session('division');
		}
		$select = array(
			'required' => true,
			'name' => 'division',
			'class' => 'form-control',
			'label' => _('Division'),
			'values' => $values,
			'default' => $division_default
		);
		$form->addSelect($select);
		
		/* 
		if (user_has('addDefaultDepartment')) {
			$form->addCheckbox(array(
				'name' => 'default',
				'value' => 'default',
				'class' => 'checkbox',
				'label' => _('Default Department')
			));
		} */
		
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
