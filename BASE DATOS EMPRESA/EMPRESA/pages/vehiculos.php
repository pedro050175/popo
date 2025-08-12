<div class="container mt-4">
    <div class="row">
        <div class="col-md-2">
            <h5><strong>Vehículos</strong></h5>
        </div>
        <div class="col-md-6">
            <form action="vehiculos" method="get" class="d-flex">
                <input type="text" name="buscar_matr_bast" class="form-control me-1" id="floatingInput" placeholder="Buscar matrícula o bastidor">
                <input type="text" name="buscar_marca" class="form-control me-1" id="floatingInput" placeholder="Buscar marca">
                <input type="hidden" name="num_pagina"   class="form-control me-2" id="floatingInput" value="1"><!--hay que poner el num de pagina en la URL para que no falle en metodo findAll del repository ya que da por echo que hay un $_GET['num_apgina'-->
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
                    <a href="vehiculos?ordenar=Marca_modelo&num_pagina=1">Vehiculo</a>
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
        <div class="row mb-3">       
            <div class="col-md-2"> <a class="nav-link active" aria-current="page">Vehículos: <?=count($vehiculos)?></a></div>
            <!--todo esto que sigue es para la paginacion-->
            <div class="col-md-6"><a class="nav-link active" aria-current="page">Pagina: <?=$_GET['num_pagina']?> de: <?= $num_paginas?></a></div>    
            <?php $_GET['num_pagina'] < $num_paginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
            <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
            <?php $ordenar = $_GET['ordenar'] ?? '' ?>  <!--si existe $_GET['ord..'] el listado esta ordenado, el enlace siguiente y atras debe llevar tmb variable ordenar para que siga ordenado-->

            <div class="col-md-4"><a href="/mis_pruebas/vehiculos?num_pagina=<?=$num_pagina_atras?>&ordenar=<?=$ordenar?>">[Atras</a>
            <a href="/mis_pruebas/vehiculos?num_pagina=<?=$num_pagina_sig?>&ordenar=<?=$ordenar?>">Siguiente]</a>
            <a href="/mis_pruebas/vehiculos?num_pagina=1&ordenar=<?=$ordenar?>">[Inicio</a>
            <a href="/mis_pruebas/vehiculos?num_pagina=<?=$num_paginas?>&ordenar=<?=$ordenar?>">Fin]</a></div>
        </div>  
        </div>
</div>
