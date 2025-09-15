<div>
    <form action="<?= DIRECTORIO?>analisis_movimientos" method = "GET">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Analisis de movimientos</legend>
                <div class="row">
                    <div class="col-md-4">
                        <label for="entidad1" class="etiqueta">Entidad 1</label> 
                        <input size=40 class="cuadro_text" type="text" name="envia" id="entidad1" value="<?= $_GET['envia'] ?? ''?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="entidad2" class="etiqueta">Entidad 2</label> 
                        <input size=40 class="cuadro_text" type="text" name="recibe" id="entidad2" value="<?= $_GET['recibe'] ?? ''?>" required>
                    </div>
                </div>
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>movimientos?num_pagina=1';">
                <button type="reset" class="boton_link">Borrar</button>
                <button type="submit" class="boton_link">Analizar</button>
                <input type="hidden" name="num_pagina" value="1">
        </fieldset>
    </form>
</div>
<div>
<?php $total2 = 0; $total = 0?>
<?php if (!empty($movimientos1)) :?> 
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="etiqueta" scope="col">#</th>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Envia</th>
                <th class="etiqueta" scope="col">Recibe</th>
                <th class="etiqueta" scope="col">Concepto</th>
                <th class="etiqueta" scope="col">Debe</th>
                <th class="etiqueta" scope="col">Vehiculo</th>
                <th class="etiqueta" scope="col">Propietario</th>
                <th class="etiqueta" scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos1 as $movimiento):?> 
                <?php $total += $movimiento->getdiferencia(); ?>
                <tr>
                    <th scope="row"><?=$movimiento->getidMovimiento()?></th>
                    <td><?=formatea_fecha($movimiento->getfecha())?></td>
                    <td><?=$movimiento->getenviaInfo()->getNombre()?></td>
                    <td><?=$movimiento->getrecibeInfo()->getNombre()?></td>
                    <td><?=$movimiento->getconcepto()?></td>
                    <td><?=number_format($movimiento->getdiferencia(), 2, ',', '.')?>€</td>
                    <td><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></td>
                    <td><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></td>
                    <td><?=$movimiento->getobservaciones()?></td>        
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <p class = "etiqueta_desplazada">Total debe <?= $movimiento->getrecibeInfo()->getNombre()?> a <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total, 2, ',', '.')?> €</p>
<? endif ;?>
<?php if (!empty($movimientos2)) :?> 
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="etiqueta" scope="col">#</th>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Envia</th>
                <th class="etiqueta" scope="col">Recibe</th>
                <th class="etiqueta" scope="col">Concepto</th>
                <th class="etiqueta" scope="col">Debe</th>
                <th class="etiqueta" scope="col">Vehiculo</th>
                <th class="etiqueta" scope="col">Propietario</th>
                <th class="etiqueta" scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos2 as $movimiento):?> 
                <?php $total2 += $movimiento->getdiferencia(); ?>
                <tr>
                    <th scope="row"><?=$movimiento->getidMovimiento()?></th>
                    <td><?=formatea_fecha($movimiento->getfecha())?></td>
                    <td><?=$movimiento->getenviaInfo()->getNombre()?></td>
                    <td><?=$movimiento->getrecibeInfo()->getNombre()?></td>
                    <td><?=$movimiento->getconcepto()?></td>
                    <td><?=number_format($movimiento->getdiferencia(), 2, ',', '.')?>€</td>
                    <td><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></td>
                    <td><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></td>
                    <td><?=$movimiento->getobservaciones()?></td>        
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <p class = "etiqueta_desplazada">Total debe <?= $movimiento->getrecibeInfo()->getNombre()?> a <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total2, 2, ',', '.')?> €</p>
<? endif ;?>
<?php if ($total != 0 and $total2 != 0) :?>
    <p class = "etiqueta_desplazada">Resumen deuda entre <?= $movimiento->getrecibeInfo()->getNombre()?> y <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total2-$total, 2, ',', '.')?> €</p>
<?php endif ;?>
</div>