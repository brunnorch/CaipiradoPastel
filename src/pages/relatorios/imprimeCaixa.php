<?php
session_start();
include_once('../../conexao.php');
require_once('../../../public/assets/dompdf/autoload.inc.php');

$dataCaixa = $_GET['data'];

/* QUANTIDADE DE COMANDAS DO DIIA */
$comandas = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM comandas WHERE dataVenda = '$dataCaixa'");
$comandas = mysqli_fetch_assoc($comandas);

/* PASTEIS DANIFICADOS */
$danificados = mysqli_query($conexao, "SELECT SUM(quantDanificado) AS total FROM danificado WHERE dataDanificado = '$dataCaixa' AND idProduto LIKE '10%'");
$danificados = mysqli_fetch_assoc($danificados);
/* SELECTS DO DIA */
$pasteis = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '10%'");
$pasteis = mysqli_fetch_assoc($pasteis);

$salgados = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '20%'");
$salgados = mysqli_fetch_assoc($salgados);

$doces = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '30%'");
$doces = mysqli_fetch_assoc($doces);

$bebidas = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '40%' AND NOT nomeProduto ='vasilhame'");
$bebidas = mysqli_fetch_assoc($bebidas);

$refrigerantes = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '50%'");
$refrigerantes = mysqli_fetch_assoc($refrigerantes);

$alcoolicos = mysqli_query($conexao, "SELECT SUM(qtdProduto) AS total FROM pedidos WHERE dataVenda = '$dataCaixa' AND idProduto LIKE '60%'");
$alcoolicos = mysqli_fetch_assoc($alcoolicos);

/* VALORES DO CAIXA */
$caixa = mysqli_query($conexao, "SELECT * FROM caixa WHERE dataCaixa = '$dataCaixa'");
$caixa = mysqli_fetch_assoc($caixa);

/* ESTILO DO PEDIDO.PDF */
$style = "
<style>
    @page {
        margin: 0px;
        width: 80mm;
        height: auto;

        }
        tr.separated td {
            border-bottom: 1px solid black;
        }
    
        table {
    
            border-collapse: collapse;
        }
</style>
";

$body = '
    <div>
        <div style="text-align: center;">
            <h2>Relatorio do Caixa</h2>
            <h4>' . date('d/m/Y', strtotime($dataCaixa)) . '</h4>
        </div>
        <div >
            <table style=" width: 80mm;">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>    
                        <td>Quantidade de comandas</td>
                        <td>' . $comandas['total'] . '</td>
                    </tr>
                    <br>
                    <tr>
                        <td>Pasteis danificados</td>
                        <td>' . $danificados['total'] . '</td>
                    </tr>
                    <tr>
                        <td>Quantidade de pasteis</td>
                        <td>' . $pasteis['total'] . '</td>
                    </tr>
                    <tr >
                        <td>Quantidade de salgados</td>
                        <td>' . $salgados['total'] . '</td>
                    </tr>
                    <tr>
                        <td>Quantidade de doces</td>
                        <td>' . $doces['total'] . '</td>
                    </tr>
                    <tr>
                        <td>Quantidade de bebidas</td>
                        <td>' . $bebidas['total'] . '</td>
                    </tr>
                    <tr>
                        <td>Quantidade de refrigerantes</td>
                        <td>' . $refrigerantes['total'] . '</td>
                    </tr>
                    
                    <tr>
                        <td>Quantidade de alcoolicos</td>
                        <td>' . $alcoolicos['total'] . '</td>
                    </tr>
                    <br>
                    <tr>
                        <td>Valor inicial</td>
                        <td>R$' . number_format($caixa['saldoInicial'], 2, ", ", " . ") . '</td>
                    </tr>
                    <tr>
                        <td>Valor em cartao</td>
                        <td>R$' . number_format($caixa['cartao'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <td>Valor em pix</td>
                        <td>R$' . number_format($caixa['pix'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <td>Valor em dinheiro</td>
                        <td>R$' . number_format($caixa['dinheiro'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <td>Valor Total</td>
                        <td>R$' . number_format($caixa['pix'] + $caixa['dinheiro'] + $caixa['cartao'] + $caixa['saldoInicial'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <br>
                    <tr>
                        <td>Saida de caixa</td>
                        <td>-R$' . number_format($caixa['saida'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <td>Total do caixa</td>
                        <td>R$' . number_format($caixa['pix'] + $caixa['dinheiro'] + $caixa['cartao'] + $caixa['saldoInicial'] - $caixa['saida'], 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <td>Saldo do caixa</td>
                        <td>R$' . number_format($caixa['saldoInicial'] + $caixa['dinheiro'] - $caixa['saida'], 2, ", ", " . ")  . '</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

';

$caixaDia = $style . $body;

use Dompdf\Dompdf;
//gerando o pdf
$caixaDia = utf8_decode($caixaDia);
// reference the Dompdf namespace


// instantiate and use the dompdf class
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($caixaDia);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('c7', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream(
    "Caixa " . $dataCaixa . ".pdf",
    array(
        "Attachment" => false
    )
);
