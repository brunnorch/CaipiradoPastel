<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/*PESQUISA DE COMANDAS POR FILTRO */
if (isset($_POST['submit'])) {
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $saidas = mysqli_query($conexao, "SELECT dataSaida, valorSaida, descricao FROM 
    saida_caixa WHERE dataSaida >= '$inicio' AND dataSaida <= '$fim' order by dataSaida");
    $saidas = mysqli_fetch_all($saidas);
} else {
    $saidas = mysqli_query($conexao, "SELECT dataSaida, valorSaida, descricao FROM 
    saida_caixa WHERE dataSaida >= '2022-01-01' AND dataSaida <= '2022-12-31'");
    $saidas = mysqli_fetch_all($saidas);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Relatório Saídas
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->

            <div class="row align-items-center justify-content-center">
                <div class="row col-md-10">
                    <div class="row justify-content-center" style="padding: 0 0 30px 0;">
                        <!--       <form action="../relatorios/saidas.php" method="POST">
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
                        </form> -->
                    </div>


                    <!-- EXIBE AS SAIDAS DO FILTRO ESCOLHIDO -->
                    <table id="caixa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Data da Saída</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saidas as $saida) : ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($saida[0])) ?></td>
                                    <td>R$<?= number_format($saida[1], 2, ",", ".") ?></td>
                                    <td><?= ucfirst($saida[2]) ?></td>

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

        });


    });
</script>

</html>