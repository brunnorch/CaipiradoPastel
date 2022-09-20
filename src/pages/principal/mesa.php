<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


/* PEGAR O NUMERO DA MESA E DA COMANDA */
$numeroMesa = mysqli_query($conexao, "SELECT idMesa,comanda,garcom FROM numero_mesas");
$numeroMesa = mysqli_fetch_all($numeroMesa);

$_SESSION['desconto'] = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Mesas Ativas
            </span>
        </div>
        <div class="home-content">
            <!-- MESAS ATIVAS -->
            <div class="container">
                <div class="row col-md-12">
                    <?php foreach ($numeroMesa as $mesa) : ?>
                        <div class='col-md-3'>
                            <div class='p-3 border bg-light rounded-3' style='text-align: center;'>
                                <h4><?= $mesa[0] ?></h4>
                                <p>Comanda <?= $mesa[1] ?> Garçom <?= ucfirst($mesa[2]) ?></p>
                                <div>
                                    <a href='../mesas/verMesa.php?id=<?= $mesa[1] ?>' class='btn btn-primary'>Abrir</a>
                                    <a href='../mesas/excluiMesaController.php?id=<?= $mesa[1] ?>' class='btn btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</body>
<!-- CONFIRMA EXCLUSÃO DO PRODUTO DA MESA PELO SWWERTALERT -->
<script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'EXCLUIR MESA',
            text: "Confirma a exclusão dessa mesa?",
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