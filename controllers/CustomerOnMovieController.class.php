<?php
/**
* This controller handles the customer manipulations on movies
* @author Mayas Haddad
*/
class CustomerOnMovieController
{
    protected $userConnectionController;
    protected $session;
    protected $movieEngine;
    protected $customer;
    protected $mainController;

	function __construct($mainController, $initialContext)
    {
    	$this->userConnectionController = new UserConnectionController();
        
        $this->session = new SessionManager();

        $this->movieEngine = new MovieEngine($initialContext);

        $this->customer = new Customer();

        $this->mainController = $mainController;
    }

    public function buyMovie($idMovie, $price)
    {
        $customerData = $this->customer->getCustomerByLogin($this->session->getSessionVariable('email'))[0];
            
        if(
            $this->userConnectionController->checkCustomerData($this->session->getSessionVariable())
            &&
            $customerData['credit'] >= $price
            )
        {
            $idCustomer = $customerData['id_customer'];

           if($this->customer->buyMovie($idCustomer, $idMovie, $price) === true)
           {
                $this->mainController->addTwigTemplateVariables(array('notification' => 'You have successfully bought this movie!'));
                $this->customer->retrieveFromAccount($idCustomer, $price); 
                return;
           }
        }
        $this->mainController->addTwigTemplateVariables(array('error' => 'Couldn\'t buy this movie, maybe you own it already, or you don\'t have enough credit'));
    }
}