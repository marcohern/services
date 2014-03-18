<?php

class TestController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();

		$this->layout = 'blank';
	}

	public function index() {

	}
}

?>