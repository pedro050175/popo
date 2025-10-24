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
-- Table structure for table `cuotasvehiculo`
--

DROP TABLE IF EXISTS `cuotasvehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuotasvehiculo` (
  `idCuota` int NOT NULL AUTO_INCREMENT,
  `inicio` date DEFAULT NULL,
  `duracion` tinyint unsigned DEFAULT NULL,
  `id_vehiculo` int NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `cuota` decimal(10,2) DEFAULT NULL,
  `totalPagar` decimal(10,2) DEFAULT NULL,
  `pagoFinal` decimal(10,2) DEFAULT NULL,
  `entrada` decimal(10,2) DEFAULT NULL,
  `fianza` decimal(10,2) DEFAULT NULL,
  `km` int(10) unsigned zerofill DEFAULT NULL,
  `kmAno` int(10) unsigned zerofill DEFAULT NULL,
  `financiera` varchar(50) DEFAULT NULL,
  `id_entidad` int NOT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idCuota`),
  KEY `fk_1_id_vehiculo` (`id_vehiculo`),
  KEY `fk_2_id_entidad` (`id_entidad`),
  CONSTRAINT `fk_1_id_vehiculo` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`) ON DELETE CASCADE,
  CONSTRAINT `fk_2_id_entidad` FOREIGN KEY (`id_entidad`) REFERENCES `entidad` (`id_entidad`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuotasvehiculo`
--

LOCK TABLES `cuotasvehiculo` WRITE;
/*!40000 ALTER TABLE `cuotasvehiculo` DISABLE KEYS */;
INSERT INTO `cuotasvehiculo` VALUES (1,'2025-07-21',48,78,'Renting',1695.75,0.00,0.00,0.00,0.00,0000000000,0000015000,NULL,1,NULL),(2,'2025-08-21',36,79,'Renting',1231.56,NULL,NULL,NULL,NULL,NULL,0000015000,NULL,38,NULL),(3,'2025-08-21',NULL,80,'Renting',4114.01,NULL,NULL,NULL,NULL,NULL,NULL,NULL,40,NULL),(4,'2025-08-21',60,81,'Renting',1554.00,NULL,NULL,NULL,NULL,NULL,0000016000,'volkswagen',39,NULL),(5,'2025-06-18',36,82,'Financiado',5300.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,39,NULL),(6,'2025-07-11',NULL,83,'Renting',1414.00,NULL,NULL,NULL,NULL,NULL,NULL,'athlon',39,NULL),(7,'2025-06-27',48,84,'Financiado',2916.08,NULL,NULL,NULL,NULL,NULL,NULL,'MERCEDES BENZ FINANCIAL',41,NULL),(8,'2023-05-08',NULL,85,'Renting',879.00,NULL,NULL,NULL,NULL,NULL,0000020000,'Ayvens Spain Mobility Solutions, S.A.U.',33,NULL),(9,'2024-04-24',24,86,'Renting',1169.05,NULL,NULL,NULL,NULL,NULL,0000020000,'Ayvens Spain Mobility Solutions, S.A.U.',33,NULL),(10,'2024-09-30',48,69,'Financiado',798.01,NULL,NULL,NULL,NULL,NULL,NULL,'TOYOYA FINANCIAL SERVICE',33,NULL),(11,'2024-06-17',NULL,87,'Renting',588.00,NULL,NULL,NULL,NULL,NULL,0000018000,'CONDUCE REVEL, S.',33,NULL),(12,'2022-12-28',48,88,'Renting',1801.00,NULL,NULL,NULL,NULL,NULL,0000020000,'Ayvens Spain Mobility Solutions, S.A.U.',42,NULL),(13,'2023-03-30',48,89,'Renting',2328.27,NULL,NULL,NULL,NULL,NULL,0000020000,'ARVAL',1,NULL),(14,'2023-03-30',48,90,'Renting',2093.61,NULL,NULL,NULL,NULL,NULL,0000020000,'Ayvens Spain Mobility Solutions, S.A.U.',1,NULL),(15,'2024-06-01',48,91,'Renting',1119.47,NULL,NULL,NULL,NULL,NULL,0000020000,'Ayvens Spain Mobility Solutions, S.A.U.',1,NULL),(16,'2025-04-28',72,71,'Financiado',2091.34,NULL,NULL,NULL,NULL,NULL,NULL,'volkswagen',2,NULL),(17,'2023-09-21',48,92,'Financiado',2049.66,NULL,NULL,NULL,NULL,NULL,NULL,'volkswagen',1,NULL),(18,'2024-04-21',48,93,'Financiado',622.55,NULL,NULL,NULL,NULL,NULL,NULL,'volkswagen',1,NULL);
/*!40000 ALTER TABLE `cuotasvehiculo` ENABLE KEYS */;
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
