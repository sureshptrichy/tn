<?php

// Enable session support
session_start();

// Define application root directory
define('PHOENIX_ROOT', __DIR__.'/phoenix');

// Setup class library autoloading
require_once(PHOENIX_ROOT.'/libraries/phoenix/autoload.php');


$request = Libraries\Phoenix\Request::getInstance();

debug::dump($request->getRawRequest(), 'RawRequest');
debug::dump($request->getRequestVars(), 'RequestVars');

$module = new \Phoenix\Module\Content\Module();