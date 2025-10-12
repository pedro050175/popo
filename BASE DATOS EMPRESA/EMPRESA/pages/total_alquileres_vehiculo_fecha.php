<?php
header("Content-Type: text/plain; charset=UTF-8");
?>
<div class = "bloque-movimiento">  
    <table class = "tabla_resumen">
        <caption>Alquileres (Ganancia) de los coches seleccionados entre las fechas <?=formatea_fecha($desde)?> y <?=formatea_fecha($hasta)?></caption>
        <thead>
            <tr>
                <th>Vehículo</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($mesesAñoGananciaVehiculos as $coche){ 
                    echo "<tr>";
                    echo "<th>".current($coche)."</th>";
                    while (next($coche)!==false){//OJO hay que usar la compraracion fuerte !== porque si uso != falla. next devuelve el siguiente valor de la tabla y mueve el indice para que current devuelva el valor actual
                        //pero next tmb devuelve un valor de la tabla, si en la tabla hay un 0 con while next($coche)o while (next(..)!=false) se sale porque devuelve el 0 y dice que 0 no es true. usando !== comprara valor y tipo y como el 0 no es del mismo tipo que el false no falla con valores cero
                        echo "<th>".number_format(intval(current($coche)),2, ',', '.')."€</th>";
                    }
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>





