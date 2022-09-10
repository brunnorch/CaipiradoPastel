<?php
session_start();
include_once('../../conexao.php');
include_once('../../verificalogin.php');

$user = $_SESSION['usuario'];
$total = $_SESSION['total'];

/* ADD O PEDIDO NA MESA  */
if (isset($_POST['submit'])) {
    $mesa = $_POST['mesa'];
    $comanda = $_POST['comanda'];
    $garcom = $_POST['garcom'];

    /* PEGA O ID DA COMANDA PARA VERIFICAR SE EXISTE */
    $verificaComanda = mysqli_query($conexao, "SELECT idComanda FROM comandas where idComanda = '$comanda'");
    $confirmaComanda = mysqli_fetch_row($verificaComanda);

    /* SE A  COMANDA FOR DIFERENTE DE UMA JÁ CADASTRADA O PEDIDO É CONCLUIDO */
    if ($comanda != $confirmaComanda[0]) {

        /* PEGA O ID DO USUARIO LOGADO */
        $sqlUser = "SELECT idUsuario FROM usuario WHERE usuario.usuario ='$user'";
        $resultUser = mysqli_query($conexao, $sqlUser);
        $idUsuario = mysqli_fetch_array($resultUser);

        /* ADICIONA O ID DO USUARIO NA TABELA FINALIZA_PEDIDO(TEMPORARIA) */
        $sqlFinaliza = "INSERT INTO finaliza_pedido(idUsuario) VALUES ('$idUsuario[0]')";
        $resultFinaliza = mysqli_query($conexao, $sqlFinaliza);

        /* SELECT JUNTANDO AS INFORMAÇÕES PARA CRIAR UM ARRAY */
        $sqlJoin = "SELECT produtos.idProduto, produtos.nomeProduto, produtos.valorProduto, carrinho_produto.quantidade
            FROM finaliza_pedido
            INNER JOIN usuario ON usuario.idUsuario = finaliza_pedido.idUsuario
            INNER JOIN carrinho_produto ON usuario.idUsuario = carrinho_produto.idUsuario
            INNER JOIN produtos ON produtos.idProduto = carrinho_produto.idProduto
            WHERE usuario.usuario ='$user'";
        $resultJoin = mysqli_query($conexao, $sqlJoin);
        $finalCompra = mysqli_fetch_all($resultJoin);

        /* CONCLUINDO O PEDIDO ADCIONANDO NA TABELA MESAS (TEMPORARIA) */
        foreach ($finalCompra as $row) {
            $sqlPedido = "INSERT INTO mesas (comanda,garcom,idProduto,nomeProduto, valorProduto, qtdProduto,dataVenda) VALUES ('$comanda','$garcom','$row[0]','$row[1]','$row[2]','$row[3]',NOW())";
            $resultPedido = mysqli_query($conexao, $sqlPedido);

            /* DIMINUINDO ESTOQUE DO PRODUTO CONFORME O PEDIDO */
            $sqlUpdate = "UPDATE produtos set quantiaProduto = quantiaProduto - '$row[3]'
            where idProduto = '$row[0]'";
            $resultUpdate = mysqli_query($conexao, $sqlUpdate);
        }

        /* LIMPANDO A TABELA CARRINHO_PRODUTOS E FINALIZA_PEDIDO */
        $sqlClean1 = "DELETE FROM carrinho_produto WHERE carrinho_produto.idUsuario ='$idUsuario[0]'";
        $resultClean1 = mysqli_query($conexao, $sqlClean1);

        $sqlClean2 = "DELETE FROM finaliza_pedido WHERE finaliza_pedido.idUsuario = '$idUsuario[0]'";
        $resultClean2 = mysqli_query($conexao, $sqlClean2);

        #CRIANDO UMA MESA NA TABELA NUMERO_MESA
        $sqladdMesa = mysqli_query($conexao, "INSERT INTO numero_mesas (idMesa, comanda, garcom) VALUES ('$mesa','$comanda','$garcom')");
        header('location:../principal/mesa.php');
    } else {
        $_SESSION['comandaExiste'] = true;
        header('location:../principal/carrinho.php');
    }
}
