<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

//VERIFICAR SE TEM ALGO NA PESQUISA E CASO TENHA, TRAZ AS INFORMAÇÕES
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT idProduto,nomeProduto, valorProduto, quantiaProduto FROM produtos WHERE idProduto LIKE '%$search%' OR nomeProduto LIKE '%$search%' ORDER BY idProduto";
} else {
    $sql = "SELECT idProduto,nomeProduto, valorProduto, quantiaProduto FROM produtos ORDER BY idProduto";
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
                Vendas de Produtos
            </span>
        </div>
        <div class="home-content">
            <!-- PRODUTOS PARA VENDER -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-between" style="padding: 0 0 30px 0;">
                        <?php if ($login['cargo'] != "garçom") : ?>
                            <div class="col-2">
                                <a href="../principal/caixa.php?id=fechar" class="btn btn-dark" id="fechaCaixa" name="fechaCaixa">Fechar caixa</a>
                            </div>
                        <?php endif; ?>
                        <div class="col-2">
                            <a href="../principal/carrinho.php" id="verCarrinho" class="btn btn-primary">Ver carrinho</a>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nome do Produto</th>
                                <th scope="col">Valor Unitário</th>
                                <th scope="col">Estoque</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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

                            //CRIANDO A TABELA COM OS DADOS DO BANCO
                            while ($userdata = mysqli_fetch_assoc($result)) {
                                //SE NÃO TIVER ESTOQUE, O PRODUTO NÃO APARECE NA LOJA
                                if ($userdata['quantiaProduto'] > 0) {
                                    echo "<tr>";
                                    echo "<td>" . ucfirst($userdata['nomeProduto']) . "</td>";
                                    echo "<td>R$" . number_format($userdata['valorProduto'], 2, ",", ".") . "</td>";
                                    echo "<td>" . $userdata['quantiaProduto'] . "</td>";

                                    /* SE CAIXA ANTERIOR ESTIVER ABERTO, NÃO ADICIONA */
                                    if ($caixa[0] == 1 && $caixa[1] != $hoje) {
                                        $alert = alerta("warning", "CAIXA ABERTO", "O caixa do dia " . date('d/m/Y', strtotime($caixa[1])) . " está aberto!");
                                        echo "<td><a href='' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>

                                    <a href='' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                    </td>";
                                    } elseif($caixa[0] == 0){
                                        $alert = alerta("warning", "CAIXA FECHADO", "O caixa está fechado, peça para abrir!");
                                        echo "<td><a href='' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>

                                    <a href='' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                    </td>";
                                    } else {
                                        echo "<td><a href='../../controller/vaiCarrinho.php?add=carrinho&id=$userdata[idProduto]' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus'></i></a>
                                    
                                    <a href='../../controller/danificado.php?id=$userdata[idProduto]&name=$userdata[nomeProduto]&valor=$userdata[valorProduto]' type='submit' class='btn btn-sm btn-danger'><i class='bx bx-minus'></i></a>
                                    </td>";
                                    }

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
        window.location = 'venda.php?search=' + search.value;
    }
</script>

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