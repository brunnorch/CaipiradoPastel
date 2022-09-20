<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* PASSA OS PRODUTOS DA ENTREGA PARA A TELA DETALHES DA ENTREGA  */
$idEntrega = $_GET['id'];
$pedido = mysqli_query($conexao, "SELECT idEntrega, nomeProduto, valorProduto, qtdProduto, dataEntrega FROM entregas_andamento WHERE idEntrega ='$idEntrega'");
$pedido = mysqli_fetch_all($pedido);

$cliente = mysqli_query($conexao, "SELECT * FROM entregas WHERE idEntrega ='$idEntrega'");
$cliente = mysqli_fetch_assoc($cliente);
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Detalhes da Entrega
            </span>
        </div>
        <div class="home-content">
            <!-- DETALHES DA MESA -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <h5 style="text-align: center; font-weight:bold; color:red;">
                         <?= ucfirst($cliente['clienteEntrega']) ?> -  <?= ucfirst($cliente['enderecoEntrega']) ?>, <?= $cliente['numeroEntrega'] ?>, <?= ucfirst($cliente['bairroEntrega']) ?>
                    </h5>
                    <table class="table table-primary table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor</th>
                                <th scope="col">...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedido as $detalhe) : ?>
                                <tr>
                                    <td><?= ucfirst($detalhe[1]) ?></td>
                                    <td><?= $detalhe[3] ?></td>
                                    <td>R$ <?= number_format($detalhe[3] * $detalhe[2], 2, ",", ".") ?></td>
                                    <td>
                                        <a href='../entregas/addProduto.php?id=<?= $idEntrega ?>&name=<?= $detalhe[1] ?>' class='btn btn-sm btn-success'><i class='bx bx-plus-medical'></i></a>
                                        <a href='../entregas/removeProduto.php?id=<?= $idEntrega ?>&name=<?= $detalhe[1] ?>' class='btn btn-sm btn-danger excluiProduto'><i class='bx bxs-trash-alt'></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <!-- VALOR DA ENTREGA -->
                                <td></td>
                                <th>ENTREGA :</th>
                                <th>R$ <?= number_format($cliente['taxaEntrega'], 2, ",", ".") ?></th>
                                <td></td>
                            </tr>
                            <tr>
                                <!-- TOTAL DO PEDIDO COM O ENTREGA -->
                                <td></td>
                                <th>TOTAL :</th>
                                <th>
                                    <?php
                                    $sqlSoma = mysqli_query($conexao, "SELECT sum(valorProduto*qtdProduto) from entregas_andamento where idEntrega ='$idEntrega'");
                                    $soma = mysqli_fetch_row($sqlSoma);
                                    $totalEntrega = $soma[0] + $cliente['taxaEntrega'];
                                    echo "R$ " . number_format($totalEntrega, 2, ",", ".");
                                    ?>
                                </th>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <?php
                    if ($login['cargo'] != "garçom") : ?>
                        <!-- BOTÃO DE DESCONTO -->
                        <form action="../mesas/aplicarDesconto.php" method="POST">
                            <div class="row justify-content-end">
                                <div class="col-md-2">
                                    <input type="hidden" id="total" name="total" value="<?= $totalEntrega ?>">
                                    <label for="desconto" style="color: blue; font-size:18px; font-weight:bolder;">DESCONTO</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input autofocus type="number" class="form-control" name="desconto" id="desconto" value="0" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                                        <button name="aplicarDesc" class='btn btn-primary'>Aplicar</i></button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                    <br>

                    <!-- BOTÕES FINAIS -->

                    <div class="d-flex justify-content-center">
                        <div style="padding:5px ;">
                            <a href="../entregas/editarEntrega.php?id=<?php echo $idEntrega ?>" class="btn btn-danger">Editar mesa</a>
                        </div>

                        <?php if ($login['cargo'] != "garçom") : ?>
                            <div style="padding:5px ;">
                                <a href="../entregas/imprimeEntrega.php?id=<?php echo $idEntrega ?>" class="btn btn-dark" target="_blank">Imprimir</a>
                            </div>
                            <div style="padding:5px ;">
                                <a href="#" class="btn btn-success fecharMesa" id="modal-comanda">Confirmar entrega</a>
                            </div>
                        <?php endif; ?>

                        <div style="padding:5px ;">
                            <a href="../entregas/entregaAndamento.php" class="btn btn-secondary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="my-comanda" class="modal">
        <div class="modal-content" style="width: 60%;">
            <div class="modal-header" style="display: block;">
                <span class="closeComanda">&times;</span>
                <h2>Concluir Entrega</h2>
            </div>
            <div class="modal-body">
                <!-- FORMA DE PAGMENTO -->
                <div style="text-align: center;">
                    <?php if (isset($_SESSION['valorFinal'])) : ?>

                        <legend style='color: red; font-weight: bold;'>Total do pedido: R$<?= number_format($_SESSION['valorFinal'], 2, ", ", " . ") ?></legend>
                        <input style='visibility: hidden; width:2%;height:2%;' type='number' name='valorFinal' value='<?= $_SESSION['valorFinal'] ?>'>
                        <?php $valor = $_SESSION['valorFinal']; ?>

                    <?php else : ?>

                        <legend style='color: red; font-weight: bold;'>Total do pedido: R$<?= number_format($totalEntrega, 2, ", ", " . ") ?></legend>
                        <input style='visibility: hidden; width:2%;height:2%;' type='number' name='valorFinal' value='<?= $totalEntrega ?>'>
                        <?php $valor = $totalEntrega; ?>

                    <?php endif; ?>
                    <?php unset($_SESSION['valorFinal']); ?>
                </div>
                <form class="row g-3" action="../entregas/concluiEntrega.php?id=<?= $idEntrega; ?>&valor=<?= $valor ?>" method="POST">
                    <div class="col-md-4">
                        <label class="form-label">Cartão</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" name="cartao" id="cartao" step="0.010" value="0" onchange="this.value = this.value.replace(/,/g, '.')" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">PIX</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" name="pix" id="pix" value="0" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Dinheiro</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" name="dinheiro" id="dinheiro" value="0" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                        </div>
                    </div>
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <label class="form-label">Troco para</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" name="troco" id="troco" value="0" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                                <input type="button" name="verTroco" id="verTroco" class="btn btn-sm btn-primary" onClick="trocoCliente()" value="Ver troco">
                            </div>
                        </div>
                    </div>

                    <?php
                    /* ALERTA PARA PREÇO INCORRETO */
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

                    /* ALERTA PARA FALTANDO VALOR */
                    if (isset($_SESSION['falta'])) {
                        $alert = alerta("warning", "VALOR INCORRETO", "Valor inserido não bate com o total da comanda!");
                    }
                    unset($_SESSION['falta']);

                    ?>

                    <div style="text-align: center;">
                        <input type="submit" id="fimEntrega" name="fimEntrega" class="btn btn-success" value="Confirmar">
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

<!-- MODAL PARA FECHAR A CONTA -->
<script>
    // Get DOM Elements
    const comanda = document.querySelector('#my-comanda');
    const modalComanda = document.querySelector('#modal-comanda');
    const closeComanda = document.querySelector('.closeComanda');

    // Events
    modalComanda.addEventListener('click', openModal);
    closeComanda.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);

    // Open
    function openModal() {
        comanda.style.display = 'block';
    }

    // Close
    function closeModal() {
        comanda.style.display = 'none';
    }

    // Close If Outside Click
    function outsideClick(e) {
        if (e.target == comanda) {
            comanda.style.display = 'none';
        }
    }
</script>

<!-- CONFIRMA EXCLUSÃO DO PRODUTO DA MESA/COMANDA PELO JS -->
<script>
    $('.excluiProduto').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'RETIRAR PRODUTO',
            text: "Confirma a retirada desse produto da entrega?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, retirar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
</script>

<!-- FAZENDO O CALCULO PARA MOSTRAR O TROCO DO CLIENTE -->
<script>
    var click = false;

    function trocoCliente() {
        var dinheiro = document.getElementById('dinheiro').value;
        var valor = document.getElementById('troco').value;
        var troco = valor - dinheiro;
        var trocof = troco.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
        });
        if (!click) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'O troco do cliente é ' + trocof,
                icon: 'info',
                showConfirmButton: true,
                confirmButtonText: 'OK!'
            })
            click = false;
        }
    }
</script>

</html>