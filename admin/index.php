<?php
/**
* This code is browsed by default at the very begining
* @author Mayas Haddad
*/
$initialContext = "../";
include_once($initialContext . 'tools/MainAutoloader.class.php');
MainAutoloader::init($initialContext);
$mainController = new MainController($initialContext);
//$mainController->listen("sign-up");
/*$sm = new SessionManager(array('idCustomer' => 5));
$sm->newOrResetSession();*/
$mainController->adminConnectionListener($_POST);
$mainController->render("admin/index");