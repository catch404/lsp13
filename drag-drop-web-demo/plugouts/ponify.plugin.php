<?php

m\Ki::Queue('surface-stdout',function(&$text){

	$text = preg_replace('/person/ms','<strong>pony</strong>',$text);
	$text = preg_replace('/people/ms','<strong>everypony</strong>',$text);

	return;
});
