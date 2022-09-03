<?php
session_start();
include_once('../Estrutura/estrutura.php');
include_once('../../verificalogin.php');
include_once('../../conexao.php');

// VERIFICANDO SE HÁ DADOS PARA ENVIAR
if (isset($_POST['submit'])) {
  $codigo = $_POST['codigo'];
  $nome = $_POST['nome'];
  $valor = $_POST['valor'];
  $quant = $_POST['quant'];

  //VERIFICANDO SE JÁ EXISTE UM REGISTRO 
  $sql = "SELECT COUNT(*) AS total FROM produtos WHERE nomeProduto = '$nome' OR idProduto ='$codigo'";
  $result = mysqli_query($conexao, $sql);
  $row = mysqli_fetch_assoc($result);
  if ($row['total'] == 1) {

    /* EXISTE PRODUTO COM ID OU NOME IGUAL */
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
    $alert = alerta("error", "PRODUTO EXISTENTE", "Já existe um produto com esse código ou nome!");
  }


  //REGISTRANDO
  $sql = "INSERT INTO produtos (idProduto,nomeProduto,valorProduto,quantiaProduto,dataProduto) VALUES ('$codigo','$nome','$valor','$quant', NOW())";
  if ($conexao->query($sql) === TRUE) {

    /* CONFIRMANDO CADASTRO */
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
    $alert = alerta("success", "PRODUTO CADASTRADO", "Produto adicionado ao estoque!");
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
        Cadastro de Produtos
      </span>
    </div>
    <div class="home-content ">

      <!-- CADASTRO DE PRODUTOS -->
      <div class="row align-items-center justify-content-center">
        <div class="col-md-8">
          <form class="row g-3" action="../principal/cadastro.php" method="POST">
            <div class="col-md-4">
              <label class="form-label">Codigo</label>
              <input type="number" class="form-control" id="codigo" autofocus name="codigo" maxlength="3" required>
            </div>
            <div class="col-md-8">
              <label for="text" class="form-label">Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" maxlength="30" required>
            </div>
            <div class="col-md-4">
              <label for="inputAddress" class="form-label">Data</label>
              <input readyonly type="text" class="form-control" id="dataCadastro" name="dataCaixa" style="cursor: no-drop; text-align: center;" value="<?php $hoje = date('d/m/Y');
                                                                                                                                                        echo $hoje; ?>">
            </div>
            <div class="col-md-4">
              <label for="inputCity" class="form-label">Valor</label>
              <div class="input-group mb-3">
                <span class="input-group-text">R$</span>
                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valor" id="valor" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
                <span class="input-group-text">,00</span>
              </div>
            </div>
            <div class="col-md-4">
              <label for="inputCity" class="form-label">Estoque</label>
              <input type="number" class="form-control" id="quant" name="quant" min="1" maxlength="99" required>
            </div>

            <div class="col-md-12" style="text-align: center;">
              <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
</body>

</html>