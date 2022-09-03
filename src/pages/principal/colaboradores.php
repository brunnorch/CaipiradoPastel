<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

$usuarios = mysqli_query($conexao, "SELECT idUsuario, usuario, cargo FROM usuario WHERE idUsuario > '1' ORDER BY cargo");
$usuarios = mysqli_fetch_all($usuarios);
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Colaboradores
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="row justify-content-end" style="padding: 0 0 30px 0;">
                        <div class="col-md-3">
                            <a href="../colaboradores/cadastrarColab.php" class="btn btn-success">Cadastrar</a>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Cargo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $usuario) {
                                echo "
                                <tr>
                                <td>" . ucfirst($usuario[1]) . "</td>
                                <td>" . ucfirst($usuario[2]) . "</td>
                                <td>
                                <a href='../colaboradores/alterarColab.php?id=$usuario[0]' class= 'btn btn-sm btn-success'><i class='bx bxs-edit-alt' ></i></a>
                                <a href='../colaboradores/excluirColab.php?id=$usuario[0]' class= 'btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                </td>
                                </tr>
                                ";
                            }
                            ?>
                        </tbody>
                    </table>
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
            title: 'EXCLUIR COLABORADOR',
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