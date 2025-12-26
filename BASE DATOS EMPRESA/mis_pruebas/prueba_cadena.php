<?php

$fecha ="2025-10-25";
$dias =0;
$decision = (($dias == 20) || ($dias == 10)) ? 'yes' : 'no'; 
    $fechaSumada = new DateTime($fecha);
    $fechaSumada->modify("+{$dias} days");
    echo $fechaSumada->format("Y-m-d");

?>