<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/css/main.css">
    
<link rel="icon" href="../../../public/assets/images/icone.PNG">
    <title>Login - Caipira do Pastel</title>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(../public/assets/images/caipira1.PNG);">
                </div>

                <form class="login100-form validate-form" action="../src/login.php" method="POST">
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Insira um usuario">
                        <span class="label-input100">Usuario</span>
                        <input autofocus class="input100" type="text" name="usuario" placeholder="Seu usuário">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-18" data-validate="Insira uma senha">
                        <span class="label-input100">Senha</span>
                        <input class="input100" type="password" name="senha" placeholder="Sua senha">
                        <span class="focus-input100"></span>
                    </div>
                    <?php
                    if (isset($_SESSION['nao_autenticado'])) :
                    ?>
                        <div class="notification">
                            <p>ERRO: Usuário ou senha inválidos.</p>
                        </div>
                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>

                    <div class="container-login100-form-btn">

                        <button class="login100-form-btn">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../public/assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../public/assets/vendor/animsition/js/animsition.min.js"></script>
    <script src="../public/assets/vendor/bootstrap/js/popper.js"></script>
    <script src="../public/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../public/assets/vendor/select2/select2.min.js"></script>
    <script src="../public/assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="../public/assets/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="../public/assets/vendor/countdowntime/countdowntime.js"></script>

</body>

</html>