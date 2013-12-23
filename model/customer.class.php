<?php
/**
* This model is responsible of admin data management (using PDO)
* @author Mayas Haddad
*/
class Customer
{
	protected $dataBaseConnection;

	function __construct()
	{
		$this->dataBaseConnection = DatabaseManager::getDatabaseConnection();
	}

	public function createNewCustomer($login, $lastname, $firstname, $email, $password, $credit){

		$statement = $this->dataBaseConnection->prepare(
			"INSERT INTO customer(login, lastname, firstname, email, password, credit)
			VALUES (:login, :lastname, :firstname, :email, :password, :credit)"
		);

		$statement->execute(
			array(
				':login' => $login,
				':lastname' => $lastname,
				':firstname' => $firstname,
				':email' => $email,
				':password' => md5($password),
				':credit' => $credit
			)
		);
	}

	public function removeCustomer($idCustomer)
	{
		$statement = $this->dataBaseConnection->prepare(
			"DELETE FROM customer WHERE id_customer = :idCustomer"
		);

		$statement->execute(
			array(
				':idCustomer' => $idCustomer
			)
		);
	}

	public function getAllCustomers()
	{
		return $this->dataBaseConnection->query("SELECT id_customer, login, lastname, firstname, email, credit FROM customer");
	}
}