<?php require 'pages/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/estilo.css"/>


<div class="pagina">
	<div class="pesquisar col-6">
	
		<div class="Legenda">
			<img src="assets/googledoslivros.png" alt="">
		</div>
	
		<div class="formulario">	
			<form method="GET">
				<input type="text" name="busca" class="form-control w-100 inputestilo" id="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>">
				<input type="submit" class="btn estilo" value="Pesquisar"> 
				<a href="index.php"  class="btn estilo" title="">Limpar</a>
			</form>
		</div>
	
	<script>document.getElementById("busca").focus();</script>
	
	</div>
	
<!--############################ RESULTADOS #################################################### -->


	
	

	<?php
	require 'classes/classe-livros.php';
	$l  = new Livros(); 
	$livros  = $l->getIndex();
	foreach((array)$livros as $livro): 
	?>
	
		<div class="conteudoresultado">
			<?php
				if(!empty($livro['url'])):?>
				<img src="assets/capa/<?php echo $livro['url'];  ?>" alt="50">
				<?php else:?>
				<img src="assets/capa/default.jpg" height="50" alt="">
				<?php endif; ?>			
			<?php echo "<br/>".$livro['titulo']."<br/>"; ?>
			<?php echo $livro['autor']."<br/>" ?>
			<a href="votar.php?id=<?php echo $livro['id']; ?>&voto=1"><img src="assets/star.png" height="20" /></a>
			<a href="votar.php?id=<?php echo $livro['id']; ?>&voto=2"><img src="assets/star.png" height="20" /></a>
			<a href="votar.php?id=<?php echo $livro['id']; ?>&voto=3"><img src="assets/star.png" height="20" /></a>
			<a href="votar.php?id=<?php echo $livro['id']; ?>&voto=4"><img src="assets/star.png" height="20" /></a>
			<a href="votar.php?id=<?php echo $livro['id']; ?>&voto=5"><img src="assets/star.png" height="20" /></a>
			( <?php echo $livro['media']; ?> )
	
		</div>
		<?php endforeach; ?>
	
	

</div>

	



		
	

	

