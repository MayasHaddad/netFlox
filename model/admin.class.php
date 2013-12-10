<?php
/**
* This model is responsible of admin data management (using PDO)
* @author Mayas Haddad
*/
class Admin
{
	protected $dataBaseConnection;

	function __construct()
	{
		$this->dataBaseConnection = DatabaseManager::getDatabaseConnection();
	}

	function getAdminData($email, $password)
	{
		$statement = $this->dataBaseConnection->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");
		$statement->execute(array(':email' => $email, ':password' => md5($password)));

		return $statement->fetch();
	}

	function getNumberOfAdmins($email, $password)
	{
		$statement = $this->dataBaseConnection->prepare("SELECT COUNT(*) FROM admin WHERE email = :email AND password = :password");
		$statement->execute(array(':email' => $email, ':password' => md5($password)));

		return (int) $statement->fetch()[0];
	}
}
/* This script creates a new admin 
$dbc = DatabaseManager::getDatabaseConnection();
$dbc->exec("INSERT INTO admin(email, password) VALUES('admin@example.com', '" . md5('pass') . "')");
*/