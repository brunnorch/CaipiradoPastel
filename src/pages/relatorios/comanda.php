<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/*PESQUISA DE COMANDAS POR FILTRO */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $comandas = mysqli_query($conexao, "SELECT idComanda, dataVenda,desconto, totalPedido FROM comandas WHERE dataVenda >= '$inicio' AND dataVenda <= '$fim' order by idComanda");
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

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Comanda</th>
                                <th scope="col">Data</th>
                                <th scope="col">SubTotal</th>
                                <th scope="col">Desconto</th>
                                <th scope="col">Total</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($comandas)) {
                                foreach ($comandas as $comanda) {
                                    echo "<tr>";
                                    echo "<th>" . $comanda[0] . "</td>";
                                    echo "<th>" . date('d/m/Y', strtotime($comanda[1])) . "</th>";
                                    echo "<th style='color:blue;'>R$" . number_format($comanda[3] + $comanda[2], 2, ",", ".") . "</th>";
                                    echo "<th style='color:red;'>R$" . number_format($comanda[2], 2, ",", ".") . "</th>";
                                    echo "<th style='color:green;'>R$" . number_format($comanda[3], 2, ",", ".") . "</th>";

                                    echo "<th><a href='../relatorios/imprimirComanda.php?id=$comanda[0]' target= '_blank' id='modal-detalhes-" .  $comanda[0] . "' onclick='incrementClick($comanda[0])' class='btn btn-outline-primary'>Ver</a></td>";
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