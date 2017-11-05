<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Division Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Divisions extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Divisions'),
			'view' => 'settings/divisions',
			'main_order' => 40
		);
		$this->permission = array(
			'authenticated',
			'viewDivision'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		tpl_set('divisions', get_model('division')->getDivisions(session('property'), user_is(SUPER_USER)));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addDivision';
	}

	public function call_add($params) {
		$model = get_model('division');
		$divisionForm = $this->build_division_form();
		if (FALSE === $divisionForm->valid()) {
			tpl_set('divisionForm', $divisionForm);
		} else {
			$division = $divisionForm->valid();
			
			// removed default option from the system
			$division['default'] = 0;

			$model->setAll($division);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			
			/* Delete existing inactive divisions with the same name */
			$sql = 'SELECT `#__Division`.id FROM `#__Division`, `#__Property_Division`  WHERE `#__Division`.`status` = 0 AND `#__Division`.`id` = `#__Property_Division`.`division_id` AND `#__Division`.`name` = ? AND `#__Property_Division`.`property_id` = ?';
				
			$this->G->db->executeQuery($sql, array($division['name'], session('property')));
			
			if ($this->G->db->numRows() > 0) {
				while ($result = $this->G->db->getRows()) {
					$sql = 'DELETE FROM `#__Property_Division` WHERE `division_id` = ? AND `property_id` = ?';							
					$this->G->db->executeQuery($sql, array($result['id'], session('property')));									
				}
				
				/* 
				if($division['default'] == 1) {
					$sql = 'DELETE FROM `#__Division` WHERE `name` = ? AND `id` != ?';							
					$this->G->db->executeQuery($sql, array($division['name'], $model->id));													
				} */
			}
				
			/*
			if ($division['default'] == 1) {
				$model->addToAllProperties($model->id);
			} else {
				$model->addToProperty(session('property'), $model->id);
			}
			*/
			$model->addToProperty(session('property'), $model->id);
			flash(_('The division has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editDivision';
	}

	public function call_edit($params) {
		$model = get_model('division');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id');
		}
		$divisionForm = $this->build_division_form('edit', $preload);
		if (FALSE === $divisionForm->valid()) {
			tpl_set('divisionForm', $divisionForm);
		} else {
			$division = $divisionForm->valid();

			// removed default option from the system
			$division['default'] = 0;
			
			$model->setAll($division, TRUE);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			flash(_('The division has been updated.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteDivision';
	}

	public function call_delete($params) {
		$model = get_model('division');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('The division has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	private function build_division_form($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-division',
			'class' => 'form form-division',
			'header' => array(
				'text' => sprintf(_('%1$s Division'), ucfirst($type)),
				'class' => 'form-division-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Division Name'),
			'default' => TRUE
		));
		
		/* 
		if (user_has('addDefaultDivision')) {
			$form->addCheckbox(array(
				'name' => 'default',
				'value' => 'default',
				'class' => 'checkbox',
				'label' => _('Default Division')
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
