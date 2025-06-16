create table `Pagos` (
`id` int not null auto_increment,
`Fecha` date not null,
`CompraVenta` int not null,
`Banco` varchar(20),
`Cometarios` varchar(255),
PRIMARY KEY (`id`),
Foreign KEY (`CompraVenta`) REFERENCES `CompraVentas`(`id_CompraVenta`)
)