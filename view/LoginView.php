<?php

require_once("model/ConstNames.php");

class LoginView {
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function generateHTMLbody($message, $savedUsername) {
		$response = $this->generateLoginFormHTML($message, $savedUsername);
		$response .= $this->generateRegisterLink();
		
		return $response;
	}

	
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $savedUsername) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . ConstNames::messageId . '">' . $message . '</p>
					
					<label for="' . ConstNames::name . '">Username :</label>
					<input type="text" id="' . ConstNames::name . '" name="' . ConstNames::name . '" value="' . $savedUsername . '" />

					<label for="' . ConstNames::password . '">Password :</label>
					<input type="password" id="' . ConstNames::password . '" name="' . ConstNames::password . '" />

					<label for="' . ConstNames::keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . ConstNames::keep . '" name="' . ConstNames::keep . '" />
					
					<input type="submit" name="' . ConstNames::login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function generateRegisterLink() {
		return '<a href="' . ConstNames::url . ConstNames::registerURL . '" name="Register">Register a new user</a>';
	}
	
}