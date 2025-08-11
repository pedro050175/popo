
<div class="container mt-4">
    <div class="card bg-white text-dark border">
    <div class="card-header bg-light text-dark border-bottom">
            <h4 class="mb-0"><i class="bi bi-car-front-fill me-2"></i>Información del Vehículo</h4>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Id: </strong><?=$vehiculo->getId()?></div>
            </div>
            <div class="col-md-10">
                <div class="border p-2 rounded"><strong>Marca y Modelo: </strong><?=$vehiculo->getMarca_modelo()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Matrícula: </strong><?=$vehiculo->getMatricula()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><strong>Bastidor: </strong><?=$vehiculo->getBastidor()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Fecha 1º matrícula: </strong><?=formatea_fecha($vehiculo->getFecha_matricula())?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Kilometros: </strong><?=$vehiculo->getKm()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Combustible: </strong><?=$vehiculo->getCombustible()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Fecha ITV: </strong><?=formatea_fecha($vehiculo->getFecha_itv())?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Prox. ITV: </strong><?=formatea_fecha($vehiculo->getProx_itv())?></div>
            </div>
        </div>
        <div class="row mb-3">        
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Estado: </strong><?=$vehiculo->getEstado()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Clase: </strong><?=$vehiculo->getClase()?></div>
            </div>
            <div class="col-md-6">
                <div class="border p-2 rounded"><strong>Propietario: </strong><?=$vehiculo->getdatos_propietario()->getNombre()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="border p-2 rounded"><strong>Observaciones: </strong><?=$vehiculo->getObservaciones()?></div>
            </div>
        </div>                 
    </div>
</div>
    <div class="btn-group" role="group">
        <a href="/mis_pruebas/pages/nuevo_vehiculo/<?=$vehiculo->getId()?>" role="button" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
    </div>
</div>

<div>
    <?php foreach($fotos as $foto) :?>
    <div>
        <div>
            <img src=<?= RUTA_FOTOS.rawurlencode($foto->geturl())?> width="250" height="200" alt=<?= rawurlencode($foto->geturl())?>>
            <div class="border p-2 rounded"><strong>Descripcion: </strong><?=$foto->getdescripcion()?></div>
        </div>
    </div> 
    <?php endforeach ;?> 
<!--     <img src="/mis_pruebas/fotos/bmw%20m4%201.jpeg"> -->
</div>

    
        


