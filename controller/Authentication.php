<?php

require_once("model/UserProfile.php");

class Authentication {
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $logout = 'LoginView::Logout';
    private static $sessionId = "SessionId::Status";
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

    public function attemptAuthenticate() {

        if(isset($_POST[self::$name]) && isset($_POST[self::$password])) {
            $fileData = $this->getReadableDatabaseInfo();
        
            //iterate for a match, return empty string if found
            for($i = 0; $i < count($fileData); $i++) {
                if($_POST[self::$name] === $fileData[$i]->name && $_POST[self::$password] === $fileData[$i]->password) {

                    $_SESSION[self::$sessionId] = true;

                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function getUsersLoginStatus() {
        return $_SESSION[self::$sessionId];
    }

    public function attemptLogout() {
        return isset($_REQUEST[self::$logout]);
    }

    /**
	* Controls users authentication form
	* @return string, Empty if there were no error authenticating!
	*/
    public function controlLoginInput() {
        
        //controls the inputs filled in
        if($_POST[self::$name] === "") {
            return "Username is missing";
        }
        if($_POST[self::$password] === "") {
            return "Password is missing";
        }
        
        if($this->attemptAuthenticate()) {
            return "Welcome";
        }
        
        return "Wrong name or password";
    }

    public function logout() {
        $_SESSION[self::$sessionId] = false;
    }

}