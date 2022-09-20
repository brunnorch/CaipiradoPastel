<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* RELATORIO DO CAIXA MENSAL */
$sqlCaixa = mysqli_query($conexao, "SELECT  ROW_NUMBER() over(), MONTHNAME(dataCaixa), SUM(saldoInicial), SUM(entrada), SUM(saida), SUM(saldoInicial + entrada - saida) as total
from caixa 
group by month(dataCaixa)");
$caixa = mysqli_fetch_all($sqlCaixa);

$grafico = mysqli_query($conexao, 'SELECT  MONTHNAME(dataCaixa), SUM(entrada), SUM(saida), SUM(saldoInicial + entrada - saida) as total
                from caixa 
                group by month(dataCaixa)');

$grafico = mysqli_fetch_all($grafico);
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
                Relatório Caixa
            </span>
        </div>
        <div class="home-content" style="height: 100%;">
            <div class="row align-items-center justify-content-center" style="height: 100%;">
                <div class="col-md-10" style="height: 100%;">

                    <!-- GRAFICO DE COMPARAÇÃO DOS MESES -->
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
                                    <?php foreach ($grafico as $mes) {
                                        echo "
                                        ['" . $mes[0] . "','" . $mes[3] . "'],
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

            <!-- TABELA DOS MESES DO ANO -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <!-- EXIBE OS MESES DO ANO -->
                    <table id="caixa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Mês</th>
                                <th scope="col">Saldo Inicial</th>
                                <th scope="col">Entradas</th>
                                <th scope="col">Saidas</th>
                                <th scope="col">Total caixa</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($caixa as $mes) : ?>
                                <tr>
                                    <td><?= $mes[1] ?></td>
                                    <td>R$<?= number_format($mes[2], 2, ",", ".") ?></td>
                                    <td style='color:green; font-weight:bold'>R$<?= number_format($mes[3], 2, ",", ".") ?></td>
                                    <td style='color:red; font-weight:bold'>R$<?= number_format($mes[4], 2, ",", ".") ?></td>
                                    <td style='color:blue; font-weight:bold'>R$<?= number_format($mes[5], 2, ",", ".") ?></td>
                                    <td><a href='../relatorios/caixaMesDetalhe.php?mes=detalhe&id=<?= $mes[0] ?>' class='btn btn-outline-primary'>Ver</a></td>
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
            columnDefs: [{
                searchable: false,
                orderable: false,
                targets: 0,
            }, ],
            order: [
                [1, 'asc']
            ],
        });

        $('#caixa').on('mouseenter', 'td', function() {
            var colIdx = table.cell(this).index().column;

            $(table.cells().nodes()).removeClass('highlight');
            $(table.column(colIdx).nodes()).addClass('highlight');
        });
    });
</script>

</html>