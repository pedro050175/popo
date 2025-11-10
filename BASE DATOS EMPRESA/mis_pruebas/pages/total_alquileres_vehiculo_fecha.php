<?php
    header("Content-Type: text/plain; charset=UTF-8");
?>
<!-- OJO!! no puede haber lineas en blanco antes del headers, ni un espacio en blanco ni siquiera comentarios, daria error warning: Cannot modify header information - headers already sent by
 como cuando hago un echo antes de cargar la pagina con render-->

<!-- aqui se muestran 3 tablas, 1º los alquileres de los coches elegidos con los gastos de los coches y resumen de beneficio (no van gastos de alquiler)
 2º las compra ventas de los vehiculos selecionados con los gastos de la compraventa
 3º resumen final alquileres y compraventas -->
<div class = "bloque-movimiento">  
    <table class = "tabla_resumen noultima">
        <caption>Alquileres por meses (Ganancia) de los coches seleccionados entre las fechas <?=formatea_fecha($desde)?> y <?=formatea_fecha($hasta)?></caption>
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
                    echo "<td>".current($coche)."</td>";
                    while (next($coche)!==false){//OJO hay que usar la compraracion fuerte !== porque si uso != falla. next devuelve el siguiente valor de la tabla y mueve el indice para que current devuelva el valor actual
                        //pero next tmb devuelve un valor de la tabla, si en la tabla hay un 0 con while next($coche)o while (next(..)!=false) se sale porque devuelve el 0 y dice que 0 no es true. usando !== comprara valor y tipo y como el 0 no es del mismo tipo que el false no falla con valores cero
                        echo "<td>".number_format(intval(current($coche)),2, ',', '.')."€</td>";
                    }
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>





