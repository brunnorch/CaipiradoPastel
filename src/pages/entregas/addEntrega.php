<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$user = $_SESSION['usuario'];
$total = $_SESSION['total'];

if (isset($_POST['submit'])) {
    $garcom = $_POST['garcom'];
    $cliente = $_POST['cliente'];
    $celular = $_POST['celular'];
    $bairro = $_POST['bairro'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $taxa = $_POST['taxa'];
    $dataEntrega = date('Y-m-d');

    /* ADCIONANDO A TABELA DE ENTREGAS */
    $novaEntrega = mysqli_query($conexao, "INSERT INTO entregas (garcom,clienteEntrega,celularEntrega,bairroEntrega,enderecoEntrega,numeroEntrega,taxaEntrega,dataEntrega,horaEntrega) VALUES('$garcom','$cliente','$celular','$bairro','$endereco','$numero','$taxa', NOW(),NOW())");

    /* PEGA O ID DO USUARIO LOGADO */
    $resultUser = mysqli_query($conexao, "SELECT idUsuario FROM usuario WHERE usuario.usuario ='$user'");
    $idUsuario = mysqli_fetch_array($resultUser);

    /* ADICIONA O ID DO USUARIO NA TABELA FINALIZA_PEDIDO(TEMPORARIA) */
    $resultFinaliza = mysqli_query($conexao, "INSERT INTO finaliza_pedido(idUsuario) VALUES ('$idUsuario[0]')");

    /* SELECT JUNTANDO AS INFORMAÇÕES PARA CRIAR UM ARRAY */
    $resultJoin = mysqli_query($conexao, "SELECT produtos.idProduto, produtos.nomeProduto, produtos.valorProduto, carrinho_produto.quantidade
    FROM finaliza_pedido
    INNER JOIN usuario ON usuario.idUsuario = finaliza_pedido.idUsuario
    INNER JOIN carrinho_produto ON usuario.idUsuario = carrinho_produto.idUsuario
    INNER JOIN produtos ON produtos.idProduto = carrinho_produto.idProduto
    WHERE usuario.usuario ='$user'");
    $finalCompra = mysqli_fetch_all($resultJoin);

    $idEntrega = mysqli_query($conexao, "SELECT idEntrega FROM entregas WHERE clienteEntrega = '$cliente' and dataEntrega = '$dataEntrega' and horaEntrega = NOW()");
    $idEntrega = mysqli_fetch_assoc($idEntrega);

    /* CONCLUINDO O PEDIDO ADCIONANDO NA TABELA ENTREGAS_ANDAMENTO */
    foreach ($finalCompra as $row) {
        $resultPedido = mysqli_query($conexao, "INSERT INTO entregas_andamento (idEntrega,clienteEntrega,idProduto,nomeProduto,valorProduto,qtdProduto,dataEntrega) VALUES ('$idEntrega[idEntrega]','$cliente','$row[0]','$row[1]','$row[2]','$row[3]',NOW())");

        /* DIMINUINDO ESTOQUE DO PRODUTO CONFORME O PEDIDO */
        $removeEstoque = mysqli_query($conexao, "UPDATE produtos set quantiaProduto = quantiaProduto - '$row[3]' where idProduto = '$row[0]'");
    }

    /* LIMPANDO A TABELA CARRINHO_PRODUTOS E FINALIZA_PEDIDO */
    $limpaCarrinho = mysqli_query($conexao, "DELETE FROM carrinho_produto WHERE carrinho_produto.idUsuario ='$idUsuario[0]'");
    $limpaFinaliza = mysqli_query($conexao, "DELETE FROM finaliza_pedido WHERE finaliza_pedido.idUsuario = '$idUsuario[0]'");

    header('location:../entregas/entregaAndamento.php');
} else {
    header('location:../principal/carrinho.php');
}
