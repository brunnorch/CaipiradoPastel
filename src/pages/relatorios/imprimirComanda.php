<?php
session_start();
include_once('../../conexao.php');
require_once('../../../public/assets/dompdf/autoload.inc.php');

$comanda = $_GET['id'];
$sqlComanda = mysqli_query($conexao, "SELECT comandas.idComanda, comandas.dataVenda ,pedidos.garcom,pedidos.nomeProduto, pedidos.qtdProduto, pedidos.valorProduto, 
comandas.cartao,comandas.pix,comandas.dinheiro,comandas.desconto ,comandas.totalPedido FROM comandas
INNER JOIN pedidos ON comandas.idComanda = pedidos.comanda WHERE comandas.idComanda ='$comanda'");
$rowComanda = mysqli_fetch_all($sqlComanda);

$qtdItens = 0;
$subTotal = 0;

foreach ($rowComanda as $key) {
    $body2[] = "
        <tr>
        <td>" . ucfirst($key[3])  . "</td>
        <td>" . $key[4] . "</td>
        <td>R$ " . number_format($key[5], 2, ",", ".") . "</td>
        <td>R$ " . number_format($key[4] * $key[5], 2, ",", ".") . "</td>
    </tr>
        ";
    $qtdItens += $key[4];
    $subTotal += $key[5] * $key[4];
};


/* ESTILO DO PEDIDO.PDF */
$style = "
<style>
    @page {
        margin: 0px;
        width: 80mm;
        height: auto;

    }

    .empresa {
        text-align: center;
    }

    h2 {
        margin: 18px 0 0 0;
    }

    h4 {
        text-align: center;
        margin: 10px;
    }

    p {
        margin: 0 0 18px 0;
    }

    hr {
        border: 1px solid black;
    }

    .conta {
        margin: auto;
        width: 80mm;
    }


    tr.separated td {
        border-bottom: 1px solid black;
    }

    table {

        border-collapse: collapse;
    }
</style>
";
$date = date('H:i');

/* TABELA DE PRODUTOS */
$body1 = '
<body>
    <main class="pedido">
        <div class="empresa">
            <h2>CAIPIRA DO PASTEL</h2>
            <p>Comanda ' . $comanda . ' - Gar&ccedil;om ' . ucfirst($key[2])  . '<br>' . date('d/m/Y', strtotime($key[1])) . '</p>
            <hr>
        </div>
        <div>
            <table class="conta">
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th>QTD</th>
                        <th>V. UNI</th>
                        <th>V. TOT</th>
                    </tr>
                </thead>

                <tbody>';

$body3 = '
                    <tr class="separated">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                </tbody>

                <tfoot>

                    <tr>
                        <th>QTD ITENS</th>
                        <td>' . $qtdItens . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>SUB. TOTAL</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($subTotal, 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <th>DESCONTO</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($key[9], 2, ", ", " . ") . '</td>
                    </tr>
                    <tr>
                        <th>TOTAL</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($subTotal - $key[9], 2, ", ", " . ") . '</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
        </div>

        <h4>Forma de Pagamento</h4>
        <br>
        ';
if ($rowComanda[0][6] == '0.00') {
    $body4 = "<p>Pix - R$ " . $rowComanda[0][7] .
        "<p/>Dinheiro - R$ " . $rowComanda[0][8] . "
    </main>
</body>
        ";
} elseif ($rowComanda[0][7] == '0.00') {
    $body4 = "<p>Cartao - R$ " . $rowComanda[0][6] . "</p><p>Dinheiro - R$ " . $rowComanda[0][8] . "</p>
    </main>
</body>
";
} elseif ($rowComanda[0][8] == '0.00') {
    $body4 = "<p>Cartao - R$ " . $rowComanda[0][6] . "</p><p>Pix - R$ " . $rowComanda[0][7] . "</p>
    </main>
</body>
";
} else {
    $body4 = "<p>Cartao - R$ " . $rowComanda[0][6] . "</p><p>Pix - R$ " . $rowComanda[0][7] . "</p><p>Dinheiro - R$ " . $rowComanda[0][8] . "</p>
    </main>
</body>
";
}




$infoProd = '';
foreach ($body2 as $key) {
    $infoProd = $infoProd . $key;
}

$nota = $style . $body1 . $infoProd . $body3 . $body4;



use Dompdf\Dompdf;
//gerando o pdf
$nota = utf8_decode($nota);
// reference the Dompdf namespace


// instantiate and use the dompdf class
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($nota);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('c7', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream(
    "Comanda" . $comanda . ".pdf",
    array(
        "Attachment" => false
    )
);
