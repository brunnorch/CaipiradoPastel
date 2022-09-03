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
    WHERE dataCaixa BETWEEN ('2022-0$id-01') AND ('2022-0$id-31') group by dataCaixa");
    $detalheMes = mysqli_fetch_all($sqlMes);
} else {
    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Caixa (Diário)
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-end" style="padding: 0 0 30px 0;">
                        <div class="col-md-2">
                            <a href="../relatorios/caixaMes.php" class="btn btn-primary" id="fechaCaixa" name="fechaCaixa">Voltar</a>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Data do Caixa</th>
                                <th scope="col">Saldo Inicial</th>
                                <th scope="col">Cartão</th>
                                <th scope="col">Pix</th>
                                <th scope="col">Dinheiro</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Saida</th>
                                <th scope="col">Saldo do caixa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($detalheMes as $detalhe) {
                                echo "<tr>";
                                echo "<th>" . date('d/m/Y', strtotime($detalhe[0])) . "</th>";
                                echo "<th>R$" . number_format($detalhe[1], 2, ",", ".") . "</th>";
                                echo "<th>R$" . number_format($detalhe[2], 2, ",", ".") . "</th>";
                                echo "<th>R$" . number_format($detalhe[3], 2, ",", ".") . "</th>";
                                echo "<th>R$" . number_format($detalhe[4], 2, ",", ".") . "</th>";
                                echo "<th style='color:green;'>R$" . number_format($detalhe[5], 2, ",", ".") . "</th>";
                                echo "<th style='color:red;'>R$" . number_format($detalhe[6], 2, ",", ".") . "</th>";
                                echo "<th style='color:blue;'>R$" . number_format($detalhe[7], 2, ",", ".") . "</th>";
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