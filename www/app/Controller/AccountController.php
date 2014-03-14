<?php

class AccountController extends AppController {

	public $uses = array('User','UserPassword');
	public $components = array('Security','Bellarophon');

	public static $LOGINR_OK = 1;
	public static $LOGINR_DENIED = 2;
	public static $LOGINR_EMPTY = 3;

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Security->csrfCheck = false;
		$this->Security->validatePost = false;
	}

	public function createApikey() {
		$apikey = $this->Bellarophon->createApikey(1);
		return new CakeResponse(array(
			'body' => json_encode($apikey)
		));
	}

	private function checkLogin($username, $password) {
		$u = $this->User->findByUsername($username);
		if ($u) {
			if ($u['User']['pmode'] === 'NATIVE') {
				$p = Security::hash($password, null, true);
				$pwd = $u['User']['password'];
				if ($pwd === $p) {
					return array('result' => self::$LOGINR_OK, 'user' =>$u);
				} else {
					return array('result' => self::$LOGINR_DENIED);
				}
			} else {
				$up = $this->UserPassword->findByUserId($u['User']['id']);

				$s1 = $up['UserPassword']['rand1'];
				$s2 = $up['UserPassword']['rand2'];
				$p = sha1($s1.$password.$s2);
				$pwd = $up['UserPassword']['password'];
				$this->log("[$pwd] === [$p]");
				if ($pwd === $p) {
					return array('result' => self::$LOGINR_OK, 'user' =>$u, 'user_password' => $up);
				} else {
					return array('result' => self::$LOGINR_DENIED);
				}
			}
		} else {
			return array('result' => self::$LOGINR_DENIED);
		}
		return array('result' => self::$LOGINR_EMPTY);
	}

	public function login() {
		$username = '';
		$password = '';
		if ($this->request->data) {
			$username = $this->request->data['User']['username'];
			$password = $this->request->data['User']['password'];
		}
		$result = $this->checkLogin($username, $password);
		return new CakeResponse(array(
			'body' => json_encode($result)
		));
	}

	public function createAdmin() {
		$this->User->deleteAll(array(
			'User.id' => 1
		));
		$this->UserPassword->deleteAll(array(
			'UserPassword.id' => 1
		));


		$s1 = rand(1000000, 9999999);
		$s2 = rand(1000000, 9999999);
		$p = 'system';

		$pn = Security::hash($p, null, true);

		$s1 = sha1($s1);
		$s2 = sha1($s2);
		$pe = sha1($s1.$p.$s2);

		$u = $this->User->save(array(
			'User' => array(
				'id' => 1,
				'username' => 'marcohern',
				'password' => $pn,
				'email' => 'marcohern@gmail.com',
				'role' => 'ADMIN',
				'pmode' => 'EXTENDED',
				'created' => date("Y-m-d H:i:s"),
				'updated' => null
			)
		));
		$up = $this->UserPassword->save(array(
			'UserPassword' => array(
				'id' => 1,
				'user_id' => 1,
				'rand1' => $s1,
				'rand2' => $s2,
				'password' => $pe
			)
		));
		return new CakeResponse(array(
			'body' => json_encode(array(
				'user' => $u,
				'user_password' => $up
			))
		));
	}

	public function logout() {
		//destroy the current token
	}

	public function privateAction() {
		//
	}
}

?>