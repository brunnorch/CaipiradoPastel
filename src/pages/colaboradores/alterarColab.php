<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

//PEGA O ID DA URL E PASSA AS INFORMAÇÕES DO BANCO PARA A PAGINA EDITAR
if (isset($_GET['id'])) {
    $usuario = $_GET['id'];
    $editarUser = mysqli_query($conexao, "SELECT idUsuario,usuario,senha,cargo FROM usuario WHERE idUsuario='$usuario'");
    $editarUser = mysqli_fetch_assoc($editarUser);
}

/* ALTERAR DADOS DO COLABORADOR */
if (isset($_POST['submit'])) {
    
    $usuario = $_POST['idColab'];
    $nome = mysqli_real_escape_string($conexao, trim($_POST['colab']));
    $senhaColab = mysqli_real_escape_string($conexao, trim(md5($_POST['senha'])));
    $cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);

    $novoColab = mysqli_query($conexao, "UPDATE usuario SET usuario ='$nome', senha = '$senhaColab', cargo = '$cargo' WHERE idUsuario = '$usuario'");
    function alerta($type, $title, $msg)
        {
            echo "<script type='text/javascript'>
                Swal.fire({
                    icon: '$type',
                    title: '$title',
                    text: '$msg',
                    showConfirmButton: true
                });
                </script>";
        }
        $alert = alerta("success", "USUÁRIO EDITADO", "Usuario modificado com sucesso!"); 
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Editar Colaborador
            </span>
        </div>
        <div class="home-content">
            <!-- ALTERAR CADASTRO DE COLABORADOR -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4">
                    <form class="row g-3" action="../colaboradores/alterarColab.php" method="POST">

                        <div class="col-md-12">
                            <input type="hidden" class="form-control" id="idColab" name="idColab" maxlength="30" value="<?= $editarUser['idUsuario'] ?>">
                        </div>
                        <div class="col-md-12">
                            <label for="text" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="colab" name="colab" maxlength="30" value="<?= $editarUser['usuario'] ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="text" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" maxlength="30" required>
                        </div>
                        <div class="form-check" style="margin: 40px 0 0 10px;">
                            <input class="form-check-input" type="radio" name="cargo" id="flexRadioDefault1" value="caixa" required>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Caixa
                            </label>
                        </div>
                        <div class="form-check " style="margin: 20px 0 30px 10px;">
                            <input class="form-check-input" type="radio" name="cargo" id="flexRadioDefault2" value="garçom" required>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Garçom
                            </label>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        </div>
    </section>
</body>

</html>