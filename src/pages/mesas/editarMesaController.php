<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$comanda = $_GET['id'];
/* ALTERANDO MESA OU COMANDA */
if (isset($_POST['submit'])) {
    $newMesa = $_POST['newMesa'];
    $newComanda = $_POST['newComanda'];
    $newGarcom = $_POST['newGarcom'];

    /* VERIFICA SE JÁ EXISTE UMA MESA COM A MESMA NUMERAÇÃO */
    $sqlMesa = mysqli_query($conexao, "SELECT idMesa FROM numero_mesas WHERE idMesa = '$mesa'");
    $existeMesa = mysqli_fetch_row($sqlMesa);

    /* PEGA O ID DA COMANDA PARA VERIFICAR SE EXISTE */
    $sqlComanda = mysqli_query($conexao, "SELECT comanda FROM numero_mesas where comanda = '$comanda'");
    $existeComanda = mysqli_fetch_row($sqlComanda);


    if ($newMesa == $existeMesa[0] && $newComanda == $existeComanda[0]) {
        $_SESSION['mesaExiste'] = true;
    } else {

        /* ALTERANDO MESA E COMANDA */
        $edit = mysqli_query($conexao, "UPDATE numero_mesas SET idMesa = '$newMesa', comanda = '$newComanda', garcom = '$newGarcom' where comanda = '$comanda'");
        $edit = mysqli_query($conexao, "UPDATE mesas SET comanda = '$newComanda' where comanda = '$comanda'");
        header('location:../principal/mesa.php');
    }
} else {
    header("Location:../principal/mesa.php");
}
