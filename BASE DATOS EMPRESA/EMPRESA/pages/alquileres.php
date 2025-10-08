<div class = "container mt-1">            
    
    <form action="<?= DIRECTORIO ?>alquileres" method="get" class="d-flex">
        <div class = bloque-movimiento>
            <div class="row">
                <div class="col-md-3">
                    <label for="buscar" class="etiqueta">"Contrato/Cliente"</label>    
                    <input type="search" name="buscar" class="cuadro_text" id="buscar" value="<?= $_GET['buscar'] ?? ''?>">
                </div>
                <div class="col-md-2">
                    <label for="desde" class="etiqueta">Desde:</label>
                    <input type="date" name="desde" class="cuadro_text" id="desde" value="<?= $_GET['desde'] ?? ''?>">
                </div>
                <div class="col-md-2">
                    <label for="hasta" class="etiqueta">Hasta:</label>
                    <input type="date" name="hasta" class="cuadro_text" id="hasta" value="<?= $_GET['hasta'] ?? ''?>">
                </div>
                <div class="col-md-2">
                    <label for="coche" class="etiqueta">coche:</label>
                    <input type="search" name="coche" class="cuadro_text" id="coche" value="<?= $_GET['coche'] ?? ''?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit">Buscar</button> 
                    <button type="button" style = "align: right" class="boton_submit" onclick="window.location.href='<?= DIRECTORIO ?>analisis_alquileres';">Analizar</button>  
                </div>
                <div class="col-md-1">
                    <input type="button"  class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_alquiler';"> 
                </div>
            </div>
        </div>
    </form>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>    

<table class="table table-hover table-striped fina">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Contrato</th>
            <th scope="col">Vehiculo</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha_inicio</th>
            <th scope="col">Precio</th>
            <th scope="col">Dias</th>
            <th scope="col">Comision</th>
            <th scope="col">Fianza</th>
            <th scope="col">Fianza devl</th>
            <th scope="col">Comercial</th>
            <th scope="col">Empresa</th>
            <th scope="col">Estado</th>
            <th scope="col">Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($alquileres as $alquiler):?>
            <tr>
                <?php $total += $alquiler->getprecio()+$alquiler->getsumaPrecio(); ?>
    
                <td><?=$alquiler->getid()?></a></td>
                <td><?=$alquiler->getcontrato()?></td>
                <td>
                    <a href="<?= DIRECTORIO ?>detalles_alquiler/<?=$alquiler->getid()?>" target="_blank" rel="noopener noreferrer">
                        <?=$alquiler->getvehiculoInfo()->getMarca_modelo()?>
                    </a>
                </td>
                <td style="color:blueviolet"><?=$alquiler->getclienteInfo()->getNombre()?></td>
                <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                <td style="color: red"><?=number_format($alquiler->getprecio()+$alquiler->getsumaPrecio(), 2, ',', '.')?>€</td>
                <td><?=$alquiler->getdias()+$alquiler->getsumaDias()?></td>
                <td><?=number_format($alquiler->getcomisionComercial()+$alquiler->getsumaComisionComercial(), 2, ',', '.')?>€</td>
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
<div class="row mb-3">       
    <div class="col-md-5"></div>
    <div class="col-md-2">
        <p class = "etiqueta">Suma precio: <?=number_format($total, 2, ',', '.')?>€</p>
    </div>
</div>
<div class="row mb-3">       
    <div class="col-md-2"> <em class="etiqueta">Alquileres: <?=count($alquileres)?></em></div>
    <!--todo esto que sigue es para la paginacion-->
    <?php if (isset($_GET['num_pagina'])) :?>
        <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
        <?php $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
        <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
        <?php $ordenar = $_GET['ordenar'] ?? '' ?>  <!--si existe $_GET['ord..'] el listado esta ordenado, el enlace siguiente y atras debe llevar tmb variable ordenar para que siga ordenado-->

        <div class="col-md-4"><a href="/mis_pruebas/movimientos?num_pagina=<?=$num_pagina_atras?>&ordenar=<?=$ordenar?>">[Atras</a>
        <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$num_pagina_sig?>&ordenar=<?=$ordenar?>">Siguiente]</a>
        <a href="<?= DIRECTORIO ?>movimientos?num_pagina=1&ordenar=<?=$ordenar?>">[Inicio</a>
        <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$numPaginas?>&ordenar=<?=$ordenar?>">Fin]</a></div>
    <?php endif ;?>
</div>  
<script>
$(document).ready(function() {
    if (document.getElementById("desde").value!=""){
        document.getElementById("desde").focus();
    }
    if (document.getElementById("coche").value!=''){
        document.getElementById("coche").focus();
    }
    if (document.getElementById("buscar").value!=""){
        document.getElementById("buscar").focus();
    }
});
</script>
