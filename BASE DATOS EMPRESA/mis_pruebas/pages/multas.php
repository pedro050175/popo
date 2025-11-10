<?php if (!empty($_GET['mensaje'])): ?>
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>
<div>    
    <form action = "<?=DIRECTORIO?>multas" method="GET">
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="boton_submit">Buscar</button>   
            </div>  
            <div class="col-md-6">
                <input type="button"  class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nueva_multa';"> 
            </div>
        </div>
        <div class = "botones">
            <div class="col-md"><!-- al quitarle el numero a col-md se pegan mas los cuadros de buscar -->
                <input type="search" name="coche" class="cuadro_text" id="coche" placeholder="Coche/Matr" value="<?= $_GET['coche'] ?? ''?>">
            </div>
            <div class="col-md-4">    
                <input type="date" name="desde" class="cuadro_text" id="desde" value="<?= $_GET['desde'] ?? ''?>">
                <input type="date" name="hasta" class="cuadro_text" id="hasta" value="<?= $_GET['hasta'] ?? ''?>">
            </div>
            <!-- <div class="col-md-0">    
                <label class = "etiqueta_mini" >Tri</label>
                <input type="checkbox" name="trimestre" class="cuadro_text" id="trimestre" value = "1" <?= isset($_GET['trimestre']) ? ($_GET['trimestre'] == 1 ? 'checked' : '') : ''?>>
            </div> -->
        </div>
        <input type="hidden" name="num_pagina" class="cuadro_text" value="1">
    </form>
</div>
<table class="table table-hover table-striped fina">
    <thead>
        <tr>
            <th scope="col">Vehiculo</th>
            <th scope="col">Fecha</th>
            <th scope="col">Importe</th>
            <th scope="col">Pagado</th>
            <th scope="col"><em>Identificar</em></th>
            <th scope="col">Vencimiento</th>
            <th scope="col">Importe cobrado</th>
            <th scope="col">Conductor</th>
            <th scope="col">Terminada</th>
            <th scope="col">Comentarios
                
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($multas as $multa):?>
            <tr>
                <td class="tooltip-cell info" data-tooltip="Matricula: <?=$multa->getvehiculoInfo()->getMatricula()?> Lugar: <?=$multa->getlugar()?> Expediente: <?=$multa->getexpediente()?>">
                    <?=$multa->getvehiculoInfo()->getMarca_modelo()?>
                </td>
                <td><?=formatea_fecha($multa->getfecha())?></td>
                <td><?=number_format($multa->getimporte(), 2, ',', '.')?>€</td>
                <td class="tooltip-cell info" data-tooltip="Fecha pago: <?=formatea_fecha($multa->getfechaPago())?> Paga desde: <?=$multa->getpagaDesde()?>">
                    <?=number_format($multa->getimportePagado(), 2, ',', '.')?>€
                </td>
                <td class="tooltip-cell info" data-tooltip="Fecha: <?=formatea_fecha($multa->getfechaIdentificada())?> Conductor identificado: <?=$multa->getconductorIdentificada()?>">
                    <input type = "checkbox" disabled <?=$multa->getidentificar() ? 'checked': ''?>>
                </td>
                <td><?=formatea_fecha($multa->getvencimiento())?></td>
                <td><?=number_format($multa->getimporteCobrado(), 2, ',', '.')?>€</td>
                <td><?=$multa->getconductor()?></td> 
                <td><input type = "checkbox" disabled <?=$multa->getterminada() ? 'checked': ''?>></td>
                <td class="tooltip-cell info" data-tooltip="<?= htmlspecialchars($multa->getcomentarios()) ?>">
                        <?= htmlspecialchars($multa->getcomentarios()) ?>              
                </td>
                <td>
                <div class="btn-group" role="group">
                    <a href="<?= DIRECTORIO ?>nueva_multa/<?=$multa->getidMulta()?>" role="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= DIRECTORIO ?>borrar_multa/<?=$multa->getidMulta()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta multa?');"> 
                    <i class="bi bi-trash"></i> 
                    </a>   
                </div>
                </td>  
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="row mb-3">       
    <div class="col-md-2"> <em class="etiqueta">Multas: <?=count($multas)?></em></div>
    <!--todo esto que sigue es para la paginacion-->
    <?php if (isset($_GET['num_pagina'])) :?>
        <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
        <?php $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
        <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->

        <div class="col-md-4">
            <a href="/mis_pruebas/multas?num_pagina=<?=$num_pagina_atras?>&desde=<?=$_GET['desde'] ?? '' ?>&hasta=<?=$_GET['hasta'] ?? ''?>&coche=<?=$_GET['coche'] ?? ''?>">[Atras</a>
            <a href="<?= DIRECTORIO ?>multas?num_pagina=<?=$num_pagina_sig?>&desde=<?=$_GET['desde'] ?? '' ?>&hasta=<?=$_GET['hasta'] ?? ''?>&coche=<?=$_GET['coche'] ?? ''?>">Siguiente]</a>
            <a href="<?= DIRECTORIO ?>multas?num_pagina=1&desde=<?=$_GET['desde'] ?? '' ?>&hasta=<?=$_GET['hasta'] ?? ''?>&coche=<?=$_GET['coche'] ?? ''?>">[Inicio</a>
            <a href="<?= DIRECTORIO ?>multas?num_pagina=<?=$numPaginas?>&desde=<?=$_GET['desde'] ?? '' ?>&hasta=<?=$_GET['hasta'] ?? ''?>&coche=<?=$_GET['coche'] ?? ''?>">Fin]</a>
        </div>
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
/* para el texto flotante en observaciones */
  tooltip();
/* para mostrar el mensaje de guardado correctamente de arriba */
  mensaje("mensaje");
});
</script>
