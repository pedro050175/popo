<div class = "container mt-4">
    <div class="row">
            <div class="col-md-6">
                <form action="<?= DIRECTORIO ?>alquileres" method="get" class="d-flex">
                    <input type="search" name="buscar" class="form-control me-1" id="floatingInput" placeholder="Buscar contrato/vehiculo/cliente">
                    <input type="hidden" name="num_pagina"   class="form-control me-2" id="floatingInput" value="1"><!--hay que poner el num de pagina en la URL para que no falle en metodo findAll del repository ya que da por echo que hay un $_GET['num_apgina'-->
                    <button type="submit" class="boton_submit">Buscar</button>  
                </form>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <input type="button" class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_alquiler';"> 
            </div>
        </div>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>    
</div>
<table class="table table-hover table-striped fina">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Contrato</th>
            <th scope="col">Vehiculo</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha_inicio</th>
            <th scope="col">Dias</th>
            <th scope="col">Precio</th>
            <th scope="col">Comision</th>
            <th scope="col">Ganancia</th>
            <th scope="col">Fianza</th>
            <th scope="col">Fianza devl</th>
            <th scope="col">Comercial</th>
            <th scope="col">Empresa</th>
            <th scope="col">Estado</th>
            <th scope="col">Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alquileres as $alquiler):?>
            <tr>
                <td><?=$alquiler->getid()?></td>
                <td><?=$alquiler->getcontrato()?></td>
                <td><?=$alquiler->getvehiculoInfo()->getMarca_modelo()?></td>
                <td><?=$alquiler->getclienteInfo()->getNombre()?></td>
                <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                <td><?=$alquiler->getdias()?></td>
                <td><?=number_format($alquiler->getprecio(), 2, ',', '.')?>€</td>
                <td><?=number_format($alquiler->getcomisionComercial(), 2, ',', '.')?>€</td>
                <td><?=number_format($alquiler->getganancia(), 2, ',', '.')?>€</td>
                <td><?=number_format($alquiler->getfianza(), 2, ',', '.')?>€</td>
                <td><?=number_format($alquiler->getfianzaDevuelta(), 2, ',', '.')?>€</td>
                <td><?=$alquiler->getcomercial()?></td>
                <td><?=$alquiler->getempresaInfo()->getNombre()?></td>
                <td><?=$alquiler->getestado()?></td> 
                <td><?=$alquiler->getobservaciones()?></td>
                <td>
                <div class="btn-group" role="group">
                    <a href="<?= DIRECTORIO ?>nuevo_alquiler/<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= DIRECTORIO ?>borrar_alquiler/<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este alquiler?');"> 
                    <i class="bi bi-trash"></i>
                    </a>    
                </div>
                </td>  
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

