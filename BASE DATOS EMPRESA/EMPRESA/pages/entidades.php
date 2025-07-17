<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h4>Entidades</h4>
        </div>
        <div class="col text-end">
            <a href="entidades=nombre" role="button" class="btn btn-primary">Ordenar</a>
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
                <th scope="col">Nombre</th>
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
                        </button>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="nav-link active" aria-current="page">Entidades encontradas: <?=count($entidades)?></a>
    </div>
</div>
