<?php

require(sprintf('%s/vendor/autoload.php',dirname(__FILE__)));

$server = new Game\BaseballGame;
$server->Start();
