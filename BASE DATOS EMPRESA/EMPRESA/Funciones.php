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
    foreach ($modelo as $indice => $valor){ //paso los datos de data a modelo, si falta algun campo en data, modelo lo tiene creado
        if (isset($data[$indice])){ 
        $modelo[$indice] = $data[$indice];
        }    
    } 
    return $modelo;
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
function quitaEspecialChar(?string $cadena): string{//en los campos de formulario text, si el valor a cargar en el cuadro lleva comillas u otros simbolos especiales, el navegador hace que no se muestre el texto entre comillas
    return (htmlspecialchars($cadena ?? '', ENT_QUOTES, 'UTF-8'));
}
function ordenar(array $tabla):array{
        for ( $i=0; $i<sizeof($tabla); $i++ ){  
            for ($j=$i; $j<sizeof($tabla); $j++){
                if ($tabla[$j]<$tabla[$i]){
                    $temp=$tabla[$i];
                    $tabla[$i]=$tabla[$j];
                    $tabla[$j]=$temp;
                }
            }
            
        }
    return $tabla;
    }
function parametrosIn(array &$in, array &$parametros, array $datosConvertir){//el array $datosConvertir lo convierte en dos array: uno con los datos para poner en un IN y otro con los parametros de la consulta 
    $placeholders = [];
    foreach ($datosConvertir as $i => $id) {
        $key = ':id' . $i;              // Ejemplo: :id0, :id1, :id2...
        $placeholders[] = $key; //aqui se crea una tabla [:id1,:id5,:id9] que es la que ira dentro del IN
        $parametros[$key] = (int)$id;  //[':id0' => 1, ':id1' => 5, ':id2' => 9] array asociativo       Forzamos a entero por seguridad
    }
    $in = implode(',', $placeholders); //la tabla del IN la convierte a string separado por ,
}
function diferenciaMeses (? string $fecha):int{
    $hoy = new DateTime();
    $fechaAnterior = new DateTime($fecha);
    $diferencia = $hoy->diff($fechaAnterior);
    // Diferencia total en meses (años convertidos a meses)
    $meses = ($diferencia->y * 12) + $diferencia->m;
    return $meses;
}