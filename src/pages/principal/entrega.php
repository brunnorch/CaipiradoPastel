<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* VERIFICA QUEM ESTÁ LOGADO,ADICIONA NA TABELA CARINHO_PRODUTO O USUARIO LOGADO, ID DO PRODUTO E QTD  */
$user = $_SESSION['usuario'];

/* CONEXÃO PARA EXIBIR OS PRODUTOS DO CARRINHO */
$resultall = mysqli_query($conexao, "SELECT * FROM carrinho_produto");
$count = 0;
$count = mysqli_num_rows($resultall);
$total = 0;

$resultshow = mysqli_query($conexao, "SELECT produtos.nomeProduto, produtos.valorProduto, produtos.idProduto, gerou.quantidade FROM produtos
INNER JOIN (SELECT carrinho_produto.idProduto, carrinho_produto.quantidade FROM carrinho_produto
INNER JOIN produtos ON carrinho_produto.idProduto = produtos.idProduto
INNER JOIN usuario ON carrinho_produto.idUsuario = usuario.idUsuario
WHERE usuario.usuario = '$user'
GROUP BY carrinho_produto.idProduto) as gerou 
ON produtos.idProduto = gerou.idProduto
GROUP BY produtos.idProduto");
$show = mysqli_fetch_all($resultshow);

$count = 0;
$total = 0;

/* SELECIONAR QUEM É O RESPONSAVEL POR TIRAR O PEDIDO */
$usuarios = mysqli_query($conexao, "SELECT idUsuario, usuario, cargo FROM usuario WHERE NOT cargo = 'administrador'");
$usuarios = mysqli_fetch_all($usuarios);

$hoje = date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Carrinho
            </span>
        </div>
        <div class="home-content">
            <!-- CARRINHO -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Total</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <!--PRODUTOS NO CARRINHO -->
                        <tbody>

                            <?php foreach ($show as $row) :
                                $sqlProdutos = "SELECT quantiaProduto FROM produtos WHERE nomeProduto ='$row[0]'";
                                $resultProdutos = mysqli_query($conexao, $sqlProdutos);
                                $produtos = mysqli_fetch_row($resultProdutos);
                            ?>
                                <tr>
                                    <td><?= ucfirst($row[0]) ?></td>
                                    <td><?= number_format($row[1], 2, ",", ".") ?></td>
                                    <td><?= $row[3] ?></td>

                                    <td><?= number_format($row[1] * $row[3], 2, ",", ".") ?></td>
                                    <?php if ($row[3] < $produtos[0]) : ?>
                                        <td>
                                            <a href='../../controller/addCarrinho.php?add=carrinho&id=<?= $row[2] ?>' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus-medical'></i></a>

                                        <?php else : ?>
                                        <td>
                                            <a href='' type='submit' class='btn btn-sm btn-success'><i class='bx bx-plus-medical'></i></a>

                                        <?php endif; ?>

                                        <a href='../../controller/removerCarrinho.php?remover=carrinho&id=<?= $row[2] ?>' class='btn btn-sm btn-danger'><i class='bx bxs-trash-alt'></i></a>
                                        </td>
                                </tr>

                                <?php
                                $count = $row[1] * $row[3];
                                $total = $count + $total;
                                ?>
                            <?php endforeach; ?>

                        </tbody>
                        <!-- VALOR TOTAL DA COMPRA -->
                        <tfoot style="font-size: 20px;">
                            <td></td>
                            <td></td>
                            <th>TOTAL :</th>
                            <th>
                                <?php
                                echo "R$ " . number_format($total, 2, ",", ".");
                                $_SESSION['total'] = $total;
                                ?>
                            </th>
                            <td></td>
                        </tfoot>
                    </table>
                    <div class="col-md-12" style="text-align: center;">
                        <a href='../principal/venda.php' class='btn btn-primary' id='voltar'>Voltar para vendas</a>
                    </div>

                    <div class="home-header">
                        <!-- CABEÇALHO -->
                        <span class="text">
                            Criar Entrega
                        </span>
                    </div>

                    <!-- FINALIZA PEDIDO -->
                    <div style="padding: 20px 0 0 0 ; border-width: 1px;">
                        <form class="row g-3" action="../entregas/addEntrega.php" method="POST">
                            <div class="col-md-3">
                                <label class="form-label">Garçom</label>
                                <div class="col-auto">
                                    <select class="form-select" name="garcom" required>
                                        <option selected></option>
                                        <?php foreach ($usuarios as $colabs) : ?>
                                            <option value='<?= $colabs[1] ?>'><?= ucfirst($colabs[1]) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputCity" class="form-label">Cliente</label>
                                <input type="text" class="form-control" id="cliente" name="cliente" required>
                            </div>
                            <div class="col-md-3">
                                <label for="inputCity" class="form-label">Celular</label>
                                <input type="number" class="form-control" id="celular" name="celular" required>
                            </div>
                            <div class="col-md-2">
                                <label for="inputAddress" class="form-label">Data</label>
                                <input readonly type="text" class="form-control" id="dataEntrega" name="dataEntrega" style="cursor: no-drop; text-align: center;" value="<?= $hoje; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Numero</label>
                                <input type="number" class="form-control" id="numero" name="numero" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Taxa</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="taxa" id="taxa" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                                </div>
                            </div>
                            <!-- ALERTA PARA COMANDA EXISTENTE -->
                            <?php
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

                            if (isset($_SESSION['comandaExiste'])) :
                                $alert = alerta("warning", "COMANDA EXISTENTE", "Essa comanda ja foi lançada no sistema!");
                            endif;
                            unset($_SESSION['comandaExiste']);
                            ?>

                            <div class="col-md-12" style="text-align: center;">
                                <button type="submit" name="submit" class="btn btn-success">Criar Entrega</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</body>

</html>