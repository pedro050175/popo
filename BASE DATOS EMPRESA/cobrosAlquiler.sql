create table `CobrosAlquiler` (
`id_Cobro` int not null auto_increment,
`Fecha` date,
`Alquiler` int not null,
`Tipo` int not null, #transferencia, tarjeta, o efectivo. En Php haremos que elija de una lista desplegable uno de los 3 valores
`Facturado` boolean,
`Vehiculo` int,  #vehiculo al que se factura
`Contrato_hacienda` varchar(10), -- Contrato de hacienda al que se factura
`Fianza` boolean,
`Fianza_devuelta` boolean,
`Banco` varchar(10), /*nombra del banco donde paga*/
`Comentarios` varchar(255),
PRIMARY KEY (`id_Cobro`),
FOREIGN KEY (`Alquiler`) REFERENCES `Alquileres`(`id_Alquiler`),
FOREIGN KEY (`Vehiculo`) REFERENCES `Vehiculos`(`id_Vehiculo`)
)

