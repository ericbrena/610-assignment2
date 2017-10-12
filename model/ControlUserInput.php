<?php

require_once("DatabaseHandler.php");

class ControlUserInput {
    private $controlResult;
    private $databaseHandler;

    public function __construct() {
        $this->databaseHandler = new DatabaseHandler();
    }

    public function getControlledMessage() {
        return $this->controlResult;
    }

    public function controlLoginInput($name, $password) {
        $message = "";
        //controls the inputs filled in
        if($name === "") {
            $message = "Username is missing";
        }
        if($password === "") {
            $message = "Password is missing";
        }
        if($this->databaseHandler->attemptAuthenticate($name, $password)) {
            $message = "Welcome";
            $this->controlResult = $message;

            return true;
        }
        if($message === "") {
            $message = "Wrong name or password";
        }

        $this->controlResult = $message;
        return false;
    }

    public function controlRegisterInput($name, $password, $passwordRepeat) {
        $message = "";

        //controls correct input 
        if(strlen($name) < 3) {
            $message .= " Username has too few characters, at least 3 characters.";
        }
        if(strlen($password) < 6) {
            $message .= " Password has too few characters, at least 6 characters.";
        }
        if($message === "" && $password !== $passwordRepeat) {
            $message .= "Passwords do not match.";
        }

        //control for string with bad characters
        $controlledName = $this->controlString($name);
        $controlledPassword = $this->controlString($password);
        if($controlledName === false) {
            $message .= "Username contains invalid characters.";
        } 
        else if ($controlledPassword === false) {
            $message .= "Password contains invalid characters.";
        }
        //if no errors above it will compare request to database
        else if($message === "" && $this->compareRegisterToDatabase($name)) {
            $this->controlResult = $message;
            return true;
        } 
        else if($message === "") {
            $message .= "User exists, pick another username.";
        }

        $this->controlResult = $message;
        return false;
    }

    /**
    * Controls post with given id if string with bad characters
    */
    private function controlString($string) {
        $newString = filter_var($string, FILTER_SANITIZE_STRING);
        if($newString === $string) {
            return true;
        }
        return false;
    }

}