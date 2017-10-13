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

    /**
    * Handles all the request given from user
    */
    public function handleRequest() {
        $this->handleLogout();
        $this->handleLogin();
        $this->handleRegister();
        $this->handleGameInput();
    }
    
    /**
    * Will return HTML string based on users logged in status OR url
    */
    public function getHTML() {
        $userIsLoggedIn = $this->getLoggedInStatus();

        //get message from the result of users inputs
        $userMessage = $this->controlUserInput->getControlledMessage();
        $userRequestRegisterPage = $this->requestHandler->requestRegisterPage();
        $HTML;

        //if already logged in, generate appropriate html
        if($userIsLoggedIn === true) {
            $HTML = $this->loggedInView->generateHTMLbody($userMessage);

            //if a game is active generate appropriate game html
            if($this->sessionHandler->controlSessionBoolean(ConstNames::gameActive) === true) {
                $gameBoard = $this->sessionHandler->getInfo(ConstNames::gameBoard);
                $gameNotOver = $this->gameLogic->controlGameOver($gameBoard);

                $HTML .= $this->gameView->generateGameHTML($gameBoard, $gameNotOver);
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

            //sets user logged in status to false and add message "bye!"
            $this->sessionHandler->saveInfo(ConstNames::isLoggedIn, false);
            $this->controlUserInput->userLoggedOut();
        }
    }

    private function handleLogin() {
        $userAttemptedLogin = $this->requestHandler->controlRequest(ConstNames::login);

        if($this->getLoggedInStatus() === false && $userAttemptedLogin === true) {
            $name = $this->requestHandler->getPostRequest(ConstNames::name);
            $password = $this->requestHandler->getPostRequest(ConstNames::password);

            //saves username to print if failed login
            $this->sessionHandler->saveInfo(ConstNames::savedName, $name);
            $logInResult = $this->controlUserInput->controlLoginInput($name, $password);

            //set users log in status true
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

            //saves username to print if failed register
            $this->sessionHandler->saveInfo(ConstNames::savedRegisteredName, $name);
            $registerResult = $this->controlUserInput->controlRegisterInput($name, $password, $repeatPassword);

            //register users info and change the header to webpages entry site
            if($registerResult === true) {
                $this->databaseHandler->addRegisterToDatabase($name, $password);
                $this->sessionHandler->saveInfo(ConstNames::savedName, $name);
                header('Location: ' . ConstNames::url);
            }
        }
    }

    private function handleGameInput() {

        //user needs to be logged in to send requests
        if($this->getLoggedInStatus()) {

            //creates new game if requested
            if($this->requestHandler->controlRequest(ConstNames::newGame) === true) {

                //sets to true for printing the game html
                $this->sessionHandler->saveInfo(ConstNames::gameActive, true);

                //adds the new game info to session
                $this->sessionHandler->saveInfo(ConstNames::gameBoard, $this->gameLogic->createNewGame());
            }
            
            //a game needs to be active in order to get game moves
            if($this->sessionHandler->controlSessionBoolean(ConstNames::gameActive) === true) {
                $gameBoard = $this->sessionHandler->getInfo(ConstNames::gameBoard);
                $oldGameBoard = $gameBoard;
                
                //changes game board info based on request type
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
                
                //control if a change has been made from previous move
                //if so add a new number to game board
                $boardHasChanged = $this->gameLogic->analyzeBoardChange($oldGameBoard, $gameBoard);
                if($boardHasChanged === true) {
                    $gameBoard = $this->gameLogic->generateNewBoard($gameBoard);
                }

                $this->sessionHandler->saveInfo(ConstNames::gameBoard, $gameBoard);
            }
        }
    }
}