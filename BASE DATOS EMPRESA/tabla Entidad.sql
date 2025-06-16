CREATE TABLE `Entidad` (
  `id_entidad` int NOT NULL AUTO_INCREMENT,
  `Documento_Id` varchar(14) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Apellidos` varchar(70) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Telefono` varchar(13) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_entidad`)
)