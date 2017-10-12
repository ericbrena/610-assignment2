<?php

require_once("ConstNames.php");

class RequestHandler {
    public function requestRegisterPage() {
        return substr($_SERVER['REQUEST_URI'], 0, 10) === ConstNames::registerURL;
    }

    public function attemptRegister() {
        return isset($_REQUEST[ConstNames::register]);
    }

    public function attemptLogin() {
        return isset($_REQUEST[ConstNames::login]);
    }

    /**
    * It controls if the user is attempting to logout
    * @return boolean
    */
    public function attemptLogout() {
        return isset($_REQUEST[ConstNames::logout]);
    }

    public function getPostRequest($id) {
        return $_POST[$id];
    }
}