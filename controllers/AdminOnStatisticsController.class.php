<?php
/**
* This class manages all the PDF related treatments
* @author Mayas Haddad
*/
class AdminOnStatisticsController
{
	protected $userConnectionController;
    protected $session;
    protected $pdfManager;
    protected $customer;
    protected $transaction;

	function __construct()
    {
    	$this->userConnectionController = new UserConnectionController();
        
        $this->session = new SessionManager();

        $this->pdfManager = new PdfManager();

        $this->customer = new Customer();

        $this->transaction = new Transaction();
    }

    public function getAuditStatistics($period)
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
        	$outputStat = '';
        	$header = array('login', 'lastname', 'firstname', 'email', 'credit');
        	$data = $this->customer->getAllCustomers();
        	$this->pdfManager->getAuditPdf($header, $data, $period, $this->transaction->getTurnoverOnTransactions($period));
        }
    }

    public function getCatalogueStatistics($movieEngine)
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $header = array('title', 
            'description', 
            'actors', 
            'directors', 
            'date', 
            'price', 
            'priceRent',
            'idMovie');
            $this->pdfManager->getCataloguePdf($header, $movieEngine->getAllMovies());
        }
    }
}