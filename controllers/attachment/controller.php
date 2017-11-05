<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Competency controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Attachment extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Attachment'),
			'view' => 'attachment'
		);
		$this->permission = array(
			'authenticated',
			'viewAttachment'
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
		$this->permission[] = 'addAttachment';
	}

	public function call_new($params) {
		$model = get_model('attachment');
		$pid = $params[0];
		
		$actionURL = URL . 'attachment/new/' . $pid;
		
		if($this->G->url->getQuerystringBit('rf')) {
			$actionURL .= '?rf=' . $this->G->url->getQuerystringBit('rf');
		}
		
		
		$form = $this->build_attachment_form('new', array(
			'action' => $actionURL,
			'parent_id' => $pid
		));
		if (FALSE === $form->valid()) {
			tpl_set('attachmentForm', $form);
		} else {
			$attachment = $form->valid();
			//echo "<pre>ATT: ".print_r($attachment, TRUE)."</pre>";
			//echo "<pre>UPL: ".print_r($_FILES, TRUE)."</pre>";
			//die();
			$success = false;
			$path = NULL;
			$mime = NULL;
			if (isset($_FILES['path']) && isset($_FILES['path']['size']) && $_FILES['path']['size'] > 1) {
				$path = $attachment['tnngtoken'].'-'.$_FILES['path']['name'];
				if (isset($_FILES['path']['type']) && $_FILES['path']['type'] != '') {
					$mime = $_FILES['path']['type'];
				}
				if (move_uploaded_file($_FILES['path']['tmp_name'], UPLOAD_PATH.$path)) {
					$success = true;
				}
			}
			$model->setAll($attachment);
			$model->status = 1;
			$model->parent_id = $pid;
			$model->path = $path;
			$model->mime = $mime;
			$model->cid = $this->G->user->id;
			if (!$success) {
				tpl_set('attachmentForm', $form);
				flash(_('Sorry, the attachment could not be created. Please try again.'), 'warning');
			} else {
				$model->save();
				flash(_('The attachment has been created.'), 'success');
				locate($this->G->url->getQuerystringBit('rf'));
			}
		}
		parent::display();
	}
	
	public function config_delete($params = NULL) {
		//$this->route['view'] = $this->route['view'].'_edit';
		//$this->permission[] = 'deleteDepartment';
	}

	public function call_delete($params) {
		
		$model = get_model('attachment');
		if (isset($params[0]) && $params[0] != '') {
						
			$model->setAll($model->getOne($params[0], 'id'));
			
			$model->id = $params[0];
			$model->status = 0;
			$model->delete($params[0]);				

			flash(_('The attachment has been deleted.'), 'success');
			locate($this->G->url->getQuerystringBit('rf'));
		} else {
			locate($this->G->url->getQuerystringBit('rf'));
		}		
	}	

	private function build_attachment_form($type = 'new', $preload = array()) {
		
		$preload["action"] = (isset($preload["action"])) ? $preload["action"] : '';

		
		$form = new Form($this->G, array(
			'name' => $type.'-attachment',
			'class' => 'form form-attachment',
			'action' => $preload["action"], 
			'header' => array(
				'text' => sprintf(_('%1$s Attachment'), ucfirst($type)),
				'class' => 'form-attachment-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$file = NULL;
		if (isset($preload['path'])) {
			$file = $preload['path'];
		}
		$form->addHidden(array(
			'name' => 'path-previous',
			'value' => $file
		));
		$form->addText(array(
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Attachment Name'),
			'default' => TRUE
		));
		/*
		$form->addTextarea(array(
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Attachment description')
		));
		*/
		$form->addFile(array(
			'name' => 'path',
			'required' => true,
			'class' => '',
			'label' => _('Upload a File'),
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
