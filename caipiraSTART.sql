-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 03-Set-2022 às 15:08
-- Versão do servidor: 10.5.16-MariaDB
-- versão do PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `id19496707_caipira`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE `caixa` (
  `idCaixa` int(11) NOT NULL,
  `statusCaixa` int(11) NOT NULL,
  `usuarioCaixa` varchar(45) NOT NULL,
  `saldoInicial` decimal(10,2) NOT NULL,
  `cartao` decimal(10,2) DEFAULT 0.00,
  `pix` decimal(10,2) DEFAULT 0.00,
  `dinheiro` decimal(10,2) DEFAULT 0.00,
  `entrada` decimal(10,2) DEFAULT 0.00,
  `saida` decimal(10,2) DEFAULT 0.00,
  `dataCaixa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`idCaixa`, `statusCaixa`, `usuarioCaixa`, `saldoInicial`, `cartao`, `pix`, `dinheiro`, `entrada`, `saida`, `dataCaixa`) VALUES
(1, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-01-15'),
(2, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-02-17'),
(3, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-03-18'),
(4, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-04-19'),
(5, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-05-15'),
(6, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-06-15'),
(7, 0, 'admin', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-07-15'),
(8, 0, 'cleber', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-08-31'),
(16, 1, 'cleber', 55.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2022-09-02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho_produto`
--

CREATE TABLE `carrinho_produto` (
  `idUsuario` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `carrinho_produto`
--

INSERT INTO `carrinho_produto` (`idUsuario`, `idProduto`, `quantidade`) VALUES
(1, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comandas`
--

CREATE TABLE `comandas` (
  `idComanda` int(11) NOT NULL,
  `cartao` decimal(10,2) DEFAULT 0.00,
  `pix` decimal(10,2) DEFAULT 0.00,
  `dinheiro` decimal(10,2) DEFAULT 0.00,
  `desconto` decimal(10,2) DEFAULT 0.00,
  `totalPedido` decimal(10,2) NOT NULL DEFAULT 0.00,
  `troco` decimal(10,2) DEFAULT 0.00,
  `dataVenda` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `danificado`
--

CREATE TABLE `danificado` (
  `idProduto` int(11) NOT NULL,
  `nomeDanificado` varchar(15) NOT NULL,
  `valorDanificado` decimal(10,2) NOT NULL,
  `quantDanificado` int(11) NOT NULL,
  `dataDanificado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `finaliza_pedido`
--

CREATE TABLE `finaliza_pedido` (
  `idfinalizacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesas`
--

CREATE TABLE `mesas` (
  `idMesa` int(11) NOT NULL,
  `comanda` int(11) NOT NULL,
  `garcom` varchar(45) NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int(11) NOT NULL,
  `dataVenda` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `numero_mesas`
--

CREATE TABLE `numero_mesas` (
  `idMesa` int(11) NOT NULL,
  `comanda` int(11) NOT NULL,
  `garcom` varchar(45) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `comanda` int(11) NOT NULL,
  `garcom` varchar(45) NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int(11) NOT NULL,
  `dataVenda` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `idProduto` int(11) NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `quantiaProduto` int(11) NOT NULL,
  `dataProduto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`idProduto`, `nomeProduto`, `valorProduto`, `quantiaProduto`, `dataProduto`) VALUES
(0, 'vasilhame', 1.00, 1000, '2022-09-02'),
(1, 'bacalhau', 12.00, 50, '2022-08-30'),
(2, 'calabresa', 8.00, 50, '2022-08-27'),
(3, 'carne pura', 8.00, 50, '2022-08-15'),
(4, 'carne com queijo', 8.00, 50, '2022-08-15'),
(5, 'bode', 12.00, 50, '2022-08-26'),
(6, 'camarão', 14.00, 50, '2022-08-26'),
(7, 'frango puro', 14.00, 50, '2022-08-26'),
(8, 'frango com queijo', 14.00, 50, '2022-08-26'),
(9, 'lombinho', 14.00, 50, '2022-08-26'),
(10, 'lombo canadense', 9.00, 50, '2022-08-26'),
(11, 'misto', 8.00, 50, '2022-08-26'),
(12, 'mistao', 12.00, 50, '2022-08-26'),
(13, 'goiabada', 8.00, 50, '2022-08-27'),
(14, 'banana', 8.00, 50, '2022-08-26'),
(15, 'peito de peru', 9.00, 50, '2022-08-26'),
(16, 'queijo', 8.00, 50, '2022-08-26'),
(17, 'siri', 12.00, 50, '2022-08-26'),
(18, 'toscana', 8.00, 50, '2022-08-26'),
(19, 'super mistão', 16.00, 50, '2022-08-26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida_caixa`
--

CREATE TABLE `saida_caixa` (
  `idSaida` int(11) NOT NULL,
  `valorSaida` decimal(10,2) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `dataSaida` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `saida_caixa`
--

INSERT INTO `saida_caixa` (`idSaida`, `valorSaida`, `descricao`, `dataSaida`) VALUES
(24, 22.00, 'teste para saida de relatorio', '2022-09-02'),
(25, 34.00, 'gelos', '2022-09-02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `cargo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usuario`, `senha`, `cargo`) VALUES
(1, 'cleber', 'a9f7ebd5d9d5bdc0bbf1f63db9850199', 'administrador'),
(2, 'caixa', '202cb962ac59075b964b07152d234b70', 'caixa'),
(6, 'brunno', '202cb962ac59075b964b07152d234b70', 'caixa'),
(8, 'fred', '202cb962ac59075b964b07152d234b70', 'garçom'),
(22, 'teste', '202cb962ac59075b964b07152d234b70', 'caixa');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`idCaixa`);

--
-- Índices para tabela `carrinho_produto`
--
ALTER TABLE `carrinho_produto`
  ADD PRIMARY KEY (`idUsuario`,`idProduto`),
  ADD KEY `fk_carrinho_produto_produto1_idx` (`idProduto`),
  ADD KEY `fk_carrinho_produto_carrinho1_idx` (`idUsuario`);

--
-- Índices para tabela `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`idComanda`);

--
-- Índices para tabela `danificado`
--
ALTER TABLE `danificado`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices para tabela `finaliza_pedido`
--
ALTER TABLE `finaliza_pedido`
  ADD PRIMARY KEY (`idfinalizacao`,`idUsuario`),
  ADD KEY `fk_confirmaCompra_carrinho1_idx` (`idUsuario`);

--
-- Índices para tabela `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`idMesa`);

--
-- Índices para tabela `numero_mesas`
--
ALTER TABLE `numero_mesas`
  ADD PRIMARY KEY (`idMesa`,`comanda`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices para tabela `saida_caixa`
--
ALTER TABLE `saida_caixa`
  ADD PRIMARY KEY (`idSaida`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `idCaixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `finaliza_pedido`
--
ALTER TABLE `finaliza_pedido`
  MODIFY `idfinalizacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `saida_caixa`
--
ALTER TABLE `saida_caixa`
  MODIFY `idSaida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho_produto`
--
ALTER TABLE `carrinho_produto`
  ADD CONSTRAINT `fk_carrinho_produto_carrinho1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `fk_carrinho_produto_produto1` FOREIGN KEY (`idProduto`) REFERENCES `produtos` (`idProduto`);

--
-- Limitadores para a tabela `finaliza_pedido`
--
ALTER TABLE `finaliza_pedido`
  ADD CONSTRAINT `fk_confirmaCompra_carrinho1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
