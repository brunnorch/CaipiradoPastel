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
  $grupo = $_POST['grupo'];
  $tipo = $_POST['tipo'];
  $minimo = $_POST['minimo'];

  $idFinal = $grupo . '0' . $codigo;

  //VERIFICANDO SE JÁ EXISTE UM REGISTRO 
  $result = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM produtos WHERE nomeProduto = '$nome' OR idProduto ='$idFinal'");
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
  $sql = "INSERT INTO produtos (idProduto,grupo,tipo,nomeProduto,valorProduto,minProduto,quantiaProduto,dataProduto) VALUES ('$idFinal','$grupo','$tipo','$nome','$valor','$minimo','$quant', NOW())";
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
$hoje = date('d/m/Y');
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
              <label class="form-label">Grupo</label>
              <div class="col-auto">
                <select class="form-select" name="grupo" required>
                  <option selected></option>
                  <option value='01'>01 - Pasteis</option>
                  <option value='02'>02 - Salgados</option>
                  <option value='03'>03 - Doces</option>
                  <option value='04'>04 - Bebidas</option>
                  <option value='05'>05 - Refrigerantes</option>
                  <option value='05'>06 - Alcoolicos</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Codigo</label>
              <input type="number" class="form-control" id="codigo" autofocus name="codigo" min="1" maxlength="99" required>
            </div>
            <div class="col-md-4">
              <label for="inputAddress" class="form-label">Data</label>
              <input readonly type="text" class="form-control" id="dataCadastro" name="dataCaixa" style="cursor: no-drop; text-align: center;" value="<?= $hoje ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Unidade Venda</label>
              <div class="col-auto">
                <select class="form-select" name="tipo" required>
                  <option selected></option>
                  <option value='UN'>UN</option>
                  <option value='PÇ'>PÇ</option>
                  <option value='ML'>ML</option>
                </select>
              </div>
            </div>
            <div class="col-md-8">
              <label for="text" class="form-label">Nome do Produto</label>
              <input type="text" class="form-control" id="nome" name="nome" maxlength="30" required>
            </div>
            <div class="col-md-4">
              <label for="inputCity" class="form-label">Valor</label>
              <div class="input-group mb-3">
                <span class="input-group-text">R$</span>
                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="valor" id="valor" step="0.010" onchange="this.value = this.value.replace(/,/g, '.')" required>
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Estoque Minímo</label>
              <input type="number" class="form-control" id="minimo" name="minimo" min="1" maxlength="99">
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