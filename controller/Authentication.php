<?php

require_once("model/UserProfile.php");

class Authentication {
	private static $logout = 'LoginView::Logout';
    private static $sessionId = "Session::Status";

    private static $databaseFile = "model/database.txt";

    /**
	* Reads from the database, which is a txt file
	* IMPORTANT! this is not a permament way to handle database, only a temporary solution to assignment
	* @return array, the array contains UserProfile classes
	*/
    private function getReadableDatabaseInfo() {
        
        //reads from txt file
        $fileData = file_get_contents(self::$databaseFile, "r");
        
        //make it a readable array containing UserProfile classes
        $readableFileData = unserialize($fileData);
        
        return $readableFileData;
    }

    public function attemptAuthenticate($name, $password) {

        if(isset($_POST[$name]) && isset($_POST[$password])) {
            $fileData = $this->getReadableDatabaseInfo();
        
            //iterate for a match, return empty string if found
            for($i = 0; $i < count($fileData); $i++) {
                if($_POST[$name] === $fileData[$i]->name && $_POST[$password] === $fileData[$i]->password) {

                    $_SESSION[self::$sessionId] = true;

                    return true;
                }
            }
        }
        return false;
    }

    public function getUsersLoginStatus() {
        if(isset($_SESSION[self::$sessionId]) === false) {
            $_SESSION[self::$sessionId] = false;
        }
        return $_SESSION[self::$sessionId];
    }

    public function attemptLogout() {
        return isset($_REQUEST[self::$logout]);
    }

    /**
	* Controls users login form
	* @return string
	*/
    public function controlLoginInput($name, $password) {
        
        //controls the inputs filled in
        if($_POST[$name] === "") {
            return "Username is missing";
        }

        if($_POST[$password] === "") {
            return "Password is missing";
        }
        
        if($this->attemptAuthenticate($name, $password)) {
            return "Welcome";
        }
        
        return "Wrong name or password";
    }

    public function controlRegisterInput($name, $password) {
        $message = "";
        if(strlen($_POST[$name]) < 3) {
            $message .= " Username has too few characters, at least 3 characters.";
        }

        if(strlen($_POST[$password]) < 6) {
            $message .= " Password has too few characters, at least 6 characters.";
        }
        return $message;
    }

    public function logout() {
        $_SESSION[self::$sessionId] = false;
    }

}