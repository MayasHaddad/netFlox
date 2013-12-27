<?php
/**
* This controller is responsible of session management
* @author Mayas Haddad
*/
class SessionManager
{
	function __construct($sessionVariables = array())
    {
    }

	public function newOrResetSession($posteData)
	{
		if(session_status() === PHP_SESSION_ACTIVE)
		{
			$this->endSession();
		}

		session_start();
		$_SESSION = $posteData;
	}

	public function endSession()
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}

		session_unset();
		session_destroy();
	}

	public function getSessionVariable($sessionVariableName = null)
	{	

		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}

		if($sessionVariableName)
		{
			return $_SESSION[$sessionVariableName];	
		}
		return $_SESSION;
	}
}