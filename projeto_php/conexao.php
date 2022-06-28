<?php 

	try
	{
		$conexao = new PDO("mysql:dbname=loja_produtos;host=localhost","root","");
	}
	catch(PDOExceptoin $e){
		echo "Erro com banco de dados: ".$e->getMessege();
	}
	catch(Exception $e)
	{
		echo "Erro genérico: "  .$e->getMessege();
	}

 ?>