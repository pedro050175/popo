<div class="container mt-4">
    <div class="row">
        <div class="col-md-2">
            <h4>Entidades</h4>
        </div>
        <div class="col-md-6">
            <form action="entidades" method="get" class="d-flex">
                <input type="text" name="buscar_nombre" class="form-control me-2" id="floatingInput" placeholder="Buscar nombre">
                <input type="text" name="buscar_dnicif" class="form-control me-2" id="floatingInput" placeholder="Buscar DNI/CIF">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <div class="col text-end">
            <a href="pages/nueva_entidad" role="button" class="btn btn-primary">Nueva entidad</a>
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
                <th scope="col">DNI/CIF</th>
                <th scope="col">
                    <a href="entidades?ordenar=nombre">Nombre</a>
                </th>
                <th scope="col">Dirección</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Email</th>
                <th scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entidades as $entidad):?>
                <tr>
                    <th scope="row"><?=$entidad->getId()?></th>
                    <td><?=$entidad->getCIF_DNI()?></td>
                    <td><?=$entidad->getNombre()?></td>
                    <td><?=$entidad->getDireccion()?></td>
                    <td><?=$entidad->getTelefono()?></td>
                    <td><?=$entidad->getEmail()?></td>
                    <td><?=$entidad->getObservaciones()?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="pages/nueva_entidad/<?=$entidad->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="pages/borrar/<?=$entidad->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta entidad?');"> 
                              <i class="bi bi-trash"></i>
                            </a>
                            <a href="pages/detalles_entidad/<?=$entidad->getId()?>" class= "btn btn-sm btn-outline-primary"> 
                              <i class="bi bi-eye"></i>
                            </a>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="nav-link active" aria-current="page">Entidades encontradas: <?=count($entidades)?></a>
    </div>
</div>
