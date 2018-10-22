<?php 
 class Livros{



 	// #######################################################################
	//CADASTRADNO UM NOVO LIVRO	
	public function Cadastrar($titulo, $autor, $qtdpagina, $fotos){ 
		global $pdo; 
		$sql = $pdo->prepare("INSERT INTO livros SET
			titulo = :titulo, 
			autor = :autor,
			qtdpagina = :qtdpagina");

			$sql->bindValue(":titulo", $titulo);
			$sql->bindValue(":autor", $autor);
			$sql->bindValue(":qtdpagina", $qtdpagina);
			$sql->execute();

	}
	// ########################################################################
	//EDITANDO INFORMAÇÕES DE UM DETERMINADO LIVRO
	public function editarLivro($titulo, $autor, $qtdpagina, $fotos, $id){ 
		global $pdo; 
		$sql = $pdo->prepare("INSERT INTO livros SET
			titulo = :titulo, 
			autor = :autor,
			qtdpagina = :qtdpagina WHERE id= :id");

			$sql->bindValue(":titulo", $titulo);
			$sql->bindValue(":autor", $autor);
			$sql->bindValue(":qtdpagina", $qtdpagina);
			$sql->bindValue(":id", $id);
			$sql->execute();

			
			if(count($fotos) > 0){//verificando se já existe foto da capa
				for($q=0; $q<count($fotos['tmp_name']); $q++){ 
					$tipo = $fotos['type'][$q];
					//adicinando um nome e pasta temporária 
					if(in_array($tipo, array('image/jpeg', 'image/png'))){ //tipo de arquivos de imagem 
						$nomeTemporario = md5(time().rand(0,99)).'.jpg'; //criando um nome aleatório criptografado
						move_uploaded_file($fotos['tmp_name'][$q], 'assets/capa/'.$nomeTemporario); 
						// linha 49 = movendo o arquivo de imagem para a pasta
						list($largura_orig, $altura_orig) = getimagesize('assets/capa/'.$nomeTemporario);
						//redimensionando a imagem da capa para 300x300
						$ratio = $largura_orig/$altura_orig;
						$largura = 300; 
						$altura = 300; 

						if($largura/$altura > $ratio){
							$largura = $altura*$ratio;
						} else {
						$altura = $largura/$ratio;
						}

					//últimas configurações de imagem
					$img = imagecreatetruecolor($largura, $altura);
					if($tipo == 'image/jpeg'){
						$origi = imagecreatefromjpeg('assets/capa/'.$nomeTemporario);
					} elseif($tipo == 'image/png') {
						$origi = imagecreatefrompng('assets/capa/'.$nomeTemporario);
					}
					imagecopyresampled($img, $origi, 0, 0, 0, 0, $largura, $altura, $largura_orig, $altura_orig);
					imagejpeg($img, 'assets/capa/'.$nomeTemporario, 80);
					//inserindo a imagem da capa do livro bando de dados
					$sql = $pdo->prepare("INSERT INTO capa SET id_livro = :id_livro, url = :url");
					$sql->bindValue(":id_livro", $id);
					$sql->bindValue(":url", $nomeTemporario);
					$sql->execute();
			
					}
				}
			}

		}


		// ###############################################################################
		//LISTAGEM DOS LIVROS NO PAINEL ADMINISTRATIVO
		public function Listar(){
			global $pdo; 
			$array = array();
			$sql = $pdo->query("SELECT * FROM livros");
			$sql->execute();

			if($sql->rowCount() > 0){
				$array = $sql->fetchAll();
			}

			return $array;
		}
		// ###############################################################################
		//PEGANDO UM DETERMINADO LIVRO PELO ID
		public function getLivro($id){
			$array = array();
			global $pdo; 

			$sql = $pdo->prepare("SELECT * FROM livros WHERE id = :id");
			$sql->bindValue(":id", $id);
			$sql->execute();

			if($sql->rowCount() >0){
				$array = $sql->fetch();
				$array['capa'] = array();

				$sql = $pdo->prepare("SELECT id,url FROM capa WHERE id_livro = :id_livro");
				$sql->bindValue(":id_livro", $id);
				$sql->execute();

			if($sql->rowCount() > 0){
				$array['capa'] = $sql->fetchAll();
			}
		}
		return $array;

	}

	// ###############################################################################
	//PEGANDO OS LIVROS NO SISTEMA DE BUSCA
	public function getMeusLivros(){
		global $pdo;

		if(empty($_GET['busca'])){
			$s =''; 
		} else {
			$s = $_GET['busca'];
		}

		$array = array();

		if(!empty($s)){

			$sql = $pdo->prepare("SELECT *, 
			(select capa.url from capa where capa.id_livro = livros.id limit 1) 
			as url FROM livros WHERE titulo LIKE :titulo OR autor LIKE :autor") ;
			$sql->bindValue(":titulo", '%'.$s.'%');
			$sql->bindValue(":autor", '%'.$s.'%');
			$sql->execute();
	
		} else {
	
			$sql = $pdo->prepare("SELECT *, 
			(select capa.url from capa where capa.id_livro = livros.id limit 1) 
			as url FROM livros") ;
			$sql->execute();
		}

		

		if($sql->rowCount() > 0){
			$array = $sql->fetchAll();
		}
		
		return $array;

	}

	// ###############################################################################
	//INICIAL
	public function getIndex(){
		global $pdo;

		if(empty($_GET['busca'])){

			$s ='';
			 
		} else {

			$s = $_GET['busca'];
			$array = array();
			$sql = $pdo->prepare("SELECT *, 
			(select capa.url from capa where capa.id_livro = livros.id limit 1) 
			as url FROM livros WHERE titulo LIKE :titulo OR autor LIKE :autor") ;
			$sql->bindValue(":titulo", '%'.$s.'%');
			$sql->bindValue(":autor", '%'.$s.'%');
			$sql->execute();

			if($sql->rowCount() > 0){
			$array = $sql->fetchAll();
			}
		
			return $array;
		}

	}

	// #################################################################
	//EXCLUINDO UM LIVRO DA LISTA PELO ADMINISTRADOR
	public function excluirLivro($id){

		//EXCLUINDO O LIVRO DO BANCO DE DADOS
		global $pdo;
		$sql = $pdo->prepare("DELETE FROM livros WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		//EXCLUINDO A CAPA 
		$sql = $pdo->prepare("DELETE FROM capa WHERE id_livro = :id_livro");
		$sql->bindValue(":id_livro", $id);
		$sql->execute();
	}	

	public function excluirCapa($id){
	
		//EXSCLUINDO A CAPA DO BANCO DE DADOS 	
		global $pdo;
		$id_livro = 0;
		$sql = $pdo->prepare("SELECT id_livro FROM capa WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
		if($sql->rowCount() > 0){
			$row = $sql->fetch();
			$id_livro = $row['id_livro'];
		}
		$sql = $pdo->prepare("DELETE FROM capa WHERE id = :id"); 
		$sql->bindValue(":id", $id);
		$sql->execute();
		return $id_livro;
	}


}

?>