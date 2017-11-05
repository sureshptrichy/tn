<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Review Cycle Settings controller.
 *
 * @package    truenorthng
 * @subpackage Settings
 */

final class Controller_Settings_Reviewcycles extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Leadership Reviews'),
			'view' => 'settings/reviewcycles',
			'main_order' => 200
		);
		$this->permission = array(
			'authenticated',
			'viewReviewcycle'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$model = get_model('reviewcycle');
		tpl_set('reviews', $model->get(null, null, -1, session('property')));
		parent::display();
	}

	public function config_add($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_add($params) {
		$model = get_model('reviewcycle');
		$divisions = get_model('property')->getDivisions();
		foreach ($divisions as $id => $division) {
			$divisions[$id]['_departments'] = get_model('division')->getDepartments($id);
		}
		$form = $this->build_form_1('new', array(), $divisions);
		if (FALSE === $form->valid()) {
			tpl_set('addFormUrl', URL . $this->G->url->parentUrl() . '/getforms');
			tpl_set('divisions', $divisions);
			tpl_set('form', $form);
		} else {
			$review = $form->valid();
			if (isset($review['start'])) {
				$review['start'] = strtotime($review['start']);
			}
			if (isset($review['due'])) {
				$review['due'] = strtotime($review['due']);
			}
			$review['cid'] = session('user');
			$review['setup'] = array('me' => array(), 'ae' => array());
			foreach ($review as $id => $val) {
				$type = substr($id, 0, 2);
				if (substr($id, 0 ,3) == 'ae-' || substr($id, 0 ,3) == 'me-') {
					// Compiled form assignment!
					$id = substr($id, 3);
					$val = explode(',', $val);
					foreach ($val as $form) {
						if ($form != '') {
							$form = explode(':', $form);
							if (isset($form[0]) && isset($form[1])) {
								$review['setup'][$type][$id][$form[0]] = $form[1];
							}
						}
					}
				}
			}
			$review['setup'] = json_encode($review['setup']);
			$model->setAll($review);
			$model->status = 1;
			$model->cid = $this->G->user->id;
			$model->save();
			$propertyModel = get_model('property');
			$propertyModel->addReviewcycle(session('property'), $model->id);
			flash(_('The leadership review has been created.'), 'success');
			locate('/'.$this->G->url->parentUrl().'/edit/'.$model->id.'/2');
		}
		parent::display();
	}

	public function config_edit($params = NULL) {
		if ($this->G->url->getUrlBit(4) == 8) {
			$this->route['view'] = $this->route['view'] . '_LAUNCH';
		} else {
			$this->route['view'] = $this->route['view'] . '_edit';
		}
		$this->permission[] = 'editReviewcycle';
	}

	public function call_edit($params) {
		$reviewId = $params[0];
		$step = 1;
		if (isset($params[1]) && $params[1] > 0) {
			$step = $params[1];
		}
		tpl_set('step', $step);
		$model = get_model('reviewcycle');
		$preload = $model->getOne($reviewId, 'id');
		$formList = array();
		$setup = json_decode($preload['setup'], true);
		$hourlies = null;
		foreach ($setup as $type => $sections) {
			if ($type == 'ae' || $type == 'me') {
				foreach ($sections as $sectionId => $forms) {
					$formList[$type . '-' . $sectionId] = '';
					foreach ($forms as $formId => $formName) {
						$formList[$type . '-' . $sectionId] .= ',' . $formId . ':' . $formName;
					}
				}
			}
		}
		$divisions = get_model('property')->getDivisions();
		foreach ($divisions as $id => $division) {
			$divisions[$id]['_departments'] = get_model('division')->getDepartments($id);
		}
		switch ($step) {
			case 1:
				$form = $this->build_form_1('edit', array_merge($preload, $formList), $divisions);
				if (FALSE === $form->valid()) {
					tpl_set('addFormUrl', URL . $this->G->url->parentUrl(3) . '/getforms');
					tpl_set('divisions', $divisions);
					tpl_set('setup', $setup);
					tpl_set('form', $form);
				} else {
					$review = $form->valid();
					if (isset($review['start'])) {
						$review['start'] = strtotime($review['start']);
					}
					if (isset($review['due'])) {
						$review['due'] = strtotime($review['due']);
					}

					$reviewAssignments = array('me' => array(), 'ae' => array());
					foreach ($review as $id => $val) {
						if (false !== strpos($id, '-')) {
							$typeId = explode('-', $id);
							if ($typeId[0] == 'ae' || $typeId[0] == 'me') {
								$formId = $typeId[1];
								$val = explode(',', $val);
								foreach ($val as $form) {
									if ($form != '') {
										$form = explode(':', $form);
										if (isset($form[0]) && isset($form[1])) {
											$reviewAssignments[$typeId[0]][$formId][$form[0]] = $form[1];
										}
									}
								}
							}
						}
					}
					$setup['me'] = $reviewAssignments['me'];
					$setup['ae'] = $reviewAssignments['ae'];

					$preload['setup'] = json_encode($setup);
					$model->setAll(array_merge($preload, $review));
					$model->id = $review['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->save();
					$propertyModel = get_model('property');
					$propertyModel->addReviewcycle(session('property'), $model->id);
					locate(URL.$this->G->url->parentUrl().'/2');
				}
				break;
/* 			case 2:
				$preload['hourlies-previous'] = $preload['hourlies'];
				$form = $this->build_form_2('edit', $preload, $divisions);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$hourliesFile = $form->valid();
					$success = TRUE;
					$csvPath = NULL;

					if (isset($_FILES['hourlies']) && isset($_FILES['hourlies']['size']) && $_FILES['hourlies']['size'] > 1) {
						$csvPath = $hourliesFile['tnngtoken'].'-'.$_FILES['hourlies']['name'];
						if (!move_uploaded_file($_FILES['hourlies']['tmp_name'], UPLOAD_PATH.$csvPath)) {
							$success = FALSE;
						}
					} elseif (isset($preload['hourlies-previous'])) {
						$csvPath = $preload['hourlies-previous'];
					} else {
						$success = false;
					}
					if (false === $success) {
						flash(_('The CSV file could not be uploaded'), 'danger');
					}

					$csv = loadCsv(UPLOAD_PATH.$csvPath);
					//print_r($csv);exit;
					$codes = array();
					foreach ($csv as $line) {
						$codes[] = $line['Home Loc'];
					}

					// Check 'Home Loc' against department codes.
					$codes = array_values(array_unique($codes));
					$codeCheck = array();
					foreach ($codes as $code) {
						$department = get_model('department')->getOne($code, 'code');
						$codeCheck[] = $department['code'];
					}
					$diff = array_diff($codes, $codeCheck);
					if (count($diff) > 0) {
						pr('Unknown department code <strong>'. array_pop($diff) .'</strong>', 'FAILED: ');
						die();
					}

					// Verify every department has a manager in the system.
					$missing = array();
					foreach ($codes as $code) {
						$manager = get_model('department')->getManagerFromCode($code);
						if (count($manager) == 0) {
							$missing[] = $code;
						}
					}
					if (count($missing) > 0) {
						flash('Could not find managers for the following department codes: '.implode(', ', $missing));
					}

					$preload['hourlies'] = $csvPath;
					$model->setAll($preload);
					$model->id = $preload['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->save();
					$propertyModel = get_model('property');
					$propertyModel->addReviewcycle(session('property'), $model->id);

					locate(URL.$this->G->url->parentUrl().'/3');
				}
				break; */
			/* case 3:
				if (!isset($preload['hourlies']) || trim($preload['hourlies']) == '') {
					locate(URL.$this->G->url->parentUrl().'/4');
				}
				$associates = loadCsv(UPLOAD_PATH . $preload['hourlies']);
				//print_r($associates);exit;
				// Sort by department code then name.
				foreach ($associates as $key => $row) {
					$departmentCode[$key]  = $row['Home Loc'];
					$lastName[$key] = $row['Name'];
				}
				array_multisort($departmentCode, SORT_ASC, $lastName, SORT_ASC, $associates);
				$associateList = array();
				foreach ($associates as $associate) {
					$associateList[$associate['Comp'] . '-' . $associate['Emp No']] = $associate;
				}

				// Get distinct department codes.
				$codes = array();
				foreach ($associates as $associate) {
					$codes[] = $associate['Home Loc'];
				}
				$codes = array_values(array_unique($codes));

				// Get default department managers.
				$associateManagers = array();
				foreach ($codes as $code) {
					$manager = get_model('department')->getManagerFromCode($code);
					if (count($manager) > 0) {
						$associateManagers[$code] = array_pop($manager);
					}
				}

				// Get departments.
				$departments = array();
				foreach ($codes as $code) {
					$departments[$code] = get_model('department')->getOne($code, 'code');
				}

				// Get all users who might need to be managers.
				$userlist = get_model('user')->getAllUsers();
				$users = array();
				foreach ($userlist as $id => $user) {
					$testUser = get_model('user');
					$testUser->loadUser($id);
					if ($testUser->role_level >= DEPARTMENT_MANAGER) {
						$users[$id] = $user;
					}
				}

				$managerList = array();
				if (array_key_exists('associateManagers', $setup)) {
					$managerList = $setup['associateManagers'];
				}

				// Build form preloader.
				$matches = array();
				foreach ($associates as $associate) {
					if (array_key_exists($associate['Home Loc'], $associateManagers)) {
						$matches[$associate['Comp'] . '-' . $associate['Emp No']] = $associateManagers[$associate['Home Loc']]->id;
						foreach ($managerList as $uid => $manager) {
							foreach ($manager as $aid) {
								if ($aid == $associate['Comp'] . '-' . $associate['Emp No']) {
									$matches[$associate['Comp'] . '-' . $associate['Emp No']] = $uid;
								}
							}
						}
					}
				}

				$form = $this->build_form_3('edit', $matches, $associateList, $users, $departments);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$managerList = $form->valid();
					$setup = json_decode($preload['setup'], true);
					$setup['associateManagers'] = array();
					foreach ($managerList as $aid => $mid) {
						if (false !== strpos($aid, '-')) {
							if (!array_key_exists($mid, $setup['associateManagers'])) {
								$setup['associateManagers'][$mid] = array();
							}
							$setup['associateManagers'][$mid][] = $aid;
						}
					}
					$setup = json_encode($setup);
					$preload['setup'] = $setup;

					$model->setAll($preload);
					$model->id = $preload['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->save();
					$propertyModel = get_model('property');
					$propertyModel->addReviewcycle(session('property'), $model->id);

					locate(URL.$this->G->url->parentUrl().'/4');
				}
				break; */
			case 2:
				$userList = get_model('user')->getAllUsers();

				$managers = array();
				foreach ($userList as $uid => $user) {
					if ($user['role_level'] >= DEPARTMENT_MANAGER) {
						$managers[$uid] = $user;
					}
				}

				$managerList = array();
				if (array_key_exists('managers', $setup)) {
					//$managerList = $setup['managers'];
				}

				$matches = array();
				foreach ($userList as $uid => $user) {
					$matches[$uid] = '';
				}
				if (count($managerList) > 0) {
					foreach ($managerList as $mid => $users) {
						foreach ($users as $uid) {
							$matches[$uid] = $mid;
						}
					}
				} else {
					// Pick reasonable default managers.
					foreach ($userList as $uid => $user) {
						$tempUser = get_model('user');
						$tempUser->loadUser($uid);
						if(isset($tempUser->supervisor) && $tempUser->supervisor) {
							$matches[$uid] = $tempUser->supervisor;
						} else {
							$matches[$uid] = $tempUser->getManager($uid);
						}
						//$matches[$uid] = $tempUser->getManager($uid);
					}
				}

				foreach ($userList as $xId => $xUser) {
					$manager = get_model('user')->getManager($xId);
					if (null != $manager) {
						$peers[$manager . '-' . $xId] = 1;
					}
				}

				$form = $this->build_form_4('edit', $matches, $userList, $managers);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$managerList = $form->valid();
					$setup = json_decode($preload['setup'], true);
					$setup['managers'] = array();
					foreach ($managerList as $aid => $mid) {
						if ('User' == $this->G->ids->type($aid)) {
							if (!array_key_exists($mid, $setup['managers'])) {
								$setup['managers'][$mid] = array();
							}
							$setup['managers'][$mid][] = $aid;
						}
					}
					$setup = json_encode($setup);
					$preload['setup'] = $setup;

					$model->setAll($preload);
					$model->id = $preload['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->save();
					$propertyModel = get_model('property');
					$propertyModel->addReviewcycle(session('property'), $model->id);

					locate(URL.$this->G->url->parentUrl().'/3');
				}
				break;
			/* case 3:
				$userlist = get_model('user')->getAllUsers();
				$users = array();
				foreach ($userlist as $id => $user) {
					$users[$id] = get_model('user');
					$users[$id]->loadUser($id);
				}

				$peerList = array();
				if (array_key_exists('peers', $setup)) {
					$peerList = $setup['peers'];
				}
				$peers = array();
				foreach ($peerList as $xId => $yIdList) {
					foreach ($yIdList as $yId) {
						$peers[$xId . '-' . $yId] = 1;
					}
				}

				if (count($peers) == 0) {
					//
					 // Rules: by default, select all from Property. If that is more than 5 other users, only select from the
					 // same Division. If that is still more than 5 other users, only select from the same Department.
					//
					// Check the Property first.
					if (count($users) <= 6) {
						// We're good! Select 'em all!
						foreach ($users as $xId => $xUser) {
							foreach ($users as $yId => $yUser) {
								if ($xId != $yId && $xUser->acl->role['level'] == $yUser->acl->role['level']) {
									$peers[$xId . '-' . $yId] = 1;
								}
							}
						}
					} else {
						// Too many Property users, let's check each Division.
						$divisions = get_model('property')->getDivisions();
						foreach ($divisions as $dId => $division) {
							$divisionLoad = array();
							foreach ($users as $xId => $xUser) {
								foreach ($users as $yId => $yUser) {
									if ($xId != $yId && $xUser->acl->role['level'] == $yUser->acl->role['level'] && $xUser->division == $yUser->division && (null == $xUser->division || array_key_exists($dId, $xUser->division))) {
										$divisionLoad[$xId . '-' . $yId] = 1;
									}
								}
							}
							if (count($divisionLoad) <= 5) {
								// We're good! Merge into $preload.
								$peers = array_merge($preload, $divisionLoad);
							} else {
								// Too many Division users, let's select each Department instead.
								$departments = get_model('division')->getDepartments($dId);
								foreach ($departments as $eId => $department) {
									foreach ($users as $xId => $xUser) {
										foreach ($users as $yId => $yUser) {
											if ($xId != $yId && $xUser->acl->role['level'] == $yUser->acl->role['level'] && $xUser->division == $yUser->division && (null == $xUser->division || array_key_exists($dId, $xUser->division)) && $xUser->department == $yUser->department && (null == $xUser->department || array_key_exists($eId, $xUser->department))) {
												$peers[$xId . '-' . $yId] = 1;
											}
										}
									}
								}
							}
						}
					}
				}

				$form = $this->build_form_5('edit', $peers, $users);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
					tpl_set('users', $users);
					$emails = array();
					if (array_key_exists('emailPeers', $setup)) {
						$emails = $setup['emailPeers'];
					}
					tpl_set('emails', $emails);
				} else {
					$peerReviewers = $form->valid();
					$setup = json_decode($preload['setup'], true);
					$setup['peers'] = array();
					foreach ($peerReviewers as $peerId => $enabled) {
						if ($enabled == 1) {
							$peers = explode('-', $peerId);
							if (count($peers) == 2) {
								if (!array_key_exists($peers[0], $setup['peers'])) {
									$setup['peers'][$peers[0]] = array();
								}
								$setup['peers'][$peers[0]][] = $peers[1];
							}
						}
					}
					$setup['emailPeers'] = array();
					foreach ($peerReviewers as $peerId => $addresses) {
						if ($addresses != '') {
							$user = explode('-', $peerId);
							if (count($user) == 2) {
								if ($user[1] == 'emails') {
									$addresses = explode(',', $addresses);
									for ($i = 0, $c = count($addresses); $i < $c; $i++) {
										$addresses[$i] = trim($addresses[$i]);
									}
									$setup['emailPeers'][$user[0]] = $addresses;
								}
							}
						}
					}
					$setup = json_encode($setup);
					$preload['setup'] = $setup;
					$model->setAll($preload);
					$model->id = $preload['id'];
					$model->status = 1;
					$model->cid = $this->G->user->id;
					$model->save();
					$propertyModel = get_model('property');
					$propertyModel->addReviewcycle(session('property'), $model->id);
					locate(URL.$this->G->url->parentUrl().'/6');
				}
				break; */
			case 3:
				$form = $this->build_form_6('edit', $preload);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$forSure = $form->valid();
					if (!array_key_exists('forsure', $forSure)) {
						flash('You must acknowledge your understanding of the Cycle launch.');
						locate($this->G->url->getUrl());
					}
					locate(URL.$this->G->url->parentUrl().'/4');
				}
				break;
			case 4:
				$form = $this->build_form_7('edit', $preload);
				if (FALSE === $form->valid()) {
					tpl_set('form', $form);
				} else {
					$forSure = $form->valid();
					if (!array_key_exists('forsupersure', $forSure)) {
						flash('You must acknowledge your understanding of the Cycle launch.');
						locate($this->G->url->getUrl());
					}
					locate(URL.$this->G->url->parentUrl().'/5');
				}
				break;
			case 5:
				if (true === $this->G->url->ajax) {
					// AJAX call! Launch the review!
					if ($this->launchReview($reviewId)) {
						flash('The Leadership Review has been launched!', 'success');
						locate(URL.$this->G->url->parentUrl(3));
					} else {
						tpl_set('content', '<hr><p>Launch FAILED!</p>');
					}
				} else {
					tpl_set('content', '<div id="rcLaunchLog"></div>');
				}
		}
		parent::display();
	}

	public function config_delete($params = NULL) {
		$this->route['view'] = $this->route['view'].'_edit';
		$this->permission[] = 'deleteCompetency';
	}

	public function call_delete($params) {
		$model = get_model('reviewcycle');
		if (isset($params[0]) && $params[0] != '') {
			$model->setAll($model->getOne($params[0], 'id'));
			$model->id = $params[0];
			$model->status = 0;
			$model->save();
			
			/* $sql = "DELETE FROM `#__reviewcycle_answers` WHERE reviewcycle_id = '" . $params[0] . "'";
			$model->execute($sql);
		 */
			flash(_('The Leadership Review has been deleted.'), 'success');
			
			
			locate('/'.$this->G->url->parentUrl(2));
		} else {
			locate('/'.$this->G->url->parentUrl());
		}
		parent::display();
	}
		
	
	private function launchReview($id) {
		$this->ajaxPrep();

		// Load the Review Cycle.
		$this->write('<h3>Loading Review Settings</h3>');
		$reviewModel = get_model('reviewcycle');
		$review = $reviewModel->getOne($id, 'id');
		$this->write("{$review['name']}<br>");
		$this->write(parse($review['description']));
		$review['setup'] = json_decode($review['setup'], true);
		$meForms = array();
		$aeForms = array();
		$peerAssignments = array();
		$peerEmailAssignments = array();
		$managerAssignments = array();
		$associateManagers = array();
		if (array_key_exists('ae', $review['setup'])) {
			$aeForms = $review['setup']['ae'];
		}
		if (array_key_exists('me', $review['setup'])) {
			$meForms = $review['setup']['me'];
		}
		/* if (array_key_exists('peers', $review['setup'])) {
			$peerAssignments = $review['setup']['peers'];
		}
		if (array_key_exists('emailPeers', $review['setup'])) {
			$peerEmailAssignments = $review['setup']['emailPeers'];
		} */
		if (array_key_exists('managers', $review['setup'])) {
			$managerAssignments = $review['setup']['managers'];
		}
		if (array_key_exists('associateManagers', $review['setup'])) {
			$associateManagers = $review['setup']['associateManagers'];
		}

		// Load all users.
		$this->write('<h3>Loading Users</h3>');
		$userlist = get_model('user')->getValidUsers();

		// Sort by role level then last name.
		foreach ($userlist as $key => $row) {
			$roleLevel[$key]  = $row['role_level'];
			$lastName[$key] = $row['lastname'];
		}
		array_multisort($roleLevel, SORT_DESC, $lastName, SORT_ASC, $userlist);

		$users = array();
		foreach ($userlist as $uId => $user) {
			$users[$uId] = get_model('user');
			$users[$uId]->loadUser($uId);
			//$this->write("{$users[$uId]->firstname} {$users[$uId]->lastname} - {$users[$uId]->acl->role['name']}<br>");
		}

		// Load all used compiled forms.
		$this->write('<h3>Loading Compiled Forms</h3>');
		$usedForms = array();
		$usedFormList = array();
		foreach ($meForms as $forms) {
			$usedFormList = array_merge($usedFormList, array_keys($forms));
		}
		foreach ($aeForms as $forms) {
			$usedFormList = array_merge($usedFormList, array_keys($forms));
		}
		$usedFormList = array_values(array_unique($usedFormList));
		foreach ($usedFormList as $formId) {
			$usedForms[$formId] = get_model('compiledform')->getOne($formId, 'id');
			//$this->write("{$usedForms[$formId]['name']}<br>");
		}

		// Load all used subevaluations.
		$this->write('<h3>Loading Sub-Evaluations</h3>');
		$usedSubs = array();
		$usedSubList = array();
		foreach ($usedForms as $formId => $form) {
			$usedSubs[$formId] = get_model('compiledform')->subevaluations($formId);
			$usedSubList = array_merge($usedSubList, array_keys($usedSubs[$formId]));
		}
		$usedSubList = array_values(array_unique($usedSubList));
		foreach ($usedSubList as $subId) {
			$sub = get_model('subevaluation')->getOne($subId, 'id');
			//$this->write("{$sub['name']}<br>");
		}

		// Load all used fields.
		$this->write('<h3>Loading Fields</h3>');
		$usedFields = array();
		$usedFieldList = array();
		foreach ($usedSubList as $subId) {
			$usedFields[$subId] = get_model('subevaluation')->fields($subId, NULL);
			$usedFieldList = array_merge($usedFieldList, array_keys($usedFields[$subId]));
		}
		$usedFieldList = array_values(array_unique($usedFieldList));
		foreach ($usedFieldList as $fieldId) {
			$field = get_model('field')->getOne($fieldId, 'id');
			//$this->write("{$field['name']} (<em>{$field['type']}</em>)<br>");
		}

		/* // Load hourly associates.
		$associates = array();
		if (isset($review['hourlies']) && $review['hourlies'] != '') {
			$csv = array();
			$this->write('<h3>Loading Hourly Employee File</h3>');
			$csv = loadCsv(UPLOAD_PATH . $review['hourlies']);
			$codes = array();
			foreach ($csv as $line) {
				$codes[] = $line['Home Loc'];
			}

			// Check for orphan Department codes.
			$this->write('<h4>Checking for Orphan Department Codes.</h4>');
			$codes = array_values(array_unique($codes));
			$codeCheck = array();
			foreach ($codes as $code) {
				$department = get_model('department')->getOne($code, 'code');
				$codeCheck[] = $department['code'];
				$this->write($department['code'] . '...');
			}
			$diff = array_diff($codes, $codeCheck);
			if (count($diff) > 0) {
				pr('Unknown department code <strong>'. implode(', ', array_values($diff)) .'</strong>', 'FAILED: ');
				die();
			}

			// Verify every department has a manager in the system.
			$this->write('<h4>Verifying Department Managers.</h4>');
			$missing = array();
			foreach ($codes as $code) {
				$manager = get_model('department')->getManagerFromCode($code);
				if (count($manager) == 0) {
					$missing[] = $code;
				} else {
					$manager = array_pop($manager);
					$this->write($code . ' = ' . $manager->username . '<br>');
				}
			}
			if (count($missing) > 0) {
				pr('Could not find managers for the following department codes: '.implode(', ', $missing), 'WARNING: ');
				//die();
			}

			// Save valid associates in a table.
			$this->write('<h4>Storing Valid Associates.</h4>');
			get_model('answer')->createHourliesTable('RC_' . $id);
			foreach ($csv as $associate) {
				if (!in_array($associate['Home Loc'], $missing)) {
					$this->write($associate['Name'] . '<br>', 1);
					$associateModel = get_model('associate');
					$associateModel->setTable('#__RC_' . $id . '_associates');
					$associateModel->setAll(array(
						'comp' => $associate['Comp'],
						'emp_no' => $associate['Emp No'],
						'name' => $associate['Name'],
						'home_loc' => $associate['Home Loc'],
						'home_loc_desc' => $associate['Home Loc Desc']
					));
					$associateModel->save(null, true);
					$associates[$associateModel->id] = $associateModel;
				}
			}
		}

		// Save peer emails in a table.
		$peers = array();
		$this->write('<h3>Setting Up Peers</h3>');
		$this->write('<h4>Storing Peer Emails.</h4>');
		get_model('answer')->createEmailsTable('RC_' . $id);
		$usedAddresses = array();
		foreach ($peerEmailAssignments as $uid => $addresses) {
			foreach ($addresses as $address) {
				if ($address != '') {
					if (!in_array($address, $usedAddresses)) {
						$usedAddresses[] = $address;
						$peerModel = get_model('peer');
						$peerModel->setTable('#__RC_' . $id . '_emails');
						$peerModel->setAll(array(
							'token' => $this->G->ids->createId(24, true),
							'email' => $address
						));
						$peerModel->save(null, true);
						if (!array_key_exists($peerModel->id, $peers)) {
							$this->write($peerModel->email . '<br>', 1);
						}
						$peers[$peerModel->id] = $peerModel;
					}
				}
			}
		} */

		// Create the answer array.
		//$this->write('<h3>Reticulating Splines</h3>');
		$this->write('<h3>Management Reviews</h3>');
		$answers = array();
		$usersReverse = array_reverse($users);
		$aCount = 0;
		
		//print_r($meForms);exit;
		foreach ($users as $userForId => $userFor) {
			if (is_array($userFor->division) || is_array($userFor->department)) {
				$membership = array();
				if (is_array($userFor->division)) {
					$membership = $userFor->division;
				}
				if (is_array($userFor->department)) {
					$membership = array_merge($membership, $userFor->department);
				}
				foreach ($meForms as $meId => $forms) {
					$division = 0;
					$department = 0;
					if ($this->G->ids->type($meId) == 'Division') {
						$division = $meId;
					} else {
						$divisionArray = get_model('department')->getDivision($meId);
						if (count($divisionArray) > 0) {
							if (array_key_exists('division_id', $divisionArray)) {
								$division = $divisionArray['division_id'];
							}
						}
						//$department = $meId;
					}
					$userDepartment = get_model('user');
					$userDepartment->loadUser($userForId);
					if (!empty($userDepartment->department)) {
						$d = $userDepartment->department;
						foreach ($d as $i){
							$department = $i['id'];
						}
					}
					if (in_array($meId, array_keys($membership))) {
						foreach ($forms as $fId => $form) {
							if (array_key_exists($fId, $usedSubs)) {
								foreach ($usedSubs[$fId] as $sId => $sub) {
									$self = false;
									$peer = false;
									$manager = false;
									if ($sub['self'] == 1) {
										$self = true;
										//$this->write("{$sub['name']} ($sId) - <strong>SELF</strong><br>");
									}
									if ($sub['peer'] == 1) {
										$peer = true;
										//$this->write("{$sub['name']} ($sId) - <strong>PEER</strong><br>");
									}
									if ($sub['manager'] == 1) {
										$manager = true;
										//$this->write("{$sub['name']} ($sId) - <strong>MANAGER</strong><br>");
									}
									foreach ($usersReverse as $userById => $userBy) {
										$addAnswer = false;
										if ($self && $userById == $userForId) {
											$addAnswer = true;
											$username = $users[$userById]->firstname.' '.$users[$userById]->lastname;
											//$this->write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>SELF</strong> : {$sub['name']} ($sId)<br>", 1);
										} elseif ($peer && array_key_exists($userById, $peerAssignments) && in_array($userForId, $peerAssignments[$userById])) {
											$addAnswer = true;
											$username = $users[$userById]->firstname.' '.$users[$userById]->lastname;
											//$this->write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>PEER</strong> : {$sub['name']} ($sId)<br>", 1);
										} elseif ($peer && array_key_exists($userForId, $peerEmailAssignments)) {
											foreach ($peers as $pid => $peerEmail) {
												if (in_array($peerEmail->email, $peerEmailAssignments[$userForId])) {
													$addAnswer = true;
													$username = $peerEmail->email;
													$userById = $pid;
													//$this->write("{$users[$userForId]->username} &lt;- {$peerEmail->email} : <strong>PEER EMAIL</strong> : {$sub['name']} ($sId)<br>", 1);
												}
											}
										} elseif ($manager && array_key_exists($userById, $managerAssignments) && in_array($userForId, $managerAssignments[$userById])) {
											$addAnswer = true;
											$username = $users[$userById]->firstname.' '.$users[$userById]->lastname;
											//$this->write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>MANAGER</strong> : {$sub['name']} ($sId)<br>", 1);
										}
										if (true === $addAnswer) {
											//foreach ($usedFields[$sId] as $fieldId => $field) {
												$answers[$aCount]['property_id'] = session('property');
												$answers[$aCount]['division_id'] = $division;
												$answers[$aCount]['department_id'] = $department;
												$answers[$aCount]['reviewcycle_id'] = $id;
												$answers[$aCount]['compiledform_id'] = $fId;
												$answers[$aCount]['user_by_id'] = $userById;
												$answers[$aCount]['user_for_id'] = $userForId;
												$answers[$aCount]['username'] = $username;
												//$this->write("<pre>$aCount ".print_r($answers[$aCount], true).'</pre>');
												$aCount++;
											//}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		/* if (count($associates) > 0 && count($associateManagers) > 0) {
			$this->write('<h4>Associate Reviews</h4>');
			foreach ($associates as $assId => $associate) {
				foreach ($aeForms as $aeId => $forms) {
					$division = 0;
					$department = 0;
					if ($this->G->ids->type($aeId) == 'Division') {
						$division = $aeId;
					} else {
						$divisionArray = get_model('department')->getDivision($aeId);
						if (count($divisionArray) > 0) {
							if (array_key_exists('division_id', $divisionArray)) {
								$division = $divisionArray['division_id'];
							}
						}
						$department = $aeId;
					}
					foreach ($forms as $fId => $form) {
						if (array_key_exists($fId, $usedSubs)) {
							foreach ($usedSubs[$fId] as $sId => $sub) {
								foreach ($associateManagers as $manId => $assMatch) {
									if (in_array($associate->comp . '-' . $associate->emp_no, $assMatch)) {
										$this->write("{$associate->name} &lt;- {$users[$manId]->username} : <strong>MANAGER</strong> : {$sub['name']} ($sId)<br>", 1);
										foreach ($usedFields[$sId] as $fieldId => $field) {
											$answers[$aCount]['property_id'] = session('property');
											$answers[$aCount]['division_id'] = $division;
											$answers[$aCount]['department_id'] = $department;
											$answers[$aCount]['reviewcycle_id'] = 'RC_' . $id;
											$answers[$aCount]['compiledform_id'] = $fId;
											$answers[$aCount]['subevalutaion_id'] = $sId;
											$answers[$aCount]['field_id'] = $fieldId;
											$answers[$aCount]['user_by_id'] = $manId;
											$answers[$aCount]['user_for_id'] = $assId;
											$answers[$aCount]['username'] = $users[$manId]->firstname.' '.$users[$manId]->lastname;
											//$this->write('<pre>$aCount '.print_r($answers[$aCount], true).'</pre>');
											$aCount++;
										}
									}
								}
							}
						}
					}
				}
			}
		} */

		// Create the answer and summary tables.
		//$this->write('<h3>Creating Review Cycle Tables</h3>');
		$answerModel = get_model('answer');
		$answerModel->cycleName = 'reviewcycle_answers';
		//$this->write("<p>That was quick :)</p>");

		// Create Answer records.
		$count = count($answers);
		//$this->write("<h3>Creating $count Answer Records</h3>");
		for ($i = 0, $c = count($answers); $i < $c; $i++) {
			$count = $i + 1;
			//$this->write("$count");
			if ($i < ($c - 1)) {
				//$this->write("...");
			}
			//pr($answers[$i]);

			try {
				$answerModel->createRecord(
					$answers[$i]['property_id'],
					$answers[$i]['division_id'],
					$answers[$i]['department_id'],
					$answers[$i]['reviewcycle_id'],
					$answers[$i]['compiledform_id'],
					$answers[$i]['user_for_id'],
					$answers[$i]['user_by_id']
				);
			} catch (\Exception $e) {
				// Seriously ignoring this.
			}
		}

		// Lock all used Forms, Subevaluation and Fields.
		//$this->write('<h3>Updating FSF Records</h3>');
		$this->write('<h3>Locking Leadership Review...</h3> ');
		$review['setup'] = json_encode($review['setup']);
		$review['start'] = time();
		$review['locked'] = 1;
		$reviewModel->setAll($review, true);
		$reviewModel->save();
		$this->write('Locked<br>');

		/* $this->write('Locking Compiled Forms in use...');
		foreach ($usedFormList as $rId) {
			$this->write('. ');
			$formModel = get_model('compiledform');
			$form = $formModel->getOne($rId, 'id');
			$form['locked'] = 1;
			$formModel->setAll($form, true);
			$formModel->save();
		}
		$this->write('Locked<br>');

		$this->write('Locking Subevaluations in use...');
		foreach ($usedSubList as $sId) {
			$this->write('. ');
			$formModel = get_model('subevaluation');
			$form = $formModel->getOne($sId, 'id');
			$form['locked'] = 1;
			$formModel->setAll($form, true);
			$formModel->save();
		}
		$this->write('Locked<br>');

		$this->write('Locking Fields in use...');
		foreach ($usedFieldList as $fId) {
			$this->write('. ');
			$fieldModel = get_model('field');
			$field = $fieldModel->getOne($fId, 'id');
			$field['locked'] = 1;
			$fieldModel->setAll($field, true);
			$fieldModel->save();
		}
		$this->write('Locked<br>'); */

		// Email peer reviewers that do not have logins.
		/* $this->write('<h3>Emailing Peer Reviewers</h3>');
		$emailAddresses = array();
		foreach ($peerEmailAssignments as $uid => $addresses) {
			foreach ($addresses as $address) {
				if (!array_key_exists($address, $emailAddresses)) {
					$emailAddresses[$address] = array();
				}
				$emailAddresses[$address][$uid] = $users[$uid];
			}
		}
		foreach ($emailAddresses as $address => $peerUsers) {
			$this->write($address . ': ');
			foreach ($peers as $peerId => $peer) {
				if ($peer->email == $address) {
					break;
				}
			}
			$peerUsersHtmlList = '';
			foreach($peerUsers as $puid => $peerUser) {
				$peerUsersHtmlList .= $peerUser->firstname . ' ' . $peerUser->lastname . '<br>';
			}
			$peerLink = HOST . URL . 'performancereviews/peer/' . $peer->token . '?pid=' . session('property') . '&rid=' . $id;
			$subject = 'You have been asked to do a Peer Review';
			$body = <<<EMAILBODY
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Peer Review Request</title>
	</head>
	<body>
		<p>You have been asked to perform a Peer Review on the following people:</p>
		{$peerUsersHtmlList}
		<p>You can fill in reviews by visiting the True North website at<br>
			&nbsp;&nbsp;&nbsp;&nbsp;<a href="$peerLink">$peerLink</a>
		</p>
	</body>
</html>
EMAILBODY;
			$headers = array(
				'MIME-Version: 1.0',
				'Content-type: text/html; charset=utf-8',
				'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
				'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
				'From: ' . mb_encode_mimeheader('True North') . ' <tn@tn2.com>',
				'Reply-To: ' . mb_encode_mimeheader('True North') . ' <tn@tn2.com>',
				'Return-Path: ' . mb_encode_mimeheader('True North') . ' <tn@tn2.com>',
				'X-Mailer: PHP/' . phpversion(),
				'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']
			);
			
			$this->write('<em>mail content:</em>.'.$body.'<br>');
			
			$success = false;
			$success = mail($address, $subject, $body, implode("\r\n", $headers));
			if (true === $success) {
				$this->write('<em>sent</em>.<br>');
			} else {
				$this->write('<em>failed</em>.<br>');
			}
		} */

		return true;
	}

	private function write($text, $indent = 0) {
		$spaces = str_repeat('&nbsp;', $indent * 4);
		echo $spaces . $text . PHP_EOL . str_repeat(' ', 2048);
		flush();
	}

	/**
	 * Prepare for long-poll connection.
	 */
	private function ajaxPrep() {
		header('Content-type: application/octet-stream');

		// Turn off output buffering
		ini_set('output_buffering', 'off');
		// Turn off PHP output compression
		ini_set('zlib.output_compression', false);
		// Implicitly flush the buffer(s)
		ini_set('implicit_flush', true);
		ob_implicit_flush(true);

		// Clear, and turn off output buffering
		while (ob_get_level() > 0) {
			// Get the curent level
			$level = ob_get_level();
			// End the buffering
			ob_end_clean();
			// If the current level has not changed, abort
			if (ob_get_level() == $level) break;
		}

		// Disable apache output buffering/compression
		if (function_exists('apache_setenv')) {
			apache_setenv('no-gzip', '1');
			apache_setenv('dont-vary', '1');
		}
	}

	public function config_getforms($params = NULL) {
		$this->route['view'] = $this->route['view'] . '_new_add_compiled_form';
		$this->permission[] = 'addReviewcycle';
	}

	public function call_getforms($params) {
		$formType = $params[0];
		$model = get_model('compiledform');
		$forms = $model->compiledforms();
		$formList = array();
		$used = $this->G->url->getQuerystringBit('used');
		$used = explode(',', $used);
		$usedForms = array();
		foreach ($used as $usedForm) {
			if ($usedForm != '') {
				$usedForm = explode(':', $usedForm);
				if (isset($usedForm[0])) {
					$usedForms[] = $usedForm[0];
				}
			}
		}
		foreach ($forms as $id => $form) {
			if ($form['evaltype'] == $formType) {
				if (!in_array($id, $usedForms)) {
					$formList[$id] = $form;
				}
			}
		}
		tpl_set('forms', $formList);
		tpl_set('formType', $formType);
		tpl_set('parent', $params[1]);
		parent::display();
	}

	private function build_form_1($type = 'new', $preload = array(), $divisions = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addText(array(
			'required' => true,
			'name' => 'name',
			'class' => 'form-control',
			'label' => _('Cycle Name'),
			'default' => TRUE
		));
		$form->addTextarea(array(
			'required' => true,
			'name' => 'description',
			'class' => 'form-control',
			'label' => _('Cycle Description')
		));
		$form->addDate(array(
			'required' => true,
			'name' => 'due',
			'class' => 'form-control',
			'label' => _('Expected Due Date')
		));
		foreach ($divisions as $id => $division) {
			$form->addHidden(array(
				'name' => 'me-' . $id
			));
			$form->addHidden(array(
				'name' => 'ae-' . $id
			));
			foreach ($division['_departments'] as $did => $department) {
				$form->addHidden(array(
					'name' => 'me-' . $did
				));
				$form->addHidden(array(
					'name' => 'ae-' . $did
				));
			}
		}
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_2($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$hourlies = NULL;
		if (isset($preload['hourlies'])) {
			$hourlies = $preload['hourlies'];
		}
		$form->addHidden(array(
			'name' => 'hourlies-previous',
			'value' => $hourlies
		));
		$form->addFile(array(
			'name' => 'hourlies',
			'class' => '',
			'label' => _('Upload "Hourlies" CSV'),
			'types' => array(
				'csv'
			)
		));
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_3($type = 'new', $preload = array(), $associates = array(), $users = array(), $departments = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$userList = array();
		foreach ($users as $uid => $user) {
			$userList[$uid] = $user['lastname'] . ', ' . $user['firstname'] . ' (' . $user['username'] . ')';
		}
		$lastCode = 0;
		$form->addInstructions(array(
			'name' => 'associate-instructions',
			'value' => "<h2>Select Supervisor for each associate user (Defaults to the assigned Supervisor)</h2>"
		));
		foreach ($associates as $aid => $associate) {
			if (array_key_exists($aid, $preload)) {
				if ($lastCode != $associate['Home Loc']) {
					$lastCode = $associate['Home Loc'];
					$form->addInstructions(array(
						'name' => 'department-name',
						'value' => "<h3>{$departments[$lastCode]['name']} - <em>$lastCode</em></h3>"
					));
				}
				$form->addSelect(array(
					'name' => $aid,
					'class' => 'form-control',
					'label' => $associate['Name'] . ' <span class="empNum">' . $associate['Emp No'] . '</span>',
					'values' => $userList,
					'default' => $preload[$aid]
				));
			}
		}
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_4($type = 'new', $preload = array(), $users = array(), $managers = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$userList = array();
		foreach ($managers as $uid => $user) {
			$userList[$uid] = $user['lastname'] . ', ' . $user['firstname'] . ' (' . $user['username'] . ')';
		}
		$form->addInstructions(array(
			'name' => 'associate-instructions',
			'value' => "<h2>Select Supervisor for each user (Defaults to the assigned Supervisor)</h2>"
		));
		foreach ($users as $aid => $user) {
			if (array_key_exists($aid, $preload)) {
				$form->addSelect(array(
					'name' => $aid,
					'class' => 'form-control',
					'label' => $user['lastname'] . ', ' . $user['firstname'] . ' <span class="username">' . $user['username'] . '</span>',
					'values' => $userList,
					'default' => $preload[$aid]
				));
			}
		}
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_4_OLD($type = 'new', $preload = array(), $users = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addInstructions(array(
			'name' => 'manager-selection',
			'value' => "<h3>Select Managers for \"Manager\" Subevaluations</h3>"
		));

		foreach ($users as $xId => $xUser) {
			foreach ($users as $yId => $yUser) {
				$form->addHidden(array(
					'name' => $xId . '-' . $yId,
					'class' => 'managerSelector'
				));
			}
		}
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_5($type = 'new', $preload = array(), $users = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addInstructions(array(
			'name' => 'peer-selection',
			'value' => "<h3>Select Peers for \"Peer\" Subevaluations</h3>"
		));
		foreach ($users as $xId => $xUser) {
			foreach ($users as $yId => $yUser) {
				$form->addHidden(array(
					'name' => $xId . '-' . $yId,
					'class' => 'peerSelector'
				));
			}
		}
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_6($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addCheckbox(array(
			'name' => 'forsure',
			'value' => 'forsure',
			'class' => 'checkbox',
			'label' => _('I understand that Launching the Leadership Review cannot be undone, and that any and all Compiled Forms and Subevaluations used by this Leadership Review will no longer be editable.')
		));
		$name = 'continue';
		$label = _('Continue');
		if (strtolower($type) == 'edit') {
			$name = 'continue';
			$label = _('Continue');
		}
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}

	private function build_form_7($type = 'new', $preload = array()) {
		$form = new Form($this->G, array(
			'name' => $type.'-reviewcycle',
			'class' => 'form form-reviewcycle',
			'header' => array(
				'text' => sprintf(_('%1$s Leadership Review'), ucfirst($type)),
				'class' => 'form-reviewcycle-heading'
			)
		), $preload);
		$form->addHidden(array(
			'name' => 'id'
		));
		$form->addCheckbox(array(
			'name' => 'forsupersure',
			'value' => 'forsupersure',
			'class' => 'checkbox',
			'label' => _('I am absolutely sure that this Leadership Review should be started right now.')
		));
		$name = 'launch';
		$label = _('Launch Leadership Review');
		$form->addSubmit(array(
			'name' => $name,
			'class' => 'btn-lg btn-primary btn-block',
			'label' => $label
		));
		return $form;
	}
}
