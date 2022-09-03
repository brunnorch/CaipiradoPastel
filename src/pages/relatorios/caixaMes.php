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

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Caixa
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Mês</th>
                                <th scope="col">Saldo Inicial</th>
                                <th scope="col">Entradas</th>
                                <th scope="col">Saidas</th>
                                <th scope="col">Saldo caixa</th>
                                <th scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($caixa as $mes) {

                                echo "<tr>";
                                echo "<th>" . $mes[1]  . "</td>";
                                echo "<th>R$" . number_format($mes[2], 2, ",", ".") . "</th>";
                                echo "<th style='color:green;'>R$" . number_format($mes[3], 2, ",", ".") . "</th>";
                                echo "<th style='color:red;'>R$" . number_format($mes[4], 2, ",", ".") . "</th>";
                                echo "<th style='color:blue;'>R$" . number_format($mes[5], 2, ",", ".") . "</th>";
                                echo "<th><a href='../relatorios/caixaMesDetalhe.php?mes=detalhe&id=$mes[0]' id='modal-caixa' class='btn btn-outline-primary'>Ver</a></th>";
                                echo "</tr>";
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