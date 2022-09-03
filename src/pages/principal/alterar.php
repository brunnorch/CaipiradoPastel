<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

if (!empty($_GET['id'])) {
    //PEGA O ID DA URL E PASSA AS INFORMAÇÕES DO BANCO PARA A PAGINA EDITAR
    $id = $_GET['id'];
    $sql = "SELECT idProduto,nomeProduto,valorProduto, quantiaProduto FROM produtos WHERE idProduto=$id";
    $result = mysqli_query($conexao, $sql);
    $userdata = mysqli_fetch_assoc($result);
}
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
                            <label class="form-label">Codigo</label>
                            <input readonly type="number" class="form-control" id="codigo" name="codigo" maxlength="3" value="<?php echo $userdata['idProduto']; ?>" style="cursor: no-drop;" required>
                        </div>
                        <div class="col-md-8">
                            <label for="text" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="30" value="<?php echo $userdata['nomeProduto']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Data</label>
                            <input readyonly type="text" class="form-control" id="dataAlteracao" name="dataAlteracao" style="cursor: no-drop; text-align: center;" value="<?php $hoje = date('d/m/Y');
                                                                                                                                                                            echo $hoje; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label">Valor</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valor" id="valor" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" value="<?php echo $userdata['valorProduto']; ?>" required>
                                <span class="input-group-text">,00</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="quant" name="quant" min="1" maxlength="99" value="<?php echo $userdata['quantiaProduto']; ?>" required>
                        </div>
                        <div>
                            <?php
                            if (isset($_SESSION['cadastrado'])) :
                            ?>
                                <div style="color: green;">
                                    <p>PRODUTO CADASTRADO COM SUCESSO!</p>
                                </div>
                            <?php
                            endif;
                            unset($_SESSION['cadastrado']);
                            ?>
                            <?php
                            if (isset($_SESSION['existente'])) :
                            ?>
                                <div style="color:red;">
                                    <p>PRODUTO JÁ CADASTRADO</p>
                                </div>
                            <?php
                            endif;
                            unset($_SESSION['existente']);
                            ?>
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