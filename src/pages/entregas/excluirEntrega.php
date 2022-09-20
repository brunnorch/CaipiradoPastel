<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

if (isset($_GET['id'])) {
    $idEntrega = $_GET['id'];

    /* PEGA OS NOMES E QUANTIDADES DE PRODUTOS QUE FOI PARA ENTREGA  */
    $retornaEstoque = mysqli_query($conexao, "SELECT nomeProduto, qtdProduto from entregas_andamento where idEntrega ='$idEntrega'");
    $retornaEstoque = mysqli_fetch_all($retornaEstoque);

    /* PASSA OS PRODUTOS PARA DEVOLVER PARA O ESTOQUE */
    foreach ($retornaEstoque as $key) {
        $voltaEstoque = mysqli_query($conexao, "UPDATE produtos SET quantiaProduto = quantiaProduto + '$key[1]' WHERE nomeProduto= '$key[0]'");
    }

    //EXCLUI MESA
    $excluiEntrega = mysqli_query($conexao, "DELETE FROM entregas WHERE idEntrega = '$idEntrega'");
    $excluiEntrega = mysqli_query($conexao, "DELETE FROM entregas_andamento WHERE idEntrega = '$idEntrega'");
    header('location:../entregas/entregaAndamento.php');
}
