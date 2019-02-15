<?php 
include('conecta.php');

if(isset($_POST['edit'])){
	$id_produto = $_POST['idProduto'];
	$id = (int)$id_produto;
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$pic = $_FILES["foto"];
	if (!empty($pic)){
		// Se a foto estiver sido selecionada
		if (!empty($pic["name"])) {

		// Largura máxima em pixels
			$largura = 1500;
		// Altura máxima em pixels
			$altura = 1800;
		// Tamanho máximo do arquivo em bytes
			$tamanho = 10000000;

			$error = array();

    	// Verifica se o arquivo é uma imagem
			if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $pic["type"])){
				$error[1] = "Isso não é uma imagem.";
			} 

		// Pega as dimensões da imagem
			$dimensoes = getimagesize($pic["tmp_name"]);

		// Verifica se a largura da imagem é maior que a largura permitida
			if($dimensoes[0] > $largura) {
				$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
			}

		// Verifica se a altura da imagem é maior que a altura permitida
			if($dimensoes[1] > $altura) {
				$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
			}

		// Verifica se o tamanho da imagem é maior que o tamanho permitido
			if($pic["size"] > $tamanho) {
				$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
			}

		// Se não houver nenhum erro
			if (count($error) == 0) {

			// Pega extensão da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $pic["name"], $ext);

        	// Gera um nome único para a imagem
				$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

        	// Caminho de onde ficará a imagem
				$caminho_imagem = "fotos/" . $nome_imagem;

			// Faz o upload da imagem para seu respectivo caminho
				move_uploaded_file($pic["tmp_name"], $caminho_imagem);
				$sql = $pdo->prepare("UPDATE `tb_produto` SET nome_produto = :nome, foto_produto = :foto, descricao_produto = :descricao WHERE id_produto = :id");

				$sql->execute(array(
					':nome'    => $nome,
					':foto'		=> $caminho_imagem,	
					':descricao' => $descricao,
					':id'	=> $id
				));

				if($sql->rowCount() > 0){
					echo '<script>alert("Registro atualizado com Sucesso!");</script>';
					echo '<script>window.location.href="index.php";</script>';
				}else{
					echo '<script>alert("Falha ao atualizar registro!");</script>';
					echo '<script>window.location.href="act_produtos.php";</script>';
				}
			}
		}else{
			$id_produto = $_POST['idProduto'];
			$id = (int)$id_produto;
			$nome = $_POST['nome'];
			$descricao = $_POST['descricao'];
			$sql = $pdo->prepare("UPDATE `tb_produto` SET nome_produto = :nome, descricao_produto = :descricao WHERE id_produto = :id");

			$sql->execute(array(
				':nome'    => $nome,
				':descricao' => $descricao,
				':id'	=> $id
			));

			if($sql->rowCount() > 0){
				echo '<script>alert("Registro atualizado com Sucesso!");</script>';
				echo '<script>window.location.href="index.php";</script>';
			}else{
				echo '<script>alert("Falha ao atualizar registro!");</script>';
				echo '<script>window.location.href="act_produtos.php";</script>';
			}
		}
	}
}else if(isset($_POST['del'])){
	$id_produto = $_POST['idProduto'];
	$id = (int)$id_produto;
	$sql =  $pdo->prepare("DELETE FROM tb_produto WHERE id_produto = ?");
	$sql->execute(array($id));
	echo '<script>alert("Registro deletado com Sucesso!");</script>';
	echo '<script>window.location.href="index.php";</script>';
}
?>