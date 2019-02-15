<!DOCTYPE html>
<html>
<head>


	<title>Meu CRUD PHP</title>

	<link rel="stylesheet" type="text/css" href="estilo/style.css">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<?php include('conecta.php'); ?>
</head>
<body>
	<header>
		<div class="title">
			<p>Meu CRUD PHP</p>
		</div>
	</header>
	<section class="sec-in">
		<div class="title-in">
			<p>Insira os produtos aqui:</p>
		</div>
		<div class="form-prod">
			<form method="POST" enctype="multipart/form-data" action="edit_del_produtos.php">
				<?php   
				$id_update = $_POST['id_produto'];
				$id = (int)$id_update;
				$sql = $pdo->prepare("SELECT * FROM tb_produto WHERE id_produto = ?");
				$sql->execute(array($id));
                                    //echo 'PDO::errorInfo()';
                                    //print_r($sql->errorInfo()); 
				if($sql->rowCount() > 0){
					foreach($sql->fetchAll() as $dados):
						$id_produto = $dados['id_produto'];
						?>
						<input type="text" name="nome" placeholder="Nome..." value="<?php echo $dados['nome_produto']; ?>">
						<input type="file" name="foto" placeholder="Foto...">
						<textarea type="text" name="descricao" placeholder="Descrição..." value="<?php echo $dados['descricao_produto']; ?>"></textarea>
						<input type="hidden" name="idProduto" value="<?php echo $id; ?>"/>
						<?php 
					endforeach;
				} ?>
				<input type="submit" name="edit">
			</form>
		</div>
	</section>
	<section class="sec-list">
		<div class="tab-list">
			<div class="title-in">
				<p>Deseja detelar esse registro?</p>
			</div>
			<table>
				<tr>
					<th class="table-tile">Ação</th>
					<th class="table-tile">Código</th>
					<th class="table-tile">Nome</th>
					<th class="table-tile">Foto</th>
					<th class="table-tile">Descrição</th>
				</tr>
				<?php
				$sql = $pdo->prepare("SELECT * FROM tb_produto WHERE id_produto = ?");
				$sql->execute(array($id));
				if ($sql->rowCount() > 0){
					foreach($sql->fetchAll() as $dadosproduto):
						$id_produto = $dadosproduto['id_produto'];
						?>
						<form action="edit_del_produtos.php" enctype="multipart/form-data" method="POST">
							<tr>
								<td class="acao_produto">
									<input type="text" style="display: none;" name="idProduto" value="<?php echo $id_produto;?>" />

									<button class="btn-edit" type="submit" name="del" ><i class="fas fa-user-times"></i></button>
									
								</td>
								<td class="id_produto"><?php echo $dadosproduto['id_produto'];  ?></td>
								<td class="nome_produto"><?php echo $dadosproduto['nome_produto']; ?></td>
								<td class="foto_produto"><img src="<?php echo $dadosproduto['foto_produto']; ?>"></td>
								<td class="descricao_produto"><?php echo $dadosproduto['descricao_produto']; ?></td>
							</tr>
						</form>
						<?php 
					endforeach;
				}  
				?>
			</table>
		</div>
	</section>
	<footer>
		<div class="footer">
			<p>Direitos reservados | Junior Cintra</p>
		</div>
		
	</footer>
</body>
</html>