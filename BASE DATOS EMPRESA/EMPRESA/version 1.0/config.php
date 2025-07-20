<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', '/mis_pruebas/'); //carpeta donde esta index.php.   
define ('TABLAS', ["Cliente" => 'alquileres', "Comprador" => 'compraventas', "Vendedor" => 'compraventas', "Propietario" => 'vehiculos']); // ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla']
?>