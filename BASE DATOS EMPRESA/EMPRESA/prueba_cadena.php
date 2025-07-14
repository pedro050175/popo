<?php
$datos = "entidades?error=No+se+puede+borrar+la+entidad+porque+hay+relacionados.";

$datos=preg_replace('/[?].+/','',$datos);
echo $datos;
?>