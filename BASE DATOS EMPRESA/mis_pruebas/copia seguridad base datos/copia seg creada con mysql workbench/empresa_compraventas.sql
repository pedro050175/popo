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
-- Table structure for table `compraventas`
--

DROP TABLE IF EXISTS `compraventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compraventas` (
  `id_compraventa` int NOT NULL AUTO_INCREMENT,
  `fechaCompra` date DEFAULT NULL,
  `precioCompraReal` decimal(10,2) DEFAULT NULL,
  `precioCompraDeclarado` decimal(10,2) DEFAULT NULL,
  `fechaFactComp` date DEFAULT NULL,
  `declaraComp` tinyint unsigned DEFAULT '1',
  `impuestoCompra` varchar(20) DEFAULT NULL,
  `comprador` int DEFAULT NULL,
  `anuladaCompra` tinyint unsigned DEFAULT NULL,
  `vehiculo` int NOT NULL,
  `reserva` tinyint unsigned DEFAULT NULL,
  `comercialVenta` varchar(50) DEFAULT NULL,
  `fechaVenta` date DEFAULT NULL,
  `precioVentaReal` decimal(10,2) DEFAULT NULL,
  `precioVentaDeclarado` decimal(10,2) DEFAULT NULL,
  `fechaFactVent` date DEFAULT NULL,
  `declaraVent` tinyint unsigned DEFAULT '1',
  `impuestoVenta` varchar(20) DEFAULT NULL,
  `vendedor` int DEFAULT NULL,
  `anuladaVenta` tinyint unsigned DEFAULT NULL,
  `observaciones` varchar(355) DEFAULT NULL,
  PRIMARY KEY (`id_compraventa`),
  KEY `fk_comprador` (`comprador`) /*!80000 INVISIBLE */,
  KEY `fk_vehi` (`vehiculo`),
  KEY `fk_vendedor` (`vendedor`),
  CONSTRAINT `fk_comprador` FOREIGN KEY (`comprador`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_vehi` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_vendedor` FOREIGN KEY (`vendedor`) REFERENCES `entidad` (`id_entidad`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compraventas`
--

LOCK TABLES `compraventas` WRITE;
/*!40000 ALTER TABLE `compraventas` DISABLE KEYS */;
INSERT INTO `compraventas` VALUES (1,'2025-10-01',100000.00,90000.00,'2025-10-01',1,'iva',1,0,1,NULL,NULL,'2025-10-02',120000.00,110000.00,'2025-10-02',1,'iva',2,NULL,NULL);
/*!40000 ALTER TABLE `compraventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-18 20:04:06
