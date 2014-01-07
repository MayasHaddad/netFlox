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

	public function updateCustomer($idCustomer, $newCustomerData)
	{
		$statement = $this->dataBaseConnection->prepare(
			"UPDATE customer SET login = :login, lastname = :lastname, firstname = :firstname, credit = :credit
			WHERE id_customer = :idCustomer"
		);

		$statement->execute(
			array(
				':login' => $newCustomerData['login'],
				':lastname' => $newCustomerData['lastname'], 
				':firstname' => $newCustomerData['firstname'],
				':credit' => $newCustomerData['credit'],
				':idCustomer' => $idCustomer
			)
		);
	}

	public function getOneCustomer($idCustomer)
	{
		$statement = $this->dataBaseConnection->prepare(
			"SELECT id_customer, login, lastname, firstname, email, credit FROM customer 
			WHERE id_customer = :idCustomer"
		);

		$statement->execute(
			array(
				':idCustomer' => $idCustomer
			)
		);

		return $statement->fetch();
	}

	public function getCustomerByLogin($loginCustomer)
	{
		$statement = $this->dataBaseConnection->prepare(
			"SELECT id_customer, login, lastname, firstname, email, credit FROM customer 
			WHERE login LIKE :login"
		);

		$statement->execute(
			array(
				':login' => $loginCustomer
			)
		);

		return $statement->fetchAll();
	}

	public function getAccountCredit($idCustomer)
	{
		return $this->getOneCustomer($idCustomer)['credit'];	
	}

	public function getAllCustomers()
	{
		return $this->dataBaseConnection->query("SELECT id_customer, login, lastname, firstname, email, credit FROM customer");
	}

	public function getNumberOfCustomers($email, $password)
	{
		$statement = $this->dataBaseConnection->prepare("SELECT COUNT(*) FROM customer WHERE (email = :email OR login = :email) AND password = :password");
		
		$statement->execute(
			array(
				':email' => $email,
				':password' => md5($password)
			)
		);

		return (int) $statement->fetch()[0];
	}

	public function getId($email, $password)
	{
		$statement = $this->dataBaseConnection->prepare(
			"SELECT id_customer FROM customer 
			WHERE (email = :email OR login = :email)AND password = :password"
		);

		$statement->execute(
			array(
				':email' => $email,
				':password' => md5($password)
			)
		);

		return $statement->fetch();
	}

	public function accountCreditTransaction($idGenerousCustomer, $idLuckyCustomer, $creditAmount)
	{
		try 
		{  
  			$this->dataBaseConnection->beginTransaction();
  			
  			$statement = $this->dataBaseConnection->prepare(
			'UPDATE customer SET credit = credit - :creditAmount WHERE id_customer = :idCustomer'
			);
		    $statement->execute(
				array(
					':idCustomer' => $idGenerousCustomer,
					':creditAmount' => $creditAmount
				)
			);

		    $statement = $this->dataBaseConnection->prepare(
			'UPDATE customer SET credit = credit + :creditAmount WHERE id_customer = :idCustomer'
			);
		    $statement->execute(
				array(
					':idCustomer' => $idLuckyCustomer,
					':creditAmount' => $creditAmount
				)
			);

			$this->dataBaseConnection->commit();
		} 
		catch (Exception $e) 
		{
			$this->dataBaseConnection->rollBack();
		}
	}

	public function buyMovie($idCustomer, $idMovie, $price)
	{
		$statement = $this->dataBaseConnection->prepare("INSERT INTO movie_buy_transaction VALUES (:id_customer, :id_movie, now(), :price)");
		
		return $statement->execute(
			array(
				':id_customer' => $idCustomer,
				':id_movie' => $idMovie,
				':price' => $price
			)
		);
	}
}