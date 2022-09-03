<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


/* DANIFICADOS */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];

    $sqlProdutos = mysqli_query($conexao, "SELECT nomeDanificado, SUM(quantDanificado), SUM(quantDanificado)*valorDanificado FROM danificado 
    WHERE dataDanificado >= '$inicio' AND dataDanificado <= '$fim' 
    GROUP BY nomeDanificado ORDER BY SUM(quantDanificado) DESC;");
    $produtos = mysqli_fetch_all($sqlProdutos);
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
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="row justify-content-center" style="padding: 0 0 30px 0;">
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

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantia danificada</th>
                                <th scope="col">Custo perdido</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($produtos)) {
                                foreach ($produtos as $produto) {
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
            </div>
        </div>
    </section>
</body>

</html>