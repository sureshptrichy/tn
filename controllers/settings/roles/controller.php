<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Role Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Roles extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Roles'),
			'view' => 'settings/roles',
			'main_order' => 100,
                        'separator' => _('Permissions')
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
		$model = get_model('acl');
		$roles = $model->loadRoles();
		$permissions = array();
		foreach ($roles as $id => $role) {
			$permissions[$id] = $model->loadAcl($role);
		}
		tpl_set('roles', $roles);
		tpl_set('permissions', $permissions);
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addRole';
	}

	public function call_add($params) {
		$model = get_model('acl');
		$roleForm = $this->build_role_form();
		if (FALSE === $roleForm->valid()) {
			tpl_set('roleForm', $roleForm);
		} else {
			$role = $roleForm->valid();
			$model->setAll($role);
			$model->status = 1;
			$model->display_order = 100;
			$model->saveRole();
			flash(_('The role has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'editRole';
	}

	public function call_edit($params) {
		$model = get_model('acl');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id', NULL, '_Roles');
			$sql = 'SELECT `#__Acl_Perms`.* FROM `#__Acl_Perms`, `#__Acl` WHERE `#__Acl_Perms`.`status` = 1 AND `#__Acl_Perms`.`id` = `#__Acl`.`perm_id` AND `#__Acl`.`role_id` = ? ORDER BY `#__Acl_Perms`.`aid`';
			$perms = $model->execute($sql, $params[0]);
			foreach ($perms as $perm) {
				$preload[$perm['id']] = $perm['name'];
			}
		}
		$roleForm = $this->build_role_form('edit', $preload);
		if (FALSE === $roleForm->valid()) {
			tpl_set('roleForm', $roleForm);
		} else {
			$role = $roleForm->valid();
			$model->setAll($role, TRUE);
			$model->status = 1;
			$model->display_order = 100;
			$model->saveRole();
			flash(_('The role has been updated.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	private function build_role_form($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-role',
			'class' => 'form form-role',
			'header' => array(
				'text' => sprintf(_('%1$s Role'), ucfirst($type)),
				'class' => 'form-role-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Role Name'),
			'default' => TRUE
		));
		$model = get_model('acl');
		$perms = $model->loadPerms();
		//echo "<pre>".print_r($perms, TRUE)."</pre>";
		foreach ($perms as $id => $name) {
			$form->addCheckbox(array(
				'name' => $id,
				'value' => $name,
				'class' => 'checkbox',
				'label' => $name
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
