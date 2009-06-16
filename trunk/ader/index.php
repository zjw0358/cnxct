<?php
/*
	$Date$
	$Author$
	$Id: index.php 18 2009-06-16 03:16:13Z cfc4nPHP $
*/
define('THINK_PATH','./ThinkPHP');

define('APP_NAME','myApp');
define('APP_PATH','.');

require(THINK_PATH.'/ThinkPHP.php');

$app = new App();
$app->run();
?>