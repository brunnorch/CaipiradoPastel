<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');
include_once('../../controller/grupos.php');


/* ALERTA PARA AVISAR QUE JÁ TEM CAIXA ABERTO */
$hoje = date('Y-m-d');
$caixa = mysqli_query($conexao, "SELECT statusCaixa, dataCaixa FROM caixa order by dataCaixa desc");
$caixa = mysqli_fetch_row($caixa);

/*SWEETALERT*/
function alerta($type, $title, $msg)
{
    echo "<script type='text/javascript'>
             Swal.fire({
                 icon: '$type',
                 title: '$title',
                 text: '$msg',
                 showConfirmButton: true
             });
         </script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>
    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Vendas de Produtos
            </span>
        </div>
        <div class="home-content">

            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <center>
                        <!-- BOTÕES DE FECHAR CAIXA E CARRINHO -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-around btnFunctions">
                            <?php if ($login['cargo'] != "garçom") : ?>
                                <div class="col-auto">
                                    <a href="../principal/caixa.php?id=fechar" class="btn btn-dark" id="fechaCaixa" name="fechaCaixa">Fechar</a>
                                    <a href="../relatorios/imprimeCaixa.php?data=<?= $caixa[1] ?>" target='_blank' class="btn btn-warning">Relatório</a>
                                </div>
                                <div class="col-auto">
                                    <a href="../relatorios/comanda.php" class="btn btn-primary">Comandas</a>
                                </div>
                            <?php endif; ?>
                            <div class="col-auto">
                                <a href="../principal/carrinho.php" id="verCarrinho" class="btn btn-success">Mesa</a>
                                <a href="../principal/entrega.php" id="verCarrinho" class="btn btn-success">Entrega</a>
                            </div>
                        </div>
                    </center>
                    <!-- ABAS -->
                    <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist" style="padding: 30px 0 0 0 ;">
                            <button class="nav-link active" id="nav-pasteis-tab" data-bs-toggle="tab" data-bs-target="#nav-pasteis" type="button" role="tab" aria-controls="nav-pasteis" aria-selected="true">Pasteis</button>
                            <button class="nav-link" id="nav-salgados-tab" data-bs-toggle="tab" data-bs-target="#nav-salgados" type="button" role="tab" aria-controls="nav-salgados" aria-selected="false">Salgados</button>
                            <button class="nav-link" id="nav-doces-tab" data-bs-toggle="tab" data-bs-target="#nav-doces" type="button" role="tab" aria-controls="nav-doces" aria-selected="false">Doces</button>
                            <button class="nav-link" id="nav-bebidas-tab" data-bs-toggle="tab" data-bs-target="#nav-bebidas" type="button" role="tab" aria-controls="nav-bebidas" aria-selected="false">Bebidas</button>
                            <button class="nav-link" id="nav-refrigerantes-tab" data-bs-toggle="tab" data-bs-target="#nav-refrigerantes" type="button" role="tab" aria-controls="nav-refrigerantes" aria-selected="false">Refrigerantes</button>
                            <button class="nav-link" id="nav-alcoolicos-tab" data-bs-toggle="tab" data-bs-target="#nav-alcoolicos" type="button" role="tab" aria-controls="nav-alcoolicos" aria-selected="false">Alcoolicos</button>
                        </div>
                    </nav>

                    <!-- ALERTA PARA CAIXA ABERTO -->
                    <?php if ($caixa[0] == 1 && $caixa[1] != $hoje) :
                        $alert = alerta("warning", "CAIXA ABERTO", "O caixa do dia " . date('d/m/Y', strtotime($caixa[1])) . " está aberto!"); ?>

                        <!-- ALERTA PARA CAIXA FECHADO -->
                    <?php elseif ($caixa[0] == 0) :
                        $alert = alerta("warning", "CAIXA FECHADO", "O caixa está fechado, peça para abrir!"); ?>

                        <!-- EXIBE PRODUTOS EM SUAS ABAS -->
                    <?php else : ?>
                        <div class="tab-content" id="nav-tabContent">

                            <!-- ABAS DE PASTEIS -->
                            <div class="tab-pane fade show active" id="nav-pasteis" role="tabpanel" aria-labelledby="nav-pasteis-tab">
                                <table id="pasteis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Nome do Produto</th>
                                            <th scope="col">Valor Unitário</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pasteis as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ABAS DE SALGADOS -->
                            <div class="tab-pane fade" id="nav-salgados" role="tabpanel" aria-labelledby="nav-salgados-tab">
                                <table id="salgados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($salgados as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ABAS DE DOCES -->
                            <div class="tab-pane fade" id="nav-doces" role="tabpanel" aria-labelledby="nav-doces-tab">
                                <table id="doces" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Nome do Produto</th>
                                            <th scope="col">Valor Unitário</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($doces as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ABAS DE BEBIDAS -->
                            <div class="tab-pane fade" id="nav-bebidas" role="tabpanel" aria-labelledby="nav-bebidas-tab">
                                <table id="bebidas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Nome do Produto</th>
                                            <th scope="col">Valor Unitário</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bebidas as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ABAS DE REFRIGERANTES -->
                            <div class="tab-pane fade" id="nav-refrigerantes" role="tabpanel" aria-labelledby="nav-refrigerantes-tab">
                                <table id="refrigerantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Nome do Produto</th>
                                            <th scope="col">Valor Unitário</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($refrigerantes as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ABAS DE ALCOOLICOS -->
                            <div class="tab-pane fade" id="nav-alcoolicos" role="tabpanel" aria-labelledby="nav-alcoolicos-tab">
                                <table id="alcoolicos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Nome do Produto</th>
                                            <th scope="col">Valor Unitário</th>
                                            <th scope="col">Estoque</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($alcoolicos as $info) : ?>
                                            <?php if ($info[6] > 0) : ?>
                                                <tr>
                                                    <td><?= ucfirst($info[3]) ?></td>
                                                    <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                                    <td><?= $info[6] ?></td>
                                                    <td>
                                                        <a href='../../controller/vaiCarrinho.php?add=carrinho&id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                                        <a href='../../controller/danificado.php?id=<?= $info[0] ?>&name= <?= $info[3] ?>&valor=<?= $info[4] ?>' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                                    </td>
                                                <tr></tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</body>


<!-- CONFIRMA FECHAMENTO DO CAIXA PELO JS -->
<script>
    $('.btn-dark').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'FECHAMENTO DO CAIXA',
            text: "Confirma o fechamento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, fechar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
</script>

<!-- CONFIRMA REITRADA DO ESTOQUE PARA DANIFICADOS -->
<script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'PRODUTO DANIFICADO',
            text: "Confirma a alteração para produto danificado?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
</script>

</html>