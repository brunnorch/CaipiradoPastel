<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

if (!empty($_GET['id'])) {
    //PEGA O ID DA URL E PASSA AS INFORMAÇÕES DO BANCO PARA A PAGINA EDITAR
    $id = $_GET['id'];
    $result = mysqli_query($conexao, "SELECT idProduto,grupo,tipo,nomeProduto,valorProduto,minProduto, quantiaProduto FROM produtos WHERE idProduto=$id");
    $userdata = mysqli_fetch_assoc($result);
}
$hoje = date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Manutenção do Produto
            </span>
        </div>
        <div class="home-content">
            <!-- ALTERAÇÃO DE PRODUTOS -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">
                    <form class="row g-3" action="../../controller/updateEstoque.php" method="POST">
                        <div class="col-md-4">
                            <label class="form-label">Grupo</label>
                            <div class="col-auto">
                                <select class="form-select" name="grupo" required>
                                    <?php if ($userdata['grupo'] == 1) : ?>
                                        <option selected>01 - Pasteis</option>
                                    <?php elseif ($userdata['grupo'] == 2) : ?>
                                        <option selected>02 - Salgados</option>
                                    <?php elseif ($userdata['grupo'] == 3) : ?>
                                        <option selected>03 - Doces</option>
                                    <?php elseif ($userdata['grupo'] == 4) : ?>
                                        <option selected>04 - Bebidas</option>
                                    <?php elseif ($userdata['grupo'] == 5) : ?>
                                        <option selected>05 - Alcoolicos</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Codigo</label>
                            <input readonly type="number" class="form-control" id="codigo" name="codigo" maxlength="3" value="<?= $userdata['idProduto']; ?>" style="cursor: no-drop;" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Data</label>
                            <input readyonly type="text" class="form-control" id="dataAlteracao" name="dataAlteracao" style="cursor: no-drop; text-align: center;" value="<?= $hoje ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unidade Venda</label>
                            <div class="col-auto">
                                <select class="form-select" name="tipo" required>
                                    <option value='<?= $userdata['tipo'] ?>' selected><?= $userdata['tipo'] ?></option>
                                    <option value='UN'>UN</option>
                                    <option value='PÇ'>PÇ</option>
                                    <option value='ML'>ML</option>
                                    <option value='LT'>LT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="text" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="30" value="<?= $userdata['nomeProduto']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label">Valor</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valor" id="valor" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" value="<?= $userdata['valorProduto']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estoque Minímo</label>
                            <input type="number" class="form-control" id="minimo" name="minimo" min="1" maxlength="99" value="<?= $userdata['minProduto']; ?>">
                        </div>
                        <div class=" col-md-4">
                            <label for="inputCity" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="quant" name="quant" min="1" maxlength="99" value="<?= $userdata['quantiaProduto']; ?>" required>
                        </div>
                        <div>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</body>

</html>