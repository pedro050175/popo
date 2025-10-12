<?php
header("Content-Type: text/plain; charset=UTF-8");
?>
<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen">
        <caption>Total Alquileres de los coches seleccionados desde que se alquilan</caption>
        <thead>
            <tr>
                <th class="etiqueta">Vehículo</th>
                <th class="etiqueta">Ganacia</th>
                <th class="etiqueta">Precio</th>
                <th class="etiqueta">Dias</th>
                <th class="etiqueta">Gastos</th>
                <th class="etiqueta">Beneficio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alquileresVehiculos as $alquiler) :?>
                <tr>
                    <td><?= $alquiler['Marca_modelo']?></td>
                    <td><?= $alquiler['totalGananciaAlquileres']?></td>
                    <td><?= $alquiler['totalPrecioAlquileres']?></td>
                    <td><?= $alquiler['totalDiasAlquileres']?></td>
                </tr>
            <?php endforeach ;?>    
        </tbody>
    </table>
</div>
