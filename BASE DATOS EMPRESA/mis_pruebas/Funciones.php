<?php

use lib\BaseDatosPDO;

function numeroPaginas(string $consulta) : int { //cuenta el numpero de paginas de 5 filas que tiene una $consulta
        $conexionPDO = new BaseDatosPDO();
        $conexionPDO->consulta ($consulta);
        $registro = $conexionPDO->extraer_registro();
        $numFilas = $registro['num_filas'];
        intval($numFilas%FILAS_PAGINA)==0 ? $numeroPaginas = intval($numFilas/FILAS_PAGINA) : $numeroPaginas = intval(($numFilas/FILAS_PAGINA)+1);
        
        return $numeroPaginas;
}
function formatea_fecha($fecha) {
    return $fecha ? date('d-m-y', strtotime($fecha)) : '';
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
    $hoy = new DateTime(); /* fecha actual */
    $fechaAnterior = new DateTime($fecha); /* $fecha lo convierto en una fecha */
    $diferencia = $hoy->diff($fechaAnterior); /* me devuelve la diferencia */
    // Diferencia total en años * 12 lo paso a meses y le sumo la diferencia en meses (años convertidos a meses)
    $meses = ($diferencia->y * 12) + $diferencia->m;
    return $meses;
}
function ivaDeValorConIVA($valor): float{
    /* devuelve  $valor/1,21  */
    $clave = (IVA/100)+1; /*de la constante IVA=21 saco el 1,21 */
    return ($valor-($valor/$clave));/* calculo el iva */
}
function ivaDeValorSinIVA($valor): float{
    /* devuelve  $valor*0,21  */
    $clave = (IVA/100); /*de la constante IVA=21 saco el 0,21 */
    return ($valor*$clave);/* calculo el iva */
}
/* devuelve la misma fecha sumandole los dias */
function fechaMasDias(string $fecha, int $dias){
    $fechaSumada = new DateTime($fecha);
    /* modify Lee frases naturales (“+10 days”, “-1 month”, etc.) */
    $fechaSumada->modify("+{$dias} days");
    return ($fechaSumada->format("Y-m-d"));
}
/* indica si la fecha de hoy+la cantidad de dias que se le pasa como parametro 
es mayor o igual a la que se le pasa como parametro, se usa para los vencimientos, para
saber si una fecha vencimiento esta proxima al cumplirse */ 
function fechaProxHoy(string $fecha, int $dias){
    $fecha = new DateTime($fecha);
    $hoy = new DateTime();
    $hoy->modify("+{$dias} days");
    if ($hoy >= $fecha) {
        return true;
    }
    return false;
}