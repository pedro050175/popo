<?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
<?php endif; ?>
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
                
        </fieldset>
    </form>
</div>

<!--movimientos 1-->
<?php $total2 = 0; $total = 0?>
<?php if (!empty($movimientos1)) :?>
    <p class = "etiqueta_desplazada blue">Movimientos de <?= $movimientos1[0]->getenviaInfo()->getNombre()?> a <?= $movimientos1[0]->getrecibeInfo()->getNombre()?></p> 
    <?php foreach ($movimientos1 as $movimiento):?> <!--imprimo 1 movimiento en una tabla, cierro la tabla e imprimo entregas en otra tabla fuera de la tabla movimiento, se podria poner un <td> y dentro la tabla entregas pero queda muy liado-->
        <div class = "bloque-movimiento">
            <?php
                $total += $movimiento->getdiferencia(); 
                $movimientoActual = $movimiento->getidMovimiento();
            ?>
            <table class="table table-hover table-striped fina">
                <thead>
                    <tr>
                        <th class="etiqueta" scope="col">#</th>
                        <th class="etiqueta" scope="col">Fecha</th>
                        <th class="etiqueta" scope="col">Concepto</th>
                        <th class="etiqueta" scope="col">Debe</th>
                        <th class="etiqueta" scope="col">Entrega</th>
                        <th class="etiqueta" scope="col">Devuelve</th>
                        <th class="etiqueta" scope="col">Vehiculo</th>
                        <th class="etiqueta" scope="col">Propietario</th>
                        <th class="etiqueta" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <th scope="row"><?=$movimientoActual?></th>
                            <td><?=formatea_fecha($movimiento->getfecha())?></td>
                            <td><?=$movimiento->getconcepto()?></td>
                            <td><?=number_format($movimiento->getdiferencia(), 2, ',', '.')?>€</td>
                            <td><?=number_format($movimiento->gettotalEntrega(), 2, ',', '.')?>€</td>
                            <td><?=number_format($movimiento->gettotalDevolucion(), 2, ',', '.')?>€</td>
                            <td><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></td>
                            <td><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></td>
                            <td><?=$movimiento->getobservaciones()?></td> 
                            <td><button type = "button" class = "boton_link small" onclick="mostrar(<?=$movimientoActual?>)">+</button></td>     
                        </tr>
                </tbody>
            </table>
            <!--Entregas de un movimiento-->
                <div class = "contenedor-tablas" id = "<?=$movimientoActual?>" hidden>
                    <table class = "mi_tabla w400" >
                        <caption>Entregas</caption>
                        <colgroup>
                            <col style="width: 80px;">
                            <col style="width: 80px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Importe</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entregas[$movimientoActual] as $entrega) :?>
                                <tr>
                                    <td><?= formatea_fecha($entrega->getfecha())?></td>
                                    <td><?= number_format($entrega->getimporte(), 2, ',', '.');?>€</td>
                                    <td><?= $entrega->getobservaciones()?></td>
                                </tr>
                            <?php endforeach ;?>
                            <tr>
                                <td>Total</td>
                                <td><?=number_format($movimiento->gettotalEntrega(), 2, ',', '.')?>€</td>
                            </tr>
                        </tbody>
                    </table>
                <!--Devoluciones de un movimiento-->
                    <table class = "mi_tabla w400" >
                        <caption>Devoluciones</caption>
                        <colgroup>
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Importe</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($devoluciones[$movimientoActual] as $devolucion) :?>
                                <tr>
                                    <td><?= formatea_fecha($devolucion->getfecha())?></td>
                                    <td><?= number_format($devolucion->getimporte(), 2, ',', '.');?>€</td>
                                    <td><?= $devolucion->getobservaciones()?></td>
                                </tr>
                            <?php endforeach ;?>
                            <tr>
                                <td>Total</td>
                                <td><?=number_format($movimiento->gettotalDevolucion(), 2, ',', '.')?>€</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    <?php endforeach;?>
    <p class = "etiqueta_desplazada green">Total debe <?= $movimiento->getrecibeInfo()->getNombre()?> a <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total, 2, ',', '.')?> €</p>
<? endif ;?>
<!--movimientos 2-->
<?php if (!empty($movimientos2)) :?> 
    <p class = "etiqueta_desplazada blue">Movimientos de <?= $movimientos2[0]->getenviaInfo()->getNombre()?> a <?= $movimientos2[0]->getrecibeInfo()->getNombre()?></p> 
    <?php foreach ($movimientos2 as $movimiento):?> 
        <div class = "bloque-movimiento">    
            <?php 
                $total2 += $movimiento->getdiferencia(); 
                $movimientoActual = $movimiento->getidMovimiento();
            ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="etiqueta" scope="col">#</th>
                        <th class="etiqueta" scope="col">Fecha</th>
                        <th class="etiqueta" scope="col">Concepto</th>
                        <th class="etiqueta" scope="col">Debe</th>
                        <th class="etiqueta" scope="col">Entrega</th>
                        <th class="etiqueta" scope="col">Devuelve</th>
                        <th class="etiqueta" scope="col">Vehiculo</th>
                        <th class="etiqueta" scope="col">Propietario</th>
                        <th class="etiqueta" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody> 
                    <tr>
                        <th scope="row"><?=$movimientoActual?></th>
                        <td><?=formatea_fecha($movimiento->getfecha())?></td>
                        <td><?=$movimiento->getconcepto()?></td>
                        <td><?=number_format($movimiento->getdiferencia(), 2, ',', '.')?>€</td>
                        <td><?=number_format($movimiento->gettotalEntrega(), 2, ',', '.')?>€</td>
                        <td><?=number_format($movimiento->gettotalDevolucion(), 2, ',', '.')?>€</td>
                        <td><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></td>
                        <td><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></td>
                        <td><?=$movimiento->getobservaciones()?></td>  
                        <td><button type = "button" class = "boton_link small" onclick="mostrar(<?=$movimientoActual?>)">+</button></td>      
                    </tr>
                </tbody>
            </table>
            <!--Entregas de un movimiento-->
            <div class = "contenedor-tablas" id = "<?=$movimientoActual?>" hidden>
                <table class = "mi_tabla w400" >
                    <caption>Entregas</caption>
                    <colgroup>
                        <col style="width: 80px;">
                        <col style="width: 80px;">
                        <col style="width: 120px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entregas[$movimientoActual] as $entrega) :?>
                            <tr>
                                <td><?= formatea_fecha($entrega->getfecha())?></td>
                                <td><?= number_format($entrega->getimporte(), 2, ',', '.');?>€</td>
                                <td><?= $entrega->getobservaciones()?></td>
                            </tr>
                        <?php endforeach ;?>
                        <tr>
                            <td>Total</td>
                            <td><?=number_format($movimiento->gettotalEntrega(), 2, ',', '.')?>€</td>
                        </tr>
                    </tbody>
                </table>
            <!--Devoluciones de un movimiento-->
                <table class = "mi_tabla w400" >
                    <caption>Devoluciones</caption>
                    <colgroup>
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 120px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($devoluciones[$movimientoActual] as $devolucion) :?>
                            <tr>
                                <td><?= formatea_fecha($devolucion->getfecha())?></td>
                                <td><?= number_format($devolucion->getimporte(), 2, ',', '.');?>€</td>
                                <td><?= $devolucion->getobservaciones()?></td>
                            </tr>
                        <?php endforeach ;?>
                        <tr>
                            <td>Total</td>
                            <td><?=number_format($movimiento->gettotalDevolucion(), 2, ',', '.')?>€</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach;?>   
    <p class = "etiqueta_desplazada green">Total debe <?= $movimiento->getrecibeInfo()->getNombre()?> a <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total2, 2, ',', '.')?> €</p>
<? endif ;?>
<?php if (!empty($movimientos2) or !empty($movimientos1)) :?>
    <?php if ($total2 > $total ) :?>
        <p class = "etiqueta_desplazada blue" >Resumen: <?= $movimiento->getrecibeInfo()->getNombre()?> debe a <?=$movimiento->getenviaInfo()->getNombre()?> <?= number_format($total2-$total, 2, ',', '.')?> €</p>
    <?php endif ;?>
    <?php if ($total2 <= $total ) :?>
        <p class = "etiqueta_desplazada blue" >Resumen: <?= $movimiento->getenviaInfo()->getNombre()?> debe a <?=$movimiento->getrecibeInfo()->getNombre()?> <?= number_format($total-$total2, 2, ',', '.')?> €</p>
    <?php endif ;?>
<?php endif ;?>