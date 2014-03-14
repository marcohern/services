<?php

class CountriesController extends AppController {

	public $uses = array('Country');

	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Bellarophon->deny('index');
	}

	private function convertCountriesToSimple($countries) {
		$r = array();
		foreach ($countries as $c) {
			$r[] = array(
				'id' => $c['Country']['id'],
				'fips' => $c['Country']['fips'],
				'iso' => $c['Country']['fips'],
				'name' => $c['Country']['name']
			);
		}
		return $r;
	}

	public function allowed() {
		return $this->Bellarophon->response(array('allowed' => true));
	}

	public function index() {
		$r = $this->Country->find('all');
		return $this->Bellarophon->response($r);
	}

	public function i() {
		$r = $this->convertCountriesToSimple($this->Country->find('all'));
		return $this->Bellarophon->response($r);
	}

	public function qn($word = '', $max = 0) {
		$r = $this->Country->find('all', array(
			'conditions' => array(
				'Country.name LIKE' => "%{$word}%"
			)
		));
		$r = $this->convertCountriesToSimple($r);
		return $this->Bellarophon->response($r);
	}
}

?>