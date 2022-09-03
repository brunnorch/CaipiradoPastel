<?php
session_start();
include_once('../conexao.php');

/*AUMENTANDO A QUANTIDADE DE ITENS DO CARRINHO  */
if (isset($_GET['add']) && $_GET['add'] == 'carrinho') {
    $id = $_GET['id'];
    $sqladd = "UPDATE carrinho_produto SET quantidade = quantidade + 1 WHERE idProduto = $id";
    $resultadd = mysqli_query($conexao, $sqladd);
    header("Location:../pages/principal/carrinho.php");
}
