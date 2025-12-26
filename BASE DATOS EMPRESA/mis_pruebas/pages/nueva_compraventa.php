<!-- esta parte que muestra en mensaje se podria haber metido en una funcion como esta
 function mostrarMensaje(string $texto, string $tipo = 'info'): void {
    // Sanitizar texto y tipo
    $mensaje = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
    <div class="mensajeGuardar {$tipo}" id="mensaje">
        {$mensaje}
    </div>
    HTML;
} 
y llamarla asi: mostrarMensaje($_GET['mensaje'], $_GET['tipo']);   
Esa sintaxis usa Heredoc, que permite escribir bloques grandes de texto (HTML, por ejemplo) sin tener que cerrar y abrir comillas todo el tiempo.

echo <<<HTML es un heredoc. Dentro de un heredoc, PHP interpreta variables, igual que en una cadena con comillas dobles "...". 
Los corchetes de llave {} sirven para delimitar claramente el nombre de la variable dentro del texto, sobre todo cuando está pegada a otros caracteres.
en JS tmb se usa algo parecido
    let tipo = "exito";                let mensaje = "Guardado correctamente";
    let html = `<div class="mensajeGuardar ${tipo}">
                    ${mensaje}
                </div>`;
    document.body.innerHTML += html;
    -->
<?php if (!empty($_GET['mensaje'])): ?>
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>
<!-- esto es para el dialogo de jQuery de salir sin guardar -->
<div id = "confirm" title="Aviso datos no guardados">
    <p>Desea salir sin guaradar?</p>
</div>
<form action="<?= DIRECTORIO ?>nueva_compraventa" method="post" id = "nuevaCompraventa">
    <?php if (isset($compraventa)) :?>
        <input type="hidden" name="data[id_compraventa]" id='id' value="<?=$compraventa->getid_compraventa()?>">
    <?php endif;?> 
      
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($compraventa)) ? 'Modificar ' : 'Nueva '?>Compra-venta</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" id = "salir">    
                <button type="submit" class="boton_submit disable" id ="botonGuardar" disabled> <?= (isset($compraventa)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($compraventa)) ? 'hidden' : ''?>>Limpiar</button>
            </div>
        </div>
        <?php
            $empresaActual = isset($compraventa) ? $compraventa->getempresa() : '';//estoy editando
            //$clienteActual = $clienteActual!=0 ? $clienteActual : ''; si el campo no es obligatorio hay que poner esto
            foreach ($empresas as $empresa){
                $listaEmpresas[$empresa->getId()] = $empresa->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
        <div class="row">
            <div class="col-md-2">
                <label for="select_empresa" class="form-label">Empresa</label>
                <select name="data[empresa]" class="form-select" id="select_empresa" 
                        required>
                    <option value = "" disabled <?= $empresaActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($listaEmpresas as $id => $empresa): ?>
                        <option value="<?= $id?>" <?= $id == $empresaActual ? 'selected' : '' ?>><?= $empresa ?></option>
                    <?php endforeach; ?>
                </select>     
            </div>
            <?php
                $vehiculoActual = isset($compraventa) ? $compraventa->getvehiculo() : '';//estoy editando un alquiler
                if ($vehiculoActual != ''){
                    $vehiculoActualMostrar =  htmlspecialchars($compraventa->getvehiculoInfo()->getMarca_modelo().' '.$compraventa->getvehiculoInfo()->getMatricula().' '. $compraventa->getvehiculoInfo()->getBastidor());    
                }else $vehiculoActualMostrar = '';
            ?>
            <div class="col-md-3">
                <label for="select_vehiculo" class="form-label">Vehiculo</label><!--label fuera del floating para que no se solape con el cuadro de texto -->
                <select name="data[vehiculo]" 
                        class="form-select" id="select_vehiculo"
                        data-placeholder = "Vehiculo comprado-vendido"
                        required
                        oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                        oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                    <option value = ""></option><!--hay que ponerle value="" para que el required funcione, asi el navegador entiende que si no se elije nada el valor es "" y te avisa, sino se pone, no tiene ningun valor y no avisa-->
                    <option value = <?= $vehiculoActual ?> selected><?= $vehiculoActualMostrar ?></option>
                </select> 
            </div>
            <div class="col-md-1">
                <label class="etiqueta" for="trimestre" >Trimestre</label>
                <input class="cuadro_text" type="checkbox" name="data[trimestre]" id="trimestre" <?=isset($compraventa) ? (($compraventa->gettrimestre()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($compraventa))?quitaEspecialChar($compraventa->getobservaciones()):''?>">
                    <label for="observaciones">Observaciones</label>
                </div>
            </div>
        </div>
        <p class = "titulo_marco">COMPRA</p>
        <div class = "contenido_titulo_marco">    
            <div class="row"> 
                <?php
                    $compraActual = isset($compraventa) ? $compraventa->getcompraA() : '';//estoy editando
                    $compraActual = $compraActual!=0 ? $compraActual : ''; //las funciones que devuelven un int si hay un '' devuelve 0 en lugar de ''
                    if ($compraActual != ''){
                        $compraMostrar =  htmlspecialchars($compraventa->getcompraAinfo()->getNombre());    
                    }else $compraMostrar = '';
                ?>   
                <div class="col-md-3">
                    <label for="select_compraA" class="form-label">Compra a:</label>
                    <select name="data[compraA]" class="form-select" id="select_compraA" data-placeholder = "Compra a...">
                        <option value = ""><option>
                        <option value = <?= $compraActual ?> selected><?= $compraMostrar ?></option>
                    </select>     
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="date" name="data[fechaCompra]" class="form-control" id="fechaCompra" placeholder="Fecha compra" value="<?=(isset($compraventa))?$compraventa->getfechaCompra():''?>"> 
                        <label for="fechaCompra">Fecha compra</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input class="form-control" type="text" name="data[precioCompraReal]" id="precioCompraReal" placeholder="Precio" onchange = "igualValor(this.form.precioCompraReal, this.form.precioCompraDeclarado)"
                            value = "<?= (isset($compraventa))?$compraventa->getprecioCompraReal():''?>">
                        <label for="precioCompraReal">Precio</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input class="form-control" type="text" name="data[precioCompraDeclarado]" id="precioCompraDeclarado" placeholder="Precio declarado" value = "<?= (isset($compraventa))?$compraventa->getprecioCompraDeclarado():''?>">
                        <label for="precioCompraDeclarado">Precio declarado</label>
                    </div>
                </div>
            
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="date" name="data[fechaFactComp]" class="form-control" id="fechaFactComp" placeholder="Fecha factura" value="<?=(isset($compraventa))?$compraventa->getfechaFactComp():''?>"> 
                        <label for="fechaFactComp">Fecha factura</label>
                    </div>
                </div>
                <?php
                    $impuestoCompra = isset($compraventa) ? ($compraventa->getimpuestoCompra() ?? '') : '';//si existe compraventa (impuesto no es null=>impuesto; si es null=>'') si no exite compraventa ''
                ?>
                <div class="col-md-2">
                    <label for="impuestoCompra" class="form-label">Impuesto:</label>
                    <select name="data[impuestoCompra]" class="form-select" id="impuestoCompra">
                        <option value = "" disabled <?= $impuestoCompra === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                        <?php foreach (IMPUESTOS as $impuesto): ?>
                            <option value="<?= $impuesto?>" <?= $impuesto == $impuestoCompra ? 'selected' : '' ?>><?= $impuesto ?></option>
                        <?php endforeach; ?>
                    </select>     
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="nodeclaraComp" >No declarada</label>
                    <input class="cuadro_text" type="checkbox" name="data[nodeclaraComp]" id="nodeclaraComp" <?=isset($compraventa) ? (($compraventa->getnodeclaraComp()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
                </div>  
                <div class="col-md-2">
                    <label class="etiqueta" for="anuladaCompra" >Anulada</label>
                    <input class="cuadro_text" type="checkbox" name="data[anuladaCompra]" id="anuladaCompra" <?=isset($compraventa) ? (($compraventa->getanuladaCompra()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
                </div>
            
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="number" name="data[kmCompra]" class="form-control" id="kmCompra" placeholder="km compra" value="<?=(isset($compraventa))?$compraventa->getkmCompra():''?>">
                        <label for="kmCompra">Km compra</label>
                    </div>
                </div>
                 <div class="col-md-5">
                    <div class="form-floating mb-1">
                        <textarea cols = "50" rows = "5" name="data[formaPagoCompra]" class="form-control" id="formaPagoCompra" placeholder="Pago Venta"><?=(isset($compraventa))?quitaEspecialChar($compraventa->getformaPagoCompra()):''?></textarea>
                        <label for="formaPagoCompra">Forma Pago</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="reserva" >Reserva</label>
                    <input class="cuadro_text" type="checkbox" name="data[reserva]" id="reserva" <?=isset($compraventa) ? (($compraventa->getreserva()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
                </div>
                <div>
                    <button type="button" class="boton_link" onclick = "window.location.href='<?= DIRECTORIO ?>contratoCompraventaPDF/<?= $compraventa->getid_compraventa() ?>?op=compra';" title="Contrato de compraventa en PDF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                    </button>  
                </div>    
            </div>
        </div>
        <p class = "titulo_marco">VENTA</p>
        <div class = "contenido_titulo_marco">    
            <div class="row">
                <?php
                    $vendeActual = isset($compraventa) ? $compraventa->getvendeA() : '';//estoy editando
                    $vendeActual = $vendeActual!=0 ? $vendeActual : ''; //si el campo no es obligatorio hay que poner esto
                    if ($compraActual != ''){
                        $vendeMostrar =  htmlspecialchars($compraventa->getvendeAinfo()->getNombre());    
                    }else $vendeMostrar = '';
                ?>   
                <div class="col-md-3">
                    <label for="select_vendeA" class="form-label">Vende a:</label>
                    <select name="data[vendeA]" class="form-select" id="select_vendeA" data-placeholder = "Vende a...">
                        <option value = ""></option>
                        <option value = <?= $vendeActual ?> selected><?= $vendeMostrar ?></option>
                    </select>     
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="date" name="data[fechaVenta]" class="form-control" id="fechaVenta" placeholder="Fecha venta" value="<?=(isset($compraventa))?$compraventa->getfechaVenta():''?>"> 
                        <label for="fechaVenta">Fecha</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input class="form-control" type="text" name="data[precioVentaReal]" id="precioVentaReal" 
                            placeholder="Precio" onchange = "igualValor(this.form.precioVentaReal, this.form.precioVentaDeclarado)" value = "<?= (isset($compraventa))?$compraventa->getprecioVentaReal():''?>">
                        <label for="precioVentaReal">Precio</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input class="form-control" type="text" name="data[precioVentaDeclarado]" id="precioVentaDeclarado" placeholder="Precio declarado" value = "<?= (isset($compraventa))?$compraventa->getprecioVentaDeclarado():''?>">
                        <label for="precioVentaDeclarado">Precio declarado</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="date" name="data[fechaFactVent]" class="form-control" id="fechaFactVent" placeholder="Fecha factura" value="<?=(isset($compraventa))?$compraventa->getfechaFactVenta():''?>"> 
                        <label for="fechaFactVent">Fecha factura</label>
                    </div>
                </div>
                <?php
                    $impuestoVenta = isset($compraventa) ? ($compraventa->getimpuestoVenta() ?? '') : '';//si existe compraventa (impuesto no es null=>imppuesto; si es null=>'') si no exite compraventa ''
                ?>
                <div class="col-md-2">
                    <label for="impuestoVenta" class="form-label">Impuesto:</label>
                    <select name="data[impuestoVenta]" class="form-select" id="impuestoVenta">
                        <option value = "" disabled <?= $impuestoVenta === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                        <?php foreach (IMPUESTOS as $impuesto): ?>
                            <option value="<?= $impuesto?>" <?= $impuesto == $impuestoVenta ? 'selected' : '' ?>><?= $impuesto ?></option>
                        <?php endforeach; ?>
                    </select>     
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="nodeclaraVenta" >No declara</label>
                    <input class="cuadro_text" type="checkbox" name="data[nodeclaraVenta]" id="nodeclaraVenta" <?=isset($compraventa) ? (($compraventa->getnodeclaraVenta()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
                </div>  
                <div class="col-md-2">
                    <label class="etiqueta" for="anuladaVenta" >Anulada</label>
                    <input class="cuadro_text" type="checkbox" name="data[anuladaVenta]" id="anuladaVenta" <?=isset($compraventa) ? (($compraventa->getanuladaVenta()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe compraventa evalua esto ($compraventa->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-1">
                        <input type="text" name="data[comercialVenta]" class="form-control" id="comercialVenta" placeholder="Comercial venta" value="<?=(isset($compraventa))?quitaEspecialChar($compraventa->getcomercialVenta()):''?>">
                        <label for="comercialVenta">Comercial venta</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-1">
                        <input type="number" name="data[kmVenta]" class="form-control" id="kmVenta" placeholder="km venta" value="<?=(isset($compraventa))?$compraventa->getkmVenta():''?>">
                        <label for="kmVenta">Km venta</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-1">
                        <textarea cols = "50" rows = "5" name="data[clausulasVenta]" class="form-control" id="clausulasVenta" placeholder="Clausulas Venta"><?=(isset($compraventa))?quitaEspecialChar($compraventa->getclausulasVenta()):''?></textarea>
                        <label for="clausulasVenta">Clausulas Venta</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-1">
                        <textarea cols = "50" rows = "5" name="data[formaPagoVenta]" class="form-control" id="formaPagoVenta" placeholder="Pago Venta"><?=(isset($compraventa))?quitaEspecialChar($compraventa->getformaPagoVenta()):''?></textarea>
                        <label for="formaPagoVenta">Forma Pago</label>
                    </div>
                </div>
                <div>
                    <button type="button" class="boton_link" onclick = "window.location.href='<?= DIRECTORIO ?>contratoCompraventaPDF/<?= $compraventa->getid_compraventa() ?>?op=venta';" title="Contrato de compraventa en PDF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>  
    </div>
</form>
<?php if (isset($compraventa)) :?>
    <div class = "bloque-movimiento">
        <p class = "etiqueta green">Beneficio: <?=number_format($compraventa->beneficio(), 2, ',', '.')?>€*</p>
        <p class = "etiqueta green">IVA: <?=number_format($compraventa->IVA(), 2, ',', '.')?>€</p>                        
        <p class = "etiqueta green">Beneficion-IVA: <?=number_format($compraventa->beneficioMenosIVA(), 2, ',', '.')?>€* <span class = "etiqueta_mini">*Se restan los gastos</span></p>
    </div>
    <!--Formulario nuevo cobro-->
    <button type="button" class="boton_link small" id="boton_form_cobro" onclick="mostrar('cobro')">+</button>
    <form action="<?= DIRECTORIO ?>nuevo_cobro_compraventa" method="post" id = "cobro" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nuevo cobro</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="cobro[fecha]" id="fecha" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="cobro[importe]" id="importe" placeholder="Importe" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="banco" >Banco:</label>
                    <input class="cuadro_text" type="text" name="cobro[banco]" id="banco" placeholder="Banco">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[observaciones]" id="observaciones" placeholder="observaciones">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validarTablaEnteros([form.importe, form.parteImporteFianza])">Guardar</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="cobro[compraventa]"  id="compraventa" value="<?=$compraventa->getid_compraventa()?>">
        </fieldset>
    </form>
    <!--listado cobros-->
    <p class="titulo_sec">Cobros Venta</p>
    <div>
        <table class="table table-hover table-striped fina">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Fecha</th>
                    <th class="etiqueta" scope="col">Importe</th>
                    <th class="etiqueta" scope="col">Banco</th>
                    <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalCobros = 0; ?>
                <?php foreach($cobros as $cobro) :?>
                    <tr>
                        <?php $totalCobros += $cobro->getimporte();?> 
                        <td><?=formatea_fecha($cobro->getfecha())?></td>         
                        <td><?=number_format($cobro->getimporte(), 2, ',', '.');?>€</td>                  
                        <td><?=$cobro->getbanco()?></td>         
                        <td><?=$cobro->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_cobro_compraventa/<?=$cobro->getidCobro()?>?compraventa=<?=$compraventa->getid_compraventa()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_cobro_compraventa/<?=$cobro->getidCobro()?>?compraventa=<?=$compraventa->getid_compraventa()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este cobro?');">   
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                    </tr>    
                <?php endforeach ;?>
                    <tr>
                        <td>Suma cobros</td>
                        <td><?=number_format($totalCobros, 2, ',', '.')?>€</td>
                    </tr>
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Falta por cobrar: <?=number_format($compraventa->getprecioVentaReal()-$totalCobros, 2, ',', '.')?>€</p>
    </div>
    <!--Formulario nuevo pago-->
    <button type="button" class="boton_link small" id="boton_form_pago" onclick="mostrar('pago')">+</button>
    <form action="<?= DIRECTORIO ?>nuevo_pago_compraventa" method="post" id = "pago" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nuevo pago</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="pago[fecha]" id="fecha" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="pago[importe]" id="importe" placeholder="Importe" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="banco" >Banco:</label>
                    <input class="cuadro_text" type="text" name="pago[banco]" id="banco" placeholder="Banco">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="pago[observaciones]" id="observaciones" placeholder="observaciones">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validarTablaEnteros([form.importe, form.parteImporteFianza])">Guardar</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="pago[compraventa]"  id="compraventa" value="<?=$compraventa->getid_compraventa()?>">
        </fieldset>
    </form>
    <!--listado cobros-->
    <p class="titulo_sec">Pagos Compra</p>
    <div>
        <table class="table table-hover table-striped fina">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Fecha</th>
                    <th class="etiqueta" scope="col">Importe</th>
                    <th class="etiqueta" scope="col">Banco</th>
                    <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalPagos = 0; ?>
                <?php foreach($pagos as $pago) :?>
                    <tr>
                        <?php $totalPagos += $pago->getimporte();?> 
                        <td><?=formatea_fecha($pago->getfecha())?></td>         
                        <td><?=number_format($pago->getimporte(), 2, ',', '.');?>€</td>                  
                        <td><?=$pago->getbanco()?></td>         
                        <td><?=$pago->getobservaciones()?></td>         
                        <td><div pago="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_pago_compraventa/<?=$pago->getidPago()?>?compraventa=<?=$compraventa->getid_compraventa()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_pago_compraventa/<?=$pago->getidPago()?>?compraventa=<?=$compraventa->getid_compraventa()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este pago?');">   
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                    </tr>    
                <?php endforeach ;?>
                <tr>
                    <td>Suma pagos</td>
                    <td><?=number_format($totalPagos, 2, ',', '.')?>€</td>
                </tr>   
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Falta por pagar: <?=number_format($compraventa->getprecioCompraReal()-$totalPagos, 2, ',', '.')?>€</p>
    </div>
     <!--Formulario nuevo gasto-->
    <button type="button" class="boton_link small" id="boton_form_gasto" onclick="mostrar('gasto')">+</button>
    <form action="<?= DIRECTORIO ?>nuevo_gasto_compraventa" method="post" id = "gasto" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nuevo Gasto</legend>
            <div class="row">
                <div class="col-md-6">
                    <label class="etiqueta" for="tipo" >Tipo:</label>
                    <input size = "70" class="cuadro_text" type="text" name="gasto[tipo]" id="tipo" placeholder="Tipo" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="gasto[importe]" id="importe" placeholder="Importe" required>
                </div>
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="gasto[fecha]" id="fecha" required>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-2">
                    <label class="etiqueta" for="pagaOtro" >Paga Otro:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[pagaOtro]" id="pagaOtro">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="pagado" >Pagado:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[pagado]" id="pagado">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="gasto[observaciones]" id="observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" id = "botonGuardarGasto">Guardar</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="gasto[compraventa]"  id="compraventa" value="<?=$compraventa->getid_compraventa()?>">
        </fieldset>
    </form>
    <!--listado gastos-->
    <p class="titulo_sec">Gastos Compra-Venta</p>
    <div>
    <table class="table table-hover table-striped fina">
        <thead>
            <tr>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Importe</th>
                <th class="etiqueta" scope="col">Tipo</th>
                <th class="etiqueta" scope="col">Paga otro</th>
                <th class="etiqueta" scope="col">Pagado</th>
                <th class="etiqueta" scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($gastos as $gasto) :?>
                <tr>
                    <td><?=formatea_fecha($gasto->getfecha())?></td>         
                    <td><?=number_format($gasto->getimporte(), 2, ',', '.');?>€</td>         
                    <td><?=$gasto->gettipo()?></td>
                    <td><?=$gasto->getpagaOtro() ? 'SI' : 'NO'?></td>         
                    <td><?=$gasto->getpagado() ? 'SI' : 'NO'?></td>         
                    <td><?=$gasto->getobservaciones()?></td>         
                    <td><div class="btn-group" role="group">
                        <a href="<?= DIRECTORIO ?>editar_gasto_compraventa/<?=$gasto->getidGasto()?>?compraventa=<?=$compraventa->getid_compraventa()?>" role="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../borrar_gasto_compraventa/<?=$gasto->getidGasto()?>?compraventa=<?=$compraventa->getid_compraventa()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este gasto?');">   
                            <i class="bi bi-trash"></i>
                        </a>   
                        </div>
                    </td>
                </tr>    
            <?php endforeach ;?>
            <tr>
                <td>Suma gastos</td>
                <td><?=number_format($compraventa->getsumaGastos(), 2, ',', '.')?>€<td>
            </tr> 
        </tbody>
    </table>            
    </div>
<?php endif ;?>

<script>
    $(document).ready(function() {
       
        formulario = document.getElementById("gasto");
        let botonGuardarGasto = document.getElementById("botonGuardarGasto");
        if (botonGuardarGasto){/* cuando la pagina es para una nueva compraventa no se cargan el boton de nuevo gasto con lo que no existe"botonGuardarGasto" */
            botonGuardarGasto.addEventListener("click", (evento) => {
                if (!validarTablaEnteros([formulario.importe])){
                    return false;/* esto cancela el evento submit del boton */
                }
            });
        }
        /* evento change de mi formulario. Para detectar que se ha cambiado algun campo en el formulario 
        Con one la funcion del evento se ejecuta solo una vez, jquery desvincula el evento del elemento, no es necesario que se dispare el evento en cada cambio de formulario.
        Otra forma hubiera sido dejar on y dentro de la funcion del evento poner un if(!formularioModificado){ formularioModificado = true; ...
        y asi solo se ejecuta una vez pero si que se dispara el evento y viene a la funcion en cada cambio de formulario, con one ni siquiera se dispara, 
        ya no hay evento, habria que cargar otra vez el evento  $('#nuevaCompraventa').one('change', ....*/
        var formularioModificado = false;
        $('#nuevaCompraventa').one('change', e => {
            formularioModificado = true;
            var botonGuardarForm = document.getElementById('botonGuardar');
            botonGuardarForm.classList.remove('disable');
            botonGuardarForm.disabled = false;
        });
        /* cuando se cierra la ventana el evento beforeunload y unloas, no puede usar alert, ni confirm, solo se puede mostrar el diálogo nativo del navegado */
        window.addEventListener('beforeunload', e =>{
            let botonClick = e.explicitOriginalTarget;/* explicitOriginalTarget me devuelve el elemento deo DOM que ha originado el evento salir de la ventana */
            /* si la salida no la origina el boton "guardar" es una salida por cierre de ventana o pulsando atras 
            cuando no usaba el modal de jquery UI tmb podia comprobar si se habia pulsado el boton "salir" y asi no tenia que poner a false formularioModificado, pero con el modal UI, 
            al pulsar salir salta el modal y despues se pulsa el boton Aceptar o Cancelar del modal con lo que el evento beforeunload ya no sabe que fue pulsacion de salir. Los botones
            de UI no tienen id, podria haber consultado algun otro atributo del boton pero para no complicarlo cambio la variable formularioModificado en el boton salir */
            if ((botonClick.id != "botonGuardar") && (formularioModificado == true)){/* si no pulsado guardar y se ha modificado entro en el if y el navegador avisa al usuario*/
                e.preventDefault(); 
                e.returnValue = ""; // Obligatorio para que el navegador muestre el diálogo
            }
        });
        /* jQuery UI modal, aqui se asigna el pluging al <div> de la pagina HTML correspondiente y se configura */
        $('#confirm').dialog({
            resizable : false,
            show : 'slideDown',
            hide : 'explode',
            autoOpen : false,
            buttons : {
                "Aceptar" : function () {
                    $(this).dialog('close');
                    formularioModificado = false;/*lo pongo a false para que en el evento beforeunload de cerrar la ventana no me salte el aviso del navegador  */
                    window.location.href='<?= DIRECTORIO ?>compraventas?num_pagina=1';
                },
                "Cancelar" : function (){
                    $(this).dialog('close');
                }
            }
        });
        /* boton de guardar el formulario, esta parte se puede quedar en el HTML */
        document.getElementById('botonGuardar').addEventListener("click", (e) => {
            let nuevaCompraventa = document.getElementById('nuevaCompraventa');
            if (!validarCompraventa(nuevaCompraventa)) {
                e.preventDefault(); /*si pongo return false no cancela el submit, me dice la IA que el return false solo cancela cuando se pone en onclick =" return false"
                pero no se porque en otros sitios si que lo cancela */
            };
        });
        /* boton de salir del formulario */
        document.getElementById('salir').addEventListener('click', e =>{
            if (formularioModificado == true){
                $('#confirm').dialog('open');
            } else {
                window.location.href='<?= DIRECTORIO ?>compraventas?num_pagina=1';
            }
        });
        /* para mostrar el mensaje de guardado correctamente de arriba */
        mensaje("mensaje");
        selectAjaxVehiculos(document.getElementById('select_vehiculo'));
        selectAjaxEntidades(document.getElementById('select_compraA'));
        selectAjaxEntidades(document.getElementById('select_vendeA'));
    });
</script>
<!-- lo mismo que he hecho con PHP al principio del documento lo puedo hacer con JS asi:
    var tipo = '<?= $_GET['tipo'] ?>';  
    var mensaje = '<?= $_GET['mensaje'] ?>';
    // 🔹 Creamos el HTML con interpolación ${}
    const html = `
        <div class="mensajeGuardar ${tipo}" id="prueba">
            <strong>${tipo.toUpperCase()}:</strong> ${mensaje}<br>
        </div>
    `;
    // 🔹 Lo insertamos en el documento
    document.body.insertAdjacentHTML("beforeend", html);
    let prueba = document.getElementById("prueba");  //La función insertAdjacentHTML() inserta HTML directamente en el DOM, sin tener que crear elementos uno por uno con createElement() o appendChild().
    prueba.classList.add("mostrar");
    setTmeOut (()=>{prueba.classList.remove("mostrar")},3000);
insertAdjacentHTML
    Sintaxis: element.insertAdjacentHTML(posición, textoHTML);
🔹 Las posiciones posibles
| Valor de posición | Qué hace                                                     | Ejemplo visual                          |
| ----------------- | ------------------------------------------------------------ | --------------------------------------- |
| `"beforebegin"`   | Inserta **antes** del elemento (como un hermano anterior)    | `<nuevo></nuevo><element>...</element>` |
| `"afterbegin"`    | Inserta **dentro**, justo **al principio**                   | `<element><nuevo></nuevo>...</element>` |
| `"beforeend"`     | Inserta **dentro**, justo **al final**                       | `<element>...<nuevo></nuevo></element>` |
| `"afterend"`      | Inserta **después** del elemento (como un hermano siguiente) | `<element>...</element><nuevo></nuevo>` |
🔹 Ejemplo práctico
<div id="contenedor">
    <p>Primer párrafo</p>
</div>

<script>
const contenedor = document.getElementById("contenedor");

// Insertar un nuevo párrafo al final del div
contenedor.insertAdjacentHTML("beforeend", "<p>Segundo párrafo</p>");
</script>
🟢 Resultado en el DOM:
<div id="contenedor">
    <p>Primer párrafo</p>
    <p>Segundo párrafo</p>
</div>
Por qué es útil

✅ No destruye el contenido existente (a diferencia de innerHTML = ...).
✅ Es más rápido que manipular con createElement() + appendChild() cuando insertas HTML grande.
✅ Puedes elegir exactamente dónde colocarlo.
-->