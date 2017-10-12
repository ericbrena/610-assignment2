<?php

require_once("model/RequestHandler.php");
require_once("model/UserSessionHandler.php");
require_once("model/ControlUserInput.php");
require_once("model/DatabaseHandler.php");

require_once("view/LoginView.php");
require_once("view/LoggedInView.php");
require_once("view/RegisterView.php");

class Authentication {
    private $requestHandler;
    private $sessionHandler;
    private $controlUserInput;
    private $databaseHandler;

    private $loginView;
    private $loggedInView;
    private $registerView;

    public function __construct() {
        $this->requestHandler = new RequestHandler();
        $this->sessionHandler = new UserSessionHandler();
        $this->controlUserInput = new ControlUserInput();
        $this->databaseHandler = new DatabaseHandler();

        $this->loginView = new LoginView();
        $this->loggedInView = new LoggedInView();
        $this->registerView = new RegisterView();
    }

    public function handleRequest() {
        $this->handleLogout();
        $this->handleLogin();
        $this->handleRegister();
    }
    
    public function getHTML() {
        $userIsLoggedIn = $this->getLoggedInStatus();
        $userMessage = $this->controlUserInput->getControlledMessage();
        $userRequestRegisterPage = $this->requestHandler->requestRegisterPage();
        $HTML;

        if($userRequestRegisterPage === true) {
            $savedUserName = $this->sessionHandler->tryGetSavedInfo(ConstNames::savedRegisteredName);
            $HTML = $this->registerView->generateHTMLbody($userMessage, $savedUserName);
        }
        else if($userIsLoggedIn === true) {
            $HTML = $this->loggedInView->generateHTMLbody($userMessage);
        } else {
            $savedUserName = $this->sessionHandler->tryGetSavedInfo(ConstNames::savedName);
            $HTML = $this->loginView->generateHTMLbody($userMessage, $savedUserName);
        }
        return $HTML;
    }
    
    public function getLoggedInStatus() {
        return $this->sessionHandler->isUserLoggedIn();
    }

    private function handleLogout() {
        $userAttemptedLogout = $this->requestHandler->attemptLogout();
        if($this->getLoggedInStatus() && $userAttemptedLogout === true) {
            $this->sessionHandler->logout();
            $this->controlUserInput->userLoggedOut();
        }
    }

    private function handleLogin() {
        $userAttemptedLogin = $this->requestHandler->attemptLogin();
        if($this->getLoggedInStatus() === false && $userAttemptedLogin === true) {
            $name = $this->requestHandler->getPostRequest(ConstNames::name);
            $password = $this->requestHandler->getPostRequest(ConstNames::password);

            $this->sessionHandler->saveInfo(ConstNames::savedName, $name);
            $logInResult = $this->controlUserInput->controlLoginInput($name, $password);

            if($logInResult === true) {
                $this->sessionHandler->loginUser();
            }
        }
    }

    private function handleRegister() {
        $attemptRegister = $this->requestHandler->attemptRegister();
        if($attemptRegister === true) {
            $name = $this->requestHandler->getPostRequest(ConstNames::registerName);
            $password = $this->requestHandler->getPostRequest(ConstNames::registerPassword);
            $repeatPassword = $this->requestHandler->getPostRequest(ConstNames::registerPasswordRepeat);

            $this->sessionHandler->saveInfo(ConstNames::savedRegisteredName, $name);
            $registerResult = $this->controlUserInput->controlRegisterInput($name, $password, $repeatPassword);

            if($registerResult === true) {
                $this->databaseHandler->addRegisterToDatabase($name, $password);
                $this->sessionHandler->saveInfo(ConstNames::savedName, $name);
                header('Location: ' . ConstNames::url);
            }
        }
    }
}