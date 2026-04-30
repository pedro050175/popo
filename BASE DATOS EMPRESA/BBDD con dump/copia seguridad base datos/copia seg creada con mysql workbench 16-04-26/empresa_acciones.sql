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
-- Table structure for table `acciones`
--

DROP TABLE IF EXISTS `acciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acciones` (
  `idAccion` int NOT NULL AUTO_INCREMENT,
  `tarea` int NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `modificacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idAccion`),
  KEY `fk_tarea` (`tarea`),
  CONSTRAINT `fk_tarea` FOREIGN KEY (`tarea`) REFERENCES `tareas` (`idTarea`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acciones`
--

LOCK TABLES `acciones` WRITE;
/*!40000 ALTER TABLE `acciones` DISABLE KEYS */;
INSERT INTO `acciones` VALUES (4,6,'le envio recordatorio','2026-03-31 09:51:36','2026-03-31 10:19:58','2026-03-10'),(7,18,'CAMBIO EN DGT','2026-04-06 07:27:39','2026-04-06 07:27:39','2026-04-06'),(8,18,'CAMBIO EN HACIENDA','2026-04-06 07:27:48','2026-04-06 07:27:48','2026-04-06'),(9,18,'A LA ASESORIA LE PIDO QUE LOS CAMBIE EN SEPE Y SEG SOCIAL','2026-04-06 08:20:17','2026-04-06 08:20:17','2026-04-06'),(10,18,'HECHO solicto en area cliente de Arval para el rr sport 2023','2026-04-06 08:30:09','2026-04-10 08:55:40','2026-04-06'),(11,18,'vodafone','2026-04-06 08:37:18','2026-04-06 08:37:18','2026-04-06'),(12,18,'vueling no me deja cambiarla','2026-04-06 08:40:21','2026-04-06 08:40:21','2026-04-06'),(13,18,'emuasa alberca 2A','2026-04-06 08:42:12','2026-04-06 08:42:12','2026-04-06'),(14,18,'emuasa alberca larisa','2026-04-06 08:43:20','2026-04-06 08:43:20','2026-04-06'),(15,18,'en amazon','2026-04-06 08:58:44','2026-04-06 08:58:44','2026-04-06'),(16,18,'iberdrola piso larisa alberca 1a','2026-04-06 09:59:09','2026-04-06 09:59:09','2026-04-06'),(17,18,'axa embassy pedido pro mail a atencion.clientes@axa.es desde martin@rentcardeluxe.com','2026-04-06 10:09:57','2026-04-06 10:09:57','2026-04-06'),(18,17,'subidas','2026-04-07 10:27:00','2026-04-07 10:27:00','2026-04-07'),(19,18,'cambio efecto led','2026-04-07 12:00:06','2026-04-07 12:04:52','2026-04-07'),(20,18,'cambiado en master led','2026-04-07 12:05:51','2026-04-07 12:05:51','2026-04-07'),(21,18,'pedido a audifulldrive@vwfs.com desde info@rentcardeluxe.com','2026-04-07 12:11:46','2026-04-07 12:11:46','2026-04-07'),(22,18,'pedido a atencion.longdriveservice@vwfs.com desde info@rentcardeluxe.com','2026-04-07 12:11:59','2026-04-07 12:11:59','2026-04-07'),(23,30,'desde el correo de martin@radikalworld.com le envio el expediente de homirgones a juan','2026-04-15 15:50:07','2026-04-15 15:50:07','2026-04-15');
/*!40000 ALTER TABLE `acciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-16 16:27:16
