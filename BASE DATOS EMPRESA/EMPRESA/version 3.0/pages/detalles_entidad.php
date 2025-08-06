<div class="container mt-4">
    <div class="card bg-secondary text-white">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-car-front-fill me-2"></i>Información Entidad</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2"><p><strong>CIF/DNI </strong><?=$entidad->getCIF_DNI()?></p></div>
                <div class="col-md-5"><p><strong>Nombre: </strong><?=$entidad->getNombre()?></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8"><p><strong>Dirección: </strong><?=$entidad->getDireccion()?></p></div>
                <div class="col-md-3"><p><strong>Teléfono: </strong><?=$entidad->getTelefono()?></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12"><p><strong>Mail: </strong><?=$entidad->getEmail()?></p></div>
            </div>    
            <div class="row mb-3">
                <div class="col-md-12"><p><strong>Observaciones: </strong><?=$entidad->getObservaciones()?></p></div>
            </div>    
        </div>
        </div>
    </div>
</div>


        


