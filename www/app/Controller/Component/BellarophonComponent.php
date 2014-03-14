<?php

App::uses('Component','Controller');

class BellarophonComponent extends Component {

	public $components = array('Security');

	private static $df = "Y-m-d H:i:s";
	private static $symbols = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-_*";

	public function initialize(Controller $controller) {

	}

	public function startup(Controller $controller) {
		$this->Security->csrfCheck = false;
		$this->Security->validatePost = false;
	}

	public function beforeRender(Controller $controller) {

	}

	public function shutdown(Controller $controller) {

	}

	public function beforeRedirect(Controller $controller, $url, $status=null, $exit=true) {

	}

	public function createUserToken($user_id) {
		$token = uniqid("", true);
		$created = new DateTime();
		$duration = new DateInterval("P1D");
		$expires = $created->add($duration);
		setcookie("mrc_token", $token, $expires->getTimeStamp());
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
		setcookie("mrc_token", "", time()-1);
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

	public function createUser($id, $username, $password, $email, $role, $pmode) {
		$pn = Security::hash($password);
		return array(
			'User' => array(
				'id' => $id,
				'username' => $username,
				'password' => $pn,
				'email' => $email,
				'role' => $role,
				'pmode' => $pmode,
				'created' => date(self::$df),
				'updated' => null
			)
		);
	}

	private function hashPassword($password, $rand1, $rand2) {
		$s1 = sha1($rand1);
		$s2 = sha1($rand2);
		return sha1($s1.$password.$s2);
	}

	public function createUserPassword($id, $user_id, $password) {
		$r1 = rand(1000000, 9999999);
		$r2 = rand(1000000, 9999999);
		$pe = $this->hashPassword($password, $r1, $r2);

		return array(
			'UserPassword' => array(
				'id' => $id,
				'user_id' => $user_id,
				'rand1' => $r1,
				'rand2' => $r2,
				'password' => $pe
			)
		);
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