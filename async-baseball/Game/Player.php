<?php

namespace Game;
use \React as React;

class Player {

	public $Input;
	public $Connection;
	public $EventLoop;
	public $Type = 'unknown';

	public function __construct($type) {

		$this->Type = $type;
		$this->EventLoop = React\EventLoop\Factory::create();

		$this->Connection = stream_socket_client('tcp://localhost:7890');
		if(!$this->Connection) throw new \Exception('unable to join the game.');

//		$this->Input = fopen('php://stdin','r');

		stream_set_blocking($this->Connection,false);
//		stream_set_blocking($this->Input,false);

		$this->EventLoop->addReadStream($this->Connection,[$this,'OnRecv']);
//		$this->EventLoop->addReadStream($this->Input,[$this,'OnCommand']);

		return;
	}

	////////////////
	////////////////

	public function Start() {
		return $this->EventLoop->run();
	}

	public function SendMessage($type,$msg) {
		echo ">>> SEND: [{$type}] {$msg}", PHP_EOL;

		fwrite($this->Connection,json_encode([
			'Type' => $type,
			'Message' => $msg
		]).PHP_EOL);

		return;
	}

	////////////////
	////////////////

	public function OnRecv($stream) {

		while($line = trim(fgets($stream))) {

			$obj = json_decode($line);
			if(!is_object($obj)) {
				echo "XXX RECV JUNK DATA: {$line}",PHP_EOL;
				continue;
			}

			$this->HandleMessage($obj);
		}

		return false;
	}

	public function OnCommand($stream) {

		while($line = trim(fgets($stream))) {
			switch($line) {
				case 'pitch-ball': {
					$this->SendMessage('pitch-ball','try');
					break;
				}
				default: {
					echo "XXX UNKNOWN COMMAND: {$line}", PHP_EOL;
					break;
				}
			}
		}

		return false;
	}

	////////////////
	////////////////

	public function HandleMessage($obj) {
		switch($obj->Type) {
			case 'welcome': { $this->HandleWelcome($obj->Message); break; }
			case 'info': { $this->HandleInfo($obj->Message); break; }
			case 'pitch-ball': { $this->HandlePitchBall($obj->Message); break; }
			case 'catch-ball': { $this->HandleCatchBall($obj->Message); break; }
			default: { echo "XXX UNKNOWN RECV: [{$obj->Type}] {$obj->Message}"; break; }
		}

		return;
	}

	public function HandleWelcome($msg) {
		echo "%%% WELCOME: You have been welcomed to the game.", PHP_EOL;
		$this->SendMessage('field-player',$this->Type);
		return;
	}

	public function HandleInfo($msg) {
		echo "%%% RECV INFO: {$msg}", PHP_EOL;
		return;
	}

}
