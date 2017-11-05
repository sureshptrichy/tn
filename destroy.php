<?php
// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
	$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	foreach($cookies as $cookie) {
		$parts = explode('=', $cookie);
		$name = trim($parts[0]);
		setcookie($name, '', time()-1000);
		setcookie($name, '', time()-1000, '/');
	}
}
unset($_SESSION['property']);
unset($_SESSION['division']);
unset($_SESSION['department']);
unset($_SESSION['user']);
unset($_SESSION['user_filter']);
session_destroy();
?>
<p>Session and domain cookies destroyed, please try <a href="/">logging in again.</a></p>
