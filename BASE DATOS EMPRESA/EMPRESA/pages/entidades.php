<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <form action="<?= DIRECTORIO ?>entidades" method="get" class="d-flex">
                <input type="search" name="buscar_dnicif" class="form-control me-2" id="buscar_dnicif" placeholder="Buscar DNI/CIF">
                <input type="search" name="buscar_nombre" class="form-control me-2" id="busca_nombre" placeholder="Buscar nombre">
                <button type="submit" class="boton_submit">Buscar</button>
            </form>
        </div>
        <div class="col-md-4"></div> <!--para despalzar el boton Nuevo vehiculo a la derecha-->
        <div class="col-md-2">
            <input type="button" class="boton_link" value = "Nueva Entidad" onclick="window.location.href='<?= DIRECTORIO ?>nueva_entidad';"> 
        </div>
    </div>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <table class="table table-hover table-striped medio">
            <thead>
                <tr>
                <th class="etiqueta" scope="col">#</th>
                <th class="etiqueta" scope="col">DNI/CIF</th>
                <th class="etiqueta" scope="col">
                    <a href="<?= DIRECTORIO ?>entidades?ordenar=nombre&num_pagina=1">Nombre</a>
                </th>
                <th class="etiqueta" scope="col">Dirección</th>
                <th class="etiqueta" scope="col">Teléfono</th>
                <th class="etiqueta" scope="col">Email</th>
                <th class="etiqueta" scope="col">Observaciones</th>
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
                            <a href="<?= DIRECTORIO ?>nueva_entidad/<?=$entidad->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= DIRECTORIO ?>borrar/<?=$entidad->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta entidad?');"> 
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="<?= DIRECTORIO ?>detalles_entidad/<?=$entidad->getId()?>" class= "btn btn-sm btn-outline-primary"> 
                                <i class="bi bi-eye"></i>
                            </a>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row mb-3">       
            <div class="col-md-2"><em class="etiqueta">Entidades: <?=count($entidades)?></em></div>
            <!--todo esto que sigue es para la paginacion-->
            <?php if (isset($_GET['num_pagina'])) :?>
                <div class="col-md-6"><em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $num_paginas?></em></div>                
                <?php $_GET['num_pagina'] < $num_paginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
                <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
                <?php $ordenar = $_GET['ordenar'] ?? '' ?>  <!--si existe $_GET['ord..'] el listado esta ordenado, el enlace siguiente y atras debe llevar tmb variable ordenar para que siga ordenado-->
                <div class="col-md-4"><a href="<?= DIRECTORIO ?>entidades?num_pagina=<?=$num_pagina_atras?>&ordenar=<?=$ordenar?>">[Atras</a>
                <a href="<?= DIRECTORIO ?>entidades?num_pagina=<?=$num_pagina_sig?>&ordenar=<?=$ordenar?>">Siguiente]</a>
                <a href="<?= DIRECTORIO ?>entidades?num_pagina=1&ordenar=<?=$ordenar?>">[Inicio</a>
                <a href="<?= DIRECTORIO ?>entidades?num_pagina=<?=$num_paginas?>&ordenar=<?=$ordenar?>">Fin]</a></div>
            <?php endif ;?>
        </div>
    </div>  
</div>
