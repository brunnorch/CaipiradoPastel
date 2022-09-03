<?php 
session_start();
include_once('../verificalogin.php');
include_once('../conexao.php');

/* VERIFICA QUEM ESTÁ LOGADO,ADICIONA NA TABELA CARINHO_PRODUTO O USUARIO LOGADO, ID DO PRODUTO E QTD  */
$user = $_SESSION['usuario'];

if (isset($_GET['add']) && $_GET['add'] == "carrinho") {
    $id = $_GET['id'];

/* SELECT PARA VERIFICAR SE O PRODUTO JÁ ESTÁ NO CARRINHO */
    $exists = mysqli_query($conexao, "SELECT idProduto FROM carrinho_produto WHERE idProduto = '$id'");
    $exists = mysqli_fetch_assoc($exists);  

    $qts = 1;
    if ($exists) {
        $add = mysqli_query($conexao, "UPDATE carrinho_produto SET quantidade = quantidade + 1 WHERE idProduto = '$id'");
        
        header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    }else {
        /* PEGA ID DO USUARIO LOGADO */
        $result = mysqli_query($conexao, "SELECT idUsuario FROM usuario WHERE usuario.usuario ='$user'");
        $result = mysqli_fetch_array($result);

        $resultcart = mysqli_query($conexao,"INSERT INTO carrinho_produto
        (idUsuario, idProduto, quantidade) VALUES ('$result[0]','$id','$qts')");
        header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    }

}


?>


