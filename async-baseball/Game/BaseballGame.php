<?php

namespace Game;
use \React as React;

class BaseballGame extends React\Socket\Server {

	public $EventLoop;
	public $Connections = [];

	public $HasPitcher = false;
	public $HasCatcher  = false;

	public function __construct() {

		$this->EventLoop = React\EventLoop\Factory::create();

		parent::__construct($this->EventLoop);
		$this->SetupServer();

		echo "### the game server has started", PHP_EOL;
		return;
	}

	protected function SetupServer() {
		$this->listen(7890);
		$this->on('connection',[$this,'OnConnect']);
		return;
	}

	////////////////
	////////////////

	public function Start() {
		return $this->EventLoop->run();
	}

	////////////////
	////////////////

	public function OnConnect($cx) {
		echo "### connection from {$cx->getRemoteAddress()}", PHP_EOL;

		$cx->on('data',[$this,'OnRecv']);
		$this->Connections[] = $cx;
		$this->SendMessage($cx,'welcome','Welcome to the game.');

		return;
	}

	public function OnRecv($data,$cx) {
		//echo "### data recv: {$cx->getRemoteAddress()} - $data", PHP_EOL;

		$obj = json_decode($data);
		if(!is_object($obj)) return;

		$this->HandleMessage($cx,$obj);
		return;
	}

	////////////////
	////////////////

	public function SendMessageGlobal($type,$msg) {
		echo ">>> SEND TO ALL: [{$type}] {$msg}", PHP_EOL;

		foreach($this->Connections as $cx) {
			if($cx->isWritable())
			$this->SendMessage($cx,$type,$msg,false);
		}
	}

	public function SendMessage($cx,$type,$msg,$lol=true) {

		if($lol)
		echo ">>> SEND: [{$type}] {$msg}", PHP_EOL;

		$cx->write(json_encode([
			'Type' => $type,
			'Message' => $msg
		]).PHP_EOL);
	}

	////////////////
	////////////////

	public function HandleMessage($cx,$obj) {

		switch($obj->Type) {
			case 'field-player': { $this->HandleFieldPlayer($cx,$obj->Message); break; }
			case 'pitch-ball': { $this->HandlePitchBall($cx,$obj->Message); break; }
			case 'catch-ball': { $this->HandleCatchBall($cx,$obj->Message); break; }
		}

		return;
	}

	public function HandleFieldPlayer($cx,$player) {
		$cx->PlayerType = $player;

		echo "%%% A player of type {$player} took to the field.", PHP_EOL;
		$this->SendMessageGlobal('info',"a player `{$player}` has taken the field.");

		return;
	}

	public function HandlePitchBall($cx,$msg) {

		if($cx->PlayerType !== 'PITCHER') {
			$this->SendMessage($cx,'game-error','You are not a pitcher.');
			return;
		}

		$this->SendMessageGlobal('pitch-ball','success');
		return;
	}

	public function HandleCatchBall($cx,$msg) {
		if($cx->PlayerType !== 'CATCHER') {
			$this->SendMessage($cx,'game-error','You are not the catcher.');
			return;
		}

		$this->SendMessageGlobal('catch-ball','success');
		return;
	}

}
