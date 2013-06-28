<?php

m\Ki::Queue('html-head',function(){
	echo '<style type="text/css">';
	echo file_get_contents(sprintf(
		'%s/hipster-font.css',
		dirname(__FILE__)
	));
	echo '</style>', PHP_EOL;
	return;
});
