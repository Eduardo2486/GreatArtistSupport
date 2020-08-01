<?php
	$dsn = 'mysql:host=localhost;dbname=project';
	$user = 'root';
	$pass = '';

	try{

		$pdo = new PDO($dsn,$user,$pass);

	}catch(PDOException $e){

		echo "Connection error! " . $e->getMessages();
		
	}

?>