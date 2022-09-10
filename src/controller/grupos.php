<?php
$pasteis = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='1' ORDER BY idProduto");
$pasteis = mysqli_fetch_all($pasteis);

$salgados = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='2' ORDER BY idProduto");
$salgados = mysqli_fetch_all($salgados);

$doces = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='3' ORDER BY idProduto");
$doces = mysqli_fetch_all($doces);

$bebidas = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='4' ORDER BY idProduto");
$bebidas = mysqli_fetch_all($bebidas);

$refrigerantes = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='5' ORDER BY idProduto");
$refrigerantes = mysqli_fetch_all($refrigerantes);

$alcoolicos = mysqli_query($conexao, "SELECT * FROM produtos WHERE grupo ='6' ORDER BY idProduto");
$alcoolicos = mysqli_fetch_all($alcoolicos);
