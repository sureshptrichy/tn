<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Password Reset controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Passwordreset extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Reset Password'),
			'view' => 'passwordreset'
		);
		$this->permission = array(
			'viewLogin'
		);
		$this->pageTitle = $this->route['name'];
		$this->showPageNav = FALSE;
		return parent::config($method);
	}

	/**
	 * The default method.
	 */
	public function call_index($url) {
		$form = $this->build_reset_form();
		if (false === $form->valid()) {
			tpl_set('form', $form);
			parent::display();
		} else {
			$formValues = $form->valid();
			$user = get_model('user');
			$info = $user->getOne($formValues['username'], 'username');

			if (count($info) == 0) {
				flash('Could not find that email address. Please try again.', 'danger');
				locate($this->G->url->getUrl());
			}
			else {
				$info['passwordreset'] = $this->G->ids->createId(32);
				$user->setAll($info);
				$user->id = $info['id'];
				$user->save();

				$link = HOST . URL . 'passwordreset/reset/' . $info['passwordreset'];
				$subject = 'Your password reset link for True North';
				$body = <<<EMAILBODY
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Password Reset Link</title>
	</head>
	<body>
		<p>A password reset was requested for your account on the True North site.</p>
		<p>Please click the following link in order to reset your password. If the link doesn't work, please copy and paste the URL into a browser.</p>
		<p><strong><a href="{$link}">{$link}</a></strong></p>
		<p>If you believe this email has been sent in error, please ignore it - no further action is necessary</p>
	</body>
</html>
EMAILBODY;
				$headers = array(
					'MIME-Version: 1.0',
					'Content-type: text/html; charset=utf-8',
					'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
					'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
					'From: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
					'Reply-To: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
					'Return-Path: ' . mb_encode_mimeheader('True North') . ' <no-reply@nvtruenorth.com>',
					'X-Mailer: PHP/' . phpversion(),
					'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']
				);
				$success = false;
				$success = mail($info['username'], $subject, $body, implode("\r\n", $headers));
				//mail('nick@globi.ca','Test','This is a test', implode("\r\n", $headers));
				if (true === $success) {
					flash('An email has been sent to you. Please click the link provided to reset your password.', 'success');
				} else {
					flash('We had a problem sending the email. Please try again, or contact your administrator for support.', 'danger');
				}
				locate($this->G->url->getUrl());				
			}

		}
	}

	public function call_reset($url) {
		if (count($url) == 0) {
			flash('Invalid reset token. Please check the link in your email and try again.', 'danger');
			locate(URL);
		}
		$token = $url[0];
		if ($token != '' && null !== $token) {
			$valid = get_model('user')->getOne($token, 'passwordreset');
			if (count($valid) == 0) {
				flash('Invalid reset token. Please check the link in your email and try again.', 'danger');
				locate(URL);
			}
			$form = $this->build_form();
			if (FALSE === $form->valid()) {
				tpl_set('form', $form);
				parent::display();
			} else {
				$formValues = $form->valid();
				if (isset($formValues['pass']) && isset($formValues['pass_confirmation']) && $formValues['pass_confirmation'] != '' && $formValues['pass_confirmation'] == $formValues['pass']) {
					// New password.
					$valid['password'] = $formValues['pass'];
				}
				if (isset($valid['password'])) {
					$valid['password'] = Crypt::hashString($valid['password']);
				}
				$user = get_model('user');
				$user->setAll($valid);
				$user->id = $valid['id'];
				$user->passwordreset = null;
				$user->save();

				flash('Password has successfully been changed.', 'success');
				locate(URL);
			}
		} else {
			flash('Invalid reset token. Please check the link in your email and try again.', 'danger');
			locate(URL);
		}
	}

	private function build_reset_form() {
		$form = new Form($this->G, array(
			'name' => 'passwordreset',
			'class' => 'form-passwordreset',
			'header' => array(
				'text' => _('Reset Your Password'),
				'class' => 'form-passwordreset-heading'
			)
		));
		$form->addEmail(array(
			'name' => 'username',
			'class' => 'form-control',
			'label' => _('Email address'),
			'required' => TRUE,
			'default' => TRUE
		));
		$form->addSubmit(array(
			'name' => 'passwordreset',
			'class' => 'btn-lg btn-primary btn-block',
			'label' => _('Send Reset Email')
		));
		return $form;
	}

	private function build_form() {
		$form = new Form($this->G, array(
			'name' => 'passwordreset',
			'class' => 'form-passwordreset',
			'header' => array(
				'text' => _('Reset Your Password'),
				'class' => 'form-passwordreset-heading'
			)
		));
		$form->addEmail(array(
			'name' => 'username',
			'class' => 'form-control',
			'label' => _('Email address'),
			'required' => TRUE,
			'default' => TRUE
		));
		$form->addPassword(array(
			'name' => 'pass_confirmation',
			'class' => 'form-control',
			'label' => _('New Password'),
			'validation' => array(
				'data-validation' => 'length',
				'data-validation-length' => 'min6',
				'data-validation-optional' => 'true'
			)
		));
		$form->addPassword(array(
			'name' => 'pass',
			'class' => 'form-control',
			'label' => _('Confirm New Password'),
			'validation' => array(
				'data-validation' => 'confirmation',
				'data-validation-length' => 'min6'
			)
		));
		$form->addSubmit(array(
			'name' => 'passwordreset',
			'class' => 'btn-lg btn-primary btn-block',
			'label' => _('Reset')
		));
		return $form;
	}
}
