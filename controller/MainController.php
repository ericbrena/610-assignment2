<?php

require_once("model/GameLogic.php");

require_once("model/RequestHandler.php");
require_once("model/UserSessionHandler.php");
require_once("model/ControlUserInput.php");
require_once("model/DatabaseHandler.php");

require_once("view/LoginView.php");
require_once("view/LoggedInView.php");
require_once("view/RegisterView.php");
require_once("view/GameView.php");

class MainController {
    private $gameLogic;

    private $requestHandler;
    private $sessionHandler;
    private $controlUserInput;
    private $databaseHandler;

    private $loginView;
    private $loggedInView;
    private $registerView;
    private $gameView;

    public function __construct() {
        $this->gameLogic = new GameLogic();

        $this->requestHandler = new RequestHandler();
        $this->sessionHandler = new UserSessionHandler();
        $this->controlUserInput = new ControlUserInput();
        $this->databaseHandler = new DatabaseHandler();

        $this->loginView = new LoginView();
        $this->loggedInView = new LoggedInView();
        $this->registerView = new RegisterView();
        $this->gameView = new GameView();
    }

    public function handleRequest() {
        $this->handleLogout();
        $this->handleLogin();
        $this->handleRegister();
        $this->handleGameInput();
    }
    
    public function getHTML() {
        $userIsLoggedIn = $this->getLoggedInStatus();
        $userMessage = $this->controlUserInput->getControlledMessage();
        $userRequestRegisterPage = $this->requestHandler->requestRegisterPage();
        $HTML;

        //if already logged in, generate appropriate html
        if($userIsLoggedIn === true) {
            $HTML = $this->loggedInView->generateHTMLbody($userMessage);

            //if a game is active generate appropriate game html
            if($this->sessionHandler->controlSessionBoolean(ConstNames::gameActive) === true) {
                $gameBoard = $this->sessionHandler->getInfo(ConstNames::gameBoard);
                $userLost = $this->gameLogic->controlGameOver($gameBoard);

                $HTML .= $this->gameView->generateGameHTML($gameBoard, $userLost);
            }
        }
        //if register url sent, generate registration html
        else if($userRequestRegisterPage === true) {
            $savedUserName = $this->sessionHandler->getInfo(ConstNames::savedRegisteredName);
            $HTML = $this->registerView->generateHTMLbody($userMessage, $savedUserName);
        }
        //generates login html
        else {
            $savedUserName = $this->sessionHandler->getInfo(ConstNames::savedName);
            $HTML = $this->loginView->generateHTMLbody($userMessage, $savedUserName);
        }
        return $HTML;
    }
    
    public function getLoggedInStatus() {
        return $this->sessionHandler->controlSessionBoolean(ConstNames::isLoggedIn);
    }

    private function handleLogout() {
        $userAttemptedLogout = $this->requestHandler->controlRequest(ConstNames::logout);
        if($this->getLoggedInStatus() && $userAttemptedLogout === true) {
            $this->sessionHandler->logout();
            $this->controlUserInput->userLoggedOut();
        }
    }

    private function handleLogin() {
        $userAttemptedLogin = $this->requestHandler->controlRequest(ConstNames::login);
        if($this->getLoggedInStatus() === false && $userAttemptedLogin === true) {
            $name = $this->requestHandler->getPostRequest(ConstNames::name);
            $password = $this->requestHandler->getPostRequest(ConstNames::password);

            $this->sessionHandler->saveInfo(ConstNames::savedName, $name);
            $logInResult = $this->controlUserInput->controlLoginInput($name, $password);

            if($logInResult === true) {
                $this->sessionHandler->saveInfo(ConstNames::isLoggedIn, true);
            }
        }
    }

    private function handleRegister() {
        $attemptRegister = $this->requestHandler->controlRequest(ConstNames::register);
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

    private function handleGameInput() {
        if($this->getLoggedInStatus()) {
            $this->gameLogic->createNewGame();
            if($this->requestHandler->controlRequest(ConstNames::newGame) === true) {
                $this->sessionHandler->saveInfo(ConstNames::gameActive, true);
                $this->sessionHandler->saveInfo(ConstNames::gameBoard, $this->gameLogic->createNewGame());
            }
            
            if($this->sessionHandler->controlSessionBoolean(ConstNames::gameActive) === true) {
                $gameBoard = $this->sessionHandler->getInfo(ConstNames::gameBoard);
                $oldGameBoard = $gameBoard;
                
                if($this->requestHandler->controlRequest(ConstNames::gameMoveUp) === true) {
                    $gameBoard = $this->gameLogic->moveUp($gameBoard);
                }
                else if($this->requestHandler->controlRequest(ConstNames::gameMoveRight) === true) {
                    $gameBoard = $this->gameLogic->moveRight($gameBoard);
                }
                else if($this->requestHandler->controlRequest(ConstNames::gameMoveDown) === true) {
                    $gameBoard = $this->gameLogic->moveDown($gameBoard);
                }
                else if($this->requestHandler->controlRequest(ConstNames::gameMoveLeft) === true) {
                    $gameBoard = $this->gameLogic->moveLeft($gameBoard);
                }
                
                $gameBoard = $this->gameLogic->generateNewRandomTile($gameBoard);
                $this->sessionHandler->saveInfo(ConstNames::gameBoard, $gameBoard);
            }
        }
    }
}