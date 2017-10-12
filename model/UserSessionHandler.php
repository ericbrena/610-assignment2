<?php

require_once("ConstNames.php");

class UserSessionHandler {

    /**
    * It will control if user is logged in, if user is not it will declare a session and set to false
    * IMPORTANT! it assumes the sessionid is a boolean and returns the value as a representation to the users login status
    * @return boolean
    */
    public function isUserLoggedIn() {
        if(isset($_SESSION[ConstNames::LoggedIn]) === false) {
            $_SESSION[ConstNames::LoggedIn] = false;
        }
        return $_SESSION[ConstNames::LoggedIn];
    }

    public function loginUser() {
        $_SESSION[ConstNames::LoggedIn] === true;
    }

    public function logout() {
        $_SESSION[ConstNames::LoggedIn] = false;
    }
}