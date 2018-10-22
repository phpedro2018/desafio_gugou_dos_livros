<?php 
require 'pages/header.php';
require 'classes/classe-livros.php';
	
	$l  = new Livros();
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$l->excluirLivro($_GET['id']);
		header("Location:cadastrarlivros.php");
		
	}

?>