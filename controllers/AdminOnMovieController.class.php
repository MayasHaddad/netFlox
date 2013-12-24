<?php
/**
* This controller handles the admin manipulations on movies
* @author Mayas Haddad
*/
class AdminOnMovieController
{
    protected $userConnectionController;
    protected $session;
    protected $movieEngine;
    protected $mainController;

	function __construct($mainController)
    {
    	$this->userConnectionController = new UserConnectionController();
        
        $this->session = new SessionManager();

        $this->movieEngine = new MovieEngine();

        $this->mainController = $mainController;
    }

    public function getAddMovieForm()
    {
        if($this->userConnectionController->checkAdminData($this->session->getSessionVariable()))
        {
            $this->mainController->addTwigTemlateVariables(
                array(
                    'connected' => true, 'addMovie' => true
                )
            );
        }
    }

}