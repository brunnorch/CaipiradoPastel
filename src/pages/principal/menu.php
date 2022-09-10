<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');
include_once('../../controller/grupos.php');


/*SWEETALERT PARA AVISAR O ESTOQUE BAIXO */
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
                Estoque Baixo
            </span>
        </div>
        <div class="home-content">
            <!-- PRODUTOS ABAIXO DO ESTOQUE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">

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

                    <div class="tab-content" id="nav-tabContent">


                        <!-- ABAS DE PASTEIS -->
                        <div class="tab-pane fade show active" id="nav-pasteis" role="tabpanel" aria-labelledby="nav-pasteis-tab">
                            <table id="pasteis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pasteis as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-dark'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-dark'><?= $info[6] ?></td>
                                                <td class='table-dark'><?= $info[5] ?></td>
                                                <td class='table-dark'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php $alert = alerta("warning", "ATENÇÃO AO ESTOQUE", "Existem produtos que estão abaixo do estoque minímo!"); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE SALGADOS -->
                        <div class="tab-pane fade" id="nav-salgados" role="tabpanel" aria-labelledby="nav-salgados-tab">
                            <table id="salgados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($salgados as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-warning'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-warning'><?= $info[6] ?></td>
                                                <td class='table-warning'><?= $info[5] ?></td>
                                                <td class='table-warning'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE DOCES -->
                        <div class="tab-pane fade" id="nav-doces" role="tabpanel" aria-labelledby="nav-doces-tab">
                            <table id="doces" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doces as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-primary'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-primary'><?= $info[6] ?></td>
                                                <td class='table-primary'><?= $info[5] ?></td>
                                                <td class='table-primary'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE BEBIDAS -->
                        <div class="tab-pane fade" id="nav-bebidas" role="tabpanel" aria-labelledby="nav-bebidas-tab">
                            <table id="bebidas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bebidas as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-success'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-success'><?= $info[6] ?></td>
                                                <td class='table-success'><?= $info[5] ?></td>
                                                <td class='table-success'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE REFRIGERANTES -->
                        <div class="tab-pane fade" id="nav-refrigerantes" role="tabpanel" aria-labelledby="nav-refrigerantes-tab">
                            <table id="refrigerantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($refrigerantes as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-danger'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-danger'><?= $info[6] ?></td>
                                                <td class='table-danger'><?= $info[5] ?></td>
                                                <td class='table-danger'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ABAS DE ALCOOLICOS -->
                        <div class="tab-pane fade" id="nav-alcoolicos" role="tabpanel" aria-labelledby="nav-alcoolicos-tab">
                            <table id="alcoolicos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Estoque Atual</th>
                                        <th scope="col">Minimo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alcoolicos as $info) : ?>
                                        <?php if ($info[5] >= $info[6]) : ?>
                                            <tr>
                                                <td class='table-secondary'><?= ucfirst($info[3]) ?></td>
                                                <td class='table-secondary'><?= $info[6] ?></td>
                                                <td class='table-secondary'><?= $info[5] ?></td>
                                                <td class='table-secondary'><a href='alterar.php?id=<?= $info[0] ?>' type='submit' class='btn btn-sm btn-success'>Editar</a></td>
                                            </tr>
                                        <?php endif; ?>
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

<!-- MENU HAMBURGUER -->
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement;
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>