<?php

class RequestHandler {

    public function Placeholder() {
        //based on request add message based on control of inputs
	    if(isset($_REQUEST[self::$login])) {
		    $message .= $this->authentication->controlLoginInput(self::$name, self::$password);
	    } 
	    else if (isset($_REQUEST[self::$register])) {
		    $message .= $this->authentication->controlRegisterInput(self::$registerName, self::$registerPassword, self::$registerPasswordRepeat);
	    } 
	    else if(isset($_REQUEST[self::$logout])) {
		    $message .= "Bye bye!";
	    }

	    //reads url tag to determine if user is on login or register request
	    if(substr($_SERVER['REQUEST_URI'], 0, 10) === "/?register") {
		    $response = $this->generateRegisterFormHTML($message);
		    $response .= $this->generateHomePageLink();
	    } 
	    else {
		
		    //generate html based on if user is logged in or not
		    if($this->authentication->getUsersLoginStatus()) {
			    $response = $this->generateLogoutButtonHTML($message);
		    } 
		    else {
			    $response = $this->generateLoginFormHTML($message);
			    $response .= $this->generateRegisterLink();
		    }
        }
    }

    public function attemptLogIn() {
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