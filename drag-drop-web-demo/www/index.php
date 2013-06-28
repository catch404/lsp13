<?php

$logmode = array_key_exists('logmode',$_GET);
$root = dirname(dirname(__FILE__));

if($logmode) ob_start();

define('m\Config',"{$root}/conf/monticello.conf.php");
define('m\Ki\Log',true);
require("{$root}/lib/m/m-start.php");

if($logmode) {
	ob_get_clean();
	echo "\n\n<pre>\n";
	ob_start();
	print_r(m\Ki::$Log);
	echo preg_replace(
		'/(m-(?:init|setup|config|ready|shutdown|end))/',
		'<strong style="color:red">\1</strong>',
		ob_get_clean()
	);
	echo "</pre>\n";
}
