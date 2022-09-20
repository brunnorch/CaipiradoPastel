<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


/* DETALHES DO RELATORIO MENSAL DO CAIXA */

if (isset($_GET['mes']) && $_GET['mes'] == 'detalhe') {
    $id = $_GET['id'];

    $sqlMes = mysqli_query($conexao, "SELECT dataCaixa,saldoInicial, cartao, pix, dinheiro, entrada,saida, SUM(saldoInicial + entrada - saida) as saldoCaixa
    FROM caixa
    WHERE dataCaixa BETWEEN ('2022-0$id-01') AND ('2022-0$id-30') group by dataCaixa");
    $detalheMes = mysqli_fetch_all($sqlMes);
} else {
    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
</head>
<style>
    #container {
        width: 100%;
        height: 100%;
        margin: 0;
    }
</style>

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Caixa (Diário)
            </span>
        </div>
        <div class="home-content" style="height: 100%;">


            <!-- GRAFICO DE COMPARAÇÃO DOS MESES -->
            <div class="row align-items-center justify-content-center" style="height: 100%;">
                <div class="col-md-12" style="height: 100%;">
                    <div class="row justify-content-end" style="padding: 0 0 30px 0;">
                        <div class="col-auto">
                            <a href="../relatorios/caixaMes.php" class="btn btn-primary" id="fechaCaixa" name="fechaCaixa">Voltar</a>
                        </div>
                    </div>
                    <div style="height:80%;" id="container">
                        <script>
                            anychart.onDocumentReady(function() {
                                // create column chart
                                var chart = anychart.column();

                                // turn on chart animation
                                chart.animation(true);

                                // set chart title text settings
                                chart.title('Movimentação por mês');

                                // create area series with passed data
                                var series = chart.column([
                                    <?php foreach ($detalheMes as $mes) {
                                        echo "
                                        ['" . $mes[0] . "','" . $mes[7] . "'],
                                        ";
                                    } ?>
                                ]);


                                chart.background({
                                    fill: "#E4E9F7 0.2"
                                });

                                // set series tooltip settings
                                series.tooltip().titleFormat('{%X}');

                                series
                                    .tooltip()
                                    .position('center-top')
                                    .anchor('center-bottom')
                                    .offsetX(0)
                                    .offsetY(5)
                                    .format('R${%Value}{groupsSeparator: }');

                                // set scale minimum
                                chart.yScale().minimum(0);

                                // set yAxis labels formatter
                                chart.yAxis().labels().format('R${%Value}{groupsSeparator: }');

                                // tooltips position and interactivity settings
                                chart.tooltip().positionMode('point');
                                chart.interactivity().hoverMode('by-x');

                                // axes titles
                                chart.xAxis().title('Mês');
                                chart.yAxis().title('Movimentação');

                                // set container id for the chart
                                chart.container('container');

                                // initiate chart drawing
                                chart.draw();
                            });
                        </script>
                    </div>
                </div>
            </div>


            <!-- DETALHES DO MES SELECIONADO -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">

                    <!-- EXIBE O CAIXA DE TODOS OS DIAS DO MES SELECIONADO -->
                    <table id="caixa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Data do Caixa</th>
                                <th scope="col">Saldo Inicial</th>
                                <th scope="col">Cartão</th>
                                <th scope="col">Pix</th>
                                <th scope="col">Dinheiro</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Saida</th>
                                <th scope="col">Saldo do caixa</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalheMes as $detalhe) : ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($detalhe[0])) ?></td>
                                    <td>R$<?= number_format($detalhe[1], 2, ",", ".") ?></td>
                                    <td>R$<?= number_format($detalhe[2], 2, ",", ".") ?></td>
                                    <td>R$<?= number_format($detalhe[3], 2, ",", ".") ?></td>
                                    <td>R$<?= number_format($detalhe[4], 2, ",", ".") ?></td>
                                    <td style='color:green; font-weight:bold'>R$<?= number_format($detalhe[5], 2, ",", ".") ?></td>
                                    <td style='color:red; font-weight:bold'>R$<?= number_format($detalhe[6], 2, ",", ".") ?></td>
                                    <td style='color:blue; font-weight:bold'>R$<?= number_format($detalhe[7], 2, ",", ".") ?></td>
                                    <td><a href="imprimeCaixa.php?data=<?= $detalhe[0] ?>" target='_blank' class='btn btn-dark'><i class='bx bx-printer'></i></i></a></td>
                                </tr>
                            <?php endforeach; ?>
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
        var table = $('#caixa').DataTable({
            scrollY: '350px',
            scrollCollapse: true,
            paging: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
            },

        });

        $('#caixa').on('mouseenter', 'td', function() {
            var colIdx = table.cell(this).index().column;

            $(table.cells().nodes()).removeClass('highlight');
            $(table.column(colIdx).nodes()).addClass('highlight');
        });
    });
</script>

</html>