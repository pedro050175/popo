create table `Vehiculos` (
`id_Vehiculo` int not null auto_increment,
`Matricula` varchar(10) not null,
`Bastidor` varchar(20),
`Marca y modelo` varchar(50) not null,
`km` mediumint unsigned,
`Fecha_Matricula` date,
`Cometarios` varchar(255),
`Combustible` varchar (12),
`Fecha_Itv` date,
`Estado` varchar(10),
`Clase` varchar(12) default ("Turismo"),
PRIMARY KEY (`id_Vehiculo`),
UNIQUE KEY `Matricula_UNIQUE` (`Matricula`),
UNIQUE KEY `Bastidor_UNIQUE` (`Bastidor`)
)