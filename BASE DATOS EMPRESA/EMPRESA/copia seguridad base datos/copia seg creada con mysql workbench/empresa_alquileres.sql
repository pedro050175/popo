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
-- Table structure for table `alquileres`
--

DROP TABLE IF EXISTS `alquileres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alquileres` (
  `id_alquiler` int NOT NULL AUTO_INCREMENT,
  `contrato` varchar(10) NOT NULL,
  `vehiculo` int NOT NULL,
  `cliente` int NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date DEFAULT NULL,
  `kilometros` smallint unsigned DEFAULT NULL,
  `kmInicio` smallint unsigned DEFAULT NULL,
  `kmFin` smallint unsigned DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `precioKm` decimal(10,2) DEFAULT NULL,
  `fianza` decimal(10,2) DEFAULT NULL,
  `fianzaDevuelta` decimal(10,2) DEFAULT NULL,
  `comercial` varchar(50) DEFAULT NULL,
  `empresa` int DEFAULT NULL,
  `ciudad` varchar(15) DEFAULT NULL,
  `entrega` varchar(20) DEFAULT NULL,
  `comisionComercial` decimal(10,2) DEFAULT NULL,
  `ganancia` decimal(10,2) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` varchar(25) DEFAULT NULL,
  `dias` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id_alquiler`),
  UNIQUE KEY `contrato_UNIQUE` (`contrato`),
  KEY `fk_cliente` (`cliente`),
  KEY `fk_empresa` (`empresa`),
  KEY `fk_vehicul` (`vehiculo`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_empresa` FOREIGN KEY (`empresa`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_vehicul` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alquileres`
--

LOCK TABLES `alquileres` WRITE;
/*!40000 ALTER TABLE `alquileres` DISABLE KEYS */;
INSERT INTO `alquileres` VALUES (1,'xxxxx1',1,2,'2025-09-24','2025-10-10',0,1258,1589,5000.00,3.00,3000.00,0.00,'luis',2,'murcia','cristian',100.00,4900.00,'popo','Entregado',1),(3,'xxxxx3',66,34,'2025-09-24','2025-09-26',300,0,0,2500.00,0.00,3000.00,0.00,'cristian',34,NULL,NULL,0.00,0.00,NULL,'Sin entregar',2),(10,'xxxxx',1,32,'2025-09-25',NULL,20,0,0,5555.00,0.00,0.00,0.00,NULL,32,NULL,NULL,555.00,5000.00,NULL,NULL,15),(11,'xxxxx2',66,35,'2025-01-15',NULL,1,0,0,0.00,0.00,0.00,0.00,NULL,35,NULL,NULL,0.00,0.00,NULL,NULL,0),(13,'011025',82,43,'2025-10-03','2025-10-05',300,NULL,NULL,6000.00,10.00,5000.00,5000.00,'martin',2,'Murcia',NULL,600.00,5400.00,'ESTE ALQUIER NO TIENE CONTRATO FISICO, ES DE MARTIN Y NO TENGO NADA MAS','Terminado',2),(14,'xxxxx8',1,33,'2025-10-04',NULL,230,NULL,NULL,3000.00,NULL,NULL,NULL,NULL,3,NULL,NULL,200.00,2800.00,NULL,NULL,2),(15,'020325',90,44,'2025-10-08','2025-10-13',750,NULL,NULL,1500.00,3.00,3000.00,NULL,'cristian',1,'VALENCIA','CRISTIAN',150.00,1350.00,NULL,'Entregado',5),(16,'031025',69,45,'2025-10-10','2025-11-10',NULL,NULL,NULL,1500.00,NULL,NULL,NULL,'cristian',1,'Murcia','CRISTIAN',150.00,1350.00,NULL,'Entregado',30);
/*!40000 ALTER TABLE `alquileres` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-18 20:04:07
