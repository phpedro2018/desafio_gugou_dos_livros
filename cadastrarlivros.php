<?php 
require 'pages/header.php';
require 'classes/classe-livros.php';
	$l  = new Livros();

	if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
			$titulo = addslashes($_POST['titulo']);
			$autor = addslashes($_POST['autor']);
			$qtdpagina =addslashes($_POST['qtdpagina']);
			$l->Cadastrar($titulo, $autor, $qtdpagina);
			header("location:cadastrarlivros.php");
	 } ?>

	<div class="container">
		<h1>PAINEL DE CONTROLE - GOOGLE LIVROS</h1>	
		<hr>
	
		<h3>CADASTRAR LIVROS</h3>

		<form method="POST" class="form-inline" >
			Título:	<input type="text"  class="form-control" name="titulo" required/> |  
			Autor(a): <input type="text" name="autor" class="form-control" required/> |
			Qtd de Páginas: <input type="number" name="qtdpagina" min="1" max="9999" class="form-control"  required/> | 
			<input type="submit" class="btn btn-primary" value="Cadastrar livro"> <br/><br/>
		</form>

		<hr>

		<div class="pesquisar">
			<h3>LIVROS CADASTRADOS</h3>
			<div>	
			<form method="GET" class="form-inline">
				Busca: <input type="text" class="form-control w-25" name="busca" id="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>"> |
	     		<input type="submit" value="Pesquisar" class="btn btn-success"> | 
	     		<a href="cadastrarlivros.php" title="" class="btn btn-danger">Limpar</a>
			</form>
		</div>
	
		
		<script>
			document.getElementById("busca").focus();
		</script>
	</div>

	<br>
	
	<table class="table table-striped">
	<thead>
		<tr>
			<th>Capa do Livro</th>
			<th>Id do Livro</th>
			<th>Título</th>
			<th>Autor(a)</th>
			<th>Qtd Páginas</th>
			<th>Ações</th>
			

		</tr>
	</thead>

	<?php 
	$livros  = $l->getMeusLivros();
	foreach($livros as $livro): 
	?>
	
	
		<tr>
			<td>
				<?php
				if(!empty($livro['url'])):?>
				<img src="assets/capa/<?php echo $livro['url'];  ?>" alt="" height="40">
				<?php else:?>
			<a href="editar-livro.php?id=<?php echo $livro['id']; ?>">		
				<img src="assets/capa/default.jpg" height="20" alt="">
			</a>
				<?php endif; ?>	
			</td>
			<td><?php echo $livro['id']; ?></td>
			<td><?php echo $livro['titulo']; ?></td>
			<td><?php echo $livro['autor']; ?></td>
			<td><?php echo $livro['qtdpagina']; ?></td>
			<td colspan="" rowspan="" headers="">
				
				<a href="editar-livro.php?id=<?php echo $livro['id']; ?>" title="" class="btn btn-success btn-sm"> Atualizar </a>
				<a href="excluir-livro.php?id=<?php echo $livro['id']; ?>" title="" class="btn btn-danger btn-sm"> Excluir </a>

			</td>
			
		</tr>
	

	<?php endforeach; ?>
</table>



<a href="sair.php" class="btn btn-dark">sair</a>
</div>