<?php
session_start();
include_once('../../verificalogin.php');
include_once('../../conexao.php');

$comanda = $_GET['id'];
$totalFim = $_GET['valor'];

if (isset($_POST['fimVenda'])) {
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

        /* TRANSFERE OS ITENS DO PEDIDO DA TABELA MESA(SERÁ APAGADA) PARA TABELA PEDIDOS(PERMANENTE) */
        $addPedido = mysqli_query($conexao, "INSERT INTO pedidos
        (comanda,garcom,idProduto,nomeProduto,valorProduto,qtdProduto,dataVenda)
        SELECT comanda,garcom,idProduto,nomeProduto,valorProduto,qtdProduto,dataVenda
        FROM mesas
        WHERE comanda = '$comanda'");

        /* ALIMENTANDO A TABELA COMANDAS */
        $addComanda = mysqli_query($conexao, "INSERT INTO comandas (idComanda,cartao,pix,dinheiro,desconto,totalPedido,troco,dataVenda) VALUES ('$comanda','$cartao','$pix','$dinheiro','$desconto','$totalFim','$troco',NOW())");

        /* PEGA OS VALORES DA COMANDA */
        $pagamentos = mysqli_query($conexao, "SELECT cartao, pix, dinheiro, totalPedido FROM comandas WHERE idComanda = '$comanda '");
        $valores = mysqli_fetch_row($pagamentos);

        /* ATUALIZA OS VALORES DO CAIXA COM OS VALORES DA COMANDA */
        $hoje = date('Y-m-d');
        $cartao = mysqli_query($conexao, "UPDATE caixa set cartao = cartao + '$valores[0]' where dataCaixa = '$hoje'");
        $pix = mysqli_query($conexao, "UPDATE caixa set pix = pix + '$valores[1]' where dataCaixa = '$hoje'");
        $dinheiro = mysqli_query($conexao, "UPDATE caixa set dinheiro = dinheiro + '$valores[2]' where dataCaixa = '$hoje'");

        /* ATUALIZA A COLUNA ENTRADA DA TABELA CAIXA A CADA VENDA  */
        $totalPedido = mysqli_query($conexao, "UPDATE caixa SET entrada = entrada + '$valores[3]' WHERE dataCaixa = '$hoje'");

        /* APAGANDO A TABELA MESAS E NUMERO_MESAS */
        $deletaMesa = mysqli_query($conexao, "DELETE FROM mesas WHERE comanda='$comanda'");
        $deletanMesa = mysqli_query($conexao, "DELETE FROM numero_mesas WHERE comanda='$comanda'");

        header('location:../principal/mesa.php');
    } else {
        $_SESSION['falta'] = true;
        header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        exit;
    }
}
