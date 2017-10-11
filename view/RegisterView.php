<?php

class RegisterView {
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

		
		return $response;
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

	private function generateHomePageLink() {
		return '<a href="' . self::$url . '" name="Back to login">Back to login</a>';
	}

}