<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
#Definindo o banco de dados
define('HOST', '127.0.0.1');
define('USUARIO', 'root');
define('SENHA', '');
define('DB', 'caipira');
header('Content-Type: text/html; charset=utf-8');


#Realizando a conexão
$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('não conectou');

mysqli_query($conexao, "SET NAMES 'utf8'") or die("Erro na SQL" . mysqli_error($conexao));
mysqli_query($conexao, 'SET character_set_connection=utf8') or die("Erro na SQL" . mysqli_error($conexao));
mysqli_query($conexao, 'SET character_set_client=utf8') or die("Erro na SQL" . mysqli_error($conexao));
mysqli_query($conexao, 'SET character_set_results=utf8') or die("Erro na SQL" . mysqli_error($conexao));
