create table `Impuesto` (
`id_Impuesto` int not null auto_increment,
`Nombre` varchar(12) not null,
PRIMARY KEY (`id_Impuesto`),
UNIQUE KEY `Nombre_UNIQUE` (`Nombre`)
)