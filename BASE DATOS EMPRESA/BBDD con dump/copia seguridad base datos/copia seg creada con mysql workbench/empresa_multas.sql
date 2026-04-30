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
-- Table structure for table `multas`
--

DROP TABLE IF EXISTS `multas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multas` (
  `idMulta` int NOT NULL AUTO_INCREMENT,
  `expediente` varchar(45) DEFAULT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `importePagado` decimal(10,2) DEFAULT NULL,
  `fechaPago` date DEFAULT NULL,
  `pagaDesde` varchar(45) DEFAULT NULL,
  `identificar` tinyint unsigned DEFAULT NULL,
  `fechaIdentificada` date DEFAULT NULL,
  `vencimiento` date DEFAULT NULL,
  `vehiculo` int NOT NULL,
  `lugar` varchar(45) DEFAULT NULL,
  `importeCobrado` decimal(10,2) DEFAULT NULL,
  `conductor` varchar(45) DEFAULT NULL,
  `conductorIdentificado` varchar(45) DEFAULT NULL,
  `terminada` tinyint unsigned DEFAULT NULL,
  `comentarios` varchar(350) DEFAULT NULL,
  `fechaNotificacion` date DEFAULT NULL,
  PRIMARY KEY (`idMulta`),
  UNIQUE KEY `idMulta_UNIQUE` (`idMulta`),
  KEY `fk_coche` (`vehiculo`),
  CONSTRAINT `fk_coche` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multas`
--

LOCK TABLES `multas` WRITE;
/*!40000 ALTER TABLE `multas` DISABLE KEYS */;
INSERT INTO `multas` VALUES (14,'2500457116','2025-10-01',200.00,100.00,NULL,NULL,0,NULL,'2025-12-14',79,'LORCA',NULL,'alquiler 060925',NULL,1,'LA GESTIONA Y PAGA SERGIO','2025-11-24'),(17,'43178624','2025-11-03',75.00,35.00,'2025-12-01','caja rural stelar',0,NULL,'2025-12-14',86,'MONFORTE',NULL,NULL,NULL,1,NULL,'2025-11-24'),(25,' 41-048-046.933-4','2025-11-12',100.00,50.00,'2025-12-02','tarjeta caja rural stelar',0,NULL,'2025-12-14',120,NULL,NULL,NULL,NULL,1,NULL,'2025-11-24'),(26,'0009/2025/9316732','2025-08-30',200.00,100.00,'2025-12-12','TARJETA CAJA RURAL STELAR',0,NULL,'2025-12-21',86,'cadiz',100.00,NULL,NULL,1,NULL,'2025-12-01'),(27,'2025/118696','2025-08-01',88.13,97.08,'2026-01-12','TARJETA CAJA RURAL STELAR',0,NULL,'2026-01-16',93,'MURCIA',97.00,'FERMIN',NULL,1,'NO SE LA FECHA REAL DE LA MULTA. he pedido el expediente por instacia al ayuntamiento de murcia','2025-12-27'),(28,'2025/118123','2025-08-01',88.13,97.08,NULL,'TARJETA CAJA RURAL STELAR',0,NULL,'2026-01-16',92,'MURCIA',97.00,'FERMIN',NULL,1,'he pedido el expediente por instacia al ayuntamiento de murcia','2025-12-27'),(29,'126202/2025','2025-10-10',80.00,40.00,'2026-01-05','BBVA UNIVERSO',0,NULL,'2026-01-18',99,'MURCIA',40.00,NULL,NULL,1,NULL,'2025-12-29'),(30,'943097514','2025-12-30',50.00,25.00,'2026-01-27','cajamar martin',0,NULL,'2026-01-20',133,'MARBELLA',NULL,NULL,NULL,1,'envio mail a atenciontelefonica@prpmalaga.es desde info@rentcardeluxe.es para que me envíen carta de pago, dice que en 20 dias sale la carta de pago','2025-12-31');
/*!40000 ALTER TABLE `multas` ENABLE KEYS */;
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
