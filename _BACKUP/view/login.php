<h1>Log In</h1>
<form name"loginform" action="/login" method="post">
	<?= isset($loginFormError) ? $loginFormError : '' ?>
	<p>Email Address: <input type="text" name="email" autofocus<?= isset($loginFormEmail) ? ' value="'.$loginFormEmail.'"' : '' ?>><?= isset($loginFormEmailError) ? $loginFormEmailError : '' ?></p>
	<p>Password: <input type="password" name="password"<?= isset($loginFormPassword) ? ' value="'.$loginFormPassword.'"' : '' ?>><?= isset($loginFormPasswordError) ? $loginFormPasswordError : '' ?></p>
	<input type="submit" value="Login">
	<input type="hidden" name="loginForm">
</form>