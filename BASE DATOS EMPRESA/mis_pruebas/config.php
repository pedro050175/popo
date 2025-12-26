<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', '/mis_pruebas/'); //carpeta donde esta index.php.  
define ('FILAS_PAGINA', 20);
define ('FOTOS_VEHICULOS_SERVIDOR', "http://localhost:8000/mis_pruebas/fotos_vehiculo/");//cuando subo una foto al servidor no la puedo copiar en este ordenador, la tengo que copiar en el directorio fotos del servidor y luego al mapearse aparecen en este ordenador
// tablas que esta relacionas con entidad ['nombre_tabla' => ["campo_tabla_relacionado_con_id_entidad"]]. es una tabla asiciativa que cada elemento es otra tabla con los campos relacionados 
define ('TABLAS_ENTIDAD', ["alquileres" => ["cliente", "empresa"], "compraventas" => ["compraA", "vendeA", "empresa"], "vehiculos" => ["propietario"], "movimientos" => ["envia", "recibe"]]); 
define ('TABLA_VEHICULO', ["alquileres" => ["vehiculo"], "compraventas" => ["vehiculo"], "movimientos" => ["vehiculo"], "seguros" => ["vehiculo"], "multas" => ["vehiculo"]]);
define ('IVA', 21);
define ('INICIO', '1900-01-01');/*estas dos se usan para las consultas SELECT cuando se compraran fechas, se usan para cuando el usuario no poner fecha poner estas y asi no filtra por fecha */
define ('FIN', '2100-01-01');/* RECORDAR CAMBIAR ESTA EL 01-01-2100 */
define ('EMPRESAS_GRUPO', 'radikal|stelar|emotions|magna|martin lopez|bendito|libecar|maktab|DELUXE CAR RENTAL EXPERIENCE'); /* | es como OR */
define ('ESTADOS_ALQUILER', ['Sin entregar', 'Entregado', 'Terminado', 'Cancelado', 'Interrumpido', 'Accidente', 'Robo', '']);
define ('IMPUESTOS', ["IVA", "REBU", "NETO"]);
define ('CIUDAD_CONTRATOS', 'Alguazas');
?>