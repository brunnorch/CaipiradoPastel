<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

//VERIFICAR SE TEM ALGO NA PESQUISA E CASO TENHA, TRAZ AS INFORMAÇÕES
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM produtos WHERE idProduto LIKE '%$search%' OR nomeProduto LIKE '%$search%' ORDER BY idProduto";
} else {
    $sql = "SELECT * FROM produtos ORDER BY idProduto";
}
$result = $conexao->query($sql);
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
                <div class="col-md-9">
                    <div style="text-align: center;">


                        <div class="input-group mb-3">
                            <input autofocus type="search" class="form-control" name="search" id="search" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2" onclick="searchData()"><i class='bx bx-search-alt-2'></i></button>
                        </div>

                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Data</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Estoque</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //CRIANDO A TABELA COM OS DADOS DO BANCO
                            while ($userdata = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $userdata['idProduto'] . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($userdata['dataProduto'])) . "</td>";
                                echo "<td>" . ucfirst($userdata['nomeProduto']) . "</td>";
                                echo "<td>R$" . number_format($userdata['valorProduto'], 2, ",", ".") . "</td>";
                                echo "<td>" . $userdata['quantiaProduto'] . "</td>";
                                echo "<td>
                        <a href='../principal/alterar.php?id=$userdata[idProduto]' class= 'btn btn-sm btn-success'><i class='bx bxs-edit-alt' ></i></a>
                        ";
                                if ($login['cargo'] != "caixa") {
                                    echo "
                                        <a href='../../controller/excluirEstoque.php?id=$userdata[idProduto]' class= 'btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                        </td>";
                                    echo "</tr>";
                                } else {
                                    echo "</tr>";
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

<!--BUSCAR DADOS DENTRO DO BANCO-->
<script>
    var search = document.getElementById('search');

    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });

    function searchData() {
        window.location = 'estoque.php?search=' + search.value;
    }
</script>

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