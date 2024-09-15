-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: naong
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `arquivo` varchar(45) NOT NULL,
  `dtinicial` datetime NOT NULL,
  `dtfinal` datetime NOT NULL,
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `nome_departamento` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'COMIDA','A','https://img.icons8.com/ios/50/porridge--v1.png'),(2,'ROUPA','A','https://img.icons8.com/ios/50/shirt.png');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doadores`
--

DROP TABLE IF EXISTS `doadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doadores` (
  `id_doador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `cpf_cnpj` varchar(45) NOT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `cadastro` datetime DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_doador`,`email`,`cpf_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doadores`
--

LOCK TABLES `doadores` WRITE;
/*!40000 ALTER TABLE `doadores` DISABLE KEYS */;
INSERT INTO `doadores` VALUES (1,'bruno','10399991905','içara','santa catarina','88820000',NULL,'48996609371','doador@gmail.com','$2y$10$i4EwB0RI9Xz3iS3dqZDoiOfjqATTR2heh9VeKePPq0f5fJSAmx2My','2000-01-01','2024-09-08 16:47:23','sfhgfsg','A');
/*!40000 ALTER TABLE `doadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `necessidades`
--

DROP TABLE IF EXISTS `necessidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `necessidades` (
  `id_necessidade` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `quantidade` float DEFAULT NULL,
  PRIMARY KEY (`id_necessidade`),
  KEY `fk_necessidade_ong_idx` (`id_ong`),
  KEY `fk_necessidade_departamento_idx` (`id_departamento`),
  CONSTRAINT `fk_necessidade_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_necessidade_ong` FOREIGN KEY (`id_ong`) REFERENCES `ongs` (`id_ong`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `necessidades`
--

LOCK TABLES `necessidades` WRITE;
/*!40000 ALTER TABLE `necessidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `necessidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ongs`
--

DROP TABLE IF EXISTS `ongs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ongs` (
  `id_ong` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(45) NOT NULL,
  `razao_social` varchar(45) DEFAULT NULL,
  `nome_fantasia` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `area_atuacao` varchar(255) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `site` varchar(60) DEFAULT NULL,
  `instagram` varchar(45) DEFAULT NULL,
  `facebook` varchar(45) NOT NULL,
  PRIMARY KEY (`id_ong`,`cnpj`,`email`),
  KEY `fk_id_departamento_idx` (`id_departamento`),
  CONSTRAINT `fk_id_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ongs`
--

LOCK TABLES `ongs` WRITE;
/*!40000 ALTER TABLE `ongs` DISABLE KEYS */;
INSERT INTO `ongs` VALUES (1,'58963214789632',NULL,'ong1','rua dona antonia','içara','88820000','santa catarina',NULL,'48996609371','ong1@gmail.com','2024-09-08 16:48:17','A','$2y$10$CQCnuyKappgrJQ9hbAKNA.44z8m4QQ7EsR5.2ixlNgaPpgFEFNRIm',NULL,'asilo ',1,'Precisamos de comida não perecivel','-28.7134945','-49.2861059');
/*!40000 ALTER TABLE `ongs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pontos_coleta`
--

DROP TABLE IF EXISTS `pontos_coleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pontos_coleta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ong` int(11) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `rua` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `cep` varchar(45) DEFAULT NULL,
  `numero_endereco` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ong_coleta_idx` (`ong`),
  CONSTRAINT `ong_coleta` FOREIGN KEY (`ong`) REFERENCES `ongs` (`id_ong`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pontos_coleta`
--

LOCK TABLES `pontos_coleta` WRITE;
/*!40000 ALTER TABLE `pontos_coleta` DISABLE KEYS */;
INSERT INTO `pontos_coleta` VALUES (1,1,'ponto 1 ','rua geral','criciuma','santa cantarina','brasil','88820000','256','48996609371','A'),(2,1,'evento ','centro','criciuma','santa catarina','brasil','88820000','256','48996609371','A'),(3,1,'esucri','rua geral','criciuma','santa catarina','brasil','88820000','300','48996609371','A');
/*!40000 ALTER TABLE `pontos_coleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacao_pontos_coleta`
--

DROP TABLE IF EXISTS `publicacao_pontos_coleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publicacao_pontos_coleta` (
  `id_pontos_coleta` int(11) NOT NULL,
  `id_publicacao` int(11) NOT NULL,
  KEY `fk_pontos_coleta_idx` (`id_pontos_coleta`),
  KEY `fk_publicacao_idx` (`id_publicacao`),
  CONSTRAINT `fk_pontos_coleta` FOREIGN KEY (`id_pontos_coleta`) REFERENCES `pontos_coleta` (`id`),
  CONSTRAINT `fk_publicacao` FOREIGN KEY (`id_publicacao`) REFERENCES `publicacoes` (`id_publicacoes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacao_pontos_coleta`
--

LOCK TABLES `publicacao_pontos_coleta` WRITE;
/*!40000 ALTER TABLE `publicacao_pontos_coleta` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicacao_pontos_coleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacoes`
--

DROP TABLE IF EXISTS `publicacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publicacoes` (
  `id_publicacoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_ong` int(11) DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `dtpublicacao` datetime DEFAULT NULL,
  `arquivo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_publicacoes`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacoes`
--

LOCK TABLES `publicacoes` WRITE;
/*!40000 ALTER TABLE `publicacoes` DISABLE KEYS */;
INSERT INTO `publicacoes` VALUES (1,1,'Evento centro','evento no centro de criciuma para arrecadar a','2024-09-10 01:14:30','img/publicacoes/publicacao_1.jpeg'),(2,1,'Evento Esucri','Evento na Esucri para arrecadar alimentos','2024-09-10 01:14:20','img/publicacoes/publicacao_2.jpeg');
/*!40000 ALTER TABLE `publicacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_doacoes`
--

DROP TABLE IF EXISTS `registro_doacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_doacoes` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `id_doador` int(11) DEFAULT NULL,
  `id_ong` int(11) DEFAULT NULL,
  `doacao` varchar(45) DEFAULT NULL,
  `data_doacao` datetime DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `idx_registro_ong` (`id_doador`),
  KEY `fk_registro_ong_idx` (`id_ong`),
  CONSTRAINT `fk_registro_doador` FOREIGN KEY (`id_doador`) REFERENCES `doadores` (`id_doador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_ong` FOREIGN KEY (`id_ong`) REFERENCES `ongs` (`id_ong`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_doacoes`
--

LOCK TABLES `registro_doacoes` WRITE;
/*!40000 ALTER TABLE `registro_doacoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro_doacoes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-09 20:24:23
