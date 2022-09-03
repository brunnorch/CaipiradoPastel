<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');


if (isset($_GET['id']) && isset($_GET['name'])) {
    $comanda = $_GET['id'];
    $name = $_GET['name'];

    /* EXCLUI UM POR UM */
    $sqlDel = mysqli_query($conexao, "UPDATE mesas SET qtdProduto = qtdProduto - 1 WHERE comanda ='$comanda' and nomeProduto ='$name'");
    /* VOLTA O PRODUTO PARA O ESTOQUE */
    $voltaEstoque = mysqli_query($conexao, "UPDATE produtos SET quantiaProduto = quantiaProduto + 1 WHERE nomeProduto= '$name'");

    /* SE FOR IGUAL A 0 ELE EXCLUI O PRODUTO */
    $qtdMesa = mysqli_query($conexao, "SELECT qtdProduto from mesas WHERE comanda ='$comanda' and nomeProduto ='$name'");
    $qtdMesa = mysqli_fetch_row($qtdMesa);
    if ($qtdMesa[0] == 0) {
        $removeItem = mysqli_query($conexao, "DELETE FROM mesas WHERE comanda ='$comanda' and nomeProduto ='$name'");
        header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        exit;
    }

    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
