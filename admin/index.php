<?php
/**
* This code is browsed by default at the very begining of administration panel
* @author Mayas Haddad
*/

$initialContext = "../";
include_once($initialContext . 'tools/MainAutoloader.class.php');

MainAutoloader::init($initialContext);

$mainController = new MainController($initialContext);


// One or a set of these listeners are triggered when the post/get variables match
$mainController->adminConnectionListener($_POST);

$mainController->adminSeeAllCustomersListener($_GET);

$mainController->adminSeeOneCustomerListener($_GET);

$mainController->adminRemoveCustomerListener($_GET);

$mainController->adminUpdateCustomerListener($_POST);

$mainController->customerSignUpFormListener($_GET);

$mainController->customerSignUpActionListener($_POST);

$mainController->addNewMovieForm($_GET);

$mainController->addNewMovie($_POST, $initialContext);

$mainController->adminAuditStatsFormListenner($_GET);

$mainController->adminAuditStatsListenner($_POST);

$mainController->adminCatalogueStatsListenner($_GET, $initialContext);

$mainController->deconnectionListener($_GET);

$mainController->adminStillSignedIn();

$mainController->render("admin/index");