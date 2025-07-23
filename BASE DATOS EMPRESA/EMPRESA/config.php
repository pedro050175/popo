<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', '/mis_pruebas/'); //carpeta donde esta index.php.   
define ('TABLAS', ["Cliente" => 'alquileres', "Comprador" => 'compraventas', "Vendedor" => 'compraventas', "propietario" => 'vehiculos']); // tablas que esta relacionas con entidad ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla']
define ('CAMPOS_ENTIDAD', ["id_entidad" => 0, "CIF_DNI" => '', "Nombre" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
define ('CAMPOS_ALQUILER_VEHICULO', ["id_alquiler" => 0, "Contrato" => '', "id_vehiculo" => 0, "Cliente" => 0, "Fecha_inicio" => '', "Fecha_fin" => '', "Km" => 0, "Km_inicio" => 0, "Km_fin" => 0, 
        "Dias" => 0, "Precio" => 0, "Precio_km" => 0, "id_comercial" => 0, "Empresa" => 0, "Ciudad" => '', "Entrega" => 0, "Comision_comercial" => 0, "Ganancia" => 0, 
        "Observaciones" => '', "Marca_modelo" => '', "Matricula" => '']);    
define ('CAMPOS_ALQUILER', ["id_alquiler" => 0, "Contrato" => '', "id_vehiculo" => 0, "Cliente" => 0, "Fecha_inicio" => '', "Fecha_fin" => '', "Km" => 0, "Km_inicio" => 0, "Km_fin" => 0, 
        "Dias" => 0, "Precio" => 0, "Precio_km" => 0, "id_comercial" => 0, "Empresa" => 0, "Ciudad" => '', "Entrega" => 0, "Comision_comercial" => 0, "Ganancia" => 0, 
        "Observaciones" => '']);
?>