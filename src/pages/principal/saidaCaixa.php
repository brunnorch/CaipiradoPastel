<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

/* INFORMA SAIDA DO CAIXA  */
if (isset($_POST['submit'])) {
    $dataSaida = $_POST['dataSaida'];
    $valorSaida = $_POST['valorSaida'];
    $descricao = $_POST['descricao'];
    $data = date('Y-m-d', strtotime($dataSaida));
$statusCaixa = mysqli_query($conexao, "SELECT statusCaixa FROM caixa WHERE 
dataCaixa = '$data'"); 
$statusCaixa = mysqli_fetch_assoc($statusCaixa);

    if ($statusCaixa['statusCaixa'] == null) {
        /*SWEETALERT*/
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
        $alert = alerta("warning", "CAIXA FECHADO", "O caixa de hoje não foi aberto!");
    }else {
        /* ADICIONA O REGISTRO NA TABELA DE SAIDA */
        $saida = mysqli_query($conexao, "INSERT INTO saida_caixa(valorSaida, descricao, dataSaida) VALUES ('$valorSaida','$descricao','$data')");
        
        /*ADICIONA O VALOR DA SAIDA AO CAIXA*/
        $saidaCaixa = mysqli_query($conexao, "UPDATE caixa SET saida = saida + '$valorSaida' WHERE dataCaixa = '$data'");
        
            /*SWEETALERT*/
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
            $alert = alerta("success", "SAÍDA LANÇADA", "Registro salvo com sucesso!");
        }

}

?>
<!DOCTYPE html>
<html lang="pt-br">

<body>

    <section class="home-section">
        <div class="home-header">
            <!-- CABEÇALHO -->
            <span class="text">
                Saida Caixa
            </span>
        </div>
        <div class="home-content">
            <!-- SAIDA DE CAIXA -->
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <form class="row g-3" action="../principal/saidaCaixa.php" method="POST">
                        <div class="col-md-12">
                            <label class="form-label">Operador Caixa</label>
                            <div class="col-auto">
                                <select class="form-select" required>
                                    <option selected value="1"><?= $_SESSION['usuario'] ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data da Saída</label>
                            <input type="date" class="form-control" id="dataSaida" name="dataSaida" style="text-align: center;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Quantia da saída</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valorSaida" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                                <span class="input-group-text">,00</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="descSaida" class="form-label">Descrição da saida</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" cols="50" required></textarea>

                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<!-- CONFIRMA LANCAMENTO DE SAIDA PELO SWWERTALERT -->
<script>
    $('.btnSaida').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('action')

        Swal.fire({
            title: 'FECHAMENTO DO CAIXA',
            text: "Confirma o fechamento?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, fechar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })
</script>

</html>