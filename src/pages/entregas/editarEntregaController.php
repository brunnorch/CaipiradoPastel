<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$idEntrega = $_GET['id'];
/* ALTERANDO OS DADOS DA ENTREGA */
if (isset($_POST['submit'])) {
    $garcom = $_POST['garcom'];
    $cliente = $_POST['cliente'];
    $celular = $_POST['celular'];
    $bairro = $_POST['bairro'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $taxa = $_POST['taxa'];

    $edit = mysqli_query($conexao, "UPDATE entregas SET garcom = '$garcom', clienteEntrega ='$cliente', celularEntrega ='$celular',
    bairroEntrega ='$bairro', enderecoEntrega = ' $endereco', numeroEntrega =' $numero', taxaEntrega =' $taxa' where idEntrega = '$idEntrega'");
    header('location:../entregas/entregaAndamento.php');
} else {
    header("Location:../entregas/entregaAndamento.php");
}
