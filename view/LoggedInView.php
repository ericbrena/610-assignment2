<?php

require_once("model/ConstNames.php");

class LoggedInView {

	public function generateHTMLbody($message) {
		$response = $this->generateLogoutButtonHTML($message);
		$response .= $this->generateNewGameButtonHTML();
		
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
				<p id="' . ConstNames::messageId . '">'. $message .'</p>
				<input type="submit" name="' . ConstNames::logout . '" value="logout"/>
			</form>
		';
	}

	private function generateNewGameButtonHTML() {
		return '
			<form  method="post" >
				<input type="submit" name="' . ConstNames::newGame . '" value="new game"/>
			</form>
		';
	}
}