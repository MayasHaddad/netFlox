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
        	$header = array('firstname', 'lastname', 'login', 'email', 'credit');
        	$data = $this->customer->getAllCustomers();
        	$this->pdfManager->getAuditPdf($header, $data, $period, $this->transaction->getTurnoverOnTransactions($period));
        }
    }
}