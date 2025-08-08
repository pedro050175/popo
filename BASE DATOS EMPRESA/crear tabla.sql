create table `fotos` (`id` int AUTO_INCREMENT PRIMARY KEY,
`url` varchar(500) DEFAULT NULL,
`destacada` TINYINT UNSIGNED DEFAULT NULL,
`id_vehiculo` int NOT NULL,
FOREIGN KEY (`id_vehiculo`) REFERENCES vehiculos(`id_vehiculo`) ON DELETE CASCADE);
 