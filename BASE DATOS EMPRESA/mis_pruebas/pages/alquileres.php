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
                    <label for="coche" class="etiqueta">Coche</label>
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
<!-- este mensaje se usa al cargar la pagina, se le envia con $_GET en la URL  -->
<?php if (!empty($_GET['mensaje'])): ?><!-- este div solo se crea si existe $_GET['mensaje'] -->
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>  
<!-- este mensaje se usa para mostrar avisos locales, como llamadas AJAX que cambian datos. El texto del mensaje se lo envia por JS --> 
<div class="mensajeGuardar" id = "mensajeAJAX"></div>
<table class="table table-hover table-striped fina">
    <thead>
        <tr>
            <th scope="col">Contrato</th>
            <th scope="col">Vehiculo</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Fecha fin</th>
            <th scope="col">Precio</th>
            <th scope="col">Fianza</th>
            <th scope="col">Sin facturar</th>
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
                <td><!-- sino se le carga nada a href, o se le carga '', el navegador lo cambia por la URL de la pagina actual, asi que no puedo usar el atributo href ya que hay alquileres sin ruta, uso un data  -->
                    <a href ="#" data-ruta = "<?=$alquiler->getcarpeta()?>" onclick="copyLink(this.dataset.ruta); return false;">
                        <i title = "Copiar <?=$alquiler->getcarpeta()?>" class="bi bi-clipboard-check"></i>
                    </a>
                    <?=$alquiler->getcontrato()?>
                </td>
                <td class = "tooltip-cell info" data-tooltip="<?=$alquiler->getvehiculoInfo()->getMarca_modelo()?>"><!-- (para evitar que la página abierta pueda acceder a la ventana original con window.opener), rel="noopener noreferrer" -->
                    <a href="<?= DIRECTORIO ?>detalles_alquiler/<?=$alquiler->getid()?>" target="_blank" rel="noopener noreferrer">
                        <?=$alquiler->getvehiculoInfo()->getMarca_modelo()?>
                    </a>
                </td>
                <td title="<?=$alquiler->getclienteInfo()->getNombre()?>" style="color:blueviolet"><?=$alquiler->getclienteInfo()->getNombre()?></td>
                <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                <!-- a la fecha de inicio le sumo los dias del alquiler y los dias de las ampliaciones y saco la fecha de fin, mas facil asi que sacarla de la ultima ampliacion -->
                <td><?=formatea_fecha(fechaMasDias($alquiler->getfechaInicio(), $alquiler->getdias()+$alquiler->getsumaDias()))?></td>
        <!--tooltip-cell clase para poner borde verde al pasar con el raton-->
                <td class="tooltip-cell info borde" data-tooltip="KM: <?= $alquiler->getkilometros()+$alquiler->getsumaKilometros()?>; Comercial: <?=$alquiler->getcomercial()?>; Ciudad: <?=$alquiler->getciudad()?>; Entrega: <?=$alquiler->getentrega()?>; Ganancia: <?=$alquiler->getganancia()+$alquiler->getsumaGanancia()?>; Comision comercial: <?=number_format($alquiler->getcomisionComercial()+$alquiler->getsumaComisionComercial(), 2, ',', '.')?>€">                                    
                    <?=number_format($alquiler->getprecio()+$alquiler->getsumaPrecio(), 2, ',', '.')?>€
                </td>
                <td class="tooltip-cell info borde" data-tooltip="Devuelta:<?=number_format($alquiler->getfianzaDevuelta(), 2, ',', '.')?>€">
                    <?=number_format($alquiler->getfianza(), 2, ',', '.')?>€
                </td>
                <td><?= number_format($alquiler->getsumaCobros(), 2, ',', '.') ?>€</td>
                <td><?=$alquiler->getempresaInfo()->getNombre()?></td>
                <td>
                    <?php $estadoActual = $alquiler->getestado();?>
                    <select class="selectEstado" id = "<?=$alquiler->getid()?>" 
                            data-contrato = "<?=$alquiler->getcontrato()?>"
                            style=<?= $estadoActual == "Entregado" ? "color:blueviolet" : '""' ?>><!-- con data-contrato guardo el nº de contrato para luego mostrarlo en el mensaje -->
                        <!-- tmb podria haberlo puesto asi: <?= $estadoActual == "Entregado" ? 'style="color:blueviolet"' : '' ?> -->
                            <option disabled <?= $estadoActual === '' ? 'selected' : '' ?>>--Selecc--</option>
                        <?php foreach (ESTADOS_ALQUILER as $opcion): ?>
                            <option value="<?= $opcion ?>" <?= $opcion === $estadoActual ? 'selected' : '' ?>><?= $opcion ?></option>
                        <?php endforeach; ?>
                    </select>
                </td> 
                <td class="tooltip-cell info" data-tooltip="<?= htmlspecialchars($alquiler->getobservaciones()) ?>">
                        <?= htmlspecialchars($alquiler->getobservaciones()) ?>              
                </td>
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

        <div class="col-md-4"><a href="/mis_pruebas/alquileres?num_pagina=<?=$num_pagina_atras?>">[Atras</a>
        <a href="<?= DIRECTORIO ?>alquileres?num_pagina=<?=$num_pagina_sig?>">Siguiente]</a>
        <a href="<?= DIRECTORIO ?>alquileres?num_pagina=1">[Inicio</a>
        <a href="<?= DIRECTORIO ?>alquileres?num_pagina=<?=$numPaginas?>">Fin]</a></div>
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
    /* para el texto flotante en observaciones */
    tooltip();
    mensaje("mensaje");/* le paso el id del div donde sale el mensaje y la funcion mensaje le aplica una clase para que aparezca 
    con efectos y otra para que desaparezca */
    /* para lista desplegable que cabia el estado del alquiler */
    document.querySelectorAll('.selectEstado').forEach(select => {/* seleccion todas las listas desplegables de selecEstado */
        select.addEventListener('change', evento => {/* capturo evento change para cada lista desplegable del estado */
            let idAlquiler = select.id; /* id del alquiler que es el mismo que el id del select */
            let nuevoEstado = select.value; /* opcion seleccionada en el select */
            let zonaMensaje = document.getElementById("mensajeAJAX"); /* div para mostrar el mensaje de que se ha ejecutado correctamente */
            let contrato = select.dataset.contrato; /* nº de contrato guardado con una propiedad data-contrato en el select, para mostrar en el  mensaje */
            fetch('/mis_pruebas/estadoAlquiler?id=' + idAlquiler + '&estado=' + nuevoEstado)
                .then(response => {
                        return response.text();/* esto tiene que estar para que los datos lleguen a data. El cuerpo viene en un stream y tienes que procesarlo usando: response.text() → si devuelves texto */
                })
                .then(data => {
                    zonaMensaje.classList.add("exito");
                    zonaMensaje.innerHTML = data + ' al estado: ' + '<strong>' + nuevoEstado + '</strong> del contrato; ' + contrato;
                    mensaje("mensajeAJAX");/* le paso el nombre del id, en la funcion mensaje sacara el elementoById */
                })
                .catch(error => {
                    zonaMensaje.innerHTML = "Error: " + error;
                    mensaje("mensajeAJAX");
                });
        });
    });
 
});

</script>