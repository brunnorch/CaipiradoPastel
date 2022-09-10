<?php
session_start();
include_once('../../conexao.php');
require_once('../../../public/assets/dompdf/autoload.inc.php');

$comanda = $_GET['id'];
$verMesa = mysqli_query($conexao, "SELECT comanda, nomeProduto, valorProduto, qtdProduto,garcom, dataVenda FROM mesas WHERE comanda ='$comanda'");
$verMesa = mysqli_fetch_all($verMesa);

$qtdItens = 0;
$subTotal = 0;

foreach ($verMesa as $key) {
    $body2[] = "
        <tr>
        <td>" . ucfirst($key[1])  . "</td>
        <td>" . $key[3] . "</td>
        <td>R$ " . number_format($key[2], 2, ",", ".") . "</td>
        <td>R$ " . number_format($key[3] * $key[2], 2, ",", ".") . "</td>
    </tr>
        ";
    $qtdItens += $key[3];
    $subTotal += $key[2] * $key[3];
};


/* ESTILO DO PEDIDO.PDF */
$style = "
<style>
    @page {
        margin: 0px;
        width: 80mm;
        height: auto;
        font-size: 15px;
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
        <div class="logo">
            <img src="https://caipiradopastel.000webhostapp.com/public/assets/images/LOGO.png" style ="margin: 20px 0 0 75px">
        </div>
        <div class="empresa">
            <p>Comanda ' . $comanda . ' - Gar&ccedil;om ' . ucfirst($key[4])  . '<br>' . date('d/m/Y', strtotime($key[5])) . ' - ' . $date . '</p>
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
                        <th>SUB. T</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($subTotal, 2, ", ", " . ")  . '</td>
                    </tr>
                    <tr>
                        <th>DESC</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($_SESSION['desconto'], 2, ", ", " . ") . '</td>
                    </tr>
                    <tr>
                        <th>TOTAL</th>
                        <th></th>
                        <th></th>
                        <td style="font-weight: bold;">R$ ' . number_format($subTotal - $_SESSION['desconto'], 2, ", ", " . ") . '</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
        </div>
        <h4>Obrigado pela presen&ccedil;a. Volte Sempre!</h4>
    </main>
</body>
';

$infoProd = '';
foreach ($body2 as $key) {
    $infoProd = $infoProd . $key;
}

$nota = $style . $body1 . $infoProd . $body3;



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
