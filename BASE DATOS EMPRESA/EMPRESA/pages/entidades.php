<div class="container mt-4">
    <div class="row">
        <div class="col-md-2">
            <h5><strong>Entidades</strong></h5>
        </div>
        <div class="col-md-6">
            <form action="entidades" method="get" class="d-flex">
                <input type="text" name="buscar_nombre" class="form-control me-2" id="floatingInput" placeholder="Buscar nombre">
                <input type="text" name="buscar_dnicif" class="form-control me-2" id="floatingInput" placeholder="Buscar DNI/CIF">
                <input type="hidden" name="num_pagina"   class="form-control me-2" id="floatingInput" value="1"><!--hay que poner el num de pagina en la URL para que no falle en metodo findAll del repository ya que da por echo que hay un $_GET['num_apgina'-->
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
                    <a href="entidades?ordenar=nombre&num_pagina=1">Nombre</a>
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

        <div class="row mb-3">       
            <div class="col-md-2"><a class="nav-link active" aria-current="page">Entidades: <?=count($entidades)?></a></div>
        <!--todo esto que sigue es para la paginacion-->

            <div class="col-md-6"><a class="nav-link active" aria-current="page">Pagina: <?=$_GET['num_pagina']?> de: <?= $num_paginas?></a></div>
                
            <?php $_GET['num_pagina'] < $num_paginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
            <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
            <?php $ordenar = $_GET['ordenar'] ?? '' ?>  <!--si existe $_GET['ord..'] el listado esta ordenado, el enlace siguiente y atras debe llevar tmb variable ordenar para que siga ordenado-->

            <div class="col-md-4"><a href="/mis_pruebas/entidades?num_pagina=<?=$num_pagina_atras?>&ordenar=<?=$ordenar?>">[Atras</a>
            <a href="/mis_pruebas/entidades?num_pagina=<?=$num_pagina_sig?>&ordenar=<?=$ordenar?>">Siguiente]</a>
            <a href="/mis_pruebas/entidades?num_pagina=1&ordenar=<?=$ordenar?>">[Inicio</a>
            <a href="/mis_pruebas/entidades?num_pagina=<?=$num_paginas?>&ordenar=<?=$ordenar?>">Fin]</a></div>
        </div>
            </div>  
    </div>
</div>
