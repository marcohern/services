<?php

class AccountController extends AppController {

	public $uses = array('User');
	public $components = array('Security');

	public static LOGINR_OK = 1;
	public static LOGINR_DENIED = 2;
	public static LOGINR_EMPTY = 3;

	private function checkLogin($username, $password) {
		$p = Security::hash($password, null, true);
		$u = $this->User->findByUsername($username);
		if ($u) {
			$up = $this->UserPassword->findById($u['User']['id']);
			$pwd = $u['UserPassword']['password'];
			if ($pwd === $p) {
				return $u;
			} else {
				return LOGINR_DENIED;
			}
		} else {
			return LOGINR_DENIED;
		}
		return LOGINR_EMPTY;
	}

	public function login() {
		if ($this->user->data) {
			$username = $this->request->data['User']['username'];
			$password = $this->request->data['User']['password'];
			$result = $this.>checkLogin($username, $password);	
		}
	}

	public function logout() {
		//destroy the current token
	}

	public function privateAction() {
		//
	}
}

?>