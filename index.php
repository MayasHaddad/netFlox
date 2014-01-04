<?php
/**
* This code is browsed by default at the very begining
* @author Mayas Haddad
*/
$initialContext = "./";
include_once($initialContext . 'tools/MainAutoloader.class.php');
MainAutoloader::init($initialContext);
$mainController = new MainController($initialContext);

$mainController->customerConnectionListener($_POST);

$mainController->customerSignUpFormListener($_GET);

$mainController->customerSignUpActionListener($_POST);

$mainController->searchOneMovieByName($_POST, $initialContext);

$mainController->customerOfferCredit($_POST);

$mainController->customerSearchCustomerForm($_GET);

$mainController->customerSeeCustomersByLogin($_POST);

$mainController->deconnectionListener($_GET);

$mainController->customerStillSignedIn();

$mainController->render("index");