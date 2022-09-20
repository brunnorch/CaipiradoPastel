<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


$hoje = date('Y-m-d');
/* DANIFICADOS */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    $pasteis = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '10%' GROUP BY nomeDanificado ORDER BY total DESC");
    $pasteis = mysqli_fetch_all($pasteis);

    $salgados = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '20%' GROUP BY nomeDanificado ORDER BY total DESC");
    $salgados = mysqli_fetch_all($salgados);

    $doces = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '30%' GROUP BY nomeDanificado ORDER BY total DESC");
    $doces = mysqli_fetch_all($doces);

    $bebidas = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '40%' AND NOT nomeDanificado ='vasilhame' GROUP BY nomeDanificado ORDER BY total DESC");
    $bebidas = mysqli_fetch_all($bebidas);

    $refrigerantes = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '50%' GROUP BY nomeDanificado ORDER BY total DESC");
    $refrigerantes = mysqli_fetch_all($refrigerantes);

    $alcoolicos = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' AND idProduto LIKE '60%' GROUP BY nomeDanificado ORDER BY total DESC");
    $alcoolicos = mysqli_fetch_all($alcoolicos);
}
else {
    $pasteis = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '10%' GROUP BY nomeDanificado ORDER BY total DESC");
    $pasteis = mysqli_fetch_all($pasteis);

    $salgados = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '20%' GROUP BY nomeDanificado ORDER BY total DESC");
    $salgados = mysqli_fetch_all($salgados);

    $doces = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '30%' GROUP BY nomeDanificado ORDER BY total DESC");
    $doces = mysqli_fetch_all($doces);

    $bebidas = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '40%' AND NOT nomeDanificado ='vasilhame' GROUP BY nomeDanificado ORDER BY total DESC");
    $bebidas = mysqli_fetch_all($bebidas);

    $refrigerantes = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '50%' GROUP BY nomeDanificado ORDER BY total DESC");
    $refrigerantes = mysqli_fetch_all($refrigerantes);

    $alcoolicos = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado) AS total, SUM(quantDanificado)*valorDanificado as valor FROM danificado WHERE dataDanificado >= '$hoje' AND dataDanificado <= '$hoje' AND idProduto LIKE '60%' GROUP BY nomeDanificado ORDER BY total DESC");
    $alcoolicos = mysqli_fetch_all($alcoolicos);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Danificados
            </span>
        </div>
        <div class="home-content">

            <div class="row align-items-center justify-content-center">
                <div class="col-md-9">

                    <!-- FILTRO DE DATA INICIAL E FINAL-->
                    <div class="row justify-content-center filterDate">
                        <form action="../relatorios/danificados.php" method="POST">
                            <div class="col-md-6 input-group justify-content-center">
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


                            <!-- TABELA DE PRODUTOS DOS PASTEIS-->
                            <table id="pasteis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Quantia danificada</th>
                                        <th scope="col">Custo perdido</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($pasteis)) {
                                        foreach ($pasteis as $produto) {
                                            echo "<tr>";
                                            echo "<th>" . ucfirst($produto[0]) . "</td>";
                                            echo "<th style='color:blue;'>" . $produto[1] . "</th>";
                                            echo "<th style='color:red;'>R$" . number_format($produto[2], 2, ",", ".") . "</th>";
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