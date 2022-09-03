<?php
session_start();
include_once('../conexao.php');
if (isset($_GET['remover']) && $_GET['remover'] == 'carrinho') {
    $id = $_GET['id'];

    /* EXCLUI UM POR UM */
    $sqlDel = mysqli_query($conexao, "UPDATE carrinho_produto SET quantidade = quantidade - '1' WHERE idProduto ='$id'");
    header('Location:../pages/principal/carrinho.php');

    /* SE FOR IGUAL A 0 ELE EXCLUI O PRODUTO */
    $carrinho = mysqli_query($conexao, "SELECT quantidade from carrinho_produto where idProduto ='$id'");
    $carrinho = mysqli_fetch_row($carrinho);
    if ($carrinho[0] == 0) {

        $sqldel = mysqli_query($conexao, "DELETE FROM carrinho_produto WHERE idProduto = '$id'");
        header('Location:../pages/principal/carrinho.php');
    }
}
