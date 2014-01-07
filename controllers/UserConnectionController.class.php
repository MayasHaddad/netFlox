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

    public function checkCustomerData($postedData)
    {
    	$customer = new Customer();
    	
    	if(isset($postedData['email'], $postedData['password']))
    	{
    		return ($customer->getNumberOfCustomers($postedData['email'], $postedData['password']) === 1);	
    	}
    	
    	return false;
    }

	public function handleAdminConnection($postedData, $mainControllerInstance)
	{
		if($this->checkAdminData($postedData) === true)
		{
			$this->sessionManager->newOrResetSession($postedData);

			$mainControllerInstance->addTwigTemplateVariables(array('connected' => true));
		}
	}

	public function handleCustomerConnection($postedData, $mainControllerInstance)
	{
		if($this->checkCustomerData($postedData) === true)
		{
			$this->sessionManager->newOrResetSession($postedData);

			$mainControllerInstance->addTwigTemplateVariables(array('connected' => true));

			return;
		}
		$mainControllerInstance->addTwigTemplateVariables(array('error' => 'Unable to authentificate'));
	}

	public function adminStillSignedIn($mainControllerInstance)
	{
		if($this->checkAdminData($this->sessionManager->getSessionVariable()) === true)
		{
			$mainControllerInstance->addTwigTemplateVariables(array('connected' => true));
		}
	}

	public function customerStillSignedIn($mainControllerInstance)
	{
		if($this->checkCustomerData($this->sessionManager->getSessionVariable()) === true)
		{
			$mainControllerInstance->addTwigTemplateVariables(array('connected' => true));
		}
	}

	public function handleUserDeconnection()
	{
		$this->sessionManager->endSession();
	}
}