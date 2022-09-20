<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


/* PEGAR AS INFORMAÇÕES DO CLIENTE PARA ENTREGA */
$entrega = mysqli_query($conexao, "SELECT statusEntrega,clienteEntrega,enderecoEntrega,numeroEntrega,idEntrega FROM entregas");
$entrega = mysqli_fetch_all($entrega);

$_SESSION['desconto'] = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Entregas em Andamento
            </span>
        </div>
        <div class="home-content">
            <!-- ENTREGAS EM ANDAMENTO -->
            <div class="container">
                <div class="row col-md-12">
                    <?php foreach ($entrega as $andamento) : ?>
                        <?php if ($andamento[0] == 1) : ?>
                            <div class='col-md-3'>
                                <div class='p-3 border bg-light rounded-3' style='text-align: center;'>
                                    <h4><?= ucfirst($andamento[1]) ?></h4>
                                    <p>Rua <?= ucfirst($andamento[2]) ?> Nº <?= ucfirst($andamento[3]) ?></p>
                                    <div>
                                        <a href='../entregas/verEntrega.php?id=<?= $andamento[4] ?>' class='btn btn-primary'>Abrir</a>
                                        <a href='../entregas/excluirEntrega.php?id=<?= $andamento[4] ?>' class='btn btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</body>
<!-- CONFIRMA EXCLUSÃO DA ENTREGA PELO SWWERTALERT -->
<script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'EXCLUIR ENTREGA',
            text: "Confirma a exclusão dessa entrega?",
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