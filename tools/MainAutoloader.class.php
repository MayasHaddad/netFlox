<?php
/**
* This class loads all the classes of this project
* @author Mayas Haddad
*/
class MainAutoloader
{
	public static $initialContext;

	public static function init($initialContext)
	{
		MainAutoLoader::$initialContext = $initialContext;
		$classes = array(
			'Autoloader',
			'MainController.class',
			'SessionManager.class',
			'DatabaseManager.class',
			'Admin.class',
			'UserConnectionController.class'
			);
		
		array_walk($classes, 'MainAutoLoader::performRequire');
	}

	public static function performRequire($className)
	{
		if(file_exists($className . '.php'))
		{
			require_once($className . '.php');
			return;
		}

		if(file_exists(MainAutoLoader::$initialContext . 'tools/twig/Twig-1.14.2/lib/Twig/' . $className . '.php'))
		{
			require_once(MainAutoLoader::$initialContext . 'tools/twig/Twig-1.14.2/lib/Twig/' . $className . '.php');
			return;
		}

		if(file_exists(MainAutoLoader::$initialContext . 'controllers/' . $className . '.php'))
		{
			require_once(MainAutoLoader::$initialContext . 'controllers/' . $className . '.php');
			return;
		}

		if(file_exists(MainAutoLoader::$initialContext . 'model/' . $className . '.php'))
		{
			require_once(MainAutoLoader::$initialContext . 'model/' . $className . '.php');
			return;
		}
	}
}