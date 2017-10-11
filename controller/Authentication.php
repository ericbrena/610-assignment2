<?php

require_once("model/RequestHandler.php");
require_once("model/SessionHandler.php");
require_once("model/ControlUserInput.php");
require_once("model/DatabaseHandler.php");

class Authentication {
    private $requestHandler;
    private $sessionHandler;
    private $controlUserInput;
    private $databaseHandler;

    public function __construct() {
        $this->requestHandler = new RequestHandler();
        $this->sessionHandler = new SessionHandler();
        $this->controlUserInput = new ControlUserInput();
        $this->databaseHandler = new DatabaseHandler();
    }

    public function handleRequest() {
        $userLoggedInStatus = $this->sessionHandler->isUserLoggedIn();
        $userAttemptedLogout = $this->requestHandler->attemptLogout();
        if($userLoggedInStatus && $userAttemptedLogout) {
            $this->sessionHandler->logout();
        }

        $userAttemptedLogin = $this->requestHandler->attemptLogIn();
        if($userLoggedInStatus === false && $userAttemptedLogin) {
            $this->controlUserInput->controlLoginInput();
            $logInResult = $this->databaseHandler->attemptAuthenticate();

            if($logInResult === true) {
                
            }
        }
        
    }
    
    public function getHTML() {

    }
    

    

}