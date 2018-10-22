<?php require 'pages/header.php'; ?>

<?php 
	require 'classes/classe-livros.php';
	if(empty($_SESSION['gl-Login'])){
	?>
	<script type="text/javascript">window.location.href="index.php";</script>
	<?php
	exit;
	}
	
	$l  = new Livros();

	if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
			$titulo = addslashes($_POST['titulo']);
			$autor = addslashes($_POST['autor']);
			$qtdpagina =addslashes($_POST['qtdpagina']);
			if(isset($_FILES['capa'])){
				$fotos = $_FILES['capa'];
			} else {
				$fotos = array();
		}
			$l->editarLivro($titulo, $autor, $qtdpagina, $fotos, $_GET['id']);
			header("location:cadastrarlivros.php");
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$info = $l->getLivro($_GET['id']);
	} else {
	?>
	<script type="text/javascript"> window.location.href="cadastrarlivros.php"; </script>
	<?php
	exit;	
	}


 ?>

<!--AQUI COMEÇA A PARTE VISÍVEL-->
<div class="container">
<h1>PAINEL DE CONTROLE - GOOGLE LIVROS</h1>
<hr>

<h2>EDITAR INFORMAÇÕES DO LIVRO</h2>

<div class="col-6 admin">
<form method="POST"  enctype="multipart/form-data" >
	Título do Livro: 
	<input type="text" name="titulo" class="form-control" value="<?php echo $info['titulo']; ?>" required/> 
	<br>
	Nome do(a) Autor(a): 
	<input type="text" name="autor" class="form-control" value="<?php echo $info['autor']; ?>" required/> 
	<br>
	Quantidade de Páginas: 
	<input type="text" name="qtdpagina"  class="form-control" value="<?php echo $info['qtdpagina']; ?>" required/>
	<br>
	<input type="file" name="capa[]"  class="form-control" multiple/> <br/>
	 
	<input type="submit" value="Salvar" class="btn btn-success"> <br/><br/>
</form>
</div>
</div>