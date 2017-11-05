<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

$includeAnswerTests = false; // Set to FALSE to not create any actual answers and summaries.

if ($page == 'begin') {
	switch ($step) {
		case 0:
			echo $content;
			break;
		case 1:
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

			// Load all forms.
			write("<h3>Loading Compiled Forms.</h3>");
			$formList = getForms();

			// Load all Users.
			write("<h3>Loading Users.</h3>");
			$users = getAllUsers();

			// Prepare Answers.
			write("<h3>Preparing Answers.</h3>");
			$answers = getAnswers();

			// Create Answer Table.
			write("<h3>Creating Answer Tables.</h3>");
			$answerModel = get_model('answer');
			$answerModel->createTable(get_model('reviewcycle')->current());
			write("<p>That was quick :)</p>");

			// Create Answer records.
			$count = count($answers);
			write("<h3>Creating $count Answer Records.</h3>");
			for ($i = 0, $c = count($answers); $i < $c; $i++) {
				$count = $i + 1;
				write("$count...");
				$answerModel->createRecord(
					$answers[$i]['property_id'],
					$answers[$i]['division_id'],
					$answers[$i]['department_id'],
					$answers[$i]['reviewcycle_id'],
					$answers[$i]['compiledform_id'],
					$answers[$i]['subevalutaion_id'],
					$answers[$i]['field_id'],
					$answers[$i]['user_for_id'],
					$answers[$i]['user_by_id']
				);
			}

			// Test a little!
			write("<h3>Verifying</h3>");
			write("<h4>Forms <em>YOU</em> need to fill in:</h4>");
			$currentForms = get_model('reviewcycle')->currentForms();
			foreach ($currentForms as $form) {
				write("<strong>{$formList['me'][$form['compiledform_id']]['name']}</strong> ({$form['compiledform_id']}) for {$users[$form['user_for_id']]->username}<br>", 1);
			}
			write("<h4>Forms to be completed by others for you:</h4>");
			$currentForms = get_model('reviewcycle')->currentUserForms();
			foreach ($currentForms as $form) {
				write("<strong>{$formList['me'][$form['compiledform_id']]['name']}</strong> ({$form['compiledform_id']}) by {$users[$form['user_by_id']]->username}<br>", 1);
			}

			if (true === $includeAnswerTests) {
				write("<h3>Answer Tests</h3>");
				$fieldModel = get_model('field');
				shuffle($answers);
				write("<h4>100 random answers being added.</h4>");
				for ($i = 0; $i < 100; $i++) {
					$field = $fieldModel->getOne($answers[$i]['field_id'], 'id');
					write($field['type'] . '...');
					if ($field['type'] == 'rating') {
						$answer = mt_rand(1, 5);
					} else {
						$answer = 'This is a test answer. It is *parsed* so it looks good.';
					}
					$answerModel->addAnswer(
						$answers[$i]['property_id'],
						$answers[$i]['division_id'],
						$answers[$i]['department_id'],
						$answers[$i]['reviewcycle_id'],
						$answers[$i]['compiledform_id'],
						$answers[$i]['subevalutaion_id'],
						$answers[$i]['field_id'],
						$answers[$i]['user_for_id'],
						$answers[$i]['user_by_id'],
						$answer
					);
				}
				$limit = 10;
				if ($limit > count($answers) / 100) {
					$limit = (int)count($answers) / 100;
				}
				write("<h4>$limit random answers being added in <strong>YOUR</strong> name.</h4>");
				shuffle($answers);
				for ($i = 0, $c = count($answers); $i < $c; $i++) {
					if ($answers[$i]['user_for_id'] == session('user')) {
						$limit--;
						$field = $fieldModel->getOne($answers[$i]['field_id'], 'id');
						write($field['type'] . '...');
						if ($field['type'] == 'rating') {
							$answer = mt_rand(1, 5);
						} else {
							$answer = 'This is a test answer for **you**. It is *parsed* so it looks good.';
						}
						$answerModel->addAnswer(
							$answers[$i]['property_id'],
							$answers[$i]['division_id'],
							$answers[$i]['department_id'],
							$answers[$i]['reviewcycle_id'],
							$answers[$i]['compiledform_id'],
							$answers[$i]['subevalutaion_id'],
							$answers[$i]['field_id'],
							$answers[$i]['user_for_id'],
							$answers[$i]['user_by_id'],
							$answer
						);
						if ($limit < 1) {
							break;
						}
					}
				}
			}

			break;
	}
} else {
	?><a href="<?php echo $currentUrl; ?>begin">Start (or Reset) the Cycle 2013 Test.</a><?php
}

function write($text, $indent = 0) {
	$spaces = str_repeat('&nbsp;', $indent * 4);
	echo $spaces . $text . PHP_EOL . str_repeat(' ', 2048);
	flush();
}

function array_rand_assoc($array, $limit = 1) {
	$keys = array_keys($array);
	shuffle($keys);
	$return = array();
	for ($i = 0; $i < $limit; $i++) {
		$return[$keys[$i]] = $array[$keys[$i]];
	}
	return $return;
}

function shuffle_assoc(&$array) {
	$keys = array_keys($array);
	shuffle($keys);
	foreach($keys as $key) {
		$new[$key] = $array[$key];
	}
	$array = $new;
	return true;
}

function getForms() {
	$formModel = get_model('compiledform');
	$forms = $formModel->compiledforms();
	$formList = array();
	foreach ($forms as $id => $form) {
		if (!array_key_exists($form['evaltype'], $formList)) {
			$formList[$form['evaltype']] = array();
		}
		$formList[$form['evaltype']][$id] = $form;
		write("{$form['evaltype']} - {$form['name']}<br>", 1);
	}
	return $formList;
}

function getAllUsers() {
	$userlist = get_model('user')->getValidUsers();
	$users = array();
	foreach ($userlist as $id => $user) {
		$users[$id] = get_model('user');
		$users[$id]->loadUser($id);
		write("{$users[$id]->username} - {$users[$id]->acl->role['name']} ({$users[$id]->acl->role['level']})<br>");
	}
	return $users;
}

function getAnswers() {
	$formList = getForms();
	$users = getAllUsers();

	$formModel = get_model('compiledform');
	$answers = array();
	$aCount = 0;
	foreach ($users as $userForId => $user) {
		$division = $users[$userForId]->getDivisions();
		if (count($division) != 1) {
			$division = 0;
		} else {
			$division = $division[0]['id'];
		}
		$department = $users[$userForId]->getDepartments();
		if (count($department) != 1) {
			$department = 0;
		} else {
			$department = $department[0]['id'];
		}
		shuffle_assoc($formList['me']);
		$currentFormList = reset($formList['me']);
		$currentFormList = array($currentFormList['id'] => $currentFormList);
		foreach ($currentFormList as $compiledformId => $form) {
			$subevaluations = $formModel->allsubevaluations('me', $compiledformId);
			shuffle_assoc($subevaluations);
			foreach ($subevaluations as $subevaluationId => $subevaluation) {
				$self = false;
				$peer = false;
				$manager = false;
				$managerFound = false;
				if ($subevaluation['self'] == 1) {
					$self = true;
					write("{$subevaluation['name']} ($subevaluationId) - <strong>SELF</strong><br>");
				}
				if ($subevaluation['peer'] == 1) {
					$peer = true;
					write("{$subevaluation['name']} ($subevaluationId) - <strong>PEER</strong><br>");
				}
				if ($subevaluation['manager'] == 1) {
					$manager = true;
					write("{$subevaluation['name']} ($subevaluationId) - <strong>MANAGER</strong><br>");
				}
				$usersReverse = array_reverse($users);
				foreach ($usersReverse as $userById => $user) {
					$addAnswer = false;
					if ($self && $userById == $userForId) {
						$addAnswer = true;
						write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>SELF</strong> : {$subevaluation['name']} ($subevaluationId)<br>", 1);
					} elseif ($peer && $users[$userById]->acl->role['level'] == $users[$userForId]->acl->role['level']) {
						$addAnswer = true;
						write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>PEER</strong> : {$subevaluation['name']} ($subevaluationId)<br>", 1);
					} elseif ($manager && !$managerFound && $users[$userById]->acl->role['level'] > $users[$userForId]->acl->role['level']) {
						$addAnswer = true;
						write("{$users[$userForId]->username} &lt;- {$users[$userById]->username} : <strong>MANAGER</strong> : {$subevaluation['name']} ($subevaluationId)<br>", 1);
						$managerFound = true;
					}
					if (true === $addAnswer) {
						$fields = get_model('subevaluation')->fields($subevaluationId);
						foreach ($fields as $fieldId => $field) {
							$answers[$aCount]['property_id'] = session('property');
							$answers[$aCount]['division_id'] = $division;
							$answers[$aCount]['department_id'] = $department;
							$answers[$aCount]['reviewcycle_id'] = 'RC20131e1yZzeS4oNqLvDr';
							$answers[$aCount]['compiledform_id'] = $compiledformId;
							$answers[$aCount]['subevalutaion_id'] = $subevaluationId;
							$answers[$aCount]['field_id'] = $fieldId;
							$answers[$aCount]['user_by_id'] = $userById;
							$answers[$aCount]['user_for_id'] = $userForId;
							//write('<pre>$aCount '.print_r($answers[$aCount], true).'</pre>');
							$aCount++;
						}
					}
				}
			}
		}
	}
	return $answers;
}
