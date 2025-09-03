create table `devoluciones` (`idDevolucion` int AUTO_INCREMENT PRIMARY KEY,
`fecha` date not null,
`importe` decimal not null,
`bancoEnvia` varchar(20),
`bancoRecibe` varchar(20),
`observaciones` varchar (300),
`movimiento` int not null,
FOREIGN KEY (`movimiento`) REFERENCES movimientos(`idMovimiento`) ON DELETE CASCADE);
 