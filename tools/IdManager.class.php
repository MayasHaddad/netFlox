<?php
class IdManager
{
/**
* This model is responsible of ID data management (using PDO)
* @author Mayas Haddad
*/
	protected $dataBaseConnection;

	function __construct()
	{
		$this->dataBaseConnection = DatabaseManager::getDatabaseConnection();
	}

	private function updateId()
	{
		$this->dataBaseConnection->exec("UPDATE unique_id SET unique_id = unique_id + 1");
	}

	private function initId()
	{
		$this->dataBaseConnection->exec("INSERT INTO unique_id VALUES (0)");
	}

	private function mustInit()
	{
		$statement = $this->dataBaseConnection->prepare("SELECT COUNT(*) FROM unique_id");
		$statement->execute();
		
		return ((int)$statement->fetchColumn() === 0);
	}

	public function getId()
	{
		if($this->mustInit())
		{
			$this->initId();
		}

		$statement = $this->dataBaseConnection->prepare("SELECT unique_id FROM unique_id");
		$statement->execute();
		
		$this->updateId();

		return $statement->fetchColumn();
	}
} 