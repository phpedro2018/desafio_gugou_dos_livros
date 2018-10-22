<?php 

 class Usuarios{

 	public function login($email, $senha){
 		global $pdo; 

 		$sql = $pdo->prepare("SELECT id FROM adm WHERE email = :email AND senha = :senha");
 		$sql->bindValue(":email", $email); //adm@adm.com
 		$sql->bindValue(":senha", $senha); //adm
 		$sql->execute();

 		if($sql->rowCount() > 0){

 			$dados = $sql->fetch();
 			$_SESSION['gl-Login'] = $dados['id'];

 			return true; 
 		} else {
 			return false;
 		}
 	}
 }


?>