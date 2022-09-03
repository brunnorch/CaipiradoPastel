<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

if (isset($_GET['id']) && isset($_GET['name'])) {
    $comanda = $_GET['id'];
    $name = $_GET['name'];

    /* ADCIONA MAIS UM PRODUTO DA MESA */
    $updateQtd = mysqli_query($conexao, "UPDATE mesas SET qtdProduto = qtdProduto + 1 where nomeProduto ='$name' and  comanda = '$comanda'");

    /* DIMINUI ESTOQUE */
    $menosUm = mysqli_query($conexao, "UPDATE produtos set quantiaProduto = quantiaProduto - 1 where nomeProduto = '$name'");

    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
