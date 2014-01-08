<?php
/**
* This main controller is always called and will call the necessary specific controller
* @author Mayas Haddad
*/
class MainController
{
    protected $loader;
    protected $twigInstance;
    protected $initialContext;

    protected $userConnectionController;
    protected $adminOnCustomerController;
    protected $adminOnStatisticsController;

    protected $customerOnCustomerController;
    protected $customerOnMovieController;

    protected $twigTemplateVariablesArray;

    function __construct($initialContext)
    {
    	$this->initialContext = $initialContext;

        Twig_Autoloader::register();
        
        $this->loader = new Twig_Loader_Filesystem($this->initialContext . 'templates'); // directory which contains the template files
        $this->twigInstance = new Twig_Environment($this->loader, array('cache' => false));

        $this->userConnectionController = new UserConnectionController();

        $this->adminOnCustomerController = new AdminOnCustomerController($this);

        $this->adminOnMovieController = new AdminOnMovieController($this, $initialContext);
        
        $this->adminOnStatisticsController = new AdminOnStatisticsController();
        
        $this->customerOnCustomerController = new CustomerOnCustomerController($this);

        $this->customerOnMovieController = new CustomerOnMovieController($this, $initialContext);

        $this->twigTemplateVariablesArray = array();

        $this->addTwigTemplateVariables(array('initialContext' => $initialContext));
    }

    private function setTwigTemplateVariables($twigTemplateVariablesArray)
    {
        $this->twigTemplateVariablesArray = $twigTemplateVariablesArray;
    }

    public function getTwigTemplateVariables()
    {
        return $this->twigTemplateVariablesArray;
    	//return array('customers' => array( '1' => array( 'lastname' => 'aa', 'firstname' => 'bb' ), '2' => array( 'lastname' => 'cc', 'firstname' => 'aaa') ) );
    }

    public function addTwigTemplateVariables($variableArrayToAdd)
    {
        $twigVariablesArray = $this->getTwigTemplateVariables();
        
        foreach ($variableArrayToAdd as $key => $value) {

            if(array_key_exists($key, $twigVariablesArray) === false)
            {
                $twigVariablesArray[$key] = $value;
            }
        }

        $this->setTwigTemplateVariables($twigVariablesArray);
    }

    public function render($page)
    {
        /*   $admin = new Admin();
        $sm = new SessionManager($admin->getAdminData('admin@example.com', 'pass'));
        $sm->newOrResetSession();
        echo $sm->getSessionVariable('email');
        var_dump($_SESSION);*/
        echo $this->twigInstance->render($page . '.twig', $this->getTwigTemplateVariables());
    }
    
    // Customer controllers 
    
    public function customerSignUpFormListener($getData)
    {
        if(isset($getData['sign-up'])){
            
            $this->addTwigTemplateVariables(array('signUp' => true));
            
            $this->adminOnCustomerController->addACustomerForm();
        }
    }

    public function customerSignUpActionListener($postData)
    {
        if(isset(
                    $postData['sign-up'],
                    $postData['lastname'], 
                    $postData['firstname'], 
                    $postData['mail-address'], 
                    $postData['login'], 
                    $postData['password'], 
                    $postData['confirm-password'], 
                    $postData['credit']
                )
                &&
                $postData['password'] == $postData['confirm-password']
            ) {

            $customer = new Customer();
            $customer->createNewCustomer(
                $postData['login'],
                $postData['lastname'], 
                $postData['firstname'], 
                $postData['mail-address'], 
                $postData['password'],
                $postData['credit']);
        }
    }

    public function customerConnectionListener($postData)
    {
        if(isset($postData['email'], $postData['password']))
        {
            $this->userConnectionController->handleCustomerConnection($postData, $this);
        }
        return;
    }

    public function customerOfferCredit($postData)
    {
        if(isset($postData['id-customer'], $postData['amount'], $postData['offer-credit']))
        {
            $this->customerOnCustomerController->offerCredit($postData['id-customer'], $postData['amount']);   
        }
    }

    public function customerSearchCustomerForm($getData)
    {
        if(isset($getData['search-customer']))
        {
            $this->customerOnCustomerController->getSearchCustomerForm();
        }
    }

    public function customerSeeCustomersByLogin($postData)
    {
        if(isset($postData['customerLogin'], $postData['searchCustomer']))
        {
            $this->customerOnCustomerController->showCustomerByLogin($postData['customerLogin']);
        }
    }

    public function customerBuyMovie($getData)
    {
        if(isset($getData['buy-movie'], $getData['id-movie'], $getData['price']))
        {
           $this->customerOnMovieController->buyMovie($getData['id-movie'], $getData['price']);
        }
    }

    public function customerUpdateMyProfile($getData)
    {
        if(isset($getData['update-profile']))
        {
           $this->customerOnCustomerController->printMyDataCustomer();
        }
    }
    // mixed controllers
    public function deconnectionListener($getData)
    {
        if(isset($getData['sign-out']))
        {
            $this->userConnectionController->handleUserDeconnection();
        }
    }

    public function customerStillSignedIn()
    {
        $this->userConnectionController->customerStillSignedIn($this);
    }

    // Admin controllers
    
    public function adminStillSignedIn()
    {
        $this->userConnectionController->adminStillSignedIn($this);
    }

    public function adminConnectionListener($postData)
    {
        if(isset($postData['email'], $postData['password']))
        {
            $this->userConnectionController->handleAdminConnection($postData, $this);
        }
        return;
    }

    public function adminSeeAllCustomersListener($getData)
    {
        if(isset($getData['see-customers']))
        {
            $this->adminOnCustomerController->printAllCustomers();
        }
    }

    public function adminSeeOneCustomerListener($getData)
    {
        if(isset($getData['see-one-customer'], $getData['id-customer']))
        {
            $this->adminOnCustomerController->printOneCustomer($getData['id-customer']);
        }
    }

    public function adminRemoveCustomerListener($getData)
    {
        if(isset($getData['remove-customer'], $getData['id-customer']))
        {
            $this->adminOnCustomerController->removeCustommer($getData['id-customer']);
        }
    }

    public function adminUpdateCustomerListener($postData)
    {
        if(isset($postData['update-customer'], $postData['id-customer']))
        {
            $this->adminOnCustomerController->updateCustommerData($postData['id-customer'], $postData);
        }
    }

    public function adminAuditStatsListenner($postedData)
    {
        if(isset($postedData['get-audit'], $postedData['period']))
        {
            $this->adminOnStatisticsController->getAuditStatistics($postedData['period']); 
        }
    }

    public function adminAuditStatsFormListenner($getData)
    {
        if(isset($getData['audit']))
        {
            $this->addTwigTemplateVariables(array('auditForm' => true));
        }
    }
	//Movie controllers
	
    public function addNewMovieForm($getData)
    {
        if(isset($getData['add-movie']))
        {
            $this->adminOnMovieController->getAddMovieForm();   
        }
    }

	public function addNewMovie($postData, $initialContext)
	{
		if(isset(
						$postData['title'],
						$postData['day'], 
						$postData['month'], 
						$postData['year'], 
						$postData['description'], 
						$postData['actor'], 
						$postData['director'],
                        $postData['price'],
                        $postData['priceRent']
				)
			) {
				$movieEngine = new MovieEngine($initialContext);
				$movieEngine->addMovie(
					$postData['title'],
					$postData['day'], 
					$postData['month'], 
					$postData['year'], 
					$postData['description'], 
					$postData['actor'],
					$postData['director'],
                    $postData['price'],
                    $postData['priceRent']);
			}
	}
	
	public function searchOneMovieByName($postData, $initialContext)
	{
		if(isset($postData['movieName'])) {
				$movieEngine = new MovieEngine($initialContext);
				try{
				$movieName = $movieEngine->getMovieByName(
					$postData['movieName']
					);
				    $this->addTwigTemplateVariables($movieName);
                    $this->addTwigTemplateVariables(array('searchMovie' => true));
				}
				catch(Exception $e){echo "Le Film n'exste pas";}
			}	
	}

    public function searchMovieForm($getData)
    {
        if(isset($getData['search-movie']))
        {
            $this->addTwigTemplateVariables(array('searchMovieForm' => true));
        }
    }
}