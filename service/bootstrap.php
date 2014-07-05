#!/usr/bin/php
<?php
if(defined('STDIN') ){
	echo("Running from CLI".PHP_EOL);
}else{
	echo("Can Not Running This File Directly".PHP_EOL);
	exit(0);
}
/***** DOCS

Run parameters :
php -c php.ini commandline_bootstrap.php parameter1 parameter2

******/

require __DIR__.'/config.php';
require LIBRARY_DIR.'environment.php';
require LIBRARY_DIR.'controller.php';

$env = new Environment();

require LIBRARY_DIR.'log.php';
$log = new Log("error_log.txt");
set_error_handler(array($log,'error_handler'));
$env->set("log", $log);

require LIBRARY_DIR.'db.php';
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$env->set("db", $db);

require LIBRARY_DIR.'route.php';
$route = new Route( $env );
$result = $route->prepare( $argv );


exit($result);