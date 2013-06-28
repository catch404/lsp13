<?php

namespace Game;

class Pitcher extends Player implements PlayerActions {

	public function __construct() {
		parent::__construct('PITCHER');
		return;
	}

	public function HandleWelcome($msg) {
		parent::HandleWelcome($msg);

		$this->EventLoop->addPeriodicTimer(10,function(){
			$this->SendMessage('pitch-ball','try');
		});

		return;
	}

	public function HandlePitchBall($msg) {
		echo '%%% You have pitched the ball towards the plate.', PHP_EOL;
		return;
	}

	public function HandleCatchBall($msg) {
		echo '%%% The catcher has caught the ball.', PHP_EOL;
		return;
	}

}
