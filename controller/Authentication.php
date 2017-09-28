<?php

require_once("model/UserProfile.php");

class Authentication {
	private static $logout = 'LoginView::Logout';
    private static $sessionId = "Session::Status";
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';

    private static $databaseFile = "model/database.txt";
	private static $url = "http://eb223fz.000webhostapp.com";

    /**
	* Reads from the database, which is a txt file
	* IMPORTANT! this is not a permament way to handle database, only a temporary solution to assignment
	* @return array, the array contains UserProfile classes
	*/
    private function getReadableDatabaseInfo() {
        
        //reads from txt file
        $fileData = file_get_contents(self::$databaseFile, "r");
        
        //make it a readable array
        $readableFileData = unserialize($fileData);
        
        return $readableFileData;
    }

    /**
    * It will compare post name and password to database and set session to true if it found a match
    * @return boolean
    */
    public function attemptAuthenticate() {

        if(isset($_POST[self::$name]) && isset($_POST[self::$password])) {
            $fileData = $this->getReadableDatabaseInfo();
        
            //iterate for matching credentials
            for($i = 0; $i < count($fileData); $i++) {
                if($_POST[self::$name] === $fileData[$i]->name && $_POST[self::$password] === $fileData[$i]->password) {

                    $_SESSION[self::$sessionId] = true;

                    return true;
                }
            }
        }
        return false;
    }

    /**
    * It will control if user is logged in, if user is not it will declare a session and set to false
    * IMPORTANT! it assumes the sessionid is a boolean and returns the value as a representation to the users login status
    * @return boolean
    */
    public function getUsersLoginStatus() {
        if(isset($_SESSION[self::$sessionId]) === false) {
            $_SESSION[self::$sessionId] = false;
        }
        return $_SESSION[self::$sessionId];
    }

    /**
    * It controls if the user is attempting to logout
    * @return boolean
    */
    public function attemptLogout() {
        return isset($_REQUEST[self::$logout]);
    }

    /**
	* Controls users login form
	* @return string
	*/
    public function controlLoginInput() {
        
        //saves users log in info to print to username input
        $_SESSION[self::$name] = $_POST[self::$name];

        //controls the inputs filled in
        if($_POST[self::$name] === "") {
            return "Username is missing";
        }
        if($_POST[self::$password] === "") {
            return "Password is missing";
        }
        
        if($this->attemptAuthenticate(self::$name, self::$password)) {
            return "Welcome";
        }
        
        return "Wrong name or password";
    }

    /**
    * It will compare ONLY name to database and return false if name is occupied
    * @param id of post
    */
    private function compareRegisterToDatabase($name) {
        $fileData = $this->getReadableDatabaseInfo();
        
        //iterate for matching credentials
        for($i = 0; $i < count($fileData); $i++) {
            if($_POST[$name] === $fileData[$i]->name) {
                return false;
            }
        }
        return true;
    }

    /**
    * It will take name and password from post and add them to database
    */
    private function addRegisterToDatabase($name, $password) {

        //create array of database and add new profile
        $fileData = $this->getReadableDatabaseInfo();
        $fileData[] = new UserProfile($_POST[$name], $_POST[$password]);

        //make the array to a string to add to database
        $fileData = serialize($fileData);
        file_put_contents(self::$databaseFile, $fileData);
    }

    /**
    * Controls users register form
    * @return string, containing message of the result of control
    */
    public function controlRegisterInput($name, $password, $passwordRepeat) {
        $message = "";

        $_SESSION[$name] = filter_var($_POST[$name], FILTER_SANITIZE_STRING);

        //controls correct input 
        if(strlen($_POST[$name]) < 3) {
            $message .= " Username has too few characters, at least 3 characters.";
        }
        if(strlen($_POST[$password]) < 6) {
            $message .= " Password has too few characters, at least 6 characters.";
        }
        if($message === "" && $_POST[$password] !== $_POST[$passwordRepeat]) {
            $message .= "Passwords do not match.";
        }

        //control for string with bad characters
        $controlledName = $this->controlPostString($name);
        $controlledPassword = $this->controlPostString($password);
        if($controlledName === false) {
            $message .= "Username contains invalid characters.";
        } 
        else if ($controlledPassword === false) {
            $message .= "Password contains invalid characters.";
        }
        //if no errors above it will compare request to database
        else if($message === "" && $this->compareRegisterToDatabase($name)) {
            $this->addRegisterToDatabase($name, $password);
            header('Location: ' . self::$url);
        } 
        else if($message === "") {
            $message .= "User exists, pick another username.";
        }

        return $message;
    }

    /**
    * Controls post with given id if string with bad characters
    */
    private function controlPostString($id) {
        $newString = filter_var($_POST[$id], FILTER_SANITIZE_STRING);
        if($newString === $_POST[$id]) {
            return true;
        }
        return false;
    }

    public function logout() {
        $_SESSION[self::$sessionId] = false;
    }

}