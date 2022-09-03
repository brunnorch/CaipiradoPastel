<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* FILTRO */
if (isset($_POST['submit'])) {
    $mes = $_POST['graficoMes'];

    /* FILTRO SELECIONADO */
    $grafico = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) totalDanificado, SUM(quantDanificado)*valorDanificado totalPerdido 
    FROM danificado 
    where dataDanificado BETWEEN ('2022-$mes-01') AND ('2022-$mes-31')
    GROUP BY nomeDanificado ORDER BY SUM(quantDanificado) DESC LIMIT 5");
    $grafico = mysqli_fetch_all($grafico);

    if ($mes == 00) {
        $grafico = mysqli_query($conexao, 'SELECT nomeDanificado, SUM(quantDanificado) totalDanificado, SUM(quantDanificado)*valorDanificado totalPerdido 
        FROM danificado 
         where month(dataDanificado) = month(now()) and year(dataDanificado) = year(now())
            GROUP BY nomeDanificado  ORDER BY SUM(quantDanificado) DESC LIMIT 5');
        $grafico = mysqli_fetch_all($grafico);
    }
} else {
    /* FILTRO PRE DEFINIDO (MES E ANO ATUAL) */
    $grafico = mysqli_query($conexao, 'SELECT nomeDanificado, SUM(quantDanificado) totalDanificado, SUM(quantDanificado)*valorDanificado totalPerdido 
    FROM danificado 
     where month(dataDanificado) = month(now()) and year(dataDanificado) = year(now())
        GROUP BY nomeDanificado  ORDER BY SUM(quantDanificado) DESC LIMIT 5');
    $grafico = mysqli_fetch_all($grafico);
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
                Gráfico Danificados
            </span>
        </div>
        <div class="home-content" style="height: 100%;">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center" style="height: 100%;">
                <div class="col-md-9" style="height: 100%;">
                    <form action="../graficos/graficoDanificados.php" method="POST">
                        <div class="input-group">
                            <select id="typeSelect" name="graficoMes">
                                <option value="00">Atual</option>
                                <option value="01">Janeiro</option>
                                <option value="02">Fevereiro</option>
                                <option value="03">Março</option>
                                <option value="04">Abril</option>
                                <option value="05">Maio</option>
                                <option value="06">Junho</option>
                                <option value="07">Julho</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setembro</option>
                                <option value="10">outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                            <button class="btn btn-primary" name="submit" type="submit">Ver</button>
                        </div>
                    </form>
                    <div style="height:80%;" id="container">
                        <script>
                            anychart.onDocumentReady(function() {

                                // create data
                                var data = [
                                    <?php foreach ($grafico as $produto) {
                                        echo "
                                        {
                                            x:'" . ucfirst($produto[0]) . "',
                                            value: " . $produto[1] . "
                                        },
                                        ";
                                    } ?>

                                ];


                                // create a chart and set the data
                                var chart = anychart.pie(data);
                                // background
                                chart.background({
                                    fill: "#E4E9F7 0.2"
                                });
                                chart.tooltip().format("Saíram: {%value} ");

                                // configure outlines
                                chart.normal().outline().enabled(true);
                                chart.normal().outline().width("5%");
                                chart.hovered().outline().width("10%");
                                chart.selected().outline().width("3");
                                chart.selected().outline().fill("#455a64");
                                chart.selected().outline().stroke(null);
                                chart.selected().outline().offset(2);

                                // set the chart title
                                chart.title("Produtos danificados no mês");

                                // set the container id
                                chart.container("container");

                                // initiate drawing the chart
                                chart.draw();
                            });

                            // switch the series type
                            function switchType() {
                                var select = document.getElementById("typeSelect");
                                series.seriesType(select.value);
                            }
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </section>
</body>

</html>