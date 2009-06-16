<?php
/*
	$Date$
	$Author$
	$Id$
*/
define('THINK_PATH','./ThinkPHP');

define('APP_NAME','myApp');
define('APP_PATH','.');

require(THINK_PATH.'/ThinkPHP.php');

$app = new App();
$app->run();
?>