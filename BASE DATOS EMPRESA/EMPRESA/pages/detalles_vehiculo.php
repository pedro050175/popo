  
    <div class="container mt-4">
        <div class="card bg-secondary text-white">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-car-front-fill me-2"></i>Información del Vehículo</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2"><p><strong>Id: </strong><?=$vehiculo->getId()?></p></div>
                    <div class="col-md-5"><p><strong>Marca y Modelo: </strong><?=$vehiculo->getMarca_modelo()?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2"><p><strong>Matrícula: </strong><?=$vehiculo->getMatricula()?></p></div>
                    <div class="col-md-3"><p><strong>Bastidor: </strong><?=$vehiculo->getBastidor()?></p></div>
                    <div class="col-md-4"><p><i class="bi bi-calendar-check"></i> <strong>Fecha 1º matrícula: </strong><?=formatea_fecha($vehiculo->getFecha_matricula())?></p></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2"><p><strong>Kilometros: </strong><?=$vehiculo->getKm()?></p></div>
                    <div class="col-md-3"><p><strong>Combustible: </strong><?=$vehiculo->getCombustible()?></p></div>
                    <div class="col-md-3"><p><i class="bi bi-calendar-check"></i> <strong>Fecha ITV: </strong><?=formatea_fecha($vehiculo->getFecha_itv())?></p></div>
                    <div class="col-md-3"><p><i class="bi bi-calendar-check"></i> <strong>Fecha prox. ITV: </strong><?=formatea_fecha($vehiculo->getProx_itv())?></p></div>
                </div>
                <div class="row mb-3">        
                    <div class="col-md-2"><p><strong>Estado: </strong><?=$vehiculo->getEstado()?></p></div>
                    <div class="col-md-3"><p><strong>Clase: </strong><?=$vehiculo->getClase()?></p></div>
                    <div class="col-md-6"><p><strong>Propietario: </strong><?=$vehiculo->getdatos_propietario()->getNombre()?></p></div>
                <div class="row mb-3">
                    <div class="col-md-2"><p><strong>Observaciones: </strong><?=$vehiculo->getObservaciones()?></p></div>
                </div> 
                </div>
            </div>
        </div>
    </div>

    
        


