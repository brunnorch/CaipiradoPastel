<?php
session_start();
include_once('../../verificalogin.php');
include_once('../../conexao.php');

$idEntrega = $_GET['id'];
$totalFim = $_GET['valor'];
$hoje = date('Y-m-d');

if (isset($_POST['fimEntrega'])) {
    $cartao = $_POST['cartao'];
    $pix = $_POST['pix'];
    $dinheiro = $_POST['dinheiro'];
    $troco = $_POST['troco'];
    $desconto = $_SESSION['desconto'];

    /* SOMA VALORES DAS FORMAS DE PAGAMENTO PARA INSERIR NA COLUNA TOTALPEDIDO  */
    $soma = $cartao + $pix + $dinheiro;

    /* TROCO DO CLIENTE SOMENTE PARA INSERIR NA TABELA */
    if ($troco > $dinheiro) {
        $troco -= $dinheiro;
    } else {
        $troco = 0;
    }

    if ($soma == $totalFim) {

        /* TRANSFERE OS ITENS DO PEDIDO DA TABELA ENTREGA_ANDAMENTO (SERÁ APAGADA) PARA TABELA ENTREGA_CONCLUIDA(PERMANENTE) */
        $addPedido = mysqli_query($conexao, "INSERT INTO entregas_concluida
        (idEntrega,clienteEntrega,idProduto,nomeProduto,valorProduto,qtdProduto,dataEntrega)
        SELECT idEntrega,clienteEntrega,idProduto,nomeProduto,valorProduto,qtdProduto,dataEntrega
        FROM entregas_andamento
        WHERE idEntrega = '$idEntrega'");

        /* PREENCHENDO OS CAMPOS QUE FALTARAM DA TABELA ENTREGAS COM O TIPO DE PAGAMENTO E TOTAL */
        $addComanda = mysqli_query($conexao, "UPDATE entregas SET statusEntrega = '0', cartaoEntrega = '$cartao', dinheiroEntrega = '$dinheiro', pixEntrega = '$pix',descontoEntrega ='$desconto',totalEntrega='$totalFim' WHERE idEntrega = '$idEntrega'");



        /* ATUALIZA OS VALORES DO CAIXA COM OS VALORES DO PEDIDO */
        $cartao = mysqli_query($conexao, "UPDATE caixa set cartao = cartao + '$cartao' where dataCaixa = '$hoje'");
        $pix = mysqli_query($conexao, "UPDATE caixa set pix = pix + '$pix' where dataCaixa = '$hoje'");
        $dinheiro = mysqli_query($conexao, "UPDATE caixa set dinheiro = dinheiro + '$dinheiro' where dataCaixa = '$hoje'");

        /* ATUALIZA A COLUNA ENTRADA DA TABELA CAIXA A CADA VENDA  */
        $totalPedido = mysqli_query($conexao, "UPDATE caixa SET entrada = entrada + '$totalFim' WHERE dataCaixa = '$hoje'");

        /* LIMPANDO A TABELA ENTREGAS_ANDAMENTO */
        $deletaMesa = mysqli_query($conexao, "DELETE FROM entregas_andamento WHERE idEntrega='$idEntrega'");

        header('location:../entregas/entregaAndamento.php');
    } else {
        $_SESSION['falta'] = true;
        header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        exit;
    }
}
