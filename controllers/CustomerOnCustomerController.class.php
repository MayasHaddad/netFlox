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

    public function getMyId()
    {
        return $this->customer->getId(
            $this->session->getSessionVariable('email'),
            $this->session->getSessionVariable('password')
        )[0];
    }

    public function offerCredit($idLuckyCustomer, $creditAmount)
    {
    	$idGenerousCustomer = $this->getMyId();
        
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
            $this->mainController->addTwigTemplateVariables(array('notification' => 'Credit successfully offered!'));
        }
    }

    public function getSearchCustomerForm()
    {
        if($this->userConnectionController->checkCustomerData($this->session->getSessionVariable()))
        {
            $this->mainController->addTwigTemplateVariables(array('connected' => true, 'searchCustomerForm' => true));   
        }
    }

    public function showCustomerByLogin($login)
    {   
        if($this->userConnectionController->checkCustomerData($this->session->getSessionVariable()))
        {
    	   $this->mainController->addTwigTemplateVariables(array('connected' => true, 'showCustomers' => true, 'customers' => $this->customer->getCustomerByLogin($login)));
        }	
    }

    public function printMyDataCustomer()
    {
        if($this->userConnectionController->checkCustomerData($this->session->getSessionVariable()))
        {
            $this->mainController->addTwigTemplateVariables(
                array(
                    'connected' => true, 'customer' => $this->customer->getOneCustomer($this->getMyId())
                )
            );
        }
    }
}