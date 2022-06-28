<?php  

	include_once 'conexao.php';

	$id = $_GET['id'];
	$produto = $_POST["produto"];
	$cor = $_POST["cor"];
	$preco = $_POST["preco"];

	$res = $conexao->prepare("update produtos set Nome=(:nome), Cor=(:cor) where id = (:id)");
	$res2 = $conexao->prepare("update preco set preco=(:preco) where id = (:id)");

	$res->bindValue(":nome",$produto);
	$res->bindValue(":cor",$cor);
	$res->bindValue(":id",$id);
	$res2->bindValue(":preco",$preco);
	$res2->bindValue(":id",$id);

	$res->execute();
	$res2->execute();
 		
	header("Location: index.php?acao=2"); 

?>