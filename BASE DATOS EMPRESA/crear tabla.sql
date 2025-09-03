create table `movimiento` (`id` int AUTO_INCREMENT PRIMARY KEY,
`envia` int not null,
`recibe` int not null,
`fecha` date,
`concepto` varchar(250),
`vehiculo` int NOT NULL,
FOREIGN KEY (`vehiculo`) REFERENCES vehiculos(`id_vehiculo`) ON DELETE restrict,
FOREIGN KEY (`envia`) REFERENCES entidad(`id_entidad`) ON DELETE restrict,
FOREIGN KEY (`recibe`) REFERENCES entidad(`id_entidad`) ON DELETE restrict);
 