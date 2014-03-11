<?php

class CountriesController extends AppController {

	public $uses = array('Country');

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

	public function index() {
		$r = $this->Country->find('all');
		return new CakeResponse(array(
			'type' => 'application/json',
			'body' => json_encode($r)
		));
	}

	public function i() {
		$r = $this->convertCountriesToSimple($this->Country->find('all'));
		return new CakeResponse(array(
			'type' => 'application/json',
			'body' => json_encode($r)
		));
	}

	public function qn($word = '', $max = 0) {
		$r = $this->Country->find('all', array(
			'conditions' => array(
				'Country.name LIKE' => "%{$word}%"
			)
		));
		$r = $this->convertCountriesToSimple($r);
		return new CakeResponse(array(
			'type' => 'application/json',
			'body' => json_encode($r)
		));
	}
}

?>