<div class="container mt-4">
    <div class="col text-end">  
        <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>entidades?num_pagina=1';">   
    </div>
    <div class="card bg-white text-dark border">
        <div class="card-header bg-light text-dark border-bottom">
            <h4 class="titulo_prin"><i class="bi bi-car-front-fill me-2"></i>Información Entidad</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="border p-2 rounded"><strong>CIF/DNI </strong><?=$entidad->getCIF_DNI()?></div>
                </div>
                <div class="col-md-5">
                    <div class="border p-2 rounded"><strong>Nombre: </strong><?=$entidad->getNombre()?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="border p-2 rounded"><strong>Dirección: </strong><?=$entidad->getDireccion()?></div>
                </div>
                <div class="col-md-3">
                    <div class="border p-2 rounded"><strong>Teléfono: </strong><?=$entidad->getTelefono()?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="border p-2 rounded"><strong>Mail: </strong><?=$entidad->getEmail()?></div>
                </div>
            </div>    
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="border p-2 rounded"><strong>Observaciones: </strong><?=$entidad->getObservaciones()?></div>
                </div>
            </div>    
        </div>
    </div>
</div>



        


