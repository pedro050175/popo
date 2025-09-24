<div class="container mt-4">
    <div class="col text-end">  
        <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>movimientos?num_pagina=1';">   
    </div>
    <div class="card bg-white text-dark border">
        <div class="card-header bg-light text-dark border-bottom">
                <h4 class="titulo_prin"><i class="bi bi-car-front-fill me-2"></i>Información Movimiento</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-1">
                <div class="border p-2 rounded"><strong>Id: </strong><?=$movimiento->getidMovimiento()?></div>
            </div>
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Fecha: </strong><?=formatea_fecha($movimiento->getfecha())?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><strong>Envia: </strong><?=$movimiento->getenviaInfo()->getNombre()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><strong>Recibe: </strong><?=$movimiento->getrecibeInfo()->getNombre()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="border p-2 rounded"><strong>Concepto: </strong><?=$movimiento->getconcepto()?></div>
            </div>
            <div class="col-md-6">
                <div class="border p-2 rounded"><strong>Vehiculo: </strong><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="border p-2 rounded"><strong>Observaciones: </strong><?=$movimiento->getobservaciones()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><strong>Propietario: </strong><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></div>
            </div>
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Finalizado: </strong><?=$movimiento->getterminado() ? 'SI' : 'NO'?></div>
            </div>
        </div>                 
    </div>
</div>
<div class="btn-group">
    <a href="<?= DIRECTORIO ?>nuevo_movimiento/<?=$movimiento->getidMovimiento()?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
</div>

<!--Entregas-->
<div class="container mt-1"><!--esto desplaza a la derecha un poco todo lo que haya dentro, tablas, etiquetas etc-->
    <div id = "entregas">
        <table class = "mi_tabla" >
            <caption>Entregas</caption>
            <colgroup>
                <col style="width: 100px;">
                <col style="width: 120px;">
                <col style="width: 120px;">
                <col style="width: 120px;">
                <col style="width: 140px;">
            </colgroup>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Importe</th>
                    <th>Banco Envia</th>
                    <th>Banco Recibe</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalEntrega = 0; ?>
                <?php foreach ($entregas as $entrega) :?>
                    <tr>
                        <td><?= formatea_fecha($entrega->getfecha())?></td>
                        <td><?= number_format($entrega->getimporte(), 2, ',', '.');?>€</td>
                        <td><?= $entrega->getbancoEnvia()?></td>
                        <td><?= $entrega->getbancoRecibe()?></td>
                        <td><?= $entrega->getobservaciones()?></td>
                        <?php $totalEntrega += $entrega->getimporte();?>
                    </tr>
                <?php endforeach ;?>
            </tbody>
        </table>
    <p class='etiqueta_desplazada'> Suma: <?=number_format($totalEntrega, 2, ',', '.')?>€</p>
    </div>
<!--Devoluciones-->
    <div id = "devoluciones">
        <table class = "mi_tabla" >
            <caption>Devoluciones</caption>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Importe</th>
                    <th>Banco Envia</th>
                    <th>Banco Recibe</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalDevolucion = 0; ?>
                <?php foreach ($devoluciones as $devolucion) :?>
                    <tr>
                        <td><?= formatea_fecha($devolucion->getfecha())?></td>
                        <td><?= number_format($devolucion->getimporte(), 2, ',', '.');?>€</td>
                        <td><?= $devolucion->getbancoEnvia()?></td>
                        <td><?= $devolucion->getbancoRecibe()?></td>
                        <td><?= $devolucion->getobservaciones()?></td>
                        <?php $totalDevolucion += $devolucion->getimporte();?>
                    </tr>
                <?php endforeach ;?>
            </tbody>
        </table>
        <p class='etiqueta_desplazada'> Suma: <?=number_format($totalDevolucion, 2, ',', '.')?>€</p>
        <p class='etiqueta'><strong>Diferencia: <?=number_format(($totalEntrega-$totalDevolucion), 2, ',', '.')?>€</strong></p>
    </div>
</div>