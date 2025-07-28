  
    
    <h4>Información Entidad</h4>        
    
    <div class="container mt-4">
        <p>CIF_DNI: <?=$entidad->getCIF_DNI()?></p>
        <p>Nombre: <?=$entidad->getNombre()?></p>
        <p>Dirección: <?=$entidad->getDireccion()?></p>
        <p>Teléfono: <?=$entidad->getTelefono()?></p>
        <p>Email: <?=$entidad->getEmail()?></p>
        <p>Observaciones: <?=$entidad->getObservaciones()?></p>
    </div>
    <h5>Alquileres de la Entidad</h5>
    
    <div class="row">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Contrato:</th>
                <th scope="col">Fecha_inicio:</th>
                <th scope="col">Fecha_fin</th>
                <th scope="col">Precio</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Marca_modelo</th>
                <th scope="col">Matricula</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alquileres as $alquiler):?>
                    <tr>
                    <th scope="row"><?=$alquiler->getId()?></th>
                    <td><?=$alquiler->getContrato()?></td>
                    <td><?=$alquiler->getFecha_inicio()?></td>
                    <td><?=$alquiler->getFecha_fin()?></td>
                    <td><?=$alquiler->getPrecio()?></td>
                    <td><?=$alquiler->getCiudad()?></td>
                    <td><?=$alquiler->getVehiculo()->getMarca_modelo()?></td> 
                    <td><?=$alquiler->getVehiculo()->getMatricula()?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
        


