create table `CompraVentas` (
`id_CompraVenta` int not null auto_increment,
`Fecha` date,
`Comprador` int,
`Vendedor` int,
`Vehiculo` int,
`Reserva` boolean,
`Comercial` int,
`Precio_real` decimal(10,2),
`Precio_declarado` decimal(10,2),
`Tipo_impuesto` int,
`Anulada` Boolean,
`No se declara` boolean,
`No se hace nada` boolean,
`Observaciones` varchar(255),
PRIMARY KEY (`id_Compraventa`),
FOREIGN KEY (`Comprador`) REFERENCES Entidad(`id_entidad`),
FOREIGN KEY (`Vendedor`) REFERENCES Entidad(`id_entidad`),
FOREIGN KEY (`Vehiculo`) REFERENCES Vehiculos(`id_Vehiculo`),
FOREIGN KEY (`Comercial`) REFERENCES Comercial(`id_Comercial`),
FOREIGN KEY (`Tipo_impuesto`) REFERENCES Impuesto(`id_Impuesto`)
)




