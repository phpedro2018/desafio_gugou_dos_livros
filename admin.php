<?php 
	require 'pages/header.php'; 
 
	require 'classes/classe-usuarios.php';
	$adm = new Usuarios();

	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = addslashes($_POST['email']); //adm@adm.com
		$senha = $_POST['senha']; //adm

		if($adm->login($email, $senha)){
				header("Location:cadastrarlivros.php");
			} else {
				?>
				<div style="text-align: center;">
					Usuários e/ou Senha incorretos :(
				</div>
				<?php
			}
	}

?>
<link rel="stylesheet" type="text/css" href="assets/estilo.css"/>

<div class="pagina">
	<div class="admin col-4">
		<form method="POST">
		email adm : <input type="email" class="form-control" name="email"> <br/>
		Senha: <input type="password" class="form-control" name="senha"> <br/><br/>
		<input type="submit" class="btn btn-success" value="Acessar Painel Administrativo">
		</form>
	</div>
</div>