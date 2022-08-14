<?php

	// Data to connection
	$host = "";
	$user = "";
	$pass = "";
	$database = "";

	// Connection
	try{
		$con = new PDO('mysql: host='.$host.'; dbname='.$database.';',$user,$pass,array(
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		);
	}
	catch(\PDOException $ex){
		throw new \Exception('AC507');
	}
?>