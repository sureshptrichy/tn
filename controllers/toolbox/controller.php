<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Templates controller.
 *
 * @package    truenorthng
 */

final class Controller_Toolbox extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Toolbox'),
			'view' => 'toolbox',
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
		$user = get_model('user');
		$user->loadUser(session('user_filter'));
		$model = get_model('toolbox');
		$propertyModel = get_model('property');
		$allproperties = $propertyModel->getAll(1, 'name');
		$properties = array();
		foreach ($allproperties as $property){
			//$divisions = get_model('property')->getDivisions($property['id']);
			$divisions = $model->getDivisions($property['id']);
			$property['divisions'] = array();
			foreach ($divisions as $division){
				$newfolder = null;
				if(user_is(SUPER_USER)){$newfolder = true;}
				if($user->property && array_key_exists($property['id'], $user->property)){
					if($user->role == "Administration"){$newfolder = true;}
					if($user->division && array_key_exists($division['id'], $user->division)){
						$newfolder = true;
					}
				}
				$folders = $model->getFolders($property['id'], $division['id']);
				$division['folders'] = array();
				foreach ($folders as $folder){
					$editable = null;
					if(user_is(SUPER_USER)){$editable = true;}
					if($user->property && array_key_exists($property['id'], $user->property)){
						if($user->role == "Administration"){$editable = true;}
						if($user->division && array_key_exists($division['id'], $user->division)){
							$editable = true;
						}
					}
					$folder['editable'] = $editable;
					$division['folders'][$folder['id']] = $folder;
				}
				$division['newfolder'] = $newfolder;
				$property['divisions'][$division['id']] = $division;
			}
			$properties[$property['id']] = $property;
		}
		tpl_set('properties', $properties);
		parent::display();
	}

	public function config_getTemplates($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_get';
	}

	public function call_getTemplates($params) {
		$user = get_model('user');
		$user->loadUser(session('user_filter'));
		$model = get_model('toolbox');
		$files = $model->getFiles($params[0]);
		$folder = get_model('folder')->getOne($params[0], 'id');
		$editable = null;
		if(user_is(SUPER_USER)){$editable = true;}
		if($user->property && array_key_exists($folder['property_id'], $user->property)){
			if($user->role == "Administration"){$editable = true;}
			if($user->division && array_key_exists($folder['division_id'], $user->division)){
				$editable = true;
			}
		}
		tpl_set('editable', $editable);
		tpl_set('files', $files);
		tpl_set('folderid', $params[0]);
		parent::display(false);
	}

		public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addTemplate';
	}

	public function config_download($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_download';
		$this->permission[] = 'viewTemplate';
	}
	
	public function call_download($params) {
		$model = get_model('toolbox');
		$template = $model->getOne( $params[0], 'id');
		tpl_set('template', $template);
		parent::display(FALSE);
	}

	public function call_new($params) {
		$model = get_model('Toolbox');
		$preload = array();
		$preload['folder_id'] = $params[0];
		$form = $this->build_form('new', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('templateForm', $form);
		} else {
			$templateForm = $form->valid();
			$success = TRUE;
			$path = null;
			$mime = null;
			$folderid = null;
			if (!array_key_exists('name', $templateForm) || $templateForm['name'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('description', $templateForm) || $templateForm['description'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('description', $templateForm) || $templateForm['description'] == null) {
				$success = FALSE;
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
			} else {
                            $success = FALSE;
                        }
			$model->cid = $this->G->user->id;
			if (!$success) {
				tpl_set('templateForm', $form);
				flash(_('Sorry, the file could not be created. Please try again.'), 'warning');
			} else {
				tpl_set('templateForm', $form);
				$model->save();
				flash(_('The file has been created.'), 'success');
				locate('/'.$this->G->url->parentUrl(1));
			}
		}
		parent::display();
	}
	
	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_edit';
		$this->permission[] = 'editTemplate';
	}

	public function call_edit($params) {
		$model = get_model('toolbox');
		$preload = $model->getOne($params[0], 'id');
		$preload['path-previous'] = $preload['path'];
		$form = $this->build_form('edit', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('templateForm', $form);
		} else {
			$templateForm = $form->valid();
			$success = TRUE;
			$path = null;
			$mime = null;
			if (!array_key_exists('name', $templateForm) || $templateForm['name'] == null) {
				$success = FALSE;
			}
			if (!array_key_exists('description', $templateForm) || $templateForm['description'] == null) {
				$success = FALSE;
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
				flash(_('Sorry, the file could not be saved. Please try again.'), 'warning');
			} else {
				tpl_set('templateForm', $form);
				$model->save();
				flash(_('The file has been saved.'), 'success');
				locate('/'.$this->G->url->parentUrl(0));
			}
		}
		parent::display();
	}
	
	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_delete';
		$this->permission[] = 'deleteTemplate';
	}
	
	public function call_delete($params) {
		$model = get_model('toolbox');
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
			'name' => 'file',
			'class' => 'form form-template',
			'header' => array(
				'text' => sprintf(_('%1$s File'), ucfirst($type)),
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
		$form->addHidden(array(
			'name' => 'folder_id',
			'value' => $preload['folder_id']
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('File Name'),
			'default' => TRUE
		));
		$form->addTextArea(array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control template-description',
			'label' => _('Description')
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