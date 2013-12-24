<?php
/**
* This controller handles the user connection to the account and deconnection
* @author Mayas Haddad
*/
class AdminOnCustomerController
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

    public function printAllCustomers()
    {
    	if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
    	{
    		$this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true, 'customers' => $this->customer->getAllCustomers()
                )
            );
    	}
    }

    public function printOneCustomer($idCustomer)
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true, 'customer' => $this->customer->getOneCustomer($idCustomer)
                )
            );
        }
    }

    public function removeCustommer($idCustomer)
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $this->customer->removeCustomer($idCustomer);

            $this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true, 'notification' => 'Customer successfully deleted !', 'customers' => $this->customer->getAllCustomers()
                )
            );
        }
    }

    public function addACustomerForm()
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true
                )
            );
        }
    }
    
    public function updateCustommerData($idCustomer, $newCustomerData)
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $this->customer->updateCustomer($idCustomer, $newCustomerData);

            $this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true, 'notification' => 'Customer successfully updated !', 'customers' => $this->customer->getAllCustomers()
                )
            );
        }
    }
}