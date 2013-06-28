Code Demos
==========

Code I demonstrated during the Event Driven Applications Talk at Lone Star PHP 2013. Require PHP 5.4+


drag-drop-web-demo
==================

Start a PHP server pointed at the www directory. Of course it will also with
whatever webserver of your choice too, if you already have Apache or something
setup.

	php -S localhost:9876 -t /path/to/my/demo/drag-drop-web-demo/www

Visit http://localhost:9876 in the browser.

Drag drop files from the "plugoffs" folders into the "plugins" folder. The code
is super simple not super tollerant. Make sure you drag both analytics together,
and both hipsters together.


async-baseball
==============

Start the game server from your Terminal.

	php game-start.php

Start a catcher in a NEW Terminal.

	php player-catcher.php

Start a pitcher in ANOTHER NEW Terminal.

	php player-pitcher.php

The pitcher will throw the ball automatically every 10 seconds.

