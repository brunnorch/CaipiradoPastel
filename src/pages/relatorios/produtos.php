<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

$hoje = date('Y-m-d');
/* SELECTS DE PRODUTO MAIS VENDIDOS DE CADA GRUPO */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    $pasteisGraf = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '10%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC LIMIT 10");
    $pasteisGraf = mysqli_fetch_all($pasteisGraf);

    $pasteis = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '10%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $pasteis = mysqli_fetch_all($pasteis);

    $salgados = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '20%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $salgados = mysqli_fetch_all($salgados);

    $doces = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '30%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $doces = mysqli_fetch_all($doces);

    $bebidas = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '40%' AND NOT nomeProduto ='vasilhame' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $bebidas = mysqli_fetch_all($bebidas);

    $refrigerantes = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '50%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $refrigerantes = mysqli_fetch_all($refrigerantes);

    $alcoolicos = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' AND idProduto LIKE '60%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $alcoolicos = mysqli_fetch_all($alcoolicos);
} else {
    /* SEM FILTRO, APARECE AS COMANDAS DO DIA */
    $pasteisGraf = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '10%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC LIMIT 10");
    $pasteisGraf = mysqli_fetch_all($pasteisGraf);

    $pasteis = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '10%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $pasteis = mysqli_fetch_all($pasteis);

    $salgados = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '20%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $salgados = mysqli_fetch_all($salgados);

    $doces = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '30%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $doces = mysqli_fetch_all($doces);

    $bebidas = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '40%' AND NOT nomeProduto ='vasilhame' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $bebidas = mysqli_fetch_all($bebidas);

    $refrigerantes = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '50%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $refrigerantes = mysqli_fetch_all($refrigerantes);

    $alcoolicos = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto) AS total, SUM(qtdProduto * valorProduto) as renda FROM pedidos WHERE dataVenda >= '$hoje' AND dataVenda <= '$hoje' AND idProduto LIKE '60%' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
    $alcoolicos = mysqli_fetch_all($alcoolicos);
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
                Relatório Produtos
            </span>
        </div>

        <div class="home-content" style="height: 100%;">
            <div class="row align-items-center justify-content-center" style="height: 100%;">
                <div class="col-md-10" style="height: 100%;">

                    <!-- FILTRO DE DATA INICIAL E FINAL-->
                    <div class="row justify-content-center">
                        <form action="../relatorios/produtos.php" method="POST">
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

                    <!-- ABAS DOS GRUPOS DOS PRODUTOS-->
                    <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-pasteis-tab" data-bs-toggle="tab" data-bs-target="#nav-pasteis" type="button" role="tab" aria-controls="nav-pasteis" aria-selected="true">Pasteis</button>
                            <button class="nav-link" id="nav-salgados-tab" data-bs-toggle="tab" data-bs-target="#nav-salgados" type="button" role="tab" aria-controls="nav-salgados" aria-selected="false">Salgados</button>
                            <button class="nav-link" id="nav-doces-tab" data-bs-toggle="tab" data-bs-target="#nav-doces" type="button" role="tab" aria-controls="nav-doces" aria-selected="false">Doces</button>
                            <button class="nav-link" id="nav-bebidas-tab" data-bs-toggle="tab" data-bs-target="#nav-bebidas" type="button" role="tab" aria-controls="nav-bebidas" aria-selected="false">Bebidas</button>
                            <button class="nav-link" id="nav-refrigerantes-tab" data-bs-toggle="tab" data-bs-target="#nav-refrigerantes" type="button" role="tab" aria-controls="nav-refrigerantes" aria-selected="false">Refrigerantes</button>
                            <button class="nav-link" id="nav-alcoolicos-tab" data-bs-toggle="tab" data-bs-target="#nav-alcoolicos" type="button" role="tab" aria-controls="nav-alcoolicos" aria-selected="false">Alcoolicos</button>
                        </div>
                    </nav>

                    <!-- EXIBE PRODUTOS EM SUAS ABAS -->
                    <div class="tab-content" id="nav-tabContent" style="height: 100%;">

                        <!-- ABAS DE PASTEIS -->
                        <div class="tab-pane fade show active" id="nav-pasteis" role="tabpanel" aria-labelledby="nav-pasteis-tab" style="height: 100%;">

                            <!-- GRAFICO DE PRODUTOS DOS PASTEIS-->
                            <div style="height:80%;" id="container">
                                <script>
                                    anychart.onDocumentReady(function() {

                                        // create data
                                        var data = [
                                            <?php foreach ($pasteisGraf as $produto) {
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
                                        chart.tooltip().format("Vendeu: {%value} ");

                                        // configure outlines
                                        chart.normal().outline().enabled(true);
                                        chart.normal().outline().width("5%");
                                        chart.hovered().outline().width("10%");
                                        chart.selected().outline().width("3");
                                        chart.selected().outline().fill("#455a64");
                                        chart.selected().outline().stroke(null);
                                        chart.selected().outline().offset(2);

                                        // set the chart title
                                        chart.title("Gráficos de vendas dos pasteis");

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

                            <br><br>

                            <!-- TABELA DE PRODUTOS DOS PASTEIS-->
                            <table id="pasteis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($pasteis)) {
                                        foreach ($pasteis as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <!-- ABAS DE SALGADOS -->
                        <div class="tab-pane fade" id="nav-salgados" role="tabpanel" aria-labelledby="nav-salgados-tab">


                            <!-- TABELA DE PRODUTOS DOS SALGADOS -->
                            <table id="salgados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($salgados)) {
                                        foreach ($salgados as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <!-- ABAS DE DOCES -->
                        <div class="tab-pane fade" id="nav-doces" role="tabpanel" aria-labelledby="nav-doces-tab">


                            <!-- TABELA DE PRODUTOS DOS DOCES -->
                            <table id="doces" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($doces)) {
                                        foreach ($doces as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <!-- ABAS DE BEBIDAS -->
                        <div class="tab-pane fade" id="nav-bebidas" role="tabpanel" aria-labelledby="nav-bebidas-tab">


                            <!-- TABELA DE PRODUTOS DOS BEBIDAS -->
                            <table id="bebidas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($bebidas)) {
                                        foreach ($bebidas as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <!-- ABAS DE REFRIGERANTES -->
                        <div class="tab-pane fade" id="nav-refrigerantes" role="tabpanel" aria-labelledby="nav-refrigerantes-tab">

                            <!-- TABELA DE PRODUTOS DOS REFRIGERANTES -->
                            <table id="refrigerantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($refrigerantes)) {
                                        foreach ($refrigerantes as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>


                        </div>

                        <!-- ABAS DE ALCOOLICOS -->
                        <div class="tab-pane fade" id="nav-alcoolicos" role="tabpanel" aria-labelledby="nav-alcoolicos-tab">

                            <!-- TABELA DE PRODUTOS DOS ALCOOLICOS -->
                            <table id="alcoolicos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantidade saida</th>
                                        <th scope="col">Valor rendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($alcoolicos)) {
                                        foreach ($alcoolicos as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:green;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>