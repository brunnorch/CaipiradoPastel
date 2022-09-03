<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$comanda = $_GET['id'];
/* SELECT PARA APRESENTAR NO INPUT A MESA OU COMANDA */
$info = mysqli_query($conexao, "SELECT * FROM numero_mesas WHERE comanda ='$comanda'");
$info = mysqli_fetch_row($info);

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Editar Mesa
            </span>
        </div>
        <div class="home-content">
            <!-- ALTERAR INFORMAÇÕES DA MESA -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4">
                    <form class="row g-3" action="../mesas/editarMesaController.php?id=<?php echo $comanda; ?>" method="POST">
                        <div class="col-md-12">
                            <label for="inputCity" class="form-label">Numero da Mesa</label>
                            <input type="text" class="form-control" id="newMesa" name="newMesa" value="<?php echo $info[0]; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="inputCity" class="form-label">Numero da Comanda</label>
                            <input type="text" class="form-control" id="newComanda" name="newComanda" value="<?php echo $info[1]; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Garçom</label>
                            <div class="col-auto">
                                <select class="form-select" name="newGarcom" required>
                                    <option selected></option>
                                    <?php
                                    $usuarios = mysqli_query($conexao, "SELECT usuario FROM usuario WHERE idUsuario > '2'");
                                    $usuarios = mysqli_fetch_all($usuarios);

                                    foreach ($usuarios as $usuario) {
                                        echo "
                                            <option value='" . $usuario[0] . "'>" . ucfirst($usuario[0]) . "</option>
                                            ";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                            <a href="../mesas/verMesa.php?id=<?php echo $comanda ?>" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>

                </div>
    </section>
</body>

</html>