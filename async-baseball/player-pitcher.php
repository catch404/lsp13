<?php

require(sprintf('%s/vendor/autoload.php',dirname(__FILE__)));

$client = new Game\Pitcher;
$client->Start();
