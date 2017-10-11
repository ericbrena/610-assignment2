<?php

class ControlUserInput {
    private $message;

    public function getControlledMessage() {
        return $this->message;
    }

    public function controlLoginInput() {
        $message = "";

        //controls the inputs filled in
        if($_POST[self::$name] === "") {
            $message = "Username is missing";
        }
        if($_POST[self::$password] === "") {
            $message = "Password is missing";
        }
        if($this->attemptAuthenticate(self::$name, self::$password)) {
            $message = "Welcome";

            return true;
        }
        if($message === "") {
            $message = "Wrong name or password";
        }

        $this->message = $message;
        return false;
    }

    public function controlRegisterInput($name, $password, $passwordRepeat) {
        $message = "";

        //controls correct input 
        if(strlen($_POST[$name]) < 3) {
            $message .= " Username has too few characters, at least 3 characters.";
        }
        if(strlen($_POST[$password]) < 6) {
            $message .= " Password has too few characters, at least 6 characters.";
        }
        if($message === "" && $_POST[$password] !== $_POST[$passwordRepeat]) {
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
            return true;
        } 
        else if($message === "") {
            $message .= "User exists, pick another username.";
        }

        $this->message = $message;
        return false;
    }

    /**
    * Controls post with given id if string with bad characters
    */
    private function controlString($id) {
        $newString = filter_var($_POST[$id], FILTER_SANITIZE_STRING);
        if($newString === $_POST[$id]) {
            return true;
        }
        return false;
    }

}