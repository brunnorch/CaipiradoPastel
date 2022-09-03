<?php
session_start();
include_once('../verificalogin.php');
include_once('../conexao.php');


if (isset($_GET['id'])) {
    $idProd = $_GET['id'];
    $nomeProd = $_GET['name'];
    $valorProd = $_GET['valor'];

    /* VERIFICA SE JÁ EXISTE NA TABELA DANIFICADO */
    $existe = mysqli_query($conexao, "SELECT nomeDanificado FROM danificado where nomeDanificado = '$nomeProd'");
    $existe = mysqli_fetch_assoc($existe);

    if ($existe['nomeDanificado'] == $nomeProd) {
        $add = mysqli_query($conexao, "UPDATE danificado SET quantDanificado =  quantDanificado + 1, dataDanificado = now() WHERE idProduto ='$idProd'");
    } else {
        /* ADICIONA O PASTEL NA TABELA DANIFICADO */
        $danificado = mysqli_query($conexao, "INSERT INTO danificado VALUES('$idProd','$nomeProd','$valorProd',1,NOW())");
    }

    /* TIRA UM DO ESTOQUE */
    $saiEstoque = mysqli_query($conexao, "UPDATE produtos set quantiaProduto = quantiaProduto - 1 where nomeProduto = '$nomeProd'");

    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
