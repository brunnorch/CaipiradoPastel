<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* PRODUTOS */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $sqlProdutos = mysqli_query($conexao, "SELECT nomeProduto, SUM(qtdProduto), SUM(qtdProduto)*valorProduto FROM pedidos 
    WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' GROUP BY nomeProduto ORDER BY SUM(qtdProduto) DESC");
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
                Relatório Produtos
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <div class="row justify-content-center" style="padding: 0 0 30px 0;">
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

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade saida</th>
                                <th scope="col">Valor rendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($produtos)) {
                                foreach ($produtos as $produto) {
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
    </section>
</body>

</html>