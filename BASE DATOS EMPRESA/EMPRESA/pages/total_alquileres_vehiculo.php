<?php
header("Content-Type: text/plain; charset=UTF-8");
?>
<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen noultima">
        <caption>Total Alquileres de los coches seleccionados desde que se alquilan</caption>
        <thead>
            <tr>
                <th class="etiqueta">Vehículo</th>
                <th class="etiqueta">Inicio alquiler</th>
                <th class="etiqueta">Ganacia</th>
                <th class="etiqueta">Precio</th>
                <th class="etiqueta">Dias</th>
                <th class="etiqueta">Gastos</th>
                <th class="etiqueta">Inversion</th>
                <th class="etiqueta">Beneficio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totalAlquileresVehiculos as $vehiculo) :?>
                <tr>
                    <td><?= $vehiculo['Marca_modelo']?></td>
                    <?php
                        $meses = diferenciaMeses($vehiculo['primerAlquiler']);
                    ?><!-- texto flotante que muestra el nº de meses alquilado -->
                    <td class="tooltip-cell" data-tooltip="Meses en alquiler: <?=$meses?>">
                            <?= formatea_fecha($vehiculo['primerAlquiler'])?>
                    </td>
                    <td><?= number_format($vehiculo['totalGananciaAlquileres'], 2, ',', '.')?>€</td>
                    <td><?= number_format($vehiculo['totalPrecioAlquileres'], 2, ',', '.')?>€</td>
                    <td><?= $vehiculo['totalDiasAlquileres']?></td>
                    <td><?= number_format($vehiculo['totalGastos'], 2, ',', '.')?>€</td>
                    <?php
                    /*calculo el total de cuotas pagadas, sacando los meses que se esta pagando (con fechaInioCuota) x la cuota*/
                        $meses = diferenciaMeses($vehiculo['fechaInicioCuota']);
                        $inversion = $vehiculo['cuota']* $meses+ $vehiculo['entrada'];
                    ?><!-- texto fltoante que muestra la cuta, entrada y el inicio de la cuota -->
                    <td class="tooltip-cell" data-tooltip="Cuota: <?=number_format($vehiculo['cuota'], 2, ',', '.')?>€;Entrada: <?= number_format($vehiculo['entrada'], 2, ',', '.')?>€ Inicio cuota: <?= formatea_fecha($vehiculo['fechaInicioCuota'])?>"> 
                            <?= number_format($inversion, 2, ',', '.') ?>
                    </td>
                    <td><?=  number_format($vehiculo['totalGananciaAlquileres']- $vehiculo['totalGastos']-$inversion, 2, ',', '.')?>€</td>
                </tr>
            <?php endforeach ;?>    
        </tbody>
    </table>
</div>

