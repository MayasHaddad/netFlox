<?php
/**
* This code is browsed by default at the very begining
* @author Mayas Haddad
*/
$initialContext = "./";
include_once($initialContext . 'tools/MainAutoloader.class.php');
MainAutoloader::init($initialContext);
$mainController = new MainController($initialContext);
//$mainController->listen("sign-up");
$mainController->customerSignUpFormListener($_GET);
$mainController->customerSignUpActionListener($_POST);

$mainController->addNewMovie($_POST);
$mainController->searchOneMovieByName($_POST);

$mainController->render("index");