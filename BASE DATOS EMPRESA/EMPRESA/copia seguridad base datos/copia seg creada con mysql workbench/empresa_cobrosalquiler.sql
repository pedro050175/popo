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
-- Table structure for table `cobrosalquiler`
--

DROP TABLE IF EXISTS `cobrosalquiler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cobrosalquiler` (
  `idCobro` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `alquiler` int NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `facturado` tinyint(1) DEFAULT NULL,
  `facturadoA` varchar(50) DEFAULT NULL,
  `contratoHacienda` varchar(25) DEFAULT NULL,
  `fianza` tinyint(1) DEFAULT NULL,
  `parteImporteFianza` decimal(10,2) DEFAULT NULL,
  `banco` varchar(10) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idCobro`),
  KEY `fk_alquil` (`alquiler`),
  CONSTRAINT `fk_alquil` FOREIGN KEY (`alquiler`) REFERENCES `alquileres` (`id_alquiler`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cobrosalquiler`
--

LOCK TABLES `cobrosalquiler` WRITE;
/*!40000 ALTER TABLE `cobrosalquiler` DISABLE KEYS */;
INSERT INTO `cobrosalquiler` VALUES (2,'2025-09-28',1,3000.00,NULL,NULL,NULL,1,NULL,NULL,NULL),(3,'2025-09-27',1,1000.00,1,'popo','45454',1,200.00,NULL,NULL),(4,'2025-10-03',13,11000.00,0,NULL,NULL,1,5000.00,NULL,NULL);
/*!40000 ALTER TABLE `cobrosalquiler` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-18 20:04:08
