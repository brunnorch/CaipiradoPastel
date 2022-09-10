<?php

session_start();
include_once('../conexao.php');
//VERIFICA SE TEM DADOS NO INPUT E ARMAZENA NA VARIAVEL
if (isset($_POST['submit'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $quant = $_POST['quant'];
    $tipo = $_POST['tipo'];
    $minimo = $_POST['minimo'];


    //FAZ A ALTERAÇÃO
    $sqlUpdate = "UPDATE produtos SET tipo='$tipo', dataProduto= CURDATE(), nomeProduto='$nome', valorProduto='$valor', minProduto ='$minimo', quantiaProduto='$quant' WHERE idProduto='$codigo'";
    $resultUpdate = mysqli_query($conexao, $sqlUpdate);

    header('Location: ../pages/principal/estoque.php');
    exit;
}
