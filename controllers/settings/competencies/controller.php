<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Competencies extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Competencies'),
			'view' => 'settings/competencies',
			'main_order' => 60
			
		);
		$this->permission = array(
			'authenticated',
			'viewCompetency'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('competency');
		tpl_set('competencies', $model->getCompetencies(session('property'), user_is('Super User')));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addCompetency';
	}

	public function call_add($params) {
		$model = get_model('competency');
		$competencyForm = $this->build_competency_form();
		if (FALSE === $competencyForm->valid()) {
			tpl_set('competencyForm', $competencyForm);
		} else {
			$competency = $competencyForm->valid();

			// removed default option from the system
			$competency['default'] = 0;
			
			$competency['cid'] = session('user');
			$model->setAll($competency);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			$model->addToProperty(session('property'), $model->id);
			flash(_('The competency has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editCompetency';
	}

	public function call_edit($params) {
		$model = get_model('competency');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id');
		}
		$competencyForm = $this->build_competency_form('edit', $preload);
		if (FALSE === $competencyForm->valid()) {
			tpl_set('competencyForm', $competencyForm);
		} else {
			$competency = $competencyForm->valid();

			// removed default option from the system
			$competency['default'] = 0;
			
			$model->setAll($competency, TRUE);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			flash(_('The competency has been updated.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteCompetency';
	}

	public function call_delete($params) {
		$model = get_model('competency');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('The competency has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}
	

	public function config_sort($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteCompetency';
	}

	public function call_sort($params) {
		
		$model = get_model('competency');
		if (isset($_POST['ID']) && count($_POST['ID']) > 0) {
			
			$counter = 1;
			
			foreach($_POST["ID"] as $competency_id) {
				$model->setAll($model->getOne($competency_id, 'id'));
				$model->id = $competency_id;
				$model->sort_order = $counter;
				$model->save();
				$counter++;
			}
			
			flash(_('The Sort Order has been saved.'), 'success');
			die();
		} else {
			die();
		}
		parent::display();
	}	

	private function build_competency_form($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-competency',
			'class' => 'form form-competency',
			'header' => array(
				'text' => sprintf(_('%1$s Competency'), ucfirst($type)),
				'class' => 'form-competency-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Competency Name'),
			'default' => TRUE
		));
		
		/* 
		if (user_has('addDefaultCompetency')) {
			$form->addCheckbox(array(
				'required' => true,
				'name' => 'default',
				'value' => 'default',
				'class' => 'checkbox',
				'label' => _('Default Competency')
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
