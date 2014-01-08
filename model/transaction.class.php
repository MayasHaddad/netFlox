<?php
/**
* This model is responsible of transaction data management (using PDO)
* @author Mayas Haddad
*/
class Transaction
{
	protected $dataBaseConnection;

	function __construct()
	{
		$this->dataBaseConnection = DatabaseManager::getDatabaseConnection();
	}

	public function getTurnoverOnTransactions($period)
	{
		$statement = $this->dataBaseConnection->prepare(
			"SELECT SUM(price) FROM movie_buy_transaction
			WHERE date >= :date"
		);

		$statement->execute(
			array(
				':date' => $period
			)
		);

		return $statement->fetchColumn();
	}
}