<?php


// Extract request variables from raw request
function requestGetAllVars() {

	$rawRequest = requestGetRawRequest();
	$requestVars = explode('/', $rawRequest);
	return $requestVars;
}


// Extract raw request from uri
function requestGetRawRequest() {

	$rawRequestParts = explode('?', $_SERVER['REQUEST_URI']);
	$rawRequest = trim($rawRequestParts[0], '/');
	return $rawRequest;
}


// Get next var from request stack
function requestGetNextVar() {
	
	global $requestStack;
	$requestVar = array_shift($requestStack);
	return $requestVar;
}


// Get request paramter
function requestGetParameter($index) {

	global $requestStack;
	$key = $index - 1;
	if(array_key_exists($key, $requestStack)) return $requestStack[$key];
	else return false;
}


// Request stack
$requestStack = requestGetAllVars();
