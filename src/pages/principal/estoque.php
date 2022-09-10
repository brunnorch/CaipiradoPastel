<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');
include_once('../../controller/grupos.php');

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Estoque de Produtos
            </span>
        </div>
        <div class="home-content">
            <!-- ESTOQUE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">

                    <!-- ABAS -->
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
                    <div class="tab-content" id="nav-tabContent">
                        <!-- ABAS DE PASTEIS -->
                        <div class="tab-pane fade show active" id="nav-pasteis" role="tabpanel" aria-labelledby="nav-pasteis-tab">
                            <table id="pasteis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pasteis as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE SALGADOS -->
                        <div class="tab-pane fade" id="nav-salgados" role="tabpanel" aria-labelledby="nav-salgados-tab">
                            <table id="salgados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($salgados as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE DOCES -->
                        <div class="tab-pane fade" id="nav-doces" role="tabpanel" aria-labelledby="nav-doces-tab">
                            <table id="doces" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doces as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE BEBIDAS -->
                        <div class="tab-pane fade" id="nav-bebidas" role="tabpanel" aria-labelledby="nav-bebidas-tab">
                            <table id="bebidas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bebidas as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE REFRIGERANTES -->
                        <div class="tab-pane fade" id="nav-refrigerantes" role="tabpanel" aria-labelledby="nav-refrigerantes-tab">
                            <table id="refrigerantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($refrigerantes as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE ALCOOLICOS -->
                        <div class="tab-pane fade" id="nav-alcoolicos" role="tabpanel" aria-labelledby="nav-alcoolicos-tab">
                            <table id="alcoolicos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>U. Venda</th>
                                        <th>Produto</th>
                                        <th>Valor U.</th>
                                        <th>Estoque</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alcoolicos as $info) : ?>
                                        <tr>
                                            <td><?= $info[0] ?></td>
                                            <td><?= $info[2] ?></td>
                                            <td><?= ucfirst($info[3]) ?></td>
                                            <td>R$<?= number_format($info[4], 2, ",", ".") ?></td>
                                            <td><?= $info[6] ?></td>
                                            <td><a href='../principal/alterar.php?id=<?= $info[0] ?>' class='btn btn-sm btn-success'><i class='bx bxs-edit-alt'></i></a>
                                                <?php if ($login['cargo'] != "caixa") : ?>
                                                    <a href='../../controller/excluirEstoque.php?id=<?= $info[0] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>


<!-- CONFIRMA EXCLUSÃO DO PRODUTO DO ESTOQUE PELO SWWERTALERT -->
<script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'EXCLUIR PRODUTO',
            text: "Confirma a exclusão?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
</script>

</html>