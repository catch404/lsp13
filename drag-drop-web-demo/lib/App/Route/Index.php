<?php

namespace App\Route;
use \m as m;

class Index extends m\Request\Route {
	public function Main() {
		$this->Key = 'index/home';
		return;
	}
}
