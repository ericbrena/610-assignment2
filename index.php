<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/MainController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$dtv = new DateTimeView();
$lv = new LayoutView();
$authentication = new MainController();


$authentication->handleRequest();

$userLoggedIn = $authentication->getLoggedInStatus();
$htmlString = $authentication->getHTML();

$lv->render($userLoggedIn, $htmlString, $dtv);

