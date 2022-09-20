-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: caipira
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caixa`
--

DROP TABLE IF EXISTS `caixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caixa` (
  `idCaixa` int NOT NULL AUTO_INCREMENT,
  `statusCaixa` int NOT NULL,
  `usuarioCaixa` varchar(45) NOT NULL,
  `saldoInicial` decimal(10,2) NOT NULL,
  `cartao` decimal(10,2) DEFAULT '0.00',
  `pix` decimal(10,2) DEFAULT '0.00',
  `dinheiro` decimal(10,2) DEFAULT '0.00',
  `entrada` decimal(10,2) DEFAULT '0.00',
  `saida` decimal(10,2) DEFAULT '0.00',
  `dataCaixa` date DEFAULT NULL,
  PRIMARY KEY (`idCaixa`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caixa`
--

LOCK TABLES `caixa` WRITE;
/*!40000 ALTER TABLE `caixa` DISABLE KEYS */;
INSERT INTO `caixa` VALUES (1,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-01-15'),(2,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-02-17'),(3,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-03-18'),(4,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-04-19'),(5,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-05-15'),(6,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-06-15'),(7,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-07-15'),(8,0,'cleber',0.00,0.00,0.00,0.00,0.00,0.00,'2022-08-31');
/*!40000 ALTER TABLE `caixa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho_produto`
--

DROP TABLE IF EXISTS `carrinho_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho_produto` (
  `idUsuario` int NOT NULL,
  `idProduto` int NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`idUsuario`,`idProduto`),
  KEY `fk_carrinho_produto_produto1_idx` (`idProduto`),
  KEY `fk_carrinho_produto_carrinho1_idx` (`idUsuario`),
  CONSTRAINT `fk_carrinho_produto_carrinho1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `fk_carrinho_produto_produto1` FOREIGN KEY (`idProduto`) REFERENCES `produtos` (`idProduto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho_produto`
--

LOCK TABLES `carrinho_produto` WRITE;
/*!40000 ALTER TABLE `carrinho_produto` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comandas`
--

DROP TABLE IF EXISTS `comandas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comandas` (
  `idComanda` int NOT NULL,
  `cartao` decimal(10,2) DEFAULT '0.00',
  `pix` decimal(10,2) DEFAULT '0.00',
  `dinheiro` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `totalPedido` decimal(10,2) NOT NULL DEFAULT '0.00',
  `troco` decimal(10,2) DEFAULT '0.00',
  `dataVenda` date DEFAULT NULL,
  PRIMARY KEY (`idComanda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comandas`
--

LOCK TABLES `comandas` WRITE;
/*!40000 ALTER TABLE `comandas` DISABLE KEYS */;
/*!40000 ALTER TABLE `comandas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danificado`
--

DROP TABLE IF EXISTS `danificado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danificado` (
  `idProduto` int NOT NULL,
  `nomeDanificado` varchar(15) NOT NULL,
  `valorDanificado` decimal(10,2) NOT NULL,
  `quantDanificado` int NOT NULL,
  `dataDanificado` date DEFAULT NULL,
  PRIMARY KEY (`idProduto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `danificado`
--

LOCK TABLES `danificado` WRITE;
/*!40000 ALTER TABLE `danificado` DISABLE KEYS */;
/*!40000 ALTER TABLE `danificado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entregas`
--

DROP TABLE IF EXISTS `entregas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entregas` (
  `idEntrega` int NOT NULL AUTO_INCREMENT,
  `statusEntrega` int DEFAULT '1',
  `garcom` varchar(45) NOT NULL,
  `clienteEntrega` varchar(45) NOT NULL,
  `celularEntrega` bigint NOT NULL,
  `bairroEntrega` varchar(45) NOT NULL,
  `enderecoEntrega` varchar(45) NOT NULL,
  `numeroEntrega` varchar(10) NOT NULL,
  `taxaEntrega` decimal(10,2) NOT NULL,
  `cartaoEntrega` decimal(10,2) DEFAULT '0.00',
  `dinheiroEntrega` decimal(10,2) DEFAULT '0.00',
  `pixEntrega` decimal(10,2) DEFAULT '0.00',
  `descontoEntrega` decimal(10,2) DEFAULT '0.00',
  `totalEntrega` decimal(10,2) DEFAULT '0.00',
  `dataEntrega` date DEFAULT NULL,
  `horaEntrega` time DEFAULT NULL,
  PRIMARY KEY (`idEntrega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entregas`
--

LOCK TABLES `entregas` WRITE;
/*!40000 ALTER TABLE `entregas` DISABLE KEYS */;
/*!40000 ALTER TABLE `entregas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entregas_andamento`
--

DROP TABLE IF EXISTS `entregas_andamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entregas_andamento` (
  `idAndamento` int NOT NULL AUTO_INCREMENT,
  `idEntrega` int NOT NULL,
  `clienteEntrega` varchar(45) NOT NULL,
  `idProduto` int NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int NOT NULL,
  `dataEntrega` date DEFAULT NULL,
  PRIMARY KEY (`idAndamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entregas_andamento`
--

LOCK TABLES `entregas_andamento` WRITE;
/*!40000 ALTER TABLE `entregas_andamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `entregas_andamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entregas_concluida`
--

DROP TABLE IF EXISTS `entregas_concluida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entregas_concluida` (
  `idEntrega` int NOT NULL,
  `ClienteEntrega` varchar(45) NOT NULL,
  `idProduto` int NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int NOT NULL,
  `dataEntrega` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entregas_concluida`
--

LOCK TABLES `entregas_concluida` WRITE;
/*!40000 ALTER TABLE `entregas_concluida` DISABLE KEYS */;
/*!40000 ALTER TABLE `entregas_concluida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finaliza_pedido`
--

DROP TABLE IF EXISTS `finaliza_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finaliza_pedido` (
  `idfinalizacao` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  PRIMARY KEY (`idfinalizacao`,`idUsuario`),
  KEY `fk_confirmaCompra_carrinho1_idx` (`idUsuario`),
  CONSTRAINT `fk_confirmaCompra_carrinho1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finaliza_pedido`
--

LOCK TABLES `finaliza_pedido` WRITE;
/*!40000 ALTER TABLE `finaliza_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `finaliza_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesas` (
  `idMesa` int NOT NULL AUTO_INCREMENT,
  `comanda` int NOT NULL,
  `garcom` varchar(45) NOT NULL,
  `idProduto` int NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int NOT NULL,
  `dataVenda` date DEFAULT NULL,
  PRIMARY KEY (`idMesa`)
) ENGINE=InnoDB AUTO_INCREMENT=357 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `numero_mesas`
--

DROP TABLE IF EXISTS `numero_mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `numero_mesas` (
  `idMesa` int NOT NULL,
  `comanda` int NOT NULL,
  `garcom` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`idMesa`,`comanda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_general_mysql500_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `numero_mesas`
--

LOCK TABLES `numero_mesas` WRITE;
/*!40000 ALTER TABLE `numero_mesas` DISABLE KEYS */;
/*!40000 ALTER TABLE `numero_mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `idPedido` int NOT NULL AUTO_INCREMENT,
  `comanda` int NOT NULL,
  `garcom` varchar(45) NOT NULL,
  `idProduto` int NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `qtdProduto` int NOT NULL,
  `dataVenda` date DEFAULT NULL,
  PRIMARY KEY (`idPedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `idProduto` int NOT NULL,
  `grupo` int NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `nomeProduto` varchar(45) NOT NULL,
  `valorProduto` decimal(10,2) NOT NULL,
  `minProduto` int DEFAULT NULL,
  `quantiaProduto` int NOT NULL,
  `dataProduto` date NOT NULL,
  PRIMARY KEY (`idProduto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1001,1,'UN','bacalhau',12.00,5,50,'2022-09-16'),(1002,1,'UN','calabresa',8.00,15,50,'2022-09-16'),(1003,1,'UN','carne pura',8.00,10,50,'2022-09-16'),(1004,1,'UN','carne com queijo',8.00,20,50,'2022-09-16'),(1005,1,'UN','carne de bode',9.00,10,50,'2022-09-16'),(1006,1,'UN','camarao',14.00,10,50,'2022-09-07'),(1007,1,'UN','frango puro',8.00,10,50,'2022-09-07'),(1008,1,'UN','frango com queijo',8.00,20,50,'2022-09-07'),(1009,1,'UN','lombinho',9.00,15,50,'2022-09-07'),(1010,1,'UN','lombo canadense',9.00,10,50,'2022-09-07'),(1011,1,'UN','misto',8.00,20,50,'2022-09-07'),(1012,1,'UN','mistao',8.00,20,50,'2022-09-07'),(1013,1,'UN','goiabada',8.00,5,50,'2022-09-07'),(1014,1,'UN','banana',8.00,5,50,'2022-09-07'),(1015,1,'UN','peito de peru',8.00,10,50,'2022-09-07'),(1016,1,'UN','queijo',8.00,20,50,'2022-09-07'),(1017,1,'UN','siri catado',12.00,5,50,'2022-09-07'),(1018,1,'UN','toscana',9.00,10,50,'2022-09-07'),(1019,1,'UN','super mistao',16.00,5,50,'2022-09-07'),(2030,2,'PÇ','aipim frito',16.90,6,50,'2022-09-07'),(2031,2,'PÇ','batata frita',16.90,NULL,50,'2022-09-07'),(2032,2,'PÇ','bolinho bacalhau',24.90,10,50,'2022-09-07'),(2033,2,'PÇ','bolinho queijo',16.90,NULL,50,'2022-09-07'),(2034,2,'PÇ','kibe',16.90,6,50,'2022-09-07'),(2035,2,'UN','coxinha',7.00,NULL,50,'2022-09-07'),(2036,2,'UN','pastel de forno',7.00,NULL,50,'2022-09-07'),(2037,2,'UN','empada',7.00,NULL,50,'2022-09-07'),(3001,3,'UN','cocada',2.00,NULL,50,'2022-09-06'),(3002,3,'UN','jujuba',1.00,20,50,'2022-09-07'),(3003,3,'UN','pacoca',0.50,20,50,'2022-09-07'),(4001,4,'UN','agua com gas',3.00,NULL,50,'2022-09-07'),(4002,4,'UN','agua sem gas',2.50,NULL,50,'2022-09-07'),(4003,4,'UN','vasilhame',1.00,NULL,50,'2022-09-07'),(4004,4,'ML','caldo de cana 300',3.00,NULL,50,'2022-09-07'),(4005,4,'ML','caldo de cana 500',5.00,NULL,50,'2022-09-07'),(4006,4,'ML','caldo de cana 1000',11.00,0,50,'2022-09-07'),(4007,4,'UN','Caldo de cana jarra',11.00,NULL,50,'2022-09-07'),(4008,4,'UN','coco verde',3.00,NULL,50,'2022-09-07'),(4009,4,'UN','coco verde jarra',11.00,NULL,50,'2022-09-07'),(4010,4,'ML','coco verde 1000',10.00,NULL,50,'2022-09-07'),(4011,4,'ML','suco abacaxi 500',5.00,NULL,50,'2022-09-07'),(4012,4,'UN','suco abacaxi jarra',10.00,NULL,50,'2022-09-07'),(4013,4,'ML','suco laranja 500',5.00,NULL,50,'2022-09-07'),(4014,4,'UN','suco laranja jarra',10.00,NULL,50,'2022-09-07'),(4015,4,'ML','suco limao 500',5.00,NULL,50,'2022-09-07'),(4016,4,'UN','suco limao jarra',10.00,NULL,50,'2022-09-07'),(4017,4,'ML','suco maracuja 500',5.00,NULL,50,'2022-09-07'),(4018,4,'UN','suco maracuja jarra',10.00,NULL,50,'2022-09-07'),(4019,4,'ML','suco morango 500',7.00,NULL,50,'2022-09-07'),(4020,4,'UN','suco morango jarra',14.00,NULL,50,'2022-09-07'),(5001,5,'UN','KS coca cola',3.50,NULL,50,'2022-09-07'),(5002,5,'UN','latinha antartica',3.00,NULL,50,'2022-09-07'),(5003,5,'UN','latinha pepsi',3.00,NULL,50,'2022-09-07'),(5004,5,'UN','latinha kuat',3.00,NULL,50,'2022-09-07'),(5005,5,'UN','latinha fanta',3.00,NULL,50,'2022-09-07'),(5006,5,'UN','latinha coca cola',3.00,NULL,50,'2022-09-07'),(5007,5,'UN','lata antartica',4.00,NULL,50,'2022-09-07'),(5008,5,'UN','lata pepsi',4.00,NULL,50,'2022-09-07'),(5009,5,'UN','lata fanta',4.00,NULL,50,'2022-09-07'),(5010,5,'UN','lata sprite',4.00,NULL,50,'2022-09-07'),(5011,5,'UN','lata coca cola',4.50,NULL,50,'2022-09-07'),(5012,5,'UN','LS coca cola',6.00,6,50,'2022-09-07'),(5013,5,'UN','antartica',6.00,NULL,50,'2022-09-07'),(5014,5,'UN','pepsi',6.00,NULL,50,'2022-09-07'),(5015,5,'UN','kuat',6.00,NULL,50,'2022-09-07'),(5016,5,'UN','fanta',6.00,6,50,'2022-09-07'),(5017,5,'UN','H20',4.00,NULL,50,'2022-09-07'),(5018,5,'UN','dellvale laranja',4.00,NULL,50,'2022-09-07'),(5019,5,'UN','dellvale uva',4.00,6,50,'2022-09-07'),(5020,5,'UN','skinka laranja',4.00,NULL,50,'2022-09-07'),(6001,6,'UN','longneck corona',9.00,NULL,50,'2022-09-07'),(6002,6,'UN','longneck eisenbahn',8.00,NULL,50,'2022-09-07'),(6003,6,'UN','longneck heineken',9.00,8,50,'2022-09-07'),(6004,6,'UN','longneck malzebier',7.00,NULL,50,'2022-09-07'),(6005,6,'UN','longneck zero',7.00,NULL,50,'2022-09-07'),(6006,5,'UN','lata devassa',5.00,12,50,'2022-09-07'),(6007,6,'UN','lata petra',5.00,NULL,50,'2022-09-07'),(6008,6,'UN','lata bohemia',5.00,NULL,50,'2022-09-07');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saida_caixa`
--

DROP TABLE IF EXISTS `saida_caixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saida_caixa` (
  `idSaida` int NOT NULL AUTO_INCREMENT,
  `valorSaida` decimal(10,2) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `dataSaida` date NOT NULL,
  PRIMARY KEY (`idSaida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saida_caixa`
--

LOCK TABLES `saida_caixa` WRITE;
/*!40000 ALTER TABLE `saida_caixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `saida_caixa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'caipira'
--

--
-- Dumping routines for database 'caipira'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-20 14:50:44
