<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <form action="<?= DIRECTORIO ?>movimientos" method="get" class="d-flex">
                <input type="search" name="buscar_envia" class="form-control me-1" id="floatingInput" placeholder="Buscar envia">
                <input type="search" name="buscar_recibe" class="form-control me-1" id="floatingInput" placeholder="Buscar recibe">
                <input type="hidden" name="num_pagina"   class="form-control me-2" id="floatingInput" value="1"><!--hay que poner el num de pagina en la URL para que no falle en metodo findAll del repository ya que da por echo que hay un $_GET['num_apgina'-->
                <button type="submit" class="boton_submit">Buscar</button>  
            </form>
        </div>
        <div class="col-md-4"> </div><!--para despalzar el boton Nuevo vehiculo a la derecha-->
        <div class="col-md-2">
            <input type="button" class="boton_link" value = "Nuevo movimiento" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_movimiento';"> 
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
                <th class="etiqueta" scope="col">#</th>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Envia</th>
                <th class="etiqueta" scope="col">Recibe</th>
                <th class="etiqueta" scope="col">Concepto</th>
                <th class="etiqueta" scope="col">Vehiculo</th>
                <th class="etiqueta" scope="col">Propietario</th>
                <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($movimientos as $movimiento):?>
                <tr>
                    <th scope="row"><?=$movimiento->getidMovimiento()?></th>
                    <td><?=formatea_fecha($movimiento->getfecha())?></td>
                    <td><?=$movimiento->getenviaInfo()->getNombre()?></td>
                    <td><?=$movimiento->getrecibeInfo()->getNombre()?></td>
                    <td><?=$movimiento->getconcepto()?></td>
                    <td><?=$movimiento->getvehiculoInfo()->getMarca_modelo()?></td>
                    <td><?=$movimiento->getvehiculoInfo()->getdatos_propietario()->getNombre()?></td>
                    <td><?=$movimiento->getobservaciones()?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>nuevo_movimiento/<?=$movimiento->getidMovimiento()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= DIRECTORIO ?>borrar_movimiento/<?=$movimiento->getidMovimiento()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este movimiento?');"> 
                              <i class="bi bi-trash"></i>
                            </a>
                            <a href="<?= DIRECTORIO ?>detalles_movimiento/<?=$movimiento->getidMovimiento()?>" class= "btn btn-sm btn-outline-primary"> 
                              <i class="bi bi-eye"></i>
                            </a>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row mb-3">       
            <div class="col-md-2"> <em class="etiqueta">Movimientos: <?=count($movimientos)?></em></div>
            <!--todo esto que sigue es para la paginacion-->
            <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
            <?php $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
            <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
            <?php $ordenar = $_GET['ordenar'] ?? '' ?>  <!--si existe $_GET['ord..'] el listado esta ordenado, el enlace siguiente y atras debe llevar tmb variable ordenar para que siga ordenado-->

            <div class="col-md-4"><a href="/mis_pruebas/movimientos?num_pagina=<?=$num_pagina_atras?>&ordenar=<?=$ordenar?>">[Atras</a>
            <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$num_pagina_sig?>&ordenar=<?=$ordenar?>">Siguiente]</a>
            <a href="<?= DIRECTORIO ?>movimientos?num_pagina=1&ordenar=<?=$ordenar?>">[Inicio</a>
            <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$numPaginas?>&ordenar=<?=$ordenar?>">Fin]</a></div>
        </div>  
        </div>
</div>
