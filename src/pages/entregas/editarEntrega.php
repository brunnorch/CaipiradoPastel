<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$idEntrega = $_GET['id'];
/* SELECT PARA APRESENTAR NO INPUT A MESA OU COMANDA */
$info = mysqli_query($conexao, "SELECT clienteEntrega,celularEntrega,bairroEntrega,enderecoEntrega,numeroEntrega,taxaEntrega FROM entregas WHERE idEntrega ='$idEntrega'");
$info = mysqli_fetch_row($info);


$usuarios = mysqli_query($conexao, "SELECT usuario FROM usuario WHERE idUsuario > '2'");
$usuarios = mysqli_fetch_all($usuarios);
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
                <div class="col-md-8">
                    <form class="row g-3" action="../entregas/editarEntregaController.php?id=<?= $idEntrega; ?>" method="POST">

                        <div class="col-md-3">
                            <label class="form-label">Garçom</label>
                            <div class="col-auto">
                                <select class="form-select" name="garcom" required>
                                    <option selected></option>
                                    <?php foreach ($usuarios as $usuario) : ?>
                                        <option value='<?= $usuario[0] ?>  '> <?= ucfirst($usuario[0]) ?> </option>
                                        ";
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="inputCity" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" value="<?= $info[0]; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label">Celular</label>
                            <input type="number" class="form-control" id="celular" name="celular" value="<?= $info[1]; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inputCity" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="<?= $info[2]; ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label for="inputCity" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="<?= $info[3]; ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label">Numero</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="<?= $info[4]; ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label">Taxa</label>
                            <input type="text" class="form-control" id="taxa" name="taxa" value="<?= number_format($info[5], 2, ", ", " . "); ?>" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                        </div>

                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                            <a href="../entregas/verEntrega.php?id=<?= $idEntrega ?>" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>

                </div>
    </section>
</body>

</html>