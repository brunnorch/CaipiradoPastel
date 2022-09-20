<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* FECHANDO O CAIXA */
if (isset($_GET['id']) && $_GET['id'] == "fechar") {

    $status = 0;
    $hoje = date('Y-m-d');
    $dataCaixa = mysqli_query($conexao, "SELECT dataCaixa FROM caixa WHERE statusCaixa = '1'");
    $dataCaixa = mysqli_fetch_assoc($dataCaixa);

    if ($dataCaixa['dataCaixa'] == $hoje) {
        $sqlfechaCaixa = "UPDATE caixa SET statusCaixa = '$status' WHERE dataCaixa ='$hoje'";
        $resultfechaCaixa = mysqli_query($conexao, $sqlfechaCaixa);
    } else {
        $sqlfechaCaixa = "UPDATE caixa SET statusCaixa = '$status' WHERE dataCaixa ='$dataCaixa[dataCaixa]'";
        $resultfechaCaixa = mysqli_query($conexao, $sqlfechaCaixa);
    }
}


/* ABRINDO O CAIXA */
if (isset($_POST['submit'])) {
    $valorInicial = $_POST['valorCaixa'];
    $user = $_SESSION['usuario'];
    $status = 1;
    $resultabreCaixa = mysqli_query($conexao, "INSERT INTO caixa (statusCaixa,usuarioCaixa,saldoInicial,dataCaixa) VALUES ('$status','$user','$valorInicial',NOW())");

    /* AVISANDO QUE O CAIXA ABRIU */
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
    $alert = alerta("success", "CAIXA ABERTO", "Bom trabalho. Lembre-se de fechar o caixa!");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Abrir de Caixa
            </span>
        </div>
        <div class="home-content">
            <!-- COLOQUE AQUI O CONTEUDO DESSA PAGE -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <form class="row g-3" action="../principal/caixa.php" method="POST">
                        <div class="col-md-12">
                            <label class="form-label">Operador Caixa</label>
                            <div class="col-auto">
                                <select class="form-select" required>
                                    <option selected value="1"><?= $_SESSION['usuario'] ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Data</label>
                            <input readonly type="text" class="form-control" id="dataCadastro" name="dataCaixa" style="cursor: no-drop; text-align: center;" value="<?php $hoje = date('d/m/Y');
                                                                                                                                                                    echo $hoje; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Quantia para abertura</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valorCaixa" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                                <span class="input-group-text">,00</span>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Abrir Caixa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>


</html>