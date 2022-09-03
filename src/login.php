<?php
session_start();
include('../src/conexao.php');

#Validação de usuario
if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    header('Location: ../src/index.php');
    exit();
}

#Proteção de login
$usuario = mysqli_real_escape_string($conexao, trim($_POST['usuario']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

#Verificando login
$query = "SELECT idUsuario, usuario, cargo FROM usuario WHERE usuario = '{$usuario}' AND senha = md5('{$senha}')";

#Execução da verificação
$result = mysqli_query($conexao, $query);
$row = mysqli_fetch_assoc($result);
if ($row['cargo'] == 'administrador' || $row['cargo'] == 'caixa') {
    $_SESSION['usuario'] = $usuario;
    header('Location: ../src/pages/principal/menu.php');
    exit();
} elseif ($row['cargo'] == 'garçom') {
    $_SESSION['usuario'] = $usuario;
    header('Location: ../src/pages/principal/venda.php');
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: ../src/index.php');
    exit();
}
