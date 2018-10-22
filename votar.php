<?php

require 'config.php'; 


if(!empty($_GET['id']) && !empty($_GET['voto'])) {
	$id = intval($_GET['id']);
	$voto = intval($_GET['voto']);

	if($voto >= 1 && $voto <= 5) {

		$sql = $pdo->prepare("INSERT INTO votos SET id_livro = :id_livro, nota = :nota");
		$sql->bindValue(":id_livro", $id);
		$sql->bindValue(":nota", $voto);
		$sql->execute();

		$sql = "UPDATE livros SET media = (select (SUM(nota)/COUNT(*)) 
		from votos where votos.id_livro = livros.id) WHERE id = :id";
		$sql = $pdo->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		header("Location: index.php");
		exit;

	}
}

?>