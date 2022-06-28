<?php  

	include_once("conexao.php");

	$id = $_GET['id'];
	$query = $conexao->prepare("select produtos.Id, Nome, Cor, Preco FROM produtos INNER JOIN preco ON produtos.Id = Preco.Id where produtos.Id = :id");
	$query->bindParam(":id",$id);
	$query->execute();
 
	$produto = $query->fetch(PDO::FETCH_ASSOC);
	//echo $produto['Nome'];
 
 ?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Produtos</title>

		<link rel="stylesheet" type="text/css" href="estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.php">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					Projeto em PHP
				</a>
			</div>
		</nav>
				<div class="text-center">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Atualizar Produto</h4>
								<hr/>
									<form method="post" action="atualiza_prouduto_script.php?id=<?= $id ?>" name="form">
										<div class="text-left"> 
											<label class="control-label text-right ">Nome </label>
											<input class="form-control"  type="text" name="produto" 
											value="<?php echo $produto['Nome']; ?>"><br>
										</div>
										<div class="text-left"> 
											<label class="control-label text-right ">Cor  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="A cor do produto não pode ser alterada!"></i></label>
											<input class="form-control"  type="text" name="cor" value="<?php echo $produto['Cor']; ?>" readonly><br>
										</div>
										<div class="text-left"> 
											<label class="control-label text-right ">Preço </label>
											<input class="form-control" step="0.01"  type="number" name="preco" value="<?php echo $produto['Preco']; ?>"><br>
										</div>
										<div class="text-center">        
					                    <a href="javascript:form.submit();" class="btn btn-success btn-sm"> Atualizar</a> 
					                	</div>
					                	<div class="text-center">        
					                    <a href="index.php" class="btn btn-sm"><i class="icon-plus icon-1-5x"></i> Voltar</a> 
					                	</div>
									</form>
							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>