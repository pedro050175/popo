<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Entidades</h2>
        </div>
        <div class="col text-end">
            <a href="pages/nueva_entidad" role="button" class="btn btn-primary">Nueva entidad</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">DNI/CIF</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Dirección</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entidades as $entidad):?>
                <tr>
                    
                    <th scope="row"><?=$entidad->getId()?></th>
                    <td><?=$entidad->getCIF_DNI()?></td>
                    <td><?=$entidad->getNombre()?></td>
                    <td><?=$entidad->getApellidos()?></td>
                    <td><?=$entidad->getDireccion()?></td>
                    <td><?=$entidad->getTelefono()?></td>
                    <td><?=$entidad->getEmail()?></td>
                    <td>
                        <div class="btn-group" role="group">
                        <a href="/pages/nueva_entidad/<?=$entidad->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="#" role="button" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>