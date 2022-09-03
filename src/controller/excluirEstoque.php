<?php
session_start();
include_once('../conexao.php');

if (!empty($_GET['id'])) {
    //PEGA O ID DA URL E PASSA AS INFORMAÇÕES DO BANCO PARA A EXCLUIR
    $id = $_GET['id'];
    $sql = "SELECT * FROM produtos WHERE idProduto=$id";
    $result = mysqli_query($conexao, $sql);
    $userdata = mysqli_fetch_assoc($result);

    //REALIZA A EXCLUSÃO
    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM produtos WHERE idProduto =$id";
        $resultDelete = mysqli_query($conexao, $sqlDelete);
    }
    header('Location: ../pages/principal/estoque.php');
    exit;
}
