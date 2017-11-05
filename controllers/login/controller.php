<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Login controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Login extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Login'),
			'view' => 'login'
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
		$loginForm = $this->build_login_form();
		if (FALSE === $loginForm->valid()) {
			tpl_set('loginForm', $loginForm);
			parent::display();
		} else {
			$userlogin = $loginForm->valid();
			if (!isset($userlogin['rememberme'])) {
				$userlogin['rememberme'] = NULL;
			}
			if (isset($userlogin['username']) && isset($userlogin['password']) && $this->G->user->login($userlogin['username'], $userlogin['password'], $userlogin['rememberme'])) {
				locate($userlogin['rf']);
			} else {
				tpl_set('loginForm', $loginForm);
				flash(_('Sorry, we could not sign you in with those credentials. Please try again.'), 'danger');
				parent::display();
			}
		}
	}

	private function build_login_form() {
		$form = new Form($this->G, array(
			'name' => 'login',
			'class' => 'form-signin',
			'header' => array(
				'text' => _('Please Sign In'),
				'class' => 'form-signin-heading'
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
			'name' => 'password',
			'class' => 'form-control',
			'label' => _('Password'),
			'required' => TRUE,
			'validation' => array(
				'data-validation' => 'length',
				'data-validation-length' => 'min5'
			)
		));
		$form->addCheckbox(array(
			'name' => 'rememberme',
			'value' => 'remember-me',
			'class' => 'checkbox',
			'label' => _('Remember me &nbsp;<span style="font-weight: normal">(<i>Do not select “remember me” if this is a shared computer.</i>)</span>')
		));
		$form->addSubmit(array(
			'name' => 'signin',
			'class' => 'btn-lg btn-primary btn-block',
			'label' => _('Sign in')
		));
		$form->addHidden(array(
			'name' => 'rf'
		));
		return $form;
	}
}
