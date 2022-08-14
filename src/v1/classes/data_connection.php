<?php

	// Dados de conexão
	$host = "localhost";
	$user = "root";
	$pass = "";
	$database = "api";

	// Url base do site
	$sitename = "http://localhost/api/";

	//Uso para API
	$con = new PDO('mysql: host='.$host.'; dbname='.$database.';',$user,$pass,array(
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
	);
?>