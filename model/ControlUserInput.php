<?php

class ControlUserInput {
    /**
	* Controls users login form
	* @return string
	*/
    public function controlLoginInput() {
        
        //saves users log in info to print to username input
        $_SESSION[self::$name] = $_POST[self::$name];

        //controls the inputs filled in
        if($_POST[self::$name] === "") {
            return "Username is missing";
        }
        if($_POST[self::$password] === "") {
            return "Password is missing";
        }
        
        if($this->attemptAuthenticate(self::$name, self::$password)) {
            return "Welcome";
        }
        
        return "Wrong name or password";
    }

    /**
    * Controls users register form
    * @return string, containing message of the result of control
    */
    public function controlRegisterInput($name, $password, $passwordRepeat) {
        $message = "";

        $_SESSION[$name] = filter_var($_POST[$name], FILTER_SANITIZE_STRING);

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
        $controlledName = $this->controlPostString($name);
        $controlledPassword = $this->controlPostString($password);
        if($controlledName === false) {
            $message .= "Username contains invalid characters.";
        } 
        else if ($controlledPassword === false) {
            $message .= "Password contains invalid characters.";
        }
        //if no errors above it will compare request to database
        else if($message === "" && $this->compareRegisterToDatabase($name)) {
            $this->addRegisterToDatabase($name, $password);
            header('Location: ' . self::$url);
        } 
        else if($message === "") {
            $message .= "User exists, pick another username.";
        }

        return $message;
    }

    /**
    * Controls post with given id if string with bad characters
    */
    private function controlPostString($id) {
        $newString = filter_var($_POST[$id], FILTER_SANITIZE_STRING);
        if($newString === $_POST[$id]) {
            return true;
        }
        return false;
    }

}