CREATE TABLE `gastosalquiler` (
  `idGasto` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(35) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `pagaOtro` tinyint unsigned DEFAULT NULL,
  `idAlquiler` int NOT NULL,
  `pagado` tinyint unsigned DEFAULT NULL,
  `comentarios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idGasto`),
  KEY `fk_alquiler` (`idAlquiler`),
  CONSTRAINT `fk_alquiler` FOREIGN KEY (`idAlquiler`) REFERENCES `alquileres` (`id_alquiler`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
