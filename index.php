<?php
	header('Content-Type: application/json; charset=UTF-8');

	require_once 'vendor/autoload.php';
	

	use Api\Http\Rest;

	if (isset($_REQUEST) && !empty($_REQUEST)) {
		$rest = new Rest($_REQUEST);
		echo $rest->run();
	}