<?php

require_once("UserDetails.php");

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $databaseFile = __DIR__ . "/database.txt";
	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = "";

		//if user submits a form this conditional will be true
		if(count($_POST) !== 0) {


			$loginResult = $this->controlLoginInfo();

			//if authentication is not valid, add error message
			if($loginResult !== "") {
				$message .= $loginResult;
			}
		}
		
		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="Kallekapten" />

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
	* Reads from the database, which is a txt file
	* IMPORTANT! this is not a permament way to handle database, only a temporary solution to assignment
	* @return array, the array contains UserDetails classes
	*/
	private function getReadableDatabaseInfo() {

		//reads from txt file
		$fileData = file_get_contents(self::$databaseFile, FILE_USE_INCLUDE_PATH);

		//make it a readable array containing UserDetails classes
		$readableFileData = unserialize($fileData);

		return $readableFileData;
	}

	/**
	* Controls users authentication form
	* @return string, Empty if there were no error authenticating!
	*/
	private function controlLoginInfo() {

		//controls the inputs are filled in
		if($_POST[self::$name] === "") {
			return "Username is missing";
		}
		if($_POST[self::$password] === "") {
			return "Password is missing";
		}

		$fileData = $this->getReadableDatabaseInfo();
		
		//iterate for a match, return empty string if found
		for($i = 0; $i < count($fileData); $i++) {
			if($_POST[self::$name] === $fileData[$i]->name && $_POST[self::$password] === $fileData[$i]->password) {
				return "";
			}
		}

		return "Wrong name or password";
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
	
}