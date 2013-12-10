<?php
/**
* This controller is responsible of session management
* @author Mayas Haddad
*/
class SessionManager
{
	protected $sessionVariables;

	function __construct($sessionVariables = array())
    {
    	$this->sessionVariables = $sessionVariables;
    }

	public function newOrResetSession()
	{
		if(session_status() === PHP_SESSION_ACTIVE)
		{
			$this->endSession();
		}
		session_start();
	}

	public function endSession()
	{
		session_destroy();
	}

	public function getSessionVariable($sessionVariableName)
	{
		if(session_status() === PHP_SESSION_ACTIVE)
		{
			return $_SESSION[$sessionVariableName];
		}
		throw new Exception("Could not get session variable, no active session active session", 1);
	}
}