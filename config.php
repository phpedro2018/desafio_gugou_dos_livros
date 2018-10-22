<?php 

session_start(); 
global $pdo;

try {
	$pdo = new PDO("mysql:dbname=desafio_googlelivros; host=localhost","root","root");
} catch (PDOException $e) {
	echo "FALHA...".$e->getMessage();
	exit;
	
}



?>