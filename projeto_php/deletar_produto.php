<?php  
	//incluindo conexao via banco
	include_once 'conexao.php';

	//recebendo valor via GET(http)
	$id = $_GET['id'];

	//fazendo a query de exclusao das duas tabelas utilizadas
	$res = $conexao->prepare("delete from produtos where id = (:id)");
	$res2 = $conexao->prepare("delete from preco where id = (:id)");

	//subistituindo valores
	$res->bindValue(":id",$id);
	$res2->bindValue(":id",$id);

	$res->execute();
	$res2->execute();
 		
	//retornando a pagina principal com acao=3 -> exclusao 		
	header("Location: index.php?acao=3"); 

?>