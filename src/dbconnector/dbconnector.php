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

		public function get_table($table_name,...$input) //order will look like ["field"=>"order_type"]
		{
			$field = $input[0]['fields']??[];
			$limit= $input[0]['limit']??-1;
			$offset= $input[0]['offset']??-1;
			$order= $input[0]['order']??[];
			$response_type=$input[0]['return_response']??"array";

			$fields = !empty($field)?implode(",", $field):"*";

			$limit = $limit != -1 ? "LIMIT ${limit}":"";

			$offset = $offset != -1 ? "OFFSET ${offset}":"";

			$offset = $limit==""?"":$offset; //offset cant be used alone without limit



			$order_list = empty($order)?"":"ORDER BY";
			$count = count($order);
			$i=0;

			foreach($order as $key=>$value){
				$order_list .= "${key} ${value}";
				if($i!=$count) $order_list.=",";
				$i++; 
			}

			$prepared = "SELECT ${fields} FROM ${table_name} ${limit}  ${offset} $order_list";

			var_dump($prepared);

			$stmt = $this->dbh->query($prepared);
			$row = $response_type=="array"?$stmt->fetchall(PDO::FETCH_ASSOC):json_encode($stmt->fetchall(PDO::FETCH_ASSOC));
			return $row;

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