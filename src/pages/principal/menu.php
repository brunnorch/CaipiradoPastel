<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');


$sqlestoque = "SELECT idProduto, nomeProduto, quantiaProduto FROM produtos ORDER BY idProduto";
$resultestoque = mysqli_query($conexao, $sqlestoque);

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>
    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Informações de Estoque
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Estoque Atual</th>
                                <th scope="col">Adicionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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

                            /*SE TIVER PRODUTOS QUE ESTÃO ABAIXO DE 10, GERA A TABELA PARA MOSTRAR*/
                            while ($estoque = mysqli_fetch_assoc($resultestoque)) {
                                if ($estoque['quantiaProduto'] <= 5) {
                                    echo "<tr>";
                                    echo "<td class='table-danger'>" . ucfirst($estoque['nomeProduto']) . "</td>";
                                    echo "<td class='table-danger'>" . $estoque['quantiaProduto'] . "</td>";
                                    echo "<td class='table-danger'><a href='alterar.php?id=$estoque[idProduto]' type='submit' class='btn btn-sm btn-success'>Adicionar</a></td>";
                                    echo "</tr>";
                                } elseif ($estoque['quantiaProduto'] <= 10) {
                                    echo "<tr>";
                                    echo "<td class='table-warning'>" . ucfirst($estoque['nomeProduto']) . "</td>";
                                    echo "<td class='table-warning'>" . $estoque['quantiaProduto'] . "</td>";
                                    echo "<td class='table-warning'><a href='alterar.php?id=$estoque[idProduto]' type='submit' class='btn btn-sm btn-success'>Adicionar</a></td>";
                                    echo "</tr>";
                                } elseif ($estoque['quantiaProduto'] <= 15) {
                                    echo "<tr>";
                                    echo "<td class='table-primary'>" . ucfirst($estoque['nomeProduto']) . "</td>";
                                    echo "<td class='table-primary'>" . $estoque['quantiaProduto'] . "</td>";
                                    echo "<td class='table-primary'><a href='alterar.php?id=$estoque[idProduto]' type='submit' class='btn btn-sm btn-success'>Adicionar</a></td>";
                                    echo "</tr>";
                                    $alert = alerta("warning", "ATENÇÃO AO ESTOQUE", "Existem produtos que estão abaixo de 15 itens!");
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

<!-- MENU HAMBURGUER -->
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
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