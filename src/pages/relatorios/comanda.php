<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

$hoje = date('Y-m-d');

/*PESQUISA DE COMANDAS POR FILTRO */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $comandas = mysqli_query($conexao, "SELECT idComanda, dataVenda,desconto, totalPedido FROM comandas WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' order by idComanda");
    $comandas = mysqli_fetch_all($comandas);
} else {
    /* SEM FILTRO, APARECE AS COMANDAS DO DIA */
    $comandas = mysqli_query($conexao, "SELECT idComanda, dataVenda,desconto, totalPedido FROM comandas WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' order by idComanda");
    $comandas = mysqli_fetch_all($comandas);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Comandas
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-center" style="padding: 0 0 30px 0;">
                        <form action="../relatorios/comanda.php" method="POST">
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
                    <!-- EXIBE AS COMANDAS DE ACORDO COM O FILTRO PASSADO -->
                    <table id="comanda" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Comanda</th>
                                <th scope="col">Data</th>
                                <th scope="col">SubTotal</th>
                                <th scope="col">Desconto</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($comandas)) : ?>
                                <?php foreach ($comandas as $comanda) : ?>
                                    <tr>
                                        <td><?= $comanda[0] ?></td>
                                        <td><?= date('d/m/Y', strtotime($comanda[1])) ?></td>
                                        <td style='color:blue; font-weight:bold'>R$<?= number_format($comanda[3] + $comanda[2], 2, ",", ".") ?></td>
                                        <td style='color:red; font-weight:bold'>R$<?= number_format($comanda[2], 2, ",", ".") ?></td>
                                        <td style='color:green; font-weight:bold'>R$<?= number_format($comanda[3], 2, ",", ".") ?></td>
                                        <td><a href='../relatorios/imprimirComanda.php?id=<?= $comanda[0] ?>' target='_blank' id='modal-detalhes-<?= $comanda[0] ?>' onclick='incrementClick($comanda[0])' class='btn btn-outline-primary'>Ver</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
<!-- DATA TABLE  -->
<script>
    $(document).ready(function() {
        var table = $('#comanda').DataTable({
            scrollY: '330px',
            scrollCollapse: true,
            paging: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
            },

        });

        $('#comanda').on('mouseenter', 'td', function() {
            var colIdx = table.cell(this).index().column;

            $(table.cells().nodes()).removeClass('highlight');
            $(table.column(colIdx).nodes()).addClass('highlight');
        });
    });
</script>

</html>