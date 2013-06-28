<?php

namespace Game;

class Catcher extends Player implements PlayerActions {

	public function __construct() {
		parent::__construct('CATCHER');
		return;
	}

	public function HandlePitchBall($msg) {
		echo '%%% A ball is flying at you.', PHP_EOL;

		$this->SendMessage('catch-ball','try');

		return;
	}

	public function HandleCatchBall($msg) {
		echo '%%% You have caught the ball.', PHP_EOL;
		return;
	}

}
