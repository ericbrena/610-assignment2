<?php

require_once("model/ConstNames.php");

class RegisterView {
         /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function generateHTMLbody($message, $savedUsername) {
        $response = $this->generateRegisterFormHTML($message, $savedUsername);
        $response .= $this->generateHomePageLink();
		
		return $response;
    }
    
        /**
	* Generate HTML code for the register form
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message, $savedUsername) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Register</legend>
					<p id="' . ConstNames::registerMessageId . '">' . $message . '</p>
				
					<label for="' . ConstNames::registerName . '">Username :</label>
					<input type="text" id="' . ConstNames::registerName . '" name="' . ConstNames::registerName . '" value="' . $savedUsername . '" />

					<label for="' . ConstNames::registerPassword . '">Password :</label>
					<input type="password" id="' . ConstNames::registerPassword . '" name="' . ConstNames::registerPassword . '" />
			
					<label for="' . ConstNames::registerPasswordRepeat . '">Repeat password :</label>
					<input type="password" id="' . ConstNames::registerPasswordRepeat . '" name="' . ConstNames::registerPasswordRepeat . '" />
				
					<input type="submit" name="' . ConstNames::register . '" value="register" />
				</fieldset>
			</form>
		';
    }

	private function generateHomePageLink() {
		return '<a href="' . ConstNames::url . '" name="Back to login">Back to login</a>';
	}
}
