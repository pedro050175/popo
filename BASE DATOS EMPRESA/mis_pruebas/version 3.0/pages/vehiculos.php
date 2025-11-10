<div class="container mt-4">
    <div class="row">
        <div class="col-md-2">
            <h5><strong>Vehículos</strong></h5>
        </div>
        <div class="col-md-6">
            <form action="vehiculos" method="get" class="d-flex">
                <input type="text" name="buscar_matr_bast" class="form-control me-1" id="floatingInput" placeholder="Buscar matrícula o bastidor">
                <input type="text" name="buscar_marca" class="form-control me-1" id="floatingInput" placeholder="Buscar marca">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <div class="col text-end">
            <a href="pages/nuevo_vehiculo" role="button" class="btn btn-primary">Nueva vehículo</a>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">
                    <a href="vehiculos?ordenar=Marca_modelo">Vehiculo</a>
                </th>
                <th scope="col">Matrícula</th>
                <th scope="col">Bastidor</th>
                <th scope="col">km</th>
                <th scope="col">Fecha_matrícula</th>
                <th scope="col">Fecha_itv</th>
                <th scope="col">Prox_itv</th>
                <th scope="col">Propietario</th>
                <th scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vehiculos as $vehiculo):?>
                <tr>
                    <th scope="row"><?=$vehiculo->getId()?></th>
                    <td><?=$vehiculo->getMarca_modelo()?></td>
                    <td><?=$vehiculo->getMatricula()?></td>
                    <td><?=$vehiculo->getBastidor()?></td>
                    <td><?=$vehiculo->getKm()?></td>
                    <td><?=formatea_fecha($vehiculo->getFecha_matricula())?></td>
                    <td><?=formatea_fecha($vehiculo->getFecha_itv())?></td>
                    <td><?=formatea_fecha($vehiculo->getProx_itv())?></td>
                    <td><?=$vehiculo->getdatos_propietario()->getNombre()?></td>
                    <td><?=$vehiculo->getObservaciones()?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="pages/nuevo_vehiculo/<?=$vehiculo->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="pages/borrar_vehiculo/<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este vehículo?');"> 
                              <i class="bi bi-trash"></i>
                            </a>
                            <a href="pages/detalles_vehiculo/<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-primary"> 
                              <i class="bi bi-eye"></i>
                            </a>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="nav-link active" aria-current="page">Vehículos encontrados: <?=count($vehiculos)?></a>
    </div>
</div>
