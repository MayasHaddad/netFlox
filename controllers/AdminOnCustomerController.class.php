<?php
/**
* This controller handles the user connection to the account and deconnection
* @author Mayas Haddad
*/
class AdminOnCustomerController
{
	function __construct()
    {
    	
    }

    public function printAllCustomers($mainController)
    {
    	$userConnectionController = new UserConnectionController();
    	echo "string";
    	if($userConnectionController->checkAdminData($_SESSION))
    	{
	    	$customer = new Customer();
    		var_dump($customer->getAllCustomers());
    		$mainController->setTwigTemplateVariables(array('connected' => true , 'customers' => $customer->getAllCustomers()));	
    	}
    }
}