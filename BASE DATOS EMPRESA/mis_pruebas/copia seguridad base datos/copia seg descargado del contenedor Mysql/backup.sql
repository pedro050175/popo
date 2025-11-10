-- MySQL dump 10.13  Distrib 9.3.0, for Linux (x86_64)
--
-- Host: localhost    Database: MiEmpresa
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Alquileres`
--

DROP TABLE IF EXISTS `Alquileres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Alquileres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Contrato` varchar(10) NOT NULL,
  `Vehiculo` int NOT NULL,
  `Cliente` int DEFAULT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_fin` date DEFAULT NULL,
  `km` smallint unsigned DEFAULT NULL,
  `Km_inicio` smallint unsigned DEFAULT NULL,
  `Km_fin` smallint unsigned DEFAULT NULL,
  `Dias` smallint unsigned DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Precio km` decimal(10,2) DEFAULT NULL,
  `Comercial` int DEFAULT NULL,
  `Empresa` int DEFAULT NULL,
  `Ciudad` varchar(15) DEFAULT NULL,
  `Entrega` int DEFAULT NULL,
  `Comision_comercial` decimal(10,2) DEFAULT NULL,
  `Ganancia` decimal(10,2) DEFAULT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Empresa` (`Empresa`),
  KEY `Vehiculo` (`Vehiculo`),
  KEY `Cliente` (`Cliente`),
  KEY `Comercial` (`Comercial`),
  CONSTRAINT `alquileres_ibfk_1` FOREIGN KEY (`Empresa`) REFERENCES `Entidad` (`id`),
  CONSTRAINT `alquileres_ibfk_2` FOREIGN KEY (`Vehiculo`) REFERENCES `Vehiculos` (`id`),
  CONSTRAINT `alquileres_ibfk_3` FOREIGN KEY (`Cliente`) REFERENCES `Entidad` (`id`),
  CONSTRAINT `alquileres_ibfk_4` FOREIGN KEY (`Comercial`) REFERENCES `Comercial` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Alquileres`
--

LOCK TABLES `Alquileres` WRITE;
/*!40000 ALTER TABLE `Alquileres` DISABLE KEYS */;
/*!40000 ALTER TABLE `Alquileres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CobrosAlquiler`
--

DROP TABLE IF EXISTS `CobrosAlquiler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CobrosAlquiler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Alquiler` int NOT NULL,
  `Tipo` int NOT NULL,
  `Facturado` tinyint(1) DEFAULT NULL,
  `Contrato_hacienda` varchar(10) DEFAULT NULL,
  `Fianza` tinyint(1) DEFAULT NULL,
  `Fianza_devuelta` tinyint(1) DEFAULT NULL,
  `Banco` varchar(10) DEFAULT NULL,
  `Comentarios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Alquiler` (`Alquiler`),
  CONSTRAINT `cobrosalquiler_ibfk_1` FOREIGN KEY (`Alquiler`) REFERENCES `Alquileres` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CobrosAlquiler`
--

LOCK TABLES `CobrosAlquiler` WRITE;
/*!40000 ALTER TABLE `CobrosAlquiler` DISABLE KEYS */;
/*!40000 ALTER TABLE `CobrosAlquiler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comercial`
--

DROP TABLE IF EXISTS `Comercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comercial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Documento_Id` varchar(14) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Apellido` varchar(70) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(13) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Documento_Id_UNIQUE` (`Documento_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comercial`
--

LOCK TABLES `Comercial` WRITE;
/*!40000 ALTER TABLE `Comercial` DISABLE KEYS */;
/*!40000 ALTER TABLE `Comercial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CompraVentas`
--

DROP TABLE IF EXISTS `CompraVentas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CompraVentas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Comprador` int DEFAULT NULL,
  `Vendedor` int DEFAULT NULL,
  `Vehiculo` int NOT NULL,
  `Reserva` tinyint(1) DEFAULT NULL,
  `Comercial` int DEFAULT NULL,
  `Precio_real` decimal(10,2) DEFAULT NULL,
  `Precio_declarado` decimal(10,2) DEFAULT NULL,
  `Tipo_impuesto` int DEFAULT NULL,
  `Anulada` tinyint(1) DEFAULT NULL,
  `No se declara` tinyint(1) DEFAULT NULL,
  `No se hace nada` tinyint(1) DEFAULT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1` (`Comprador`),
  KEY `fk2` (`Vendedor`),
  KEY `fk3` (`Vehiculo`),
  KEY `fk4` (`Comercial`),
  CONSTRAINT `fk1` FOREIGN KEY (`Comprador`) REFERENCES `Entidad` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk2` FOREIGN KEY (`Vendedor`) REFERENCES `Entidad` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk3` FOREIGN KEY (`Vehiculo`) REFERENCES `vehiculos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk4` FOREIGN KEY (`Comercial`) REFERENCES `comercial` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CompraVentas`
--

LOCK TABLES `CompraVentas` WRITE;
/*!40000 ALTER TABLE `CompraVentas` DISABLE KEYS */;
/*!40000 ALTER TABLE `CompraVentas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Entidad`
--

DROP TABLE IF EXISTS `Entidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Entidad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `CIF_DNI` varchar(14) DEFAULT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Apellidos` varchar(70) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(13) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Documento_Id_UNIQUE` (`CIF_DNI`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Entidad`
--

LOCK TABLES `Entidad` WRITE;
/*!40000 ALTER TABLE `Entidad` DISABLE KEYS */;
INSERT INTO `Entidad` VALUES (1,'B93621670','Stelar Emotions s.l.','','Poligono Industrial el puente nave 16, 30560, Alguazas, Murcia',NULL,NULL),(2,'B01700723','Radikal World S.L.',NULL,'C/SIERRA DE GUADARRAMA NUM 6, PUERTA B\n28830 - SAN FERNANDO DE HENARES, MADRID',NULL,NULL),(3,'B10556512','UNIVERSO RADIKAL S.L.',NULL,'Poligono Industrial el puente nave 16, 30560, Alguazas, Murcia',NULL,NULL);
/*!40000 ALTER TABLE `Entidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GastosVehiculo`
--

DROP TABLE IF EXISTS `GastosVehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `GastosVehiculo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Tipo` int NOT NULL,
  `Importe` decimal(10,2) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Paga_otro` tinyint(1) DEFAULT NULL,
  `Comentarios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Tipo` (`Tipo`),
  CONSTRAINT `gastosvehiculo_ibfk_1` FOREIGN KEY (`Tipo`) REFERENCES `TipoGasto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GastosVehiculo`
--

LOCK TABLES `GastosVehiculo` WRITE;
/*!40000 ALTER TABLE `GastosVehiculo` DISABLE KEYS */;
/*!40000 ALTER TABLE `GastosVehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Impuesto`
--

DROP TABLE IF EXISTS `Impuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Impuesto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Impuesto`
--

LOCK TABLES `Impuesto` WRITE;
/*!40000 ALTER TABLE `Impuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Impuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PagosComVen`
--

DROP TABLE IF EXISTS `PagosComVen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PagosComVen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `CompraVenta` int NOT NULL,
  `Banco` varchar(20) DEFAULT NULL,
  `Cometarios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CompraVenta` (`CompraVenta`),
  CONSTRAINT `pagoscomven_ibfk_1` FOREIGN KEY (`CompraVenta`) REFERENCES `CompraVentas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PagosComVen`
--

LOCK TABLES `PagosComVen` WRITE;
/*!40000 ALTER TABLE `PagosComVen` DISABLE KEYS */;
/*!40000 ALTER TABLE `PagosComVen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TipoGasto`
--

DROP TABLE IF EXISTS `TipoGasto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TipoGasto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TipoGasto`
--

LOCK TABLES `TipoGasto` WRITE;
/*!40000 ALTER TABLE `TipoGasto` DISABLE KEYS */;
/*!40000 ALTER TABLE `TipoGasto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vehiculos`
--

DROP TABLE IF EXISTS `Vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Vehiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Matricula` varchar(10) DEFAULT NULL,
  `Bastidor` varchar(20) DEFAULT NULL,
  `Marca y modelo` varchar(50) NOT NULL,
  `km` mediumint unsigned DEFAULT NULL,
  `Fecha_Matricula` date DEFAULT NULL,
  `Cometarios` varchar(255) DEFAULT NULL,
  `Combustible` varchar(12) DEFAULT NULL,
  `Fecha_Itv` date DEFAULT NULL,
  `Estado` varchar(10) DEFAULT NULL,
  `Clase` varchar(12) DEFAULT (_utf8mb4'Turismo'),
  `Propietario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Matricula_UNIQUE` (`Matricula`),
  UNIQUE KEY `Bastidor_UNIQUE` (`Bastidor`),
  KEY `Propetario_idx` (`Propietario`),
  CONSTRAINT `Propietario` FOREIGN KEY (`Propietario`) REFERENCES `Entidad` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vehiculos`
--

LOCK TABLES `Vehiculos` WRITE;
/*!40000 ALTER TABLE `Vehiculos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vehiculos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-16  7:43:14
