<?php

function formatea_fecha($fecha) {
    return $fecha ? date('d-m-Y', strtotime($fecha)) : '';
}
function Limpiar_parametros (array $datos): array {//Cambia los '' por NULL
    $limpios = [];
    foreach ($datos as $clave => $valor) {
        $limpios[$clave] = (is_string($valor) && trim($valor) === '') ? null : $valor;
    }
    return $limpios;
}
function duplicar_tabla (array $modelo, array $data): array{   
    $resultado = $modelo;
    foreach ($data as $indice => $valor){ //paso los datos de data a modelo, si falta algun campo en data, modelo lo tiene creado
        $resultado[$indice] = $data[$indice];
    } 
    return $resultado;
}
function errorFile(string $error): string {
    switch ($error){
        case UPLOAD_ERR_FORM_SIZE: $mensaje = "Archivo mayor de 2.000.000 bytes"; break;
        case UPLOAD_ERR_INI_SIZE: $mensaje = "Archivo supera limite directiva servidor"; break;
        case UPLOAD_ERR_PARTIAL: $mensaje = "Error durante la transferencia al servidor"; break;
        case UPLOAD_ERR_NO_TMP_DIR: $mensaje = "Error directorio temporal del servidor"; break;
        case UPLOAD_ERR_CANT_WRITE: $mensaje = "Error al escribir en disco"; break;
        case UPLOAD_ERR_EXTENSION: $mesanje = "Transferencia detenida por la extension"; break;
    }
    return $mensaje;
}
?>