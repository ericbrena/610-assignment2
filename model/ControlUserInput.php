<?php

require_once("DatabaseHandler.php");

class ControlUserInput {
    private $controlResult;
    private $databaseHandler;

    public function __construct() {
        $this->databaseHandler = new DatabaseHandler();
    }

    /**
    * returns message accumulated during runtime
    */
    public function getControlledMessage() {
        return $this->controlResult;
    }

    /**
    * This does TWO things!
    * First, it controls parameter variables
    * Second, it controls authentication to database
    * @return boolean, true if succesfull result from database, false if not
    */
    public function controlLoginInput($name, $password) {
        $message = "";
        //controls the inputs filled in
        if($name === "") {
            $message = "Username is missing";
        }
        else if($password === "") {
            $message = "Password is missing";
        }
        //attempts authenticate to database
        else if($this->databaseHandler->attemptAuthenticate($name, $password)) {
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

    /**
    * This does TWO things!
    * First, it controls parameter variables
    * Second, it controls username to database
    * @return boolean, true if no username exists, false if it does
    */
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
        else if($message === "" && $this->databaseHandler->compareRegisterToDatabase($name)) {
            $this->controlResult = $message;
            return true;
        } 
        else if($message === "") {
            $message .= "User exists, pick another username.";
        }

        $this->controlResult = $message;
        return false;
    }

    public function userLoggedOut() {
        $this->controlResult = "Bye!";
    }

    /**
    * Controls parameter for invalid
    * @return boolean, return true if valid string
    */
    private function controlString($string) {
        $newString = filter_var($string, FILTER_SANITIZE_STRING);
        if($newString === $string) {
            return true;
        }
        return false;
    }

}