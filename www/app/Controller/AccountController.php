<?php

class AccountController extends AppController {

	public $uses = array('User','UserPassword');
	public $components = array('Bellarophon');

	private $rem = array(
		'User' => array('password','pmode','preset','ptoken','ptokex', 'created','updated'),
		'UserPassword' => array('rand1','rand2','password')
	);

	public static $LOGINR_OK = 0;
	public static $LOGINR_DENIED = 1;
	public static $LOGINR_EMPTY = 2;
	public static $LOGINR_USERNOTEXISTS = 3;

	private static $messages = array(
		0 => 'OK',
		1 => 'Access denied. Password invalid.',
		2 => 'No username or password provided.',
		3 => 'Username does not exists.'
	);

	public function beforeFilter() {
		parent::beforeFilter();
	}

	private function clearFieldsRow($row, $fields) {
		$n = count($fields);
		$r = $row;
		for ($i=0; $i<$n; $i++) {
			$field = $fields[$i];
			unset($r[$field]);
		}
		return $r;
	}

	private function clearFields($record) {
		$r = array();
		foreach($this->rem as $model => $fields) {
			if (array_key_exists($model, $record)) {
				$r[$model] = $this->clearFieldsRow($record[$model], $fields);
			}
		}
		return $r;
	}

	public function createApikey() {
		$apikey = $this->Bellarophon->createApikey(1);
		return new CakeResponse(array(
			'body' => json_encode($apikey)
		));
	}

	private function checkLogin($username, $password) {
		if (empty($username) || empty($password)) {
			return array(
				'result' => self::$LOGINR_EMPTY,
				'message' => self::$messages[self::$LOGINR_EMPTY]
			);
		}
		$u = $this->User->findByUsername($username);
		if ($u) {
			if ($this->Bellarophon->compareUserPassword($u, $password)) {
				$u = $this->clearFields($u);
				return array_merge(array(
					'result' => self::$LOGINR_OK,
					'message' => self::$messages[self::$LOGINR_OK]
				), $u);
			} else {
				return array(
					'result' => self::$LOGINR_DENIED,
					'message' => self::$messages[self::$LOGINR_DENIED]
				);
			}

		} else {
			return array(
				'result' => self::$LOGINR_USERNOTEXISTS,
				'message' => self::$messages[self::$LOGINR_USERNOTEXISTS]
			);
		}
	}

	public function login() {
		$username = '';
		$password = '';
		if ($this->request->data) {
			$username = $this->request->data['User']['username'];
			$password = $this->request->data['User']['password'];
		}
		$result = $this->checkLogin($username, $password);
		return $this->Bellarophon->response($result);
	}

	public function createAdmin() {
		$this->User->deleteAll(array(
			'User.id' => 1
		));

		$password = 'system';
		$user = array_merge(
			$this->Bellarophon->createUser('marcohern',$password, 'marcohern@gmail.com','ADMIN','EXTENDED'),
			$this->Bellarophon->createUserPassword(1, $password)
		);

		$user['User']['id'] = 1;
		$user['UserPassword']['id'] = 1;

		$u = $this->User->saveAssociated($user);
		return $this->Bellarophon->response(array_merge(
			array('success' => $u),
			$user
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