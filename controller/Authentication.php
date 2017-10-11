<?php

require_once("model/RequestHandler.php");
require_once("model/SessionHandler.php");
require_once("model/ControlUserInput.php");
require_once("model/DatabaseHandler.php");

require_once("view/LoginView.php");
require_once("view/RegisterView.php");

class Authentication {
    private $requestHandler;
    private $sessionHandler;
    private $controlUserInput;
    private $databaseHandler;

    private $loginView;
    private $registerView;

    public function __construct() {
        $this->requestHandler = new RequestHandler();
        $this->sessionHandler = new SessionHandler();
        $this->controlUserInput = new ControlUserInput();
        $this->databaseHandler = new DatabaseHandler();

        $this->loginView = new LoginView();
        $this->registerView = new RegisterView();
    }

    public function handleRequest() {
        $userLoggedInStatus = $this->sessionHandler->isUserLoggedIn();
        $userAttemptedLogout = $this->requestHandler->attemptLogout();
        if($userLoggedInStatus && $userAttemptedLogout) {
            $this->sessionHandler->logout();
        }

        $userAttemptedLogin = $this->requestHandler->attemptLogin();
        if($userLoggedInStatus === false && $userAttemptedLogin) {
            $logInResult = $this->controlUserInput->controlLoginInput();

            if($logInResult === true) {
                $this->sessionHandler->loginUser();
            }
        }

        $attemptRegister = $this->requestHandler->attemptRegister();
        if($attemptRegister === true) {
            $registerResult = $this->controlUserInput->controlRegisterInput();

            if($registerResult === true) {
                $this->databaseHandler->addRegisterToDatabase($name, $password);
                header('Location: ' . self::$url);
            }
        }
    }
    
    public function getHTML() {
        $userRequest = $this->requestHandler->requestRegisterPage();
        $userMessage = $this->controlUserInput->getControlledMessage();
        $HTML;

        if($userRequest === true) {
            $HTML = $this->registerView->generateHTMLbody($userMessage);
        }
        else {
            $HTML = $this->loginView->generateHTMLbody($userMessage);
        }
        return $HTML;
    }
    

    

}