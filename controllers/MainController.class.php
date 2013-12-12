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
    
    protected $twigTemplateVariablesArray;
    protected $adminOnCustomerController;

    function __construct($initialContext)
    {
    	$this->initialContext = $initialContext;
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->initialContext . 'templates'); // directory which contains the template files
        $this->twigInstance = new Twig_Environment($this->loader, array('cache' => false));
        
        $this->userConnectionController = new UserConnectionController();
        $this->adminOnCustomerController = new AdminOnCustomerController();

        $this->twigTemplateVariablesArray = array();
    }

    public function setTwigTemplateVariables($twigTemplateVariablesArray)
    {
        $this->twigTemplateVariablesArray = $twigTemplateVariablesArray;
    }

    public function getTwigTemplateVariables()
    {
        return $this->twigTemplateVariablesArray;
    	//return array('customers' => array( '1' => array( 'lastname' => 'aa', 'firstname' => 'bb' ), '2' => array( 'lastname' => 'cc', 'firstname' => 'aaa') ) );
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
            $this->setTwigTemplateVariables(array('signUp' => true));
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
                    $postData['account-credit']
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
                $postData['account-credit']);
        }
    }

    // Admin controllers
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
        if(isset($getData['see-cutomers']))
        {
            $this->adminOnCustomerController->seeAllCustomers($this);
        }
    }
}