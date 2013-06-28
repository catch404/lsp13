<?php

m\Option::Set([
	'monticello-library'  => ['m\Surface'],
	'monticello-web-root' => sprintf('%s/www',dirname(dirname(__FILE__)))
]);


m\Ki::Queue('m-setup',function(){
	// super basic plugin system. lacks any type of security. just a file loader
	// for the presentation.

	$dir = dirname(dirname(__FILE__));
	$files = glob("{$dir}/plugins/*.plugin.php");

	foreach($files as $file)
	m_require($file);

	return;
});
