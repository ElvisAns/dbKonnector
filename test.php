<?php 

require_once "src\dbconnector\dbconnector.php";
		
	$array_instance=[
		"dbname" => "atalakuxpress",
		"hostname" => "localhost",
		"charset" => "utf8mb4",
		"database" => "mysql",
		"password" => "",
		"user"=> "root",
		"port"=>3306
	];

	$ins = new dbConnector\instance();

	try{
		$ins->connect($array_instance);
	}
	catch(Exception $e){
		echo $e;
	}


 
