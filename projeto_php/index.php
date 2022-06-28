<?php  

	include_once("conexao.php");

	//verificar se o botao 'buscar' foi acionado
	if (isset($_POST['buscar'])){
		//filtro para verificar se alguma opção de preço foi selecionada
		if (isset($_POST['valor_50'])){
			$valor_pesquisa = 50;
		} else if (isset($_POST['valor_250'])){
			$valor_pesquisa = 250;
		} elseif (isset($_POST['valor_500'])) {
			$valor_pesquisa = 500;
		} else {
			$valor_pesquisa = 0;
		}
		//filto por nome e cor, podendo pegar até palavras ao meio, exemplo 'zul'
		$pesquisa = $_POST['pesquisa'];
		if (strlen($pesquisa) <= 0 ){
			$pesquisa = 0;
		}
		$query = ("SELECT produtos.Id, Nome, Cor, Preco FROM produtos INNER JOIN preco ON produtos.Id = Preco.Id where Nome LIKE '%{$pesquisa}%' OR Cor LIKE '%{$pesquisa}%' AND Preco > {$valor_pesquisa}");
		
	} else{
		//query para selecionar todos os produtos com seus preços
		$query = ('SELECT produtos.Id, Nome, Cor, Preco FROM produtos INNER JOIN preco ON produtos.Id = Preco.Id;');
	}


	//verifica qual acao foi feita para notificar o usuario
	//acao=1 -> inserção
	//acao=2 -> atualização
	//acao=3 -> remoção
	if (isset($_GET['acao'])){
		if ($_GET['acao'] == 1) {
			echo  "<script>alert('Produto cadastrado com sucesso!');</script>";
		} else if ($_GET['acao'] == 2) {
			echo  "<script>alert('Produto atualizado com sucesso!');</script>";
		} else if($_GET['acao'] == 3) {
			echo  "<script>alert('Produto deletado com sucesso!');</script>";
		}
	}
?>

<html>
	<head>
		<meta charset="utf-8" />
		
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
							<h4>Cadastre um Produto</h4>
								<ul class="text-left">
									<li>Desconto de 20% em Produtos Vermelhos e Azuis</li>
									<li>Desconto em 10% em Produtos Amarelos</li>
									<li>Produtos Vermelhor e com valor superior de 50 reais, desconto de mais 5%</li>
								</ul>
							<hr/>
							<form method="post" action="inserir_produto.php">
								<div class="form-group">
									<table class="tabela_conteudo comHover">
										<tr>
											<td>Nome do Produto</td>
											<td>Cor</td>
											<td>Preço</td>
										</tr>
										<tr>
											<td><input type="text" class="form-control" name="produto" placeholder="Produto"></td>
											<td>
												<!--utilização estatica para nao haver problemas nas regras de negocio 
 -->												<select class="form-control" name="cor" value="Selecionar">
													<option>Azul</option>
													<option>Amarelo</option>
													<option>Vermelho</option>
													<option>Branco</option>
													<option>Preto</option>
													<option>Rosa</option>
													<option>Roxo</option>
													<option>Verde</option>
												</select>
											</td>
											<td><input type="number" step="0.01" class="form-control" name="preco" placeholder="Preço" min="0.01"></td>
											<td>
											<td><button class="btn btn-success">Cadastrar</button></td>
										</tr>
									</table>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<h4>Todos os Produtos</h4>
							<hr/>

								<table>
									
					                <tr >
					                	<th>Nome do Produto</th> 
					                    <th>Cor  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="A cor do produto não pode ser alterada!"></i></th> 
					                    <th>Preço($)</th>
					                    <th>Editar</th>
					                    <th>Excluir</th>
					                </tr>
					                <!-- foreach para percorrer todos os registos do banco -->
					                <?php foreach ($conexao->query($query) as $valor) { 
										//regras de negocio
										//20% de desconto em produtos Azuis e Vermelhos
					                	if ($valor["Cor"] == 'Azul' || $valor["Cor"] == 'Vermelho'){
					                		$valor["Preco"] = ($valor["Preco"])-($valor["Preco"]*0.2);		             
					                	}
					                	//10% de desconto em Produtos Amarelos
					                	if ($valor["Cor"] == 'Amarelo'){
					                		$valor["Preco"] = ($valor["Preco"])-($valor["Preco"]*0.1);
					                	}
					                	//5% de desconto em Produtos Vermelhor com valor acima de 50 reais          
					                	if ($valor["Cor"] == 'Vermelho' && $valor["Preco"] > '50'){
											$valor["Preco"] = ($valor["Preco"])-($valor["Preco"]*0.05);
										}					               
					                ?>
					                    <tr>
					                    	<td><input type="hidden" class="form-control" name="cor"><?= $valor["Nome"] ?></td>
					                      	<td><?= $valor["Cor"] ?></td>
					                      	<td><?= number_format($valor["Preco"],2, ',', '.') ?></td><!-- number_format para formatar o numero em moeda, especificamente em real -->
					                      	<!-- icone para atualizar abrindo outra pagina passando via http o id do produto -->
					                      	<td class="icone"><a class="fas fa-edit fa-lg tect-info"href="atualiza_produto.php?id=<?= $valor["Id"] ?>"></td>
					                      	<!-- icone para excluir abrindo outra pagina passando via http o id do produto -->
					                      	<td class="icone"><a class=" fas fa-trash fa-lg text-danger text-center"href="deletar_produto.php?id=<?= $valor["Id"] ?>"></td>
					                    </tr>
					                <?php  } ?>
								</table>
							</div>
						</div>
						<br> <br>
						<h4>Filtros</h4>
						<hr>
						<div class="text-left">
							<form action="index.php" method="post">
								<label>Nome ou Cor</label><br>
								<input type="text" name="pesquisa">
								<br>
								<label>Preço: </label>
								<br>			
								<input type="radio"name="valor_50">Até 50 reais
						   		<br>
								<input type="radio"name="valor_250">Até 250 reais
						    	<br>
								<input type="radio"name="valor_500">Acima de 500 reais
								<div class="text-center"> <!-- div para colocar o botao no centro -->
									<button  type="submit"class=" btn btn-primary ">Buscar</button>
								</div>
								<input type="hidden" name="buscar" value="1"><!-- passar um input hidden para conseguir verificar se o filtro foi acionado ou não -->
							</form>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
