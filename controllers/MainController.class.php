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

    function __construct($initialContext)
    {
    	$this->initialContext = $initialContext;
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->initialContext . 'templates'); // directory which contains the template files
        $this->twigInstance = new Twig_Environment($this->loader, array('cache' => false));
    }

    public function getTwigTemplateVariables()
    {
    	return array();
    }

    public function render($page)
    {
        echo $this->twigInstance->render($page . '.twig', $this->getTwigTemplateVariables());
    }
}