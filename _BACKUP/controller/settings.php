<?php

$requestedSettingsController = requestGetNextVar();
if($requestedSettingsController === null) $pageController .= '/menu';
else $pageController .= '/' . $requestedSettingsController;
if(securityControllerCheck($pageController, 'settings') == true) {
	include('controller/'.$pageController.'.php');
} 
