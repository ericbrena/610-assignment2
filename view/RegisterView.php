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
	public function generateHTMLbody($message) {
        $response = $this->generateRegisterFormHTML($message);
        $response .= $this->generateHomePageLink();
		
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
					<p id="' . ConstNames::registerMessageId . '">' . $message . '</p>
				
					<label for="' . ConstNames::registerName . '">Username :</label>
					<input type="text" id="' . ConstNames::registerName . '" name="' . ConstNames::registerName . '" value="' . $this->tryAddSavedInfo(ConstNames::registerName) . '" />

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

}