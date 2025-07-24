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
-- Table structure for table `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculos` (
  `id_vehiculo` int NOT NULL AUTO_INCREMENT,
  `Matricula` varchar(10) DEFAULT NULL,
  `Bastidor` varchar(20) DEFAULT NULL,
  `Marca_modelo` varchar(50) NOT NULL,
  `Km` mediumint unsigned DEFAULT NULL,
  `Fecha_matricula` date DEFAULT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `Combustible` varchar(12) DEFAULT NULL,
  `Fecha_itv` date DEFAULT NULL,
  `Estado` varchar(10) DEFAULT NULL,
  `Clase` varchar(12) DEFAULT (_utf8mb4'Turismo'),
  `propietario` int DEFAULT NULL,
  PRIMARY KEY (`id_vehiculo`),
  UNIQUE KEY `Matricula_UNIQUE` (`Matricula`),
  UNIQUE KEY `Bastidor_UNIQUE` (`Bastidor`),
  KEY `fk_propietario` (`propietario`),
  CONSTRAINT `fk_propietario` FOREIGN KEY (`propietario`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculos`
--

LOCK TABLES `vehiculos` WRITE;
/*!40000 ALTER TABLE `vehiculos` DISABLE KEYS */;
INSERT INTO `vehiculos` VALUES (1,'1485LKL','1C4HJWEGXHL621376','JEEP GRANGLER V6',156257,'2017-06-12',NULL,'Gasolina',NULL,'usado','Turismo',1),(2,'7298MPH','ZPBEC3ZL8RLA28516','LAMBO URUS PERFORMANTE',15245,'2024-03-26',NULL,'Gasolina',NULL,'usado','Turismo',1),(3,'4701MXT','WUAZZZGY4PA905457','AUDI RS3 PERFORMANCE AZUL',14211,'2023-02-08',NULL,'Gasolina',NULL,'usado','Turismo',2),(4,'7013MJD','WBS31AY030FL53505','BMW M3',45014,'2021-06-24',NULL,'Gasolina',NULL,'usado','Turismo',3);
/*!40000 ALTER TABLE `vehiculos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-24 13:01:49
