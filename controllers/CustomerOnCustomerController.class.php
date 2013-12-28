<?php
/**
* This controller handles the customer interactions with other customers
* @author Mayas Haddad
*/
class CustomerOnCustomerController
{
	protected $userConnectionController;
    protected $session;
    protected $customer;
    protected $mainController;

	function __construct($mainController)
    {
    	$this->userConnectionController = new UserConnectionController();
        
        $this->session = new SessionManager();

        $this->customer = new Customer();

        $this->mainController = $mainController;
    }

    public function offerCredit($idLuckyCustomer, $creditAmount)
    {
    	$idGenerousCustomer = $this->customer->getId(
	    	$this->session->getSessionVariable('email'),
	    	$this->session->getSessionVariable('password')
	    )[0];

    	if
    	(
    		$this->userConnectionController->checkCustomerData($this->session->getSessionVariable())
    		&&
    		$this->customer->getAccountCredit($idGenerousCustomer) >= $creditAmount
    	)
        {
        	$this->customer->accountCreditTransaction(
        		$idGenerousCustomer,
    			$idLuckyCustomer,
    			$creditAmount
    		);
        }
    }
}