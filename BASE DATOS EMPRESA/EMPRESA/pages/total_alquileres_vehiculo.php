<?php
    header("Content-Type: text/plain; charset=UTF-8");
?>
<!-- OJO!! no puede haber lineas en blanco antes del headers, ni un espacio en blanco ni siquiera comentarios, daria error warning: Cannot modify header information - headers already sent by
 como cuando hago un echo antes de cargar la pagina con render-->
<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen noultima">
        <!-- alquileres de los coches -->
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
                    <td class="tooltip-cell info" data-tooltip="Meses en alquiler: <?=$meses?>">
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
                    <td class="tooltip-cell info" data-tooltip="Cuota: <?=number_format($vehiculo['cuota'], 2, ',', '.')?>€;Entrada: <?= number_format($vehiculo['entrada'], 2, ',', '.')?>€ Inicio cuota: <?= formatea_fecha($vehiculo['fechaInicioCuota'])?>"> 
                            <?= number_format($inversion, 2, ',', '.') ?>
                    </td>
                    <td><?=  number_format($vehiculo['totalGananciaAlquileres']- $vehiculo['totalGastos']-$inversion, 2, ',', '.')?>€</td>
                </tr>
            <?php endforeach ;?>    
        </tbody>
    </table>
</div>
<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen noultima">
        <!-- compraventas de los coches -->
        <caption>Compra venta/s de los coches seleccionados</caption>
        <thead>
            <tr>
                <th class="etiqueta">Vehículo</th>
                <th class="etiqueta">Fecha com</th>
                <th class="etiqueta">Precio</th>
                <th class="etiqueta">Declara</th>
                <th class="etiqueta">Fecha ven</th>
                <th class="etiqueta">Precio</th>
                <th class="etiqueta">Declara</th>
                <th class="etiqueta">Gastos com-ven</th>
                <th class="etiqueta">IVA</th>
                <th class="etiqueta">Beneficio-gastos-iva</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totalCompraventasVehiculos as $compraventa) :?>
                <tr>
                    <td><?=$compraventa->getvehiculoInfo()->getMarca_modelo()?></td>
                    <td><?=formatea_fecha($compraventa->getfechaCompra())?></td>
                    <td class="tooltip-cell info" data-tooltip="<?=$compraventa->getimpuestoCompra()?>"><?=number_format($compraventa->getprecioCompraReal(), 2, ',', '.')?>€</td>
                    <td><?=$compraventa->getnodeclaraComp() ? '--' : 'SI'?></td>
                    <td><?=formatea_fecha($compraventa->getfechaVenta())?></td>
                    <td class="tooltip-cell info" data-tooltip="<?=$compraventa->getimpuestoVenta()?>"><?=number_format($compraventa->getprecioVentaReal(), 2, ',', '.')?>€</td>
                    <td><?=$compraventa->getnodeclaraVenta() ? '--' : 'SI'?></td>
                    <td><?=number_format($compraventa->getsumaGastos(), 2, ',', '.')?>€</td>
                    <td style="<?=$compraventa->IVA()<0 ? 'color: #f70000ff' : 'color: #4f33eeff'?>"><?=number_format($compraventa->IVA(), 2, ',', '.')?>€</td>
                    <td style="<?=$compraventa->beneficioMenosIVA()<0 ? 'color: #f70000ff' : 'color: #4f33eeff'?>"><?=number_format(($compraventa->beneficioMenosIVA()), 2, ',', '.')?>€</td>
                </tr>
            <?php endforeach ;?>    
        </tbody>
    </table>
</div>
<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen noultima">
        <!-- resumen final alquileres y compraventas -->
        <caption>Resumen alquileres y compraventas</caption>
        <thead>
            <tr>
                <th>Vehículo</th>
                <th>Beneficio alquileres</th>
                <th>Beneficio compraventas</th>
                <th>Total Beneficio</th>
            </tr>
        </thead>
        <tbody><!-- por cada alquiler de vehiculo recorre la tabla de compraventas y compara el id del coche de la tabla alquiler con el id de la tabla compraventa -->
            <?php foreach ($totalAlquileresVehiculos as $vehiculo) :?>
                <tr>
                    <td><?= $vehiculo['Marca_modelo']?></td>
                    <td><?=  number_format($vehiculo['totalGananciaAlquileres']- $vehiculo['totalGastos']-$inversion, 2, ',', '.')?>€</td>
                    <?php 
                        $totalBeneficiosCompraventas = 0;
                        /* bucle para encontrar compraventas del vehiculo actual, los datos de totalAlquileresVehiculos son tablas y los de totalCompraventasVehiculos son objetos*/
                        foreach ($totalCompraventasVehiculos as $compraventa){ 
                                if ($vehiculo['vehiculo']==$compraventa->getvehiculo()){ /* $vehiculo['vehiculo'] es el id en la tabla alquileres y $compraventa->getvehiculo() es id en objeto compraventa */
                                    $totalBeneficiosCompraventas += $compraventa->beneficioMenosIVA();/* como puede ser que un cocche tenga varias compraventas hay que sumar el beneficio de cada una */
                                }                               
                        }
                        /* cuando termino de buscar imprimo una celda con el total del beneficio de todas las compraventas */
                        echo "<td>";
                        echo number_format($totalBeneficiosCompraventas, 2, ',', '.').'€';
                        echo "</td>";
                    ?>
                    <!-- imprimo otra celda en la suma de todos los beneficios -->
                    <td><?=number_format($vehiculo['totalGananciaAlquileres']- $vehiculo['totalGastos']-$inversion+$totalBeneficiosCompraventas, 2, ',', '.')?>€</td>
                </tr>
            <?php endforeach ;?>    
        </tbody>
    </table>
</div>

