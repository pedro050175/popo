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
?>