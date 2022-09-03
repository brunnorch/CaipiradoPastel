<?php
session_start();
include_once('../../conexao.php');

if (isset($_GET['id'])) {
    //PEGA O ID DA URL E PASSA AS INFORMAÇÕES DO BANCO PARA A EXCLUIR
    $usuario = $_GET['id'];
    $excluirColab = mysqli_query($conexao, "DELETE FROM usuario WHERE idUsuario='$usuario'");

    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
