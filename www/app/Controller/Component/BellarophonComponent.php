<?php

App::uses('Component','Controller');

class BellarophonComponent extends Component {

	private $apikey;
	private $token;

	public $components = array('Security');

	private $deny = array();

	private static $df = "Y-m-d H:i:s";
	private static $symbols = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-_*";
	private static $cookie = 'mrc_token';

	public function initialize(Controller $controller) {
		$this->retrieveApikey($controller);
		$this->apikey = null;
		$this->token = null;

		$this->Security->csrfCheck = false;
		$this->Security->validatePost = false;
	}

	public function startup(Controller $controller) {
		if ($this->isDenied($controller)) {
			$controller->redirect("allowed");
		}
	} 

	public function beforeRender(Controller $controller) {

	}

	public function shutdown(Controller $controller) {

	}

	public function beforeRedirect(Controller $controller, $url, $status=null, $exit=true) {

	}

	private function retrieveApikey(Controller $c) {
		if ($c->request->data) {
			if (array_key_exists('apikey', $c->request->data)) {
				$this->apikey = $c->request->data['apikey'];
			}
		}
	}

	private function retrieveToken(Controller $c) {
		if ($c->request->data) {
			if (array_key_exists(self::$cookie, $_COOKIE)) {

			}
		}
	}

	private function isDenied(Controller $controller) {
		$action = $controller->request->params['action'];
		$found = false;
		foreach($this->deny as $denied) {
			if ($action === $denied) {
				$found = true;
				break;
			}
		}
		return $found;
	}

	public function deny($actions) {
		if (is_array($actions)) {
			$this->deny = array_merge($this->deny, $actions);
		} else {
			$this->deny[] = $actions;
		}
	}

	public function createUserToken($user_id) {
		$token = uniqid("", true);
		$created = new DateTime();
		$duration = new DateInterval("P1D");
		$expires = $created->add($duration);
		setcookie(self::$cookie, $token, $expires->getTimeStamp());
		return array(
			'UserToken' => array(
				'id' => null,
				'user_id' => $user_id,
				'token' => $token,
				'active' => 'Y',
				'created' => $created->format(self::$df),
				'expires' => $expires->format(self::$df)
			)
		);
	}

	public function destroyCurrentUserToken() {
		setcookie(self::$cookie, "", time()-1);
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
		$created = new DateTime();
		$date = date(self::$df);
		$key = $this->generateApikey();

		return array(
			'Apikey' => array(
				'id' => null,
				'user_id' => $user_id,
				'apikey' => $key,
				'active' => 'Y',
				'created' => $created->format(self::$df),
				'deactivated' => null
			)
		);
	}

	public function hashPassword($password, $rand1, $rand2) {
		$s1 = sha1($rand1);
		$s2 = sha1($rand2);
		return sha1($s1.$password.$s2);
	}

	public function compareUserPassword(array $user, $password) {
		$pwd = null;
		$p = null;
		$pmode = $user['User']['pmode'];
		if ($pmode === 'NATIVE') {
			$pwd = $user['User']['password'];
			$p = Security::hash($password, null, true);
		} else if ($pmode === 'EXTENDED') {
			$r1 = $user['UserPassword']['rand1'];
			$r2 = $user['UserPassword']['rand2'];
			$pwd = $user['UserPassword']['password'];
			$p = $this->hashPassword($password, $r1, $r2);
		}
		return ($pwd === $p) ? true : false;
	}

	public function response(array $result) {
		$response = new CakeResponse(array(
			'body' => json_encode($result)
		));
		$response->type(array('json' => 'application/json'));
		$response->type('json');
		return $response;
	}
}

?>