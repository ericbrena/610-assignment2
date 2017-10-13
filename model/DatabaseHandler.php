<?php

require_once("ConstNames.php");
require_once("UserProfile.php");

class DatabaseHandler {
    
    /**
    * Reads from the database, which is a txt file
    * IMPORTANT! this is not a permament way to handle database, only a temporary solution to assignment
    * @return array, the array contains UserProfile classes
    */
    private function getReadableDatabaseInfo() {
        
        //reads from txt file
        $fileData = file_get_contents(ConstNames::databaseFile, "r");
        
        //make it a readable array
        $readableFileData = unserialize($fileData);
        
        return $readableFileData;
    }

    /**
    * Will compare information give in parameter to database
    * @return boolean, true if succesful match
    */
    public function attemptAuthenticate($name, $password) {
        $fileData = $this->getReadableDatabaseInfo();
        
        if(gettype($fileData) === gettype(array())) {   
            //iterate for matching credentials
            for($i = 0; $i < count($fileData); $i++) {
                if($name === $fileData[$i]->name && $password === $fileData[$i]->password) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
    * Will compare information give in parameter to database
    * @return boolean, true if no username found
    */
    public function compareRegisterToDatabase($name) {
        $fileData = $this->getReadableDatabaseInfo();
        
        if(gettype($fileData) === gettype(array())) {
            //iterate for matching credentials
            for($i = 0; $i < count($fileData); $i++) {
                if($name === $fileData[$i]->name) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
    * It will take variables from parameter and add them to database
    */
    public function addRegisterToDatabase($name, $password) {
        
        //create array of database and add new profile
        $fileData = $this->getReadableDatabaseInfo();
        $fileData[] = new UserProfile($name, $password);
        
        //make the array to a string to add to database
        $fileData = serialize($fileData);
        file_put_contents(ConstNames::databaseFile, $fileData);
    }
}
