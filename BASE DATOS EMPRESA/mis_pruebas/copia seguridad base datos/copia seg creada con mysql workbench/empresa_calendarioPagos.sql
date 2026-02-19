-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: empresa
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `calendarioPagos`
--

DROP TABLE IF EXISTS `calendarioPagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calendarioPagos` (
  `idcalendarioPagos` int NOT NULL AUTO_INCREMENT,
  `empresa` int NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `siFestivo` varchar(45) DEFAULT NULL,
  `diaMes` char(2) DEFAULT NULL,
  `modalidad` varchar(65) DEFAULT NULL,
  `fechaPago` date DEFAULT NULL,
  `domiciliado` tinyint DEFAULT NULL,
  `banco` varchar(45) DEFAULT NULL,
  `pagoTransf` tinyint DEFAULT NULL,
  `aplazamiento` tinyint DEFAULT NULL,
  `inicioAplaz` date DEFAULT NULL,
  `finAplaz` date DEFAULT NULL,
  `empresaRecibe` int NOT NULL,
  `pendiente` tinyint DEFAULT NULL,
  `vencimiento` date DEFAULT NULL,
  `ultimoCambio` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcalendarioPagos`),
  KEY `empresaFK_idx` (`empresa`),
  KEY `empresaRecibeFK_idx` (`empresaRecibe`),
  CONSTRAINT `empresaFK` FOREIGN KEY (`empresa`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `empresaRecibeFK` FOREIGN KEY (`empresaRecibe`) REFERENCES `entidad` (`id_entidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendarioPagos`
--

LOCK TABLES `calendarioPagos` WRITE;
/*!40000 ALTER TABLE `calendarioPagos` DISABLE KEYS */;
INSERT INTO `calendarioPagos` VALUES (1,1,'seguros sociales',100.00,'dia habiel anterior','31','1',NULL,1,'caja rural',NULL,NULL,NULL,NULL,2,1,'2030-01-26','2026-01-30 12:33:25');
/*!40000 ALTER TABLE `calendarioPagos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-30 16:52:25
