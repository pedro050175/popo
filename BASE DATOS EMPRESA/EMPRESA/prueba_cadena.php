<?php

$hoy = new DateTime();
$inicio = new DateTime("2023-10-01");

$diferencia = $hoy->diff($inicio);

// Diferencia total en meses (años convertidos a meses)
$meses = ($diferencia->y * 12) + $diferencia->m;
echo $diferencia;



?>