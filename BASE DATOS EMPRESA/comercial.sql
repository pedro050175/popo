create table `Comercial` (
`id_Comercial` int not null auto_increment,
`Documento_Id` varchar(14) not null,
`Nombre` varchar(60) not null,
`Apellido` varchar(70) not null,
`Direccion` varchar (255),
`Telefono` varchar(13),
`Email` varchar(255),
PRIMARY KEY (`id_Comercial`),
UNIQUE KEY `Documento_Id_UNIQUE` (`Documento_Id`)Entidad
)
