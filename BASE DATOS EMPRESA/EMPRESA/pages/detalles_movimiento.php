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
            <div class="col-md-12">
                <div class="border p-2 rounded"><strong>Observaciones: </strong><?=$movimiento->getobservaciones()?></div>
            </div>
        </div>                 
    </div>
</div>
</div>
    <div class="btn-group">
        <a href="<?= DIRECTORIO ?>nuevo_movimiento/<?=$movimiento->getidMovimiento()?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
    </div>
</div>