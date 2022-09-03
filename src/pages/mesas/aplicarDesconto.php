<?php
session_start();
include_once('../../verificalogin.php');
include_once('../../conexao.php');

if (isset($_POST['aplicarDesc'])) {
    $total = $_POST['total'];
    $desc = $_POST['desconto'];

    $valorPagar = $total - $desc;
    $_SESSION['desconto'] = $desc;
    $_SESSION['valorFinal'] = $valorPagar;

    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
