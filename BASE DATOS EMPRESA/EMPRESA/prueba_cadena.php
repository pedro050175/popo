<?php
$datos = array('nombre' => "Pedro", 'apellido' => "sandoval", 'Direccion' => "Gran Via");
// var_dump($datos);
$cadena='';
foreach ($datos as $indice => $valor){
    $cadena = $cadena . "'$indice'  =  \"$valor\", ";
}
$cadena=trim($cadena,', ');
echo $cadena;
// var_dump($cadena);