<?php

function utilityLoadLibrary($library) {

	if(file_exists(APPLICATION_ROOT.'/library/'.$library.'.php')) {
		require_once(APPLICATION_ROOT.'/library/'.$library.'.php');
	}
}


function utilityLoadModel($model) {

	if(file_exists(APPLICATION_ROOT.'/model/'.$model.'.php')) {
		require_once(APPLICATION_ROOT.'/model/'.$model.'.php');
	}
}