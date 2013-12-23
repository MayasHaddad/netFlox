<?php
/**
* This code is browsed by default at the very begining
* @author Mayas Haddad
*/
$initialContext = "../";
include_once($initialContext . 'tools/MainAutoloader.class.php');

MainAutoloader::init($initialContext);

$mainController = new MainController($initialContext);

$mainController->adminConnectionListener($_POST);

$mainController->adminSeeAllCustomersListener($_GET);
$mainController->addNewMovie($_POST);

$mainController->adminRemoveCustomerListener($_GET);

$mainController->render("admin/index");