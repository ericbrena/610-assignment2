<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/BodyView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/Authentication.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new BodyView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$authentication = new Authentication();

$userStatus = true;
if($authentication->attemptLogout()) {
    $authentication->logout();
    $userStatus = false;
}
else if($authentication->getUsersLoginStatus() === false) {
    $userStatus = $authentication->attemptAuthenticate();
}

$lv->render($userStatus, $v, $dtv);

