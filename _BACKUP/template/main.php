<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?= $templateVars['siteTitle']; ?> - <?= $templateVars['pageTitle']; ?></title>
	<link rel="stylesheet" href="/template/main.css" type="text/css" media="screen, projection" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="/template/main.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo"><img src="/images/logos/<?= $templateVars['siteLogo']; ?>"></div>
		<div id="tabs">
			<h1 id="title">True North</h1>
			<? if(userIsLoggedIn()): ?>
			<a href="/dashboard">Dashboard</a>
			<a href="/strategiesandtactics">Strategies & Tactics</a>
			<a href="/calendar">Calendar</a>
			<a href="/annualstrategicplan">Annual Strategic Plan</a>
			<a href="/performancereviews">Performance Reviews</a>
			<a href="/templates">Templates</a>
			<a href="/settings">Settings</a>
			<? endif; ?>
		</div>
	</div>
	<div id="middle">
		<div id="container">
			<div id="content">
				<? include(APPLICATION_ROOT.'/view/'.$pageViewTemplate.'.php'); ?>
			</div>
		</div>
		<div id="sidebar">
			<? if(userIsLoggedIn()): ?>
			<? include(APPLICATION_ROOT.'/template/sidebar/'.$sidebarTemplate.'.php'); ?>
			<p>Logged in as: <?= $templateVars['loggedInUser']['firstname']; ?> <?= $templateVars['loggedInUser']['lastname']; ?><br>
			<a href="/logout">Logout</a></p>
			<? else: ?>
			<h3>Welcome to TRUENORTH</h3>
			<? endif; ?>
		</div>
	</div>
</div>
</body>
</html>