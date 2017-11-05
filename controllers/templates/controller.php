<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Templates controller.
 *
 * @package    truenorthng
 */

final class Controller_Templates extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Templates'),
			'view' => 'templates',
			'main_order' => '50'
		);
		$this->permission = array(
			'authenticated',
			'viewTemplate'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}
	
	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('Templates');
		$northviewTemplates = $model->getNorthviewTemplates();
		$propertyTemplates = $model->getPropertyTemplates(session('property'));
		$divisionTemplates = $model->getDivisionTemplates(session('division'));
		$departmentTemplates = $model->getDepartmentTemplates(session('department'));
		tpl_set('northviewTemplates', $northviewTemplates);
		tpl_set('propertyTemplates', $propertyTemplates);
		tpl_set('divisionTemplates', $divisionTemplates);
		tpl_set('departmentTemplates', $departmentTemplates);
		parent::display();
	}

	public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addTemplate';
	}
	
	public function call_new($params) {
		$model = get_model('Templates');
		$preload = array();
		$preload['scope'] = $params[0];
		$form = $this->build_form('new', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('templateForm', $form);
		} else {
			$templateForm = $form->valid();
			$success = TRUE;
			$path = null;
			$mime = null;
			$scope_id = null;
			if (!array_key_exists('name', $templateForm) || $templateForm['name'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('description', $templateForm) || $templateForm['description'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('scope', $templateForm) || empty($templateForm['scope'])) {
				$success = FALSE;
			}
			$scope = $templateForm['scope'][0];
			if ($scope == 'property'){
				$scope_id = session('property');
			} elseif ($scope == 'division'){
				if (session('division') == 'all'){
					$scope = 'property';
					$scope_id = session('property');
				} else {
					$scope_id = session('division');
				}
			} elseif ($scope == 'department'){
				if (session('department') == 'all'){
					$scope = 'division';
					$scope_id = session('division');
				} elseif (session('department') == 'all' && session('division') == 'all'){
					$scope = 'property';
					$scope_id = session('property');
				} else {
					$scope_id = session('department');
				}
			}
			
			if (isset($_FILES['path']) && isset($_FILES['path']['size']) && $_FILES['path']['size'] > 1) {
				$tempName = str_replace(' ',"-", $_FILES['path']['name']); 
				$_FILES['path']['name'] = $tempName;
				$path = $templateForm['tnngtoken'].'-'.$_FILES['path']['name'];
				if (isset($_FILES['path']['type']) && $_FILES['path']['type'] != '') {
					$mime = $_FILES['path']['type'];
				}
				if (!move_uploaded_file($_FILES['path']['tmp_name'], UPLOAD_PATH.$path)) {
					$success = FALSE;
				}
			}
			$model->setAll($templateForm);
			$model->status = 1;
			if ($path !== NULL) {
				$model->path = UPLOAD_URL.$path;
				$model->mime = $mime;
			}
			$model->cid = $this->G->user->id;
			if (!$success) {
				tpl_set('templateForm', $form);
				flash(_('Sorry, the template could not be created. Please try again.'), 'warning');
			} else {
				tpl_set('templateForm', $form);
				$model->save();
				$model->removeScope($model->id);
				$model->addScope($model->id, $scope, $scope_id);
				flash(_('The template has been created.'), 'success');
				locate('/'.$this->G->url->parentUrl(1));
			}
		}
		parent::display();
	}
	
	public function call_edit($params) {
		$model = get_model('Templates');
		$preload = $model->getOne($params[0], 'id');
		$preload['path-previous'] = $preload['path'];
		$scope = $model->getScope($params[0]);
		$preload['scope'] = $scope;
		$form = $this->build_form('new', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('templateForm', $form);
		} else {
			$templateForm = $form->valid();
			$success = TRUE;
			$path = null;
			$mime = null;
			$scope_id = null;
			if (!array_key_exists('name', $templateForm) || $templateForm['name'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('description', $templateForm) || $templateForm['description'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('scope', $templateForm) || empty($templateForm['scope'])) {
				$success = FALSE;
			}
			$scope = $templateForm['scope'][0];
			if ($scope == 'property'){
				$scope_id = session('property');
			} elseif ($scope == 'division'){
				if (session('division') == 'all'){
					$scope = 'property';
					$scope_id = session('property');
				} else {
					$scope_id = session('division');
				}
			} elseif ($scope == 'department'){
				if (session('department') == 'all'){
					$scope = 'division';
					$scope_id = session('division');
				} elseif (session('department') == 'all' && session('division') == 'all'){
					$scope = 'property';
					$scope_id = session('property');
				} else {
					$scope_id = session('department');
				}
			}
			
			if (isset($_FILES['path']) && isset($_FILES['path']['size']) && $_FILES['path']['size'] > 1) {
				$tempName = str_replace(' ',"-", $_FILES['path']['name']); 
				$_FILES['path']['name'] = $tempName;
				$path = $templateForm['tnngtoken'].'-'.$_FILES['path']['name'];
				if (isset($_FILES['path']['type']) && $_FILES['path']['type'] != '') {
					$mime = $_FILES['path']['type'];
				}
				if (!move_uploaded_file($_FILES['path']['tmp_name'], UPLOAD_PATH.$path)) {
					$success = FALSE;
				}
			} elseif (isset($templateForm['path-previous'])) {
				$path = $templateForm['path-previous'];
				$mime = $templateForm['mime'];
				$path = str_replace_once(UPLOAD_URL, '', $templateForm['path-previous']);
			}
			$model->setAll($templateForm, true);
			$model->status = 1;
			$model->path = UPLOAD_URL.$path;
			$model->mime = $mime;
			$model->cid = $this->G->user->id;
			if (!$success) {
				tpl_set('templateForm', $form);
				flash(_('Sorry, the template could not be saved. Please try again.'), 'warning');
			} else {
				tpl_set('templateForm', $form);
				$model->save();
				$model->removeScope($model->id);
				$model->addScope($model->id, $scope, $scope_id);
				flash(_('The template has been saved.'), 'success');
				locate('/'.$this->G->url->parentUrl(0));
			}
		}
		parent::display();
	}
	
	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_edit';
		$this->permission[] = 'editTemplate';
	}
	
	public function config_download($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_download';
		$this->permission[] = 'viewTemplate';
	}
	
	public function call_download($params) {
		$model = get_model('Templates');
		$template = $model->getOne( $params[0], 'id');
		tpl_set('template', $template);
		parent::display(FALSE);
	}
	
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_delete';
		$this->permission[] = 'deleteTemplate';
	}
	
	public function call_delete($params) {
		$model = get_model('Templates');
		if (isset($params[0]) && $params[0] != '') {
			//$model->removeFields($params[0]);
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('This Template has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}	
	
	private function build_form($type, $preload = array()) {
		$form = new Form($this->G, array(
			'name' => 'template',
			'class' => 'form form-template',
			'header' => array(
				'text' => sprintf(_('%1$s Template'), ucfirst($type)),
				'class' => 'form-template-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$file = NULL;
		$mime = NULL;
		if (isset($preload['path'])) {
			$file = $preload['path'];
			$mime = $preload['mime'];
		}
		$form->addHidden(array(
			'name' => 'path-previous',
			'value' => $file
		));
		$form->addHidden(array(
			'name' => 'mime',
			'value' => $mime
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Template Name'),
			'default' => TRUE
		));
		$form->addTextArea(array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control template-description',
			'label' => _('Description')
		));
		$form->addRadio(array(
			'name' => 'scope',
			'value' => array(
				'northview' => _('Northview Standard Templates'),
				'property' => _('Property Specific Templates'),
				'division' => _('Division Specific Templates'),
				'department' => _('Department Specific Templates')
			),
			'default' => 'none',
			'class' => 'radio',
			'label' => _('Scope')
		));
		$form->addFile(array(
			'name' => 'path',
			'class' => '',
			'label' => _('Upload File'),
			'types' => array(
				'jpg',
				'jpeg',
				'gif',
				'png',
				'doc',
				'docx',
				'xls',
				'xlsx',
				'ppt',
				'pptx',
				'pdf'
			)
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