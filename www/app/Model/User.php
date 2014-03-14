<?php

class User extends AppModel {
	public $hasOne = array('UserPassword');
}

?>