<?php

class SessionHandler {
    /**
    * It will control if user is logged in, if user is not it will declare a session and set to false
    * IMPORTANT! it assumes the sessionid is a boolean and returns the value as a representation to the users login status
    * @return boolean
    */
    public function getUsersLoginStatus() {
        if(isset($_SESSION[self::$sessionId]) === false) {
            $_SESSION[self::$sessionId] = false;
        }
        return $_SESSION[self::$sessionId];
    }

    public function logout() {
        $_SESSION[self::$sessionId] = false;
    }
}