<?php
/**
* This model is handles the user connection to the account and deconnection
* @author Mayas Haddad
*/
class UserConnectionController
{
	protected $sessionManager;

	function __construct()
    {
    	$this->sessionManager = new SessionManager();
    }

    public function checkAdminData($postedData)
    {
    	$admin = new Admin();
    	return (sizeof($admin->getAdminData($postedData['email'], $postedData['password'])) > 0);
    }

	public function handleAdminConnection($postedData, $mailControllerInstance)
	{
		if($this->checkAdminData($postedData))
		{
			$this->sessionManager->newOrResetSession();
			$mailControllerInstance->setTwigTemplateVariables(array('connected' => true));
		}
	}

	public function handleCustomerConnection($postedData)
	{

	}
}