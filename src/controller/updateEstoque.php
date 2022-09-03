<?php

session_start();
include_once('../conexao.php');
//VERIFICA SE TEM DADOS NO INPUT E ARMAZENA NA VARIAVEL
if (isset($_POST['submit'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $quant = $_POST['quant'];


    //FAZ A ALTERAÇÃO
    $sqlUpdate = "UPDATE produtos SET idProduto='$codigo', dataProduto= CURDATE(), nomeProduto='$nome', valorProduto='$valor', quantiaProduto='$quant' WHERE idProduto='$codigo'";
    $resultUpdate = mysqli_query($conexao, $sqlUpdate);

    header('Location: ../pages/principal/estoque.php');
    exit;
}
