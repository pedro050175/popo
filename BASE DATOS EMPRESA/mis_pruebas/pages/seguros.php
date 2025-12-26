<div class = "container mt-1">            
    
    <form action="<?= DIRECTORIO ?>seguros" method="get" class="d-flex" id = "formBusqueda">
        <div class = bloque-movimiento>
            <div class="row">
                <div class="col-md-3">
                    <label for="coche" class="etiqueta">Coche</label>
                    <input type="search" name="coche" class="cuadro_text" id="coche" value="<?= $_GET['coche'] ?? ''?>">
                </div>
                <div class="col-md-3">
                    <label for="otro" class="etiqueta">"Riesgo"</label>    
                    <input type="search" name="otro" class="cuadro_text" id="otro" value="<?= $_GET['otro'] ?? ''?>">
                </div>
                <div class="col-md-3">
                    <label for="tomador" class="etiqueta">Tomador</label>    
                    <input type="search" name="tomador" class="cuadro_text" id="tomador" value="<?= $_GET['tomador'] ?? ''?>">
                </div>
                <div class="col-md-3">
                    <label for="compania" class="etiqueta">"Cmpñia"</label>    
                    <input type="search" name="compania" class="cuadro_text" id="compania" value="<?= $_GET['compania'] ?? ''?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="desde" class="etiqueta">Desde:</label>
                    <input type="date" name="desde" class="cuadro_text" id="desde" value="<?= $_GET['desde'] ?? ''?>">
                </div>
                <div class="col-md-3">
                    <label for="hasta" class="etiqueta">Hasta:</label>
                    <input type="date" name="hasta" class="cuadro_text" id="hasta" value="<?= $_GET['hasta'] ?? ''?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="boton_submit">Buscar</button>  
                </div>
                <div class="col-md-2">
                    <input type="button"  class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_seguro';"> 
                </div>
            </div>
        </div>
    </form>
</div>
<!-- este mensaje se usa al cargar la pagina, se le envia con $_GET en la URL  -->
<?php if (!empty($_GET['mensaje'])): ?>
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>  
<!-- este mensaje se usa para mostrar avisos locales, como llamadas AJAX que cambian datos. El texto del mensaje se lo envia por JS --> 
<div class="mensajeGuardar" id = "mensajeAJAX"></div>
<table class="table table-hover table-striped fina">
    <thead>
        <tr>
            <th scope="col">Póliza</th>
            <th scope="col">Vehículo</th>
            <th scope="col">Riesgo</th>
            <th scope="col">Importe</th>
            <th scope="col">Fecha</th>
            <th scope="col">Vencimiento</th>
            <th scope="col">Periodo</th>
            <th scope="col">Tomador</th>
            <th scope="col">Compañía</th>
            <th scope="col">Mediador</th>
            <th scope="col">Comentarios</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($seguros as $seguro):?>
            <tr <?= $seguro->getbaja() ? 'style = "background-color : yellow"' : ''?>>
                <?php $total += $seguro->getimporte(); ?>
                <td class = "tooltip-cell info" data-tooltip="Motivo Baja: <?=$seguro->getmotivoBaja()?>Fecha: <?=formatea_fecha($seguro->getfechaBaja())?>">
                    <?=$seguro->getpoliza()?>
                </td>
                <td class = "tooltip-cell info" data-tooltip="<?=$seguro->getvehiculoInfo()->getMarca_modelo()?> Matri: <?=$seguro->getvehiculoInfo()->getMatricula() ?> Bast: <?=$seguro->getvehiculoInfo()->getBastidor()?>">
                        <?=$seguro->getvehiculoInfo()->getMarca_modelo()?>
                </td>
                <td><?=$seguro->getotroRiesgo()?></td>
                <td><?=number_format($seguro->getimporte(), 2, ',', '.')?>€</td>
                <td><?=formatea_fecha($seguro->getfecha())?></td>
                <td><?=formatea_fecha($seguro->getvencimiento())?></td>
                <td><?=$seguro->getperiodo()?></td>
                <td><?=$seguro->gettomadorInfo()->getNombre()?></td>
                <td><?=$seguro->getcompania()?></td>
                <td><?=$seguro->getmediador()?></td>
                <td class="tooltip-cell info" data-tooltip="<?= htmlspecialchars($seguro->getcomentarios()) ?>">
                        <?= htmlspecialchars($seguro->getcomentarios()) ?>              
                </td>
                <td>
                <div class="btn-group" role="group">
                    <a href="<?= DIRECTORIO ?>nuevo_seguro/<?=$seguro->getidSeguro()?>" role="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= DIRECTORIO ?>borrar_seguro/<?=$seguro->getidSeguro()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este seguro?');"> 
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
    <div class="col-md-2"> <em class="etiqueta">Seguros: <?=count($seguros)?></em></div>
    <!--todo esto que sigue es para la paginacion-->
    <?php if (isset($_GET['num_pagina'])) :?>
        <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
        <?php $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
        <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->

        <div class="col-md-4"><a href="/mis_pruebas/seguros?num_pagina=<?=$num_pagina_atras?>">[Atras</a>
        <a href="<?= DIRECTORIO ?>seguros?num_pagina=<?=$num_pagina_sig?>">Siguiente]</a>
        <a href="<?= DIRECTORIO ?>seguros?num_pagina=1">[Inicio</a>
        <a href="<?= DIRECTORIO ?>seguros?num_pagina=<?=$numPaginas?>">Fin]</a></div>
    <?php endif ;?>
</div>  
<script>
$(document).ready(function() {
    /* para poner el foco en el campo de busqueda que tenga texto, los miro todos */
    document.querySelectorAll('#formBusqueda input[type ="search"]').forEach(elemento => {
        if (elemento.value!=""){
            elemento.focus();
        }
    });//forEach
    mensaje('mensaje');
    /* para el texto flotante en observaciones */
    tooltip(); 
});

</script>