<?php

require_once("controller/Authentication.php");

class BodyView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $savedName = "LoginView::SavedUserName";
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private static $registerName = "RegisterView::UserName";
	private static $savedRegisteredName = "RegisterView::SavedUserName";
	private static $registerPassword = "RegisterView::Password";
	private static $registerPasswordRepeat = "RegisterView::PasswordRepeat";
	private static $register = "RegisterView::Register";
	private static $registerMessageId = "RegisterView::Message";

	private static $url = "http://eb223fz.000webhostapp.com/";

	private $authentication;

	public function __construct() {
		$this->authentication = new Authentication();
	}
	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = "";
		$response;

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
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->tryAddSavedInfo(self::$name) . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	/**
	* Generate HTML code for the register form
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Register</legend>
					<p id="' . self::$registerMessageId . '">' . $message . '</p>
				
					<label for="' . self::$registerName . '">Username :</label>
					<input type="text" id="' . self::$registerName . '" name="' . self::$registerName . '" value="' . $this->tryAddSavedInfo(self::$registerName) . '" />

					<label for="' . self::$registerPassword . '">Password :</label>
					<input type="password" id="' . self::$registerPassword . '" name="' . self::$registerPassword . '" />
			
					<label for="' . self::$registerPasswordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$registerPasswordRepeat . '" name="' . self::$registerPasswordRepeat . '" />
				
					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
	}

	/**
	* It will see if any saved sessions exist of name, if add to message
	* IMPORTANT! It assumes the session contains a string
	* @return string
	*/
	private function tryAddSavedInfo($id) {
		$message = "";
		if(isset($_SESSION[$id])) {
			$message = $_SESSION[$id];
		}
		return $message;
	}

	private function generateHomePageLink() {
		return '<a href="' . self::$url . '" name="Back to login">Back to login</a>';
	}

	private function generateRegisterLink() {
		return '<a href="' . self::$url . '/?register" name="Register">Register a new user</a>';
	}
	
}