<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', "/mis_pruebas/"); //carpeta donde esta index.php.  
define ('FILAS_PAGINA', 10);
define ('FOTOS_VEHICULOS_SERVIDOR', "http://localhost:8000/mis_pruebas/fotos_vehiculo/");//cuando subo una foto al servidor no la puedo copiar en este ordenador, la tengo que copiar en el directorio fotos del servidor y luego al mapearse aparecen en este ordenador
// tablas que esta relacionas con entidad ['nombre_tabla' => ["campo_tabla_relacionado_con_id_entidad"]]. es una tabla asiciativa que cada elemento es otra tabla con los campos relacionados 
define ('TABLAS', ["alquileres" => ["cliente"], "compraventas" => ["Comprador", "Vendedor"], "vehiculos" => ["propietario"]]); 
define ('TABLA_VEHICULO', ["alquileres" => ["vehiculo"], "compraventas" => ["id_vehiculo"], "movimientos" => ["vehiculo"]]);
?>