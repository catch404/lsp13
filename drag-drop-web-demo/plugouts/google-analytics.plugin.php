<?php

m\Ki::Queue('html-body-end',function(){

	$file = sprintf(
		'%s/google-analytics.%s.html',
		dirname(__FILE__),
		$_SERVER['HTTP_HOST']
	);

	if(file_exists($file) && is_readable($file))
	echo file_get_contents($file);

	return;
});

