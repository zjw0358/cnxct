<?php
/*
	Date:2009-6-4
	add
	$Id: .index.php   cfc4n $
*/
define('THINK_PATH','./ThinkPHP');

define('APP_NAME','myApp');
define('APP_PATH','.');

require(THINK_PATH.'/ThinkPHP.php');

$app = new App();
$app->run();
?>