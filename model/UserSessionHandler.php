<?php

require_once("ConstNames.php");

class UserSessionHandler {
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
