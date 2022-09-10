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


/* VERIFICA QUEM ESTÁ LOGANDO E REDIRECIONA */
$login = mysqli_query($conexao, "SELECT idUsuario, usuario, cargo FROM usuario WHERE usuario = '{$usuario}' AND senha = md5('{$senha}')");
$logado = mysqli_fetch_assoc($login);
if ($logado['cargo'] == 'administrador' || $logado['cargo'] == 'caixa') {
    $_SESSION['usuario'] = $usuario;
    header('Location: ../src/pages/principal/menu.php');
    exit();
} elseif ($logado['cargo'] == 'garçom') {
    $_SESSION['usuario'] = $usuario;
    header('Location: ../src/pages/principal/venda.php');
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: ../src/index.php');
    exit();
}
