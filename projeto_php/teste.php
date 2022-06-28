
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>
<?php
$retorno_host = 'url_do_banco'; // Local da base de dados MySql
$retorno_database = 'nome_do_banco'; // Nome da base de dados MySql
$retorno_usuario = 'usuario'; // Usuario com acesso a base de dados MySql
$retorno_senha = 'senha';  // Senha de acesso a base de dados MySql

$nome = $_POST['NOME'];

if($nome!=""){
    $lnk = mysql_connect($retorno_host, $retorno_usuario, $retorno_senha) or die ('Nao foi possível conectar ao MySql: ' . mysql_error());
    mysql_select_db($retorno_database, $lnk) or die ('Nao foi possível ao banco de dados selecionado no MySql: ' . mysql_error());  

    $sql1 = "SELECT * from estudantes where locate('$nome',nome)>0 order by nome asc";
    $query = mysql_query($sql1) or die(mysql_error());

    if(@mysql_num_rows($query) > 0){ // Verifico se o SQL retornou algum registro
?>
Encontrado registros com <?php echo $nome ?>:
<br><br>
<?php
        while($dados = mysql_fetch_array($query)){ //loop para exibir na página os registros que foram encontrados
?>
<strong>Nome:</strong> <?php echo $dados['nome']?>
<br>
<?php
        }
        echo "<br>";
    }else{
?>
Nada encontrado com <?php echo $nome ?>
<br><br>
<?php
    }
    mysql_close($lnk);
}
?>
<body>
<form method="post" action="teste.php">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="NOME">Nome: </label>
            <input class="form-control" id="NOME" placeholder="Nome do colaborador" name="NOME">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 24;">Buscar</button>
</form>
</body>
</html>
