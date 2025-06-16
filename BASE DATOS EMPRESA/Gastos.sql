create table `Gastos` (
`id` int not null auto_increment,
`Tipo` int not null,
`Importe` decimal(10,2),
`Fecha` date not null,
`Paga_otro` boolean, -- si paga otro no se tendra en cuenta en la rentabilidad del coche
`Comentarios` varchar(255),
PRIMARY KEY (`id`),
FOREIGN KEY (`Tipo`) REFERENCES `TipoGasto`(`id`)
)