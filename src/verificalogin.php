<?php
#Autenticando usuario
if (!$_SESSION['usuario']) {
    header('Location: ../src/index.php');
    exit();
}
