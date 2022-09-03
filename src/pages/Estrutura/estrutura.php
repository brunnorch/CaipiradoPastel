<?php ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="icon" href="../../../public/assets/images/icone.PNG">
    <title>Caipira do Pastel</title>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS DO SIDEBAR -->
    <link rel="stylesheet" href="../Estrutura/estrutura.css">
    <!-- CSS DO CONTEUDO -->
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- SWEET ALERT PARA ESTOQUE -->
    <script src="../../../public/assets/js/sweetalert2.all.min.js"></script>
    <!-- JQUERY -->
    <script src="../../../public/assets/js/jquery-3.6.1.min.js"></script>
    <!-- SCRIPT DO GRAFICO (CHARTS) -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body style="background: #E4E9F7;">
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-menu'></i>
            <span class="logo_name">Gerencial</span>
        </div>
        <ul class="nav-links">
            
            <?php
            include_once('../../conexao.php');
            /* VERIFICA QUEM ESTÁ LOGADO PARA DAR O NIVEIS DE ACESSO */
            $login = mysqli_query($conexao, "SELECT usuario,cargo FROM usuario WHERE usuario = '$_SESSION[usuario]'");
            $login = mysqli_fetch_assoc($login);
            if ($login['cargo'] == "administrador" || $login['cargo'] == "caixa") : ?>
            <li>
                <a href="../principal/menu.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Início</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../principal/menu.php">Início</a></li>
                </ul>
            </li>
                <li>
                    <div class="iocn-link">
                        <a href="../principal/estoque.php">
                            <i class='bx bx-package'></i>
                            <span class="link_name">Produtos</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Produtos</a></li>
                        <li><a href="../principal/cadastro.php">Cadastrar</a></li>
                        <li><a href="../principal/estoque.php">Estoque</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-wallet-alt'></i>
                            <span class="link_name">Caixa</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Caixa</a></li>
                        <?php
                        /* STATUS DO CAIXA  */
                        $statusCaixa = mysqli_query($conexao, "SELECT statusCaixa FROM caixa order by statusCaixa desc");
                        $statusCaixa = mysqli_fetch_assoc($statusCaixa);

                        /* SE O CAIXA ESTIVER ABERTO, REDIRECIONA PARA VENDAS */
                        if ($statusCaixa['statusCaixa'] == 0 || $statusCaixa['statusCaixa'] == null) : ?>
                            <li><a href='../principal/caixa.php'>Abrir Caixa</a></li>
                        <?php else : ?>
                            <li><a href='../principal/venda.php'>Caixa Aberto</a></li>
                        <?php endif; ?>
                        <li><a href="../principal/saidaCaixa.php">Lançar Saída</a></li>
                    </ul>

                <li>
                    <?php if ($statusCaixa['statusCaixa'] == 0 || $statusCaixa['statusCaixa'] == null) : ?>
                        <a href='../principal/caixa.php'>
                            <i class='bx bx-shopping-bag'></i>
                            <span class='link_name'>Vendas</span>
                        </a>
                        <ul class='sub-menu blank'>
                            <li><a class='link_name' href='../principal/caixa.php'>Vendas</a></li>
                        </ul>
                    <?php else : ?>
                        <a href='../principal/venda.php'>
                            <i class='bx bx-shopping-bag'></i>
                            <span class='link_name'>Vendas</span>
                        </a>
                        <ul class='sub-menu blank'>
                            <li><a class='link_name' href='../principal/venda.php'>Vendas</a></li>
                        </ul>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="../principal/mesa.php">
                        <i class='bx bx-dish'></i>
                        <span class="link_name">Mesas</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="../principal/mesa.php">Mesas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bx-map'></i>
                        <span class="link_name">Delivery</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Delivery</a></li>
                    </ul>
                </li>

                <!-- NIVEIS DE ACESSO -->
                <?php if ($login['cargo'] == "administrador") : ?>
                    <li>
                        <div class="iocn-link">
                            <a href="#">
                                <i class='bx bx-book-alt'></i>
                                <span class="link_name">Relatórios</span>
                            </a>
                            <i class='bx bxs-chevron-down arrow'></i>
                        </div>
                        <ul class="sub-menu">
                            <li><a class="link_name" href="#">Relatórios</a></li>
                            <li><a href="../relatorios/caixaMes.php">Caixa</a></li>
                            <li><a href="../relatorios/saidas.php">Saídas</a></li>
                            <li><a href="../relatorios/comanda.php">Comandas</a></li>
                            <li><a href="../relatorios/produtos.php">Produtos</a></li>
                            <li><a href="../relatorios/danificados.php">Danificados</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="iocn-link">
                            <a href="#">
                                <i class='bx bx-bar-chart-alt-2'></i>
                                <span class="link_name">Gráficos</span>
                            </a>
                            <i class='bx bxs-chevron-down arrow'></i>
                        </div>
                        <ul class="sub-menu">
                            <li><a class="link_name" href="#">Gráficos</a></li>
                            <li><a href="../graficos/graficoMensal.php">Caixa</a></li>
                            <li><a href="../graficos/graficoProdutos.php">Produtos</a></li>
                            <li><a href="../graficos/graficoDanificados.php">Danificados</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="../principal/colaboradores.php">
                            <i class='bx bx-id-card'></i>
                            <span class="link_name">Colaboradores</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="#">Colaboradores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php else : ?>
                <li>
                    <?php
                     /* STATUS DO CAIXA  */
                        $statusCaixa = mysqli_query($conexao, "SELECT statusCaixa FROM caixa order by statusCaixa desc");
                        $statusCaixa = mysqli_fetch_assoc($statusCaixa);
                    if ($statusCaixa['statusCaixa'] == 0 || $statusCaixa['statusCaixa'] == null) : ?>

                        <a href='../principal/caixa.php'>
                            <i class='bx bx-shopping-bag'></i>
                            <span class='link_name'>Vendas</span>
                        </a>
                        <ul class='sub-menu blank'>
                            <li><a class='link_name' href='../principal/caixa.php'>Vendas</a></li>
                        </ul>
                    <?php else : ?>
                        <a href='../principal/venda.php'>
                            <i class='bx bx-shopping-bag'></i>
                            <span class='link_name'>Vendas</span>
                        </a>
                        <ul class='sub-menu blank'>
                            <li><a class='link_name' href='../principal/venda.php'>Vendas</a></li>
                        </ul>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="../principal/mesa.php">
                        <i class='bx bx-dish'></i>
                        <span class="link_name">Mesas</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="../principal/mesa.php">Mesas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bx-map'></i>
                        <span class="link_name">Delivery</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Delivery</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <li>
                <div class="profile-details">
                    <div class="profile-content">
                    </div>
                    <div class="name-job">
                        <div class="profile_name"><?= ucfirst($login['usuario']) ?></div>
                    </div>
                    <a href="../../logout.php">
                        <i class='bx bx-log-out'></i>
                    </a>
                </div>
            </li>
        </ul>
    </div>

</body>

<!-- SIDE BAR -->
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement;
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>