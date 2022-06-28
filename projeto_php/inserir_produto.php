<?php  

	include_once 'conexao.php';

	$produto = $_POST["produto"];
	$cor = $_POST["cor"];
	$preco = $_POST["preco"];

	$res = $conexao->prepare("insert into produtos(nome, cor) values(:nome, :cor)");
	$res2 = $conexao->prepare("insert into preco(preco) values(:preco)");

	$res->bindValue(":nome",$produto);
	$res->bindValue(":cor",$cor);
	$res2->bindValue(":preco",$preco);

	$res->execute();
	$res2->execute();

	header("Location: index.php?acao=1"); 

?>