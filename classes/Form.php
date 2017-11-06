<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Form management class.
 *
 * @package    truenorthng
 * @subpackage Form
 */

class Form extends Object {
	private $model;
	private $prefill;

	public function __construct(G $G, $args, $prefill = array()) {
		if (!is_array($args)) {
			$args = array($args);
		}
		if (!isset($args['chrome'])) {
			$args['chrome'] = TRUE;
		}
		$args['fields'] = array();
		parent::__construct($G, $args);
		
		$this->removeExpiredFormEntries();
		
		$this->model = get_model('form');
		$this->model->id = '';
		$this->model->name = $args['name'];
		$this->model->created = time();
		$this->model->expires = $this->model->created + $this->G->formExpiry;
		if (!is_array($prefill)) {
			$prefill = array($prefill);
		}
		$this->prefill = $prefill;
		//echo "<pre>".$this->model->name.": ".print_r($this->prefill, TRUE)."</pre>";
	}

	public function addText($args) {
		$this->addField('text', $args);
	}

	public function addTextarea($args) {
		$this->addField('textarea', $args);
	}

	public function addFile($args) {
		$this->addField('file', $args);
	}

	public function addSelect($args) {
		$this->addField('select', $args);
	}

	public function addEmail($args) {
		$this->addField('email', $args);
	}

	public function addDate($args) {
		$this->addField('date', $args);
	}

	public function addPassword($args) {
		$this->addField('password', $args);
	}

	public function addCheckbox($args) {
		$this->addField('checkbox', $args);
	}

	public function addRadio($args) {
		$this->addField('radio', $args);
	}

	public function addSubmit($args) {
		$this->addField('submit', $args);
	}

	public function addHidden($args) {
		$this->addField('hidden', $args);
	}

	public function addList($args) {
		$this->addField('list', $args);
	}

	public function addHiddenArray($args) {
		$this->addField('hiddenArray', $args);
	}

	public function addHiddenReviewData($args) {
		$this->addField('hiddenReviewData', $args);
	}

	public function addStatic($args) {
		$this->addField('static', $args);
	}

	public function addButton($args) {
		$this->addField('button', $args);
	}

	public function addRating($args) {
		$this->addField('rating', $args);
	}

	public function addInstructions($args) {
		$this->addField('instructions', $args);
	}

	public function reviewFormInfo($args) {
		$this->addField('reviewFormInfo', $args);
	}
	
	public function reviewFormSection($args) {
		$this->addField('reviewFormSection', $args);
	}
	
	public function reviewFormStaticSection($args) {
		$this->addField('reviewFormStaticSection', $args);
	}

	public function reviewFormRatingKey($args) {
		$this->addField('reviewFormRatingKey', $args);
	}	
	
	public function matrix($args) {
		$this->addField('matrix', $args);
	}
	
	public function signature($args) {
		$this->addField('signature', $args);
	}	
	
	private function addField($type, $args) {
		if (isset($args['name'])) {
			$name = $args['name'];
			$args['type'] = $type;
			$this->data['fields'][$name] = $args;
		}
	}
	/*
	openTag & closeTag allows to add tags to the form
	Must set nowrapper in controller so the tag is not wrapped in the form group div
	Other form elements can be added between openTag and closeTag as long as nowrapper is set on the form element.
	Must follow form model of having unquie names
	*/		
	
	public function openTag($args) {
		$this->addField('openTag', $args);
	}
	
	public function plainText($args) {
		$this->addField('plainText', $args);
	}
	
	public function closeTag($args) {
		$this->addField('closeTag', $args);
	}
	
	public function value($name, $postonly = FALSE) {
		$return = NULL;
		$post = $this->G->url->getPostBit($name);
		$query = NULL;
		$prefill = NULL;
		$forced = NULL;
		if (!$postonly) {
			//pr($name);
			//pr($this->prefill);
			$query = $this->G->url->getQuerystringBit($name);
			if (isset($this->prefill[$name]) && $this->prefill[$name] != '') {
				$prefill = $this->prefill[$name];
				if (is_array($prefill)) {
					$ids = array_keys($prefill);
					$prefill = array_shift($ids);
				}
				/*
				pr($name, 'NAME ');
				pr($prefill);
				pr($this->data['fields'][$name]);
				pr($this->prefill[$name]);
				*/
				if (isset($this->data['fields'][$name]['values']) && isset($this->data['fields'][$name]['values'][$prefill])) {
					//$prefill = $this->data['fields'][$name]['values'][$this->prefill[$name]];
				}
			}
			if (isset($this->data['fields'][$name]['value'])) {
				//$forced = $this->data['fields'][$name]['value'];
			}
		}
		if ($forced) {
			$return = $forced;
		} elseif ($prefill) {
			$return = $prefill;
		} elseif ($post) {
			$return = $post;
		} elseif ($query) {
			$return = $query;
		}
		return $return;
	}

	public function html() {
		$this->model->save();
		$return = NULL;
		$form_disabled = NULL;
		if ($this->chrome) {
			if($this->disabled) {
				$form_disabled = ' disabled';
			}
			$return = '<form id="' . $this->id . '"  class="' . $this->class . '" action="' . $this->action . '" role="form" method="post" autocomplete="off" enctype="multipart/form-data" '.$form_disabled.'>';
			//$return .= '<fieldset '.$form_disabled.'>';
			$return .= '<h2 class="' . $this->header['class'] . '">' . $this->header['text'] . '</h2>';
		}
		foreach ($this->fields as $name => $field) {
			if (!isset($field['nowrapper'])) {
				$return .= '<div class="form-group">';
			}
			$autofocus = NULL;
			$disabled = NULL;
			$readonly = NULL;
			$multiple = NULL;
			$size = NULL;
			$inputType = NULL;
			//$required = NULL;
			$validation = NULL;
			if (!array_key_exists('validation', $field)) {
				$field['validation'] = array();
			}
			if (isset($field['default']) && $field['default']) {
				//$autofocus = 'autofocus';
			}
			if (isset($field['required']) && $field['required']) {
				if (isset($field['validation']['data-validation']) && $field['validation']['data-validation']) {
					$field['validation']['data-validation'] .= ' required';
				} else {
					$field['validation']['data-validation'] = 'required';
				}
			}
			if ($field['type'] == 'email') {
				if (isset($field['validation']['data-validation']) && $field['validation']['data-validation']) {
					$field['validation']['data-validation'] .= ' email';
				} else {
					$field['validation']['data-validation'] = 'email';
				}
			}
			if ($field['type'] == 'date') {
				if (isset($field['validation']['data-validation']) && $field['validation']['data-validation']) {
					$field['validation']['data-validation'] .= ' date';
				} else {
					$field['validation']['data-validation'] = 'date';
				}
			}
			if (isset($field['validation']) && $field['validation']) {
				foreach ($field['validation'] as $key => $value) {
					$validation .= ' ' . $key . '="' . $value . '"';
				}
			}
			if (isset($field['disabled']) && $field['disabled']) {
				$disabled = 'disabled';
			}
			if (isset($field['readonly']) && $field['readonly']) {
				$readonly = 'readonly';
			}
			if (isset($field['multiple']) && $field['multiple']) {
				$multiple = 'multiple="multiple"';
			}
			if (isset($field['size']) && $field['size']) {
				$size = 'size="'.$field['size'].'"';
			}
			if (isset($field['inputType']) && $field['inputType']) {
				if ($field['inputType'] == 'radio'){
					$inputType = ' type="'.$field['inputType'].'"';
				} elseif($field['inputType'] == 'label') {
					$inputType = ' for="'.$field['id'].'"';
				}
			}
			switch ($field['type']) {
				case 'hidden':
					$class = '';
					if (isset($field['class'])) {
						$class = $field['class'];
					}
					$return .= '<input type="hidden" name="' . $name . '" class="' . $class . '" value="' . $this->value($name) . '">';
					break;
				case 'hiddenArray':
					foreach ($field['values'] as $id => $val) {
						$return .= '<input type="hidden" name="' . $name . '" value="' . $val . '">';
					}
					break;
				case 'hiddenReviewData':
					foreach ($field['values'] as $id => $val) {
						$return .= '<input type="hidden" name="' . $id . '" value="' . $val . '">';
					}
					break;
				case 'static':
					$return .= '<label>' . $field['label'] . '</label>';
					$value = $this->value($name);
					$return .= '<p class="form-control-static ' . $field['class'] . '">' . $value . '</p>';
					break;
				case 'text':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<input type="text" ' . $validation . ' id="' . $name . '" name="' . $name . '" class="' . $field['class'] . '" placeholder="' . $field['label'] . '" ' . $autofocus . ' ' . $disabled . ' ' . $readonly . ' value="' . $this->value($name) . '">';
					break;
				case 'date':
					$date = NULL;
					if ($this->value($name) != '') {
						$date = date('m/d/Y', $this->value($name));
					}
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<input type="text" ' . $validation . ' data-validation-format="mm/dd/yyyy" id="' . $name . '" name="' . $name . '" class="' . $field['class'] . ' datepicker" placeholder="' . $field['label'] . '" ' . $autofocus . ' ' . $disabled . ' value="' . $date . '">';
					//$return .= '<script>$(document).ready(function() {$("#'.$name.'").datepicker({format: "yyyy/mm/dd",todayBtn: "linked",autoclose: true,todayHighlight: true});});</script>';
					break;
				case 'textarea':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					
					if($this->id == 'tactic-form' && $name == 'comment' && isset($this->prefill["existing_comments"])) {
						if ($this->prefill["existing_comments"] != '') { 
												
							$progress_notes = unserialize(base64_decode($this->prefill["existing_comments"]));
							
							$notes = '<div class="main-comment">';
							if(count($progress_notes) > 0) {
								foreach($progress_notes as $note) {
									
									$notes .= '<p><i class="fa fa-comment"></i><span>Posted On: <strong>'.date("M d, Y", $note["dt"]).'</strong></span><input type="hidden" name="existing_comments[]" value="'.htmlentities(base64_encode(serialize($note)), ENT_QUOTES).'" /> <br/>'.stripslashes($note["notes"]).' &nbsp;&nbsp;<a href="javascript:;" class="label label-danger del-comment">Delete</a></p>
									';				
								}
								$notes .= "<br/></div>";
							}
							$return .= $notes;
						}
					}
					
					
					$return .= '<textarea ' . $validation . ' id="' . $name . '" name="' . $name . '" class="' . $field['class'] . '" ' . $autofocus . ' ' . $disabled . '>' . $this->value($name) . '</textarea>';
					break;
				case 'email':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<input type="text" ' . $validation . ' id="' . $name . '" name="' . $name . '" class="' . $field['class'] . '" placeholder="' . $field['label'] . '" ' . $autofocus . ' ' . $disabled . ' value="' . $this->value($name) . '">';
					break;
				case 'password':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<input type="password" ' . $validation . ' id="' . $name . '" name="' . $name . '" class="' . $field['class'] . '" placeholder="' . $field['label'] . '" ' . $autofocus . ' ' . $disabled . '>';
					break;
				case 'radio':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label><br>';
					foreach ($field['value'] as $radioId => $radioLabel) {
						$checked = NULL;
						
						if (!$this->value($name) || $this->value($name) == '') {

							if (isset($field['default']) && $radioId == $field['default']) {
								$checked = 'checked';
							}
						} else {
							if ($this->value($name) == $radioId) {
								$checked = 'checked';
							}
						}
						

						$return .= '<label class="radio-inline">';
						$return .= '<input ' . $validation . ' type="radio" name="' . $name . '[]" value="' . $radioId . '" ' . $checked . ' ' . $disabled . '> ' . $radioLabel;
						$return .= '</label>';
					}
					break;
				case 'checkbox':
					if (is_array($field['value'])) {
						$return .= '<label for="' . $name . '">' . $field['label'] . '</label><br>';
						foreach ($field['value'] as $boxId => $boxLabel) {
							$checked = NULL;
							if ($this->value($boxId)) {
								$checked = 'checked';
							}
							$return .= '<label class="checkbox-inline">';
							$return .= '<input type="checkbox" name="' . $name . '[]" value="' . $boxId . '" ' . $checked . ' ' . $disabled . '> ' . $boxLabel;
							$return .= '</label>';
						}
					} else {
						$checked = NULL;
						if ($this->value($name)) {
							$checked = 'checked';
						}
						$return .= '<label class="' . $field['class'] . '">';
						$return .= '<input type="checkbox" name="' . $name . '" value="' . $field['value'] . '" ' . $checked . ' ' . $disabled . '> ' . $field['label'];
						$return .= '</label>';
					}
					break;
				case 'select':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<select ' . $validation . ' class="' . $field['class'] . '" id="' . $name . '" name="' . $name . '" ' . $disabled . ' '.$multiple.' '.$size.'>';
					foreach ($field['values'] as $id => $val) {
						$selected = NULL;
						if (!$this->value($name) || $this->value($name) == '') {
							if (isset($field['default']) && $id == $field['default']) {
								$selected = 'selected';
							}
						} else {
							if ($this->value($name) == $id) {
								$selected = 'selected';
							}
						}
						
						/* if($multiple) {
							//print_r($this->value($name));
							print_r($field['default']);
							echo $id;
						} */
							
						
						if(isset($field['default']) && is_array($field['default']) && in_array($id, $field['default'])) {
							$selected = 'selected';
						}
						
						$return .= '<option value="' . $id . '" ' . $selected . '>' . $val . '</option>';
					}
					$return .= '</select>';
					break;
				case 'rating':
					for ($i = 5; $i >= 1; $i--) {
						$checked = NULL;
						if ($this->value($name) == $i) {
							$checked = 'checked';
						} elseif($field['value'] == $i){
							$checked = 'checked';
						}
						$return .= '<input type="radio" class="'.$field['class'].'" name="'.$field['name_set'].'" value="'.$i.'" id="'.$field['id'].$i.'" '.$checked.'> ';
						$return .= '<label for="'.$field['id'].$i.'" name="'.md5(rand().time().rand()).'">'.$i.'</label>';
					}
					break;
				case 'list':
					$return .= '<div class="subeval-list clearfix">';
					$return .= '<div class="subevaluations">';
					$return .= '<label>Review Sections</label>';
					$return .= '<ul>';
					
					foreach ($field['shortList'] as $id) {
						foreach($id as $item){
							$item_id = $id['id'];
							$item_name = $id['name'];
							$item_desc = (isset($id['description']) && $id['description'] != '') ? '<br/><i style="font-size:12px;">'.$id['description'].'</i>' : '';
							$item_type = $id['type'];
							if(array_key_exists('cummulation', $id)){
								$item_cummulation = ' ('.ucwords(strtolower($id['cummulation'])).')';
							} else {
								$item_cummulation = null;
							}
						}
						global $G;
						if($item_type == 'static'){
							if($this->disabled) {
								$return .= '<li class="static-item"><span class="static-content"><span class="static-content-edit">Edit</span>'.$item_name.'</span><input type="hidden" name="subevaluations[]" value="'. $item_id .'"></li>';
							} else {
								$return .= '<li class="static-item"><span class="static-content"><span class="static-content-edit"><a class="static-content-link" href="'.URL.$G->url->parentUrl(2).URL.'static'.URL.'edit/'.$item_id.'">Edit</a></span>'.$item_name.'</span><input type="hidden" name="subevaluations[]" value="'. $item_id .'"></li>';	
							}
						} elseif($item_type == 'rcMatrix'){
							$return .= '<li class="matrix-item">'.$item_name.$item_cummulation.$item_desc.'<input type="hidden" name="subevaluations[]" value="'. $item_id .'"></li>';
						} elseif($item_type == 'signature'){
							$return .= '<li class="signature-item">'.$item_name.$item_cummulation.$item_desc.'<input type="hidden" name="subevaluations[]" value="'. $item_id .'"></li>';
						} else {
							$return .= '<li>'.$item_name.$item_cummulation.$item_desc.'<input type="hidden" name="subevaluations[]" value="'. $item_id .'"></li>';
						}
					}
					$return .= '</ul>';
					$return .= '</div>';
					$return .= '<div class="eval-buttons">';
					$return .= '<button name="addsection" class="btn btn-info clearfix" > < </button>';
					$return .= '<button name="removesection" class="btn btn-info clearfix" > > </button>';
					$return .= '</div>';
					$return .= '<div class="subevaluations-fulllist">';
					$return .= '<label>Sub Sections</label>';
					$return .= '<ul>';
					global $G;
					$return .= '<li class="static-item"><span class="static-content">Static Content</span><input type="hidden" name="" value=""></li>';
					$return .= '<li class="matrix-item"><span class="matrix-content">Results/Culture Matrix</span><input type="hidden" name="" value=""></li>';
					$return .= '<li class="signature-item"><span class="signature-content">Signature</span><input type="hidden" name="" value=""></li>';
					foreach ($field['fullList'] as $id) {
						foreach($id as $item){
							$item_id = $id['id'];
							$item_name = $id['name'];
							$item_desc = (isset($id['description']) && $id['description'] != '') ? '<br/><i style="font-size:12px;">'.$id['description'].'</i>' : '';
							$item_cummulation = ucwords(strtolower($id['cummulation']));
						}
						$return .= '<li>'.$item_name .' ('.$item_cummulation.')'.$item_desc.'<input type="hidden" name="' . $item_name . '" value="' . $item_id . '"></li>';
					}
					$return .= '</ul>';
					$return .= '</div>';
					$return .= '</div>';
					break;
				case 'file':
					$return .= '<label for="' . $name . '">' . $field['label'] . '</label>';
					$return .= '<input type="file" ' . $validation . ' id="' . $name . '" name="' . $name . '" class="' . $field['class'] . '" placeholder="' . $field['label'] . '" ' . $autofocus . ' ' . $disabled . ' value="' . $this->value($name) . '">';
					if ($this->value($name) != '') {
						$imageExtensions = array('jpg', 'jpeg', 'gif', 'png');
						if (in_array(substr($this->value($name), strrpos($this->value($name), '.') + 1), $imageExtensions)) {
							$return .= '<img src="' . $this->value($name) . '" class="img-thumbnail img-responsive" />';
						} else {
							$return .= 'Currently <em>'.$this->value($name).'</em>';
						}
					}
					break;
				case 'button':
					$return .= '<button name="' . $name . '" class="btn ' . $field['class'] . '" ' . $autofocus . ' ' . $disabled . '>' . $field['label'] . '</button>';
					break;
				case 'submit':
					$return .= '<button name="' . $name . '" class="btn ' . $field['class'] . '" type="submit" ' . $autofocus . ' ' . $disabled . '>' . $field['label'] . '</button>';
					break;
				case 'openTag':
					$checked = NULL;
					if (isset($field['checked'])) {
						$checked = 'checked';
					}
					if ($inputType){
						$return .= '<'.$field['tag'].' class="'.$field['class'].'" '.$inputType.' name="'.$field['name_set'].'" value="'.$field['value'].'" id="'.$field['id'].'" '.$checked.'> ';
					} else {
						$return .= '<'.$field['tag'].' class="'.$field['class'].'" > ';
					}
					break;
				case 'plainText':
					$return .= $field['value'];
					break;
				case 'instructions':
					$return .= $field['value'];
					break;
				case 'closeTag':
					$return .= '</'.$field['tag'].'>';
					break;
				case 'reviewFormInfo':
					if(isset($field['hourly_name']) && $field['hourly_name'] != "") {
						$return .= '<div class="container-fluid clearfix">';
							$return .= '<div class="col-md-4 reviewform-info">';
								$return .= '<p>Name: '.$field['hourly_name'].'</p>';
								$return .= '<p>Position: '.$field['hourly_position'].'</p>';
								$return .= '<p>Department: '.$field['hourly_department'].'</p>';
								$return .= '<p>Division: '.$field['hourly_division'].'</p>';
								$return .= '<p>Property: '.$field['property_name'].'</p>';
							$return .= '</div>';
							$return .= '<div class="col-md-4 reviewform-info">';
								$return .= '<p>Last Review Date: '.$field['last_review_date'].'</p>';
								$return .= '<p>Review Cycle: '.$field['review_cycle'].'</p>';
								$return .= '<p>Manager/Evaluator: '.$field['review_cycle'].'</p>';
								$return .= '<p>Review Form: '.$field['reviewform_name'].'</p>';
							$return .= '</div>';
							$return .= '<div class="col-md-4 reviewform-info">';
								$return .= '<p>Current Rate: '.$field['current_rate'].'</p>';
								$return .= '<p>Date of Hire: '.$field['hire_date'].'</p>';
								$return .= '<p>Date of Current Position: '.$field['position_date'].'</p>';
								$return .= '<p>Seniority Date: '.$field['seniority_date'].'</p>';
							$return .= '</div>';
						$return .= '</div>';
					} else {
						$return .= '<div class="container-fluid clearfix">';
							$return .= '<div class="col-md-6 reviewform-info">';
								$return .= '<p>Employee Info: '.$field['target_user'].'</p>';
								$return .= '<p>Manager: '.$field['manager'].'</p>';
							$return .= '</div>';
							$return .= '<div class="col-md-6 reviewform-info">';
								$return .= '<p>Department: '.$field['department'].'</p>';
								$return .= '<p>Property: '.$field['property'].'</p>';
							$return .= '</div>';							
							/* $return .= '<div class="col-md-6 reviewform-info">';
								$return .= '<p>Last Review Date: '.$field['last_review_date'].'</p>';
								$return .= '<p>Review Cycle: '.$field['review_cycle'].'</p>';
								$return .= '<p>Manager/Evaluator: '.$field['review_cycle'].'</p>';
								$return .= '<p>Review Form: '.$field['reviewform_name'].'</p>';
							$return .= '</div>';
							$return .= '<div class="col-md-4 reviewform-info">';
								$return .= '<p>Current Rate: '.$field['current_rate'].'</p>';
								$return .= '<p>Date of Hire: '.$field['hire_date'].'</p>';
								$return .= '<p>Date of Current Position: '.$field['position_date'].'</p>';
								$return .= '<p>Seniority Date: '.$field['seniority_date'].'</p>';
							$return .= '</div>'; */
						$return .= '</div>';						
					}
					break;
				case 'reviewFormSection':
					$fullsize = '';
					if(array_key_exists('sectionType', $field) AND $field['sectionType'] == 'text'){
						$fullsize = ' full-size';
					}
					$return .= '<div class="container-fluid form-section'.$fullsize.'">';
						$return .= '<div class="section-header clearfix">';
							
							if(isset($field['sectionSubCategory']))
								$return .= '<div><h4><strong>'.$field['sectionSubCategory'].'</strong></h4></div>';
														
							$return .= '<div class="pull-left"><strong>'.$field['sectionName'].'</strong></div>';
							if(array_key_exists('sectionType', $field) AND $field['sectionType'] == 'rating'){
								$return .= '<div class="pull-right rating-stars">';
								// DISPLAY AVERAGE IF YOU'RE A MANAGER OR HIGHER								
								if(array_key_exists('rating_avg', $field) && $field['rating_avg'] > 0){
									$right = ($field['rating_avg'] * 100)/5;
									if(array_key_exists('ratings', $field) && !empty($field['ratings'])){
										$modal = 'data-modal="{';
										$count = 0;
										foreach ($field['ratings'] as $rated) {
											if($rated['field_id'] == $field['sectionId']){
												$count = $count+1;
											}
										}
										$count_check = 0;
											//pr($field, "ids ");
										foreach ($field['ratings'] as $rated) {
											//pr($field['sectionId'].' '.$rated['field_id']);
											if($rated['field_id'] == $field['sectionId']){
												$count_check = $count_check+1;
												if ($rated['answer'] == ''){
													$answer = 'No Rating';
												} else {
													$answer = $rated['answer'];
												}
												if ($count == $count_check){
													$modal .= "'".$rated['user_name']."':'".$answer."'";
												} else {
													$modal .= "'".$rated['user_name']."':'".$answer."',";
												}
											}
										}
										$modal .= '}"';
									} else {
										$modal = '';
									}
									//pr($field);
									
									//pr($right);
								}
								// DISPLAY THE ANSWER OF THIS USER
								if(array_key_exists('answer', $field) && $field['answer'] != null){
									$return .= '<p>Answer</p>';
									$return .= '<div class="stars">';
										for ($i = 5; $i >= 1; $i--) {
											$checked = NULL;
											if ($this->value($name) == $i) {
												$checked = 'checked';
											} elseif($field['answer'] == $i){
												$checked = 'checked';
											}
											$return .= '<input type="radio" disabled="disabled" name="'.$name.'_u" value="'.$i.'" id="'.$name.$i.'_u" '.$checked.'> ';
											$return .= '<label class="fixed-rating" for="'.$name.$i.'_u" name="'.md5(rand().time().rand()).'"></label>';
										}
									$return .= '</div>';
								}
								// DISPLAY THE ANSWER OF THIS MANAGER
								if(array_key_exists('managerAnswer', $field) && $field['managerAnswer'] != null){
									$return .= '<p>Manager</p>';
									$return .= '<div class="stars">';
										for ($i = 5; $i >= 1; $i--) {
											$checked = NULL;
											if ($this->value($name) == $i) {
												$checked = 'checked';
											} elseif($field['managerAnswer'] == $i){
												$checked = 'checked';
											}
											$return .= '<input type="radio" disabled="disabled" name="'.$name.'_m" value="'.$i.'" id="'.$name.$i.'_m" '.$checked.'> ';
											$return .= '<label class="fixed-rating" for="'.$name.$i.'_m" name="'.md5(rand().time().rand()).'"></label>';
										}
									$return .= '</div>';
								}
								// DISPLAY RATING STARS IF YOU CAN RATE THIS FORM
								else if(array_key_exists('rateable', $field) && $field['rateable'] != null){
									$return .= '<p>Your Rating</p>';
									$return .= '<div class="stars">';
										for ($i = 5; $i >= 1; $i--) {
											$checked = NULL;
											if ($this->value($name) == $i) {
												$checked = 'checked';
											} elseif($field['value'] == $i){
												$checked = 'checked';
											}
											$return .= '<input type="radio" class="" name="'.$name.session("user").'" value="'.$i.'" id="'.$name.'['.session("user").']'.$i.'" '.$checked.'> ';
											$return .= '<label for="'.$name.'['.session("user").']'.$i.'" name="'.md5(rand().time().rand()).'"></label>';
										}
									$return .= '</div>';
								}
								$return .= '</div>';
								/*	
								// TODO: Quickfix for Printing stars
								if(array_key_exists('rating_avg', $field) && $field['rating_avg'] > 0){
									$right  = ($field['rating_avg'] * 100)/5;
									$return .= '<div class="pull-right rating-stars-print visible-print">';
									$return .= '<div class="rating-avg-print" >';
									$return .= '<img src="'.THEME_URL.'images/stars-filled.png"/>';
									$return .= '<img src="'.THEME_URL.'images/fill.png" class="stars-print-bg" style="right:-'.$right.'%;"/>';
									$return .= '</div>';
									$return .= '<div class="stars-print">';
									$return .= '<img src="'.THEME_URL.'images/stars.png"/>';
									$return .= '</div>';
									$return .= '</div>';
								}
								// --->
								$return .= '<div class="pull-right rating-stars hidden-print">';
									if(array_key_exists('rating_avg', $field) && $field['rating_avg'] > 0){
										pr($field['rating_avg'], "AVERAGE ");
										$right  = ($field['rating_avg'] * 100)/5;
										if(array_key_exists('ratings', $field) && !empty($field['ratings'])){
											$modal = 'data-modal="{';
											$count = 0;
											foreach ($field['ratings'] as $rated) {
												if($rated['field_id'] == $field['sectionId']){
													$count = $count+1;
												}
											}
											$count_check = 0;
												//pr($field, "ids ");
											foreach ($field['ratings'] as $rated) {
												//pr($field['sectionId'].' '.$rated['field_id']);
												if($rated['field_id'] == $field['sectionId']){
													$count_check = $count_check+1;
													if ($rated['answer'] == ''){
														$answer = 'No Rating';
													} else {
														$answer = $rated['answer'];
													}
													if ($count == $count_check){
														$modal .= "'".$rated['user_name']."':'".$answer."'";
													} else {
														$modal .= "'".$rated['user_name']."':'".$answer."',";
													}
												}
											}
											$modal .= '}"';
										} else {
											$modal = '';
										}
										$return .= '<p>Average Rating</p> <div class="rating-avg" '.$modal.'>';
										//$return .= '<div class="rating-avg"><img src="'.THEME_URL.'images/stars-fg-w.png" class="stars-fg-w"/><img src="'.THEME_URL.'images/stars-bg.png" class="stars-bg" style="left:-'.$left.'%"/></div>';
										for ($i = 5; $i >= 1; $i--) {
											$return .= '<label name="'.md5(rand().time().rand()).'"></label>';
										}
										$return .= '<img src="'.THEME_URL.'images/fill.png" class="stars-bg" style="right:-'.$right.'%;"/>';
										$return .= '</div>';
										//pr($right);
									}
									if(array_key_exists('value', $field)){
										$return .= '<p>Your Rating</p> <div class="stars">';
										if(array_key_exists('donotsave', $field) && $field['donotsave'] == 'displayonly'){
											
											$right = 100;
											$right = ($field['value'] * 100)/5;
											if ($right == 0){
												$return .= '<img src="'.THEME_URL.'images/stars.png"/ class="rating-display">';
											} else {
												$return .= '<img src="'.THEME_URL.'images/stars-filled.png"/ class="rating-display">';
												$return .= '<img src="'.THEME_URL.'images/fill.png" class="displayonly-bg" style="right:-'.$right.'%;"/>';
											}
										} else {
											for ($i = 5; $i >= 1; $i--) {
												$checked = NULL;
												if ($this->value($name) == $i) {
													$checked = 'checked';
												} elseif($field['value'] == $i){
													$checked = 'checked';
												}
												$return .= '<input type="radio" class="" name="'.$name.'" value="'.$i.'" id="'.$name.$i.'" '.$checked.'> ';
												$return .= '<label for="'.$name.$i.'" name="'.md5(rand().time().rand()).'"></label>';
											}
										}
										$return .= '</div>';
									}
								$return .= '</div>';
								*/
							}
						$return .= '</div>';
						$return .= '<div class="section-description">';
							$return .= $field['sectionDescription'];
						$return .= '</div>';
						if(array_key_exists('sectionType', $field) AND $field['sectionType'] == 'text'){
							if(array_key_exists('rateable', $field) && $field['rateable'] != null){
								if(array_key_exists('value', $field)){
									$return .= '<textarea id="'.$name.'" class="form-control" name="'.$name.'">'.$field['value'].'</textarea>';
								} else {
									$return .= '<textarea id="'.$name.'" class="form-control" name="'.$name.'">'.$this->value($name).'</textarea>';
								}
							} elseif(array_key_exists('peerAnswers', $field) && !empty($field['peerAnswers'])){
								foreach ($field['peerAnswers'] as $peer){
									$return .= '<div class="text-answer">';
									$return .= '<strong>'.$peer['name'].'</strong>';
									$return .= '<blockquote>';
									$return .= '<p>'.$peer["answer"].'</p>';
									$return .= '</blockquote>';
									$return .= '</div>';
								}
							} else {
								if(array_key_exists('answer', $field) && $field['answer'] != null){
									//$return .= '<p id="'.$name.'" class="form-control displayonly-textarea" name="'.$name.'">'.$field['answer'].'</p>';
									$return .= '<div class="text-answer">';
									$return .= '<blockquote>';
									$return .= '<p>'.$field["answer"].'</p>';
									$return .= '</blockquote>';
									$return .= '</div>';
								}
							}
							/*
							if(array_key_exists('donotsave', $field) && $field['donotsave'] == 'displayonly'){
								if(array_key_exists('value', $field)){
									$return .= '<pre id="'.$name.'" class="form-control displayonly-textarea" name="'.$name.'">'.$field['value'].'</pre>';
								} else {
									$return .= '<pre id="'.$name.'" class="form-control displayonly-textarea" name="'.$name.'">'.$this->value($name).'</pre>';
								}
							} else {
								if(array_key_exists('value', $field)){
									$return .= '<textarea id="'.$name.'" class="form-control" name="'.$name.'">'.$field['value'].'</textarea>';
								} else {
									$return .= '<textarea id="'.$name.'" class="form-control" name="'.$name.'">'.$this->value($name).'</textarea>';
								}
							}
							*/
						}
					$return .= '</div>';
					break;

				case 'reviewFormStaticSection':
					$return .= '<div class="container-fluid form-section">';
						$return .= '<div class="section-header clearfix">';
							$return .= '<span class="pull-left"><strong>'.$field['sectionName'].'</strong></span>';
						$return .= '</div>';
						$return .= '<div class="section-description">';
							$return .= $field['sectionContent'];
						$return .= '</div>';
					$return .= '</div>';
					break;
				case 'reviewFormRatingKey':
					$return .= '<div class="container-fluid form-section rating-key-section full-size">';
						$return .= '<div class="section-header clearfix">';
							$return .= '<span class="pull-left"><strong>Rating Key</strong></span>';
						$return .= '</div>';
						$return .= '<div class="section-description">';
							$return .= <<<RATINGKEY
<ol class="rating-guide" reversed>
<li><span class="rating-key">Outstanding </span> <span>Consistently exceeds job expectations and is recoqnized as a leader and role model</span></li>
<li><span class="rating-key">Above Expectations </span> <span>Consistently meets and occasionally exceeds job expectations</span></li>
<li><span class="rating-key">Meets Expectations </span> <span>Consistently meets job expectations</span></li>
<li><span class="rating-key">Below Expectations </span> <span>Occasionally fails to meet job expectations</span></li>
<li><span class="rating-key">Unacceptable </span> <span>Consistently fails to meet job expectations and performance improvement is required</span></li>
</ol>
RATINGKEY;
						$return .= '</div>';
					$return .= '</div>';
					break;
				case 'matrix':
					if(array_key_exists('result_avg', $field)){$result_avg = $field['result_avg'];} else {$result_avg = NULL;}
					if(array_key_exists('culture_avg', $field)){$culture_avg = $field['culture_avg'];} else {$culture_avg = NULL;}
					if(array_key_exists('rating_avg', $field)){$rating_avg = $field['rating_avg'];} else {$rating_avg = NULL;}
					if(array_key_exists('ratings', $field)){$ratings = $field['ratings'];} else {$ratings = NULL;}
					$return .= rcMatrix($result_avg, $culture_avg, $rating_avg, '', $ratings, $this->G);
					break;
				case 'signature':
					$return .= '<div id="signature-block" class="container-fluid">
									<div class="row"><div class="col-md-12" style="height:30px;">&nbsp;</div></div>
									<div class="row"><div class="col-md-12" ><hr /></div></div>
									<div class="row"><div class="col-md-12" style="height:60px;">&nbsp;</div></div>
									<div class= "row" style="height:30px;">
									<div class="col-md-2">&nbsp;</div>
									<div class="col-md-2 text-right"><span style="font-size:12px;font-weight:bold;"></span></div>
									<div class="col-md-2">&nbsp;</div>
									<div class="col-md-2 text-right"><span style="font-size:12px;font-weight:bold;"></span></div>
									<div class="col-md-2">&nbsp;</div>
									<div class="col-md-2 text-right"><span style="font-size:12px;font-weight:bold;"></span></div>
									</div>
									<div class= "row">
									<div class="col-md-3">Team Member Signature</div>
									<div class="col-md-1">Date</div>
									<div class="col-md-3">Manager Signature</div>
									<div class="col-md-1">Date</div>
									<div class="col-md-3">Senior Manager Signature</div>
									<div class="col-md-1">Date</div>
									</div>
									<div class="row"><div class="col-md-12" style="height:60px;">&nbsp;</div></div>
								</div>
					';
					break;
			}
			if (!isset($field['nowrapper'])) {
				$return .= '</div>';
			}
		}
		//$return .= '<input type="hidden" name="rf" value="'.$this->G->url.'">';
		if ($this->chrome) {
			$return .= '<button name="reset" class="btn btn-warning" type="reset">' . _('Reset') . '</button>';
			$return .= '<input type="hidden" name="tnngtoken" value="' . $this->model->id . '">';
			//$return .= '</fieldset>';
			$return .= '</form>';
		}
		return $return;
	}

	public function valid() {
		$return = FALSE;
		$token = $this->value('tnngtoken', TRUE);
		$lookup = $this->model->getOne($token, 'id');
		if (isset($lookup['created']) && $lookup['created'] <= time() && isset($lookup['expires']) && $lookup['expires'] >= time()) {
			//echo '<pre>FORM LOOKUP:'.print_r($lookup, TRUE).'</pre>';
			$return = array_merge($lookup, $_POST);
		}
		return $return;
	}
	
	public function id(){
		$this->model->save();
		return $this->model->id;
	}
	
	public function removeExpiredFormEntries() {
		global $G;
		$expiryTime = time() - 86400;
		$sql = 'DELETE FROM #__Form 
						WHERE expires < ' . $expiryTime;
		$G->db->executeQuery($sql);
		
		$sql = 'DELETE FROM #__Ids 
						WHERE type = "Form" AND expires < ' . $expiryTime;
		$G->db->executeQuery($sql);
		
	}
}
