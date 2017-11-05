<?php
if (php_sapi_name() != "cli") {
	die("This script is not accessible via HTTP...");
}

	// server name
	$server="crius.commerx.com";
	// optional port
	$port=22;
	// username
	$username="root";
	// password
	$password="";
	// remote home path
	$home_path="/var/www/truenorth/beta.nvtruenorth.com";
	// local/svn repository
	$repository_path="git@git.commerx.com:globi/truenorth.git";

	// max releases
	$max_releases=10;
	$release_path = "{$home_path}/releases/" . date('YmdHis', time());
	
	
	$commands = array();
	
	$commands[] = "echo initializing environment";
	
	// initializing folder structure
	$commands[] = "mkdir {$home_path}/releases";
	$commands[] = "mkdir {$home_path}/shared";
	$commands[] = "mkdir {$home_path}/shared/logs";
	
	
	$commands[] = "chmod 775 {$home_path}/shared/logs";
	
	
	$commands[] = "echo deploying to {$release_path}";
	
	// export application
	$commands[] = "git clone --depth 1 {$repository_path} {$release_path}";
	
	// create tmp folders
	$commands[] = "mkdir {$release_path}/logs";
	$commands[] = "mkdir {$release_path}/tmp";
	$commands[] = "chmod 775 {$release_path}/logs";
	$commands[] = "chmod 775 {$release_path}/tmp";
		
	// change ownership
	$commands[] = "chown truenorth:www-data -R {$release_path}";

	// sym link to logs
	$commands[] = "ln -s {$home_path}/shared/logs {$release_path}/logs";

	// sym link to current
	$commands[] = "unlink {$home_path}/current";
	$commands[] = "ln -s {$release_path} {$home_path}/current";
	
	$commands[] = "echo cleaning up old releases";
	$commands[] = "rm `find {$home_path}/releases/*/ -maxdepth 0 | sort -r  | tail -n +".((int)$max_releases+1)."` -R -f";
	
	passthru("ssh {$server} -p {$port} -l {$username} \"".\implode(";", $commands)."\"");
