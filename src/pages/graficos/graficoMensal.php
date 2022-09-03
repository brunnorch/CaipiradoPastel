<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


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
    <style>
        #container {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>
</head>

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Gráfico Mensal
            </span>
        </div>
        <div class="home-content" style="height: 100%;">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center" style="height: 100%;">
                <div class="col-md-9" style="height: 100%;">
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

        </div>
    </section>
</body>

</html>