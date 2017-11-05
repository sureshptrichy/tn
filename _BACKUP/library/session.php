<?php

function sessionVarExists($var) {
	
	if(isset($_SESSION[$var])) return true;
	else return false;
}

function sessionSetVar($var, $value) {

	$_SESSION[$var] = $value;
}

function sessionGetVar($var) {

	if(isset($_SESSION[$var])) return $_SESSION[$var];
	else return false;
}

function sessionRemoveVar($var) {
	
	unset($_SESSION[$var]);
}
