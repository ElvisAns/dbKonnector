<?php

namespace dbConnector;
use \PDO; //Import PDO as a trait

	class Instance
	{
	
	public $dbh; // handle of the db connexion

    private static $instance;

		public function connect(array $parameters)

		{			
			$dbname = $parameters['dbname']??"";
			$hostname = $parameters['hostname']??"127.0.0.1"; //consider we are on local host
			$port = $parameters['port']??3306; //consider we have mysql databse
			$user = $parameters['user']??"";
			$pwd = $parameters['password']??""; //if password is not specified we replace it with empty string
			$dbtype = $parameters['database']??"mysql"; //defautly the database will try to reach out mysql
			$charset = $charset['charset']??"utf8mb4"; //use utf8mb4 as default charset

			$dsn = "${dbtype}:host=${hostname};dbname=${dbname};port=${port};charset=${charset}";
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];

			try 
			{
			    $this->dbh = new PDO($dsn, $user, $pwd, $options);
			    return "connected";
			} 
			catch (\PDOException $e) {
			     throw new \PDOException($e->getMessage());
			}
		}

		public function get_instance()
		{
			return $this->dbh;
		}

		public function get_table(String $table_name,array $field,int $limit=-1,int $offset=-1,array $order=[], String $response_type="array") //order will look like ["field"=>"order_type"]
		{


		}

		public function get_table_where(String $table_name,array $conditions, array $fields=[],int $limit=-1,int $offset=-1,array $order=[],String $response_type="array")
		{

		}

		public function insert(String $table_name,array $datas)
		{

		}

		public function delete(String $table_name,array $conditions){

		}

		public function update(String $table_name,array $conditions, array $datas){

		}

		public function explicit_close(){
			$this->dbh = null;
		}

		public function __destruct(){
			$this->dbh = null; //close the connexion instance
		}

	}