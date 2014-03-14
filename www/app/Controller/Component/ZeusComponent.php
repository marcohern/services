<?php
/**
 * Zeus component
 *
 * Has super powers. Allows the developer to create administrators easily.
 * It it intended that in production, this component should not be available.
 *
 */
App::uses('Component','Controller');

class ZeusComponent extends Component {

	private static $df = "Y-m-d H:i:s";

	public $components = array('Security','Bellarophon');
	
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

	public function createUserPassword($id, $user_id, $password) {
		$r1 = rand(1000000, 9999999);
		$r2 = rand(1000000, 9999999);
		$pe = $this->Bellarophon->hashPassword($password, $r1, $r2);

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
}

?>