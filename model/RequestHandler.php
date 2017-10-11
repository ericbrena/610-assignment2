<?php

class RequestHandler {
    public function requestRegisterPage() {
        return substr($_SERVER['REQUEST_URI'], 0, 10) === self::$registerPage;
    }

    public function attemptRegister() {
        return isset($_REQUEST[self::$register]);
    }

    public function attemptLogin() {
        return isset($_REQUEST[self::$LogIn]);
    }

    /**
    * It controls if the user is attempting to logout
    * @return boolean
    */
    public function attemptLogout() {
        return isset($_REQUEST[self::$logout]);
    }
}