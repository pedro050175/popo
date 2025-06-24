<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', '/mis_pruebas/'); //carpeta donde esta index.php. El servidor de php del contenedor(ngnix) cargará index.php cuando alguien escriba localhost:8000/entidades o vehiculos (action) 
//asi que cualquier ruta del tipo localhosto:8000/xxxx saltara a index con una URL donde pone localhosto:8000/xxxx  
?>