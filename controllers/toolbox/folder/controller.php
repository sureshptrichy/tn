<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Templates controller.
 *
 * @package    truenorthng
 */

final class Controller_Toolbox_Folder extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Folder'),
			'view' => 'folder',
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

	public function config_new($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addTemplate';
	}
	
	public function call_new($params) {
		$model = get_model('folder'); 
		$preload = array();
		$templateName = '';
		$preload['property_id'] = $params[0];
		$preload['division_id'] = $params[1];
		$division = $model->getDivisionName($preload['division_id']);
		$templateName = $division[$preload['division_id']]['name'];
		$preload['templateName'] = $templateName;
		$form = $this->build_form('new', $preload);
		if (FALSE === $form->valid()) {
			tpl_set('templateForm', $form);
		} else {
			$templateForm = $form->valid();
			$success = TRUE;
			$path = null;
			$mime = null;
			$property_id = null;
			$division_id = null;
			$departmentId = null;
			if (!array_key_exists('name', $templateForm) || $templateForm['name'] == null) {
				$success = FALSE;
			}
			$property_id = $templateForm['property_id'];
			$division_id = $templateForm['division_id'];
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
			tpl_set('templateForm', $form);
			if (!$success) {
				tpl_set('templateForm', $form);
				flash(_('Sorry, the folder could not be created. Please try again.'), 'warning');
			} else {
				tpl_set('templateForm', $form);
				$model->save();
				flash(_('The folder has been created.'), 'success');
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
		$model = get_model('folder');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			flash(_('This folder has been deleted.'), 'success');
			locate('/'.$this->G->url->parentUrl(3));
		} else {
			locate('/'.$this->G->url->parentUrl(3));
		}
		parent::display();
	}
	
	public function config_edit($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_edit';
		$this->permission[] = 'editTemplate';
	}

	public function call_edit($params) {
		$model = get_model('folder');
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

	private function build_form($type, $preload = array()) {
		if (array_key_exists('templateName', $preload)){
			$title = sprintf(_('%1$s '.$preload['templateName'].' Folder'), ucfirst($type));
		} else {
			$title = sprintf(_('%1$s Folder'), ucfirst($type));
		}
		$form = new Form($this->G, array(
			'name' => 'template',
			'class' => 'form form-template',
			'header' => array(
				'text' => $title,
				'class' => 'form-template-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		if(array_key_exists('property_id', $preload)){
			$form->addHidden(array(
				'name' => 'property_id',
				'value' => $preload['property_id']
			));
		}
		if(array_key_exists('division_id', $preload)){
			$form->addHidden(array(
				'name' => 'division_id',
				'value' => $preload['division_id']
			));
		}
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Folder Name'),
			'default' => TRUE
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
		$form->addFile(array(
			'name' => 'path',
			'class' => '',
			'label' => _('Upload a Thumbnail (86px x 68px)'),
			'types' => array(
				'jpg',
				'jpeg',
				'gif',
				'png'
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