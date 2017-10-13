<?php

require_once("ConstNames.php");

class UserSessionHandler {

    /**
    * It will control if user is logged in, if user is not it will declare a session and set to false
    * IMPORTANT! it assumes the sessionid is a boolean
    * @return boolean
    */
    public function controlSessionBoolean($id) {
        if(isset($_SESSION[$id]) === false) {
            $_SESSION[$id] = false;
        }
        return $_SESSION[$id];
    }
	public function getInfo($id) {
		$info = "";
		if(isset($_SESSION[$id])) {
			$info = $_SESSION[$id];
		}
		return $info;
    }
    
    public function saveInfo($id, $message) {
        $_SESSION[$id] = $message;
    }
}