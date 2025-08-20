<?php
define ('SERVIDOR', 'mysql');
define ('USUARIO', 'root');
define ('PASS', 'root');
define ('BASE_DATOS', 'empresa');
define ('DIRECTORIO', "/mis_pruebas/"); //carpeta donde esta index.php.  
define ('FILAS_PAGINA', 5);
define ('FOTOS_VEHICULOS_SERVIDOR', "http://localhost:8000/mis_pruebas/fotos_vehiculo/");//cuando subo una foto al servidor no la puedo copiar en este ordenador, la tengo que copiar en el directorio fotos del servidor y luego al mapearse aparecen en este ordenador
// tablas que esta relacionas con entidad ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla'] 
define ('TABLAS', ["alquileres" => 'Cliente', "compraventas" => 'Comprador', "compraventas" => 'Vendedor', "vehiculos" => 'propietario']); 
//CUIDADO con poner indices iguales que se machacan
define ('TABLA_VEHICULO', ["gastosvehiculo" => 'id_vehiculo', "alquileres" => 'id_vehiculo', "compraventas" => 'id_vehiculo']);
define ('CAMPOS_ENTIDAD', ["id_entidad" => 0, "CIF_DNI" => '', "Nombre" => '', "Observaciones" => '', "Direccion" => '', "Telefono" =>'', "Email" => '']);//todos los campos de la tabla entidad
define ('CAMPOS_VEHICULO', ["id_vehiculo" => 0, "Matricula" =>'', "Bastidor" => '', "Marca_modelo" => '', "Km" => 0, "Fecha_matricula" => '', "Observaciones" => '',
                        "Combustible" => '', "Fecha_itv" => '', "Estado" => '', "Clase" => '', "propietario" => 0, "Prox_itv" => '']);    
define ('CAMPOS_ALQUILER', ["id_alquiler" => 0, "Contrato" => '', "id_vehiculo" => 0, "Cliente" => 0, "Fecha_inicio" => '', "Fecha_fin" => '', "Kilometros" => 0, "Km_inicio" => 0, "Km_fin" => 0, 
        "Dias" => 0, "Precio" => 0, "Precio_km" => 0, "id_comercial" => 0, "Empresa" => 0, "Ciudad" => '', "Entrega" => 0, "Comision_comercial" => 0, "Ganancia" => 0, "Observaciones" => '']);
define ('CAMPOS_FOTO', ["id" => 0, "url" => '', "destacada" => 0, "id_vehiculo" => '0', "descripcion" => '']);
?>