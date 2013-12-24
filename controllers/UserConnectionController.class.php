<?php
/**
* This controller handles the user connection to the account and deconnection
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
    	
    	if(isset($postedData['email'], $postedData['password']))
    	{
    		return ($admin->getNumberOfAdmins($postedData['email'], $postedData['password']) === 1);	
    	}
    	
    	return false;
    }

	public function handleAdminConnection($postedData, $mailControllerInstance)
	{
		if($this->checkAdminData($postedData) === true)
		{
			$this->sessionManager->newOrResetSession($postedData);

			$mailControllerInstance->setTwigTemplateVariables(array('connected' => true));
		}
	}

	public function handleCustomerConnection($postedData)
	{
		
	}
}