<?php

App::uses('Component','Controller');

class BellarophonComponent extends Component {

	private static $symbols = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-_*";

	public function initialize(Controller $controller) {

	}

	public function startup(Controller $controller) {

	}

	public function beforeRender(Controller $controller) {

	}

	public function shutdown(Controller $controller) {

	}

	public function beforeRedirect(Controller $controller, $url, $status=null, $exit=true) {

	}

	private function generateApikey() {
		$slen = strlen(self::$symbols);
		$key = '';
		for ($i=0; $i<60; $i++) {
			$ri = rand(0, $slen);
			$c = substr(self::$symbols, $ri, 1);
			$key .= $c;
		}
		return $key;
	}

	public function createApikey($user_id) {
		$format = "Y-m-d H:i:s";
		$created = new DateTime();
		$date = date("Y-m-d H:i:s");
		$key = $this->generateApikey();

		return array(
			'user_id' => $user_id,
			'apikey' => $key,
			'active' => 'Y',
			'created' => $created->format($format),
			'deactivated' => null
		);
	}
}

?>