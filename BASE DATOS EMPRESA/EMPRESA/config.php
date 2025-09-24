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
//CUIDADO con poner indices iguales que se machacan
define ('TABLA_VEHICULO', ["gastosvehiculo" => ["id_vehiculo"], "alquileres" => ["vehiculo"], "compraventas" => ["id_vehiculo"], "movimientos" => ["vehiculo"]]);
define ('CAMPOS_ENTIDAD', ["id_entidad" => 0, "CIF_DNI" => '', "Nombre" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
//esta tabla es porque cuando se leen datos de la tabla movimientos, como tiene dos campos relacionados con id_entidad, al leerlos tengo que crear alias con lo que cambian los nombres de la tabla asociativa que recoge los datos 
define ('CAMPOS_ENVIA_MOVIMIENTO', ["id_entidad" => 0, "CIF_DNI" => '', "nombreEnvia" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
define ('CAMPOS_PROPIETARIO_VEHICULO_MOVIMIENTO', ["id_entidad" => 0, "CIF_DNI" => '', "nombrePropietario" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
define ('CAMPOS_RECIBE_MOVIMIENTO', ["id_entidad" => 0, "CIF_DNI" => '', "nombreRecibe" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
define ('CAMPOS_VEHICULO', ["id_vehiculo" => 0, "Matricula" =>'', "Bastidor" => '', "Marca_modelo" => '', "Km" => 0, "Fecha_matricula" => '', "Observaciones" => '',
                        "Combustible" => '', "Fecha_itv" => '', "Estado" => '', "Clase" => '', "propietario" => 0, "Prox_itv" => '']);    
define ('CAMPOS_ALQUILER', ["id_alquiler" => 0, "contrato" => '', "vehiculo" => 0, "cliente" => 0, "fechaInicio" => '', "fechaFin" => '', "kilometros" => 0, "kmInicio" => 0, "kmFin" => 0, 
        "dias" => 0, "precio" => 0, "precioKm" => 0, "fianza" => 0, "fianzaDevuelta" => 0, "comercial" => '', "empresa" => 0, "ciudad" => '', "entrega" => '', "comisionComercial" => 0, "ganancia" => 0, "observaciones" => '', "estado" => '']);
define ('CAMPOS_EMPRESA_ALQUILER', ["id_entidad" => 0, "CIF_DNI" => '', "nombreEmpresa" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);
define ('CAMPOS_FOTO', ["id" => 0, "url" => '', "destacada" => 0, "id_vehiculo" => '0', "descripcion" => '']);
define ('CAMPOS_GASTO_VEHICULO', ["id_gasto" => 0, "tipo" =>'', "Importe" => 0, "Fecha" =>'', "Paga_otro" => 0, "Comentarios" => '', "id_vehiculo" => 0, "pagado" => 0]);
define ('CAMPOS_CUOTA_VEHICULO', ["idCuota" => 0, "inicio" => '', "duracion" => 0, "id_vehiculo" => 0, "tipo" => '', "cuota" => 0, "totalPagar" => 0, "pagoFinal" => 0, "entrada" => 0, "fianza" => 0,
"km" => 0, "kmAno" => 0, "financiera" => '', "id_entidad" => 0,  "observaciones" => '']);
define ('CAMPOS_MOVIMIENTO', ["idMovimiento" => 0, "envia" => 0, "recibe" => 0, "fecha" => '', "concepto" => '', "vehiculo" => 0, "observaciones" => '' , "totalEntregas" => 0, "totalDevoluciones" => 0, "diferencia" => 0, "terminado" => 0]);
define ('CAMPOS_ENTREGA', ["idEntrega" => 0, "fecha" => '', "importe" => 0, "bancoEnvia" => '', "bancoRecibe" => '', "observaciones" => '', "movimiento" => 0]);
define ('CAMPOS_DEVOLUCION', ["idDevolucion" => 0, "fecha" => '', "importe" => 0, "bancoEnvia" => '', "bancoRecibe" => '', "observaciones" => '', "movimiento" => 0]);

?>