<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

if (isset($_GET['id'])) {
    $comanda = $_GET['id'];

    /* PEGA OS NOMES E QUANTIDADES DE PRODUTOS QUE FOI PARA MESA  */
    $retornaEstoque = mysqli_query($conexao, "SELECT comanda, nomeProduto, qtdProduto from mesas where comanda ='$comanda'");
    $retornaEstoque = mysqli_fetch_all($retornaEstoque);
    /* PASSA OS PRODUTOS PARA DEVOLVER PARA O ESTOQUE */
    foreach ($retornaEstoque as $key) {
        $voltaEstoque = mysqli_query($conexao, "UPDATE produtos SET quantiaProduto = quantiaProduto + '$key[2]' WHERE nomeProduto= '$key[1]'");
    }

    //EXCLUI MESA
    $excluiMesa = mysqli_query($conexao, "DELETE FROM mesas WHERE comanda = '$comanda'");
    $excluiComanda = mysqli_query($conexao, "DELETE FROM numero_mesas WHERE comanda = '$comanda'");
    header('location:../principal/mesa.php');
}
