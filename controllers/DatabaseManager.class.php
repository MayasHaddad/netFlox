<?php
/**
* This controller is responsible of database management (using PDO)
* @author Mayas Haddad
*/
class DatabaseManager
{
	static protected $dsn = 'mysql:host=localhost;dbname=netflox';
	static protected $username = 'root';
	static protected $password = '';

	function __construct()
	{

	}

	static function getDatabaseConnection()
	{
		return new PDO(self::$dsn, self::$username, self::$password);
	}
}