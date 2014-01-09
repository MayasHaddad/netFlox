<?php
/**
* This controller handles the customer interactions with other customers (or themselves)
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

    public function updateMyDataCustomer($postedData)
    {
        if($this->userConnectionController->checkCustomerData($this->session->getSessionVariable()))
        {
            if($postedData['oldPassword'] !== '' && $postedData['newPassword'] !== '' && $postedData['newPasswordConfirm'] !== '')
            {
                if($this->customer->getNumberOfCustomers($this->session->getSessionVariable('email'), $postedData['oldPassword']) === 0)
                {
                    $this->mainController->addTwigTemplateVariables(array('error' => 'Old password mismatch!'));
                    return;
                }
                if($postedData['newPassword'] !== $postedData['newPasswordConfirm'])
                {
                    $this->mainController->addTwigTemplateVariables(array('error' => 'New password mismatch!'));
                    return;
                }
            
                $this->customer->updatePassword($postedData['id-customer'], $postedData['newPassword']);
            }

            $this->customer->updateCustomer($postedData['id-customer'], $postedData);
            $this->mainController->addTwigTemplateVariables(array('notification' => 'Account successfully updated!'));
            return;
        }
        $this->mainController->addTwigTemplateVariables(array('error' => 'Missing field!'));
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