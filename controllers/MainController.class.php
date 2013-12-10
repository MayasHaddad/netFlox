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

    function __construct($initialContext)
    {
    	$this->initialContext = $initialContext;
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->initialContext . 'templates'); // directory which contains the template files
        $this->twigInstance = new Twig_Environment($this->loader, array('cache' => false));
        
        $this->userConnectionController = new UserConnectionController();

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

    public function adminConnectionListener($postData)
    {
        if(isset($postData['email'], $postData['password']))
        {
            $this->userConnectionController->handleAdminConnection($postData, $this);
        }
        return;
    }
}