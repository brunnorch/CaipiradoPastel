<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/*PESQUISA DE COMANDAS POR FILTRO */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $saidas = mysqli_query($conexao, "SELECT dataSaida, valorSaida, descricao FROM 
    saida_caixa WHERE dataSaida >= '$inicio' AND dataSaida <= '$fim' order by dataSaida");
    $saidas = mysqli_fetch_all($saidas);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Saídas
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="row col-md-12">
                    <div class="row justify-content-center" style="padding: 0 0 30px 0;">
                        <form action="../relatorios/saidas.php" method="POST">
                            <div class="input-group justify-content-center">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="floatingInputGrid" name="inicio" placeholder="Data Inicial" required>
                                    <label for="floatingInputGrid">Data inicial</label>
                                </div>
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="floatingInputGrid" name="fim" placeholder="Data Final" required>
                                    <label for="floatingInputGrid">Data Final</label>
                                </div>
                                <input type="submit" value="Pesquisar" name="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <?php if(isset($saidas)) : ?>
                    <?php foreach ($saidas as $saida) : ?>
                        <div class='col'>
                            <div class='p-3 border bg-light rounded-3' style='text-align: center;'>
                                <h4><?= date('d/m/Y', strtotime($saida[0]))  ?></h4>
                                <p>R$ <?= $saida[1]  ?></p>
                                <div>
                                    <p><?= ucfirst($saida[2])  ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</body>

</html>