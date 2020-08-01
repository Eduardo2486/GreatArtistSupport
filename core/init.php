<?php 
	
	include 'database/connection.php';
	include 'classes/User.php';
	include 'classes/Post.php';
	include 'classes/Card.php';

	global $pdo;

	session_start();
	
	

	$getFromU = new User($pdo);
	$getFromP = new Post($pdo);
	$getFromC = new Card($pdo);

	define("BASE_URL","http://localhost/montoya/");
	
?>
