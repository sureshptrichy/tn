<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Properties Settings controller.
 *
 * @package truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Properties extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Properties'),
			'view' => 'settings/properties',
			'main_order' => 30,
                        'separator' => _('Property')
		);
		$this->permission = array(
			'authenticated',
			'viewProperty'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($params) {
		$model = get_model('property');
		tpl_set('properties', $model->getAll(1, '`name`'));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'].'_new';
		$this->permission[] = 'addProperty';
	}

	public function call_add($params) {
		$model = get_model('property');
		$propertyForm = $this->build_property_form('new', array('code'=> rand()));
		if (FALSE === $propertyForm->valid()) {
			tpl_set('propertyForm', $propertyForm);
		} else {
			$property = $propertyForm->valid();
			if (isset($property['openUserView'])) {
				$property['openUserView'] = 1;
			} else {
				$property['openUserView'] = 0;
			}
			$success = TRUE;
			$logoPath = NULL;
			if (isset($_FILES['logo']) && isset($_FILES['logo']['size']) && $_FILES['logo']['size'] > 1) {
				$logoPath = $property['tnngtoken'].'-'.$_FILES['logo']['name'];
				if (!move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH.$logoPath)) {
					$success = FALSE;
				}
			}
			if (!isset($property['code']) || !is_numeric($property['code'])){
				$property['code'] = rand();
				//$success = FALSE;
			}
			$model->setAll($property);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			if ($logoPath !== NULL) {
				$model->logo = UPLOAD_URL.$logoPath;
			}
			if (!$success) {
				tpl_set('propertyForm', $propertyForm);
				flash(_('Sorry, the property could not be created. Please try again.'), 'warning');
			} else {
				$model->save();
				flash(_('The property has been created.'), 'success');
				locate('/'.$this->G->url->parentUrl());
			}
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'editProperty';
	}

	public function call_edit($params) {
		$model = get_model('property');
		$preload = NULL;
		if (isset($params[0])) {
			$preload = $model->getOne($params[0], 'id');
			$preload['logo-previous'] = $preload['logo'];
		}
		$propertyForm = $this->build_property_form('edit', $preload);
		if (FALSE === $propertyForm->valid()) {
			tpl_set('propertyForm', $propertyForm);
		} else {
			$property = $propertyForm->valid();
			if (isset($property['openUserView'])) {
				$property['openUserView'] = 1;
			} else {
				$property['openUserView'] = 0;
			}
			$success = TRUE;
			$logoPath = NULL;
			if (isset($_FILES['logo']) && isset($_FILES['logo']['size']) && $_FILES['logo']['size'] > 1) {
				$logoPath = $property['tnngtoken'].'-'.$_FILES['logo']['name'];
				if (!move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH.$logoPath)) {
					$success = FALSE;
				}
			} elseif (isset($property['logo-previous'])) {
				$logoPath = substr(strrchr($property['logo-previous'], "/"), 1 );
			}
			//echo $logoPath;exit;
			if (!isset($property['code']) || !is_numeric($property['code'])){
				$success = FALSE;
			}
			$model->setAll($property, TRUE);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			if ($logoPath !== NULL) {
				$model->logo = UPLOAD_URL.$logoPath;
			}
			if (!$success) {
				tpl_set('propertyForm', $propertyForm);
				flash(_('Sorry, the property could not be created. Please try again.'), 'warning');
			} else {
				$model->save();
				flash(_('The property has been updated.'), 'success');
				locate('/'.$this->G->url->parentUrl(2));
			}
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteProperty';
	}

	public function call_delete($params) {
		$model = get_model('property');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('The property has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}

	private function build_property_form($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-property',
			'class' => 'form form-property',
			'header' => array(
				'text' => sprintf(_('%1$s Property'), ucfirst($type)),
				'class' => 'form-property-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$logo = NULL;
		if (isset($preload['logo'])) {
			$logo = $preload['logo'];
		}
		$form->addHidden(array(
			'name' => 'logo-previous',
			'value' => $logo
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Property Name'),
			'default' => TRUE
		));
		$form->addHidden(array(
			'required' => true,
			'name' => 'code',
			'class' => 'form-control',
			'label' => _('Property Code'),
			'readonly' => true
		));
		$form->addFile(array(
			'name' => 'logo',
			'class' => '',
			'label' => _('Upload a Logo'),
			'types' => array(
				'jpg',
				'jpeg',
				'gif',
				'png'
			)
		));
		if (user_is(SUPER_USER) || user_is(PROPERTY_MANAGER)) {
			$form->addCheckbox(array(
				'name' => 'openUserView',
				'value' => 'openUserView',
				'class' => 'checkbox',
				'label' => _('Always show all available users and their Objectives and Strategies.')
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
