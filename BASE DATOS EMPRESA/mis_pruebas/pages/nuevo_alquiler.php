<form action="<?= DIRECTORIO ?>nuevo_alquiler" method="post" id = "nuevoAlquiler">
    <?php if (isset($alquiler)) :?>
    <input type="hidden" name="data[id]" id='id' value="<?=$alquiler->getid()?>">
    <?php endif;?>      
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($alquiler)) ? 'Modificar ' : 'Nuevo '?>alquiler</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" id = "salir">   
                <button type="submit" class="boton_submit disable" id = "botonGuardar" disabled onclick = "return validarAlquiler(this.form);"> <?= (isset($alquiler)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($alquiler)) ? 'hidden' : ''?>>Limpiar</button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2">    
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaInicio]" class="form-control" id="fechaInicio" placeholder="Fecha inicio" value="<?=(isset($alquiler))?$alquiler->getfechaInicio():''?>" required> 
                    <label for="fechaIncio">Fecha inicio</label>
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="form-floating mb-1">
                    <input class="form-control" type="number" name="data[dias]" id="dias" placeholder="Dias" onchange = "actualizaFechaFin(this.form)" value = "<?= (isset($alquiler))?$alquiler->getdias():''?>">
                    <label for="dias">Dias:</label>
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="form-floating mb-1">
                    <input type="text" name="data[contrato]" class="form-control" id="contrato" placeholder="Contrato" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getcontrato()):''?>" required>
                    <label for="contrato">Contrato</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[precio]" id="precio" placeholder="Precio" value = "<?= (isset($alquiler))?$alquiler->getprecio():''?>">
                    <label for="precio">Precio:</label>
                </div>
            </div>  
        </div>
        <?php
            $vehiculoActual = isset($alquiler) ? $alquiler->getvehiculo() : '';//estoy editando un alquiler
            $vehiculoActual = $vehiculoActual!=0 ? $vehiculoActual : '';//getvehiculo devuelve un numero, si no existe el vehiculo devuelve un 0 (CAMPOS_alquiler lo pone a cero)
           if ($vehiculoActual != ''){
                    $vehiculoActualMostrar =  htmlspecialchars($alquiler->getvehiculoInfo()->getMarca_modelo().' '.$alquiler->getvehiculoInfo()->getMatricula().' '. $alquiler->getvehiculoInfo()->getBastidor());    
                }else $vehiculoActualMostrar = '';
        ?>
        <div class="row">            
            <div class="col-md-4">
                <label for="select_vehiculo" class="form-label">Vehiculo</label><!--label fuera del floating para que no se solape con el cuadro de texto -->
                <div class="form-floating mb-1">
                    <select name="data[vehiculo]" 
                            class="form-select" id="select_vehiculo" 
                            data-placeholder = "Vehiculo alquilado"
                            required
                            oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                            oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                        <option value = ""></option><!--hay que ponerle value="" para que el required funcione, asi el navegador entiende que si no se elije nada el valor es "" y te avisa, sino se pone, no tiene ningun valor y no avisa-->
                        <option value = <?= $vehiculoActual ?> selected><?= $vehiculoActualMostrar ?></option>
                    </select> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-2">
                    <input class="form-control" type="number" name="data[kilometros]" id="kilometros" placeholder="Kilometros" value = "<?=(isset($alquiler))? $alquiler->getkilometros() : ''?>">
                    <label for="kilometros">Kilometros:</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="number" name="data[kmInicio]" id="kmInicio" placeholder="Km inicio" value = "<?= (isset($alquiler))?$alquiler->getkmInicio():''?>">
                    <label for="kmInicio">Km inicio:</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="number" name="data[kmFin]" id="kmFin" placeholder="Km fin" value = "<?= (isset($alquiler))?$alquiler->getkmFin():''?>">
                    <label for="kmFin">Km fin:</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaFin]" class="form-control" id="fechaFin" placeholder="Fecha fin" value="<?=(isset($alquiler))?$alquiler->getfechaFin():''?>"> 
                    <label for="fechaFin">Fecha fin</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[precioKm]" id="precioKm" placeholder="Precio km" value = "<?= (isset($alquiler))?$alquiler->getprecioKm():''?>">
                    <label for="precioKm">Precio km:</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[fianza]" id="fianza" placeholder="Fianza" value = "<?= (isset($alquiler))?$alquiler->getfianza():''?>">
                    <label for="fianza">Fianza:</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[fianzaDevuelta]" id="fianzaDevuelta" placeholder="Fianza Devuelta" value = "<?= (isset($alquiler))?$alquiler->getfianzaDevuelta():''?>">
                    <label for="fianzaDevuelta">Fianza Devuelta:</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[comercial]" class="form-control" id="comercial" placeholder="Comercial" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getcomercial()):'CRISTIAN'?>">
                    <label for="comercial">Comercial</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[comisionComercial]" 
                        id="comisionComercial" placeholder="Comision €:" onchange="actualizaGanancia(this.form)" value = "<?= (isset($alquiler))?$alquiler->getcomisionComercial():''?>">
                    <label for="comisionComercial">Comision €:</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[ganancia]" id="ganancia" placeholder="Ganancia" value = "<?= (isset($alquiler))?$alquiler->getganancia():''?>">
                    <label for="ganancia">Ganancia:</label>
                </div>
            </div>
            <?php
                $clienteActual = isset($alquiler) ? $alquiler->getcliente() : '';//estoy editando un alquiler
                $clienteActual = $clienteActual!=0 ? $clienteActual : '';
                if ($clienteActual != ''){
                        $clienteMostrar =  htmlspecialchars($alquiler->getclienteinfo()->getNombre());    
                    }else $clienteMostrar = '';
            ?>
            <div class="col-md-3">
                <label for="select_cliente" class="form-label">Cliente</label>
                <select name="data[cliente]" class="form-select" id="select_cliente" data-placeholder = "Cliente alquiler..."
                        required
                        oninvalid="document.getElementById('clienteError').style.display='block';"
                        oninput="document.getElementById('clienteError').style.display='none';"><!--esto es por si no elige un cliente, oninvalid es evento de no elegido (clienteError esta definido abajo) y oninput es evento de que se ha eligido para quitar el error-->
                    <option value = ""></option>
                    <option value = <?= $clienteActual ?> selected><?= $clienteMostrar ?></option>
                </select> 
                <div id="clienteError" style="color: red; display: none; font-size: 0.9em;">
                    Por favor selecciona un cliente.
                </div>   
            </div>
        </div>
        </div>
            <?php
                $empresaActual = isset($alquiler) ? $alquiler->getempresa() : '';//estoy editando un alquiler
                $empresaActual = $empresaActual!=0 ? $empresaActual : '';
                foreach ($empresas as $empresa){
                    $listaEmpresas[$empresa->getId()] = $empresa->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
                }
            ?>
        <div class="row">
            <div class="col-md-3">
                <label for="select_empresa" class="form-label">Empresa que alquila</label>
                <div class="form-floating mb-1">
                    <select name="data[empresa]" class="form-select" id="select_empresa" required>
                        <option value = "" disabled <?= $empresaActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                        <?php foreach ($listaEmpresas as $id => $empresa): ?>
                            <option value="<?= $id?>" <?= $id == $empresaActual ? 'selected' : '' ?>><?= $empresa ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[ciudad]" class="form-control" id="ciudad" placeholder="Ciudad" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getciudad()):''?>">
                    <label for="ciudad">Ciudad</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[entrega]" class="form-control" id="entrega" placeholder="Entrega" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getentrega()):''?>">
                    <label for="entrega">Entrega</label>
                </div>
            </div>
            <?php
                $estadoActual = isset($alquiler) ? $alquiler->getestado() : '';
                $estadoActual = $estadoActual ?? '';
            ?>    
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <select name="data[estado]" class="form-select" id="estado">
                        <option disabled <?= $estadoActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                        <?php foreach (ESTADOS_ALQUILER as $opcion): ?>
                            <option value="<?= $opcion ?>" <?= $opcion === $estadoActual ? 'selected' : '' ?>><?= $opcion ?></option>
                            <?php endforeach; ?>
                        </select> 
                        <label for="estado">Estado</label>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getobservaciones()):''?>">
                    <label for="observaciones">Observaciones</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-1">
                    <input type="text" name="data[carpeta]" class="form-control" id="carpeta" placeholder="carpeta" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getcarpeta()):''?>">
                    <label for="carpeta">Carpeta</label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-floating mb-1">
                    <button type="button" class="boton_link" onclick = "copy('carpeta')" title="Copiar la ruta de la carpeta del alquiler"><i class="bi bi-clipboard-check"></i></button>
                </div>
                <div class="form-floating mb-1">
                    <button type="button" class="boton_link" onclick = "" title="Contrato de alquiler en PDF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div> 
    </div>
</form>

<?php if (isset($alquiler)) :?>
    <!--Formulario nueva ampliacion-->

    <button type="button" class="boton_link small" id="boton_form_ampliacion" onclick="mostrar('ampliacion')">+</button>
    <form action="<?= DIRECTORIO ?>nueva_ampliacion_alquiler" method="post" id="ampliacion" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva ampliacion</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fechaInicio" class="etiqueta">Fecha inicio:</label> 
                    <input class="cuadro_text" type="date" name="ampliacion[fechaInicio]" id="fechaInicio" required>
                </div>        
                <div class="col-md-3">
                    <label for="dias" class="etiqueta">Dias:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[dias]" id="dias" onchange = "actualizaFechaFin(this.form)" placeholder="dias">
                </div>
                <div class="col-md-3">
                    <label for="fechaFin" class="etiqueta">Fecha fin:</label> 
                    <input class="cuadro_text" type="date" name="ampliacion[fechaFin]" id="fechaFin">
                </div>                
                <div class="col-md-3">
                    <label for="kilometros" class="etiqueta">Kilometros:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[kilometros]" id="kilometros" placeholder="kilometros">
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="precio" >Precio:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[precio]" id="precio" placeholder="precio" required>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="comisionComercial" >Comision Comercial:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[comisionComercial]" id="comisionComercial" placeholder="Comision Comercial" onchange="actualizaGanancia(this.form)">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="ganancia" >Ganancia:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[ganancia]" id="ganancia" placeholder="ganancia">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="Observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="ampliacion[observaciones]" id="Observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validarTablaEnteros([form.dias, form.precio, form.ganancia, form.comisionComercial])">Guardar</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="ampliacion[alquiler]"  id="alquiler" value="<?=$alquiler->getid()?>">
        </fieldset>
    </form>

    <!--listado ampliaciones-->
    <p class="titulo_sec">Ampliaciones</p>
    <div>
        <table class="table table-hover table-striped fina">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Fecha inicio</th>
                    <th class="etiqueta" scope="col">Dias</th>
                    <th class="etiqueta" scope="col">Fecha fin</th>
                    <th class="etiqueta" scope="col">Precio</th>
                    <th class="etiqueta" scope="col">Kilometros</th>
                    <th class="etiqueta" scope="col">Comision</th>
                    <th class="etiqueta" scope="col">Ganancia</th>
                    <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = $alquiler->getprecio(); ?>
                <?php foreach($ampliaciones as $ampliacion) :?>
                    <tr>
                        <?php $total += $ampliacion->getprecio();?> 
                        <td><?=formatea_fecha($ampliacion->getfechaInicio())?></td>
                        <td><?=$ampliacion->getdias();?></td>         
                        <td><?=formatea_fecha($ampliacion->getfechaFin())?></td>
                        <td><?=number_format($ampliacion->getprecio(), 2, ',', '.');?>€</td>         
                        <td><?=$ampliacion->getkilometros();?></td>         
                        <td><?=number_format($ampliacion->getcomisionComercial  (), 2, ',', '.');?>€</td>                 
                        <td><?=number_format($ampliacion->getganancia(), 2, ',', '.');?>€</td>         
                        <td><?=$ampliacion->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_ampliacion_alquiler/<?=$ampliacion->getidAmpliacion()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_ampliacion_alquiler/<?=$ampliacion->getidAmpliacion()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta ampliacion?');">  
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                </tr>    
                <?php endforeach ;?>    
            </tbody>
        </table> 
        <p class='etiqueta_desplazada'> Suma: <?=number_format($total, 2, ',', '.')?>€</p>   
    </div>
    <!--Formulario nuevo cobro-->
    <button type="button" class="boton_link small" id="boton_form_cobro" onclick="mostrar('cobro')">+</button>
    <form action="<?= DIRECTORIO ?>nuevo_cobro_alquiler" method="post" id = "cobro" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Crear cobro</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="cobro[fecha]" id="fecha" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="texto" name="cobro[importe]" id="importe" placeholder="Importe" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="facturado" >Facturado:</label>
                    <input class="cuadro_text" type="checkbox" name="cobro[facturado]" id="facturado">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="facturadoA" >Facturado A:</label>
                    <input class="cuadro_text" type="text" name="cobro[facturadoA]" id="facturadoA" placeholder="Facturado A">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="contratoHacienda" >Contrato Hacienda:</label>
                    <input class="cuadro_text" type="text" name="cobro[contratoHacienda]" id="contratoHacienda" placeholder="Contrato Hacienda">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="fianza" >Fianza:</label>
                    <input class="cuadro_text" type="checkbox" name="cobro[fianza]" id="fianza">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="parteImporteFianza" >Parte Importe fianza:</label>
                    <input class="cuadro_text" type="texto" name="cobro[parteImporteFianza]" id="parteImporteFianza" placeholder="No dejarlo vacio">
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
            <input type="hidden" name="cobro[alquiler]"  id="alquiler" value="<?=$alquiler->getid()?>">
        </fieldset>
        <span class = "etiqueta_mini">Si la fianza va en el mismo cobro que el alquiler se pondra facturado cuando facture la parte que es de alquiler y ya no se computa en pagos sin facturar. 
            Y si la fianza va en un cobro ella sola, HAY QUE PONER en "PARTE_IMPORTE_FIANZA" EL COBRO, no dejarlo vacio, y no se pone facturado nunca, 
            se resta ella misma porque es un cobro = x y cantidad de fianza = x y en el total sin facturar computa como 0 porque se hace importe - parte fianza</span>
    </form>

    <!--listado cobros-->
    <p class="titulo_sec">Cobros</p>
    <div>
        <table class="table table-hover table-striped fina">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Fecha</th>
                    <th class="etiqueta" scope="col">Importe</th>
                    <th class="etiqueta" scope="col">Facturado</th>
                    <th class="etiqueta" scope="col">Facturado a</th>
                    <th class="etiqueta" scope="col">Contrato Hacienda</th>
                    <th class="etiqueta" scope="col">Fianza</th>
                    <th class="etiqueta" scope="col">Parte importe fianza</th>
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
                        <td style = "text-align: center"><?=number_format($cobro->getimporte(), 2, ',', '.');?>€</td>         
                        <td style = "text-align: center"><?=$cobro->getfacturado() ? 'SI' : 'NO'?></td>         
                        <td><?=$cobro->getfacturadoA()?></td>         
                        <td><?=$cobro->getcontratoHacienda()?></td>         
                        <td style = "text-align: center"><?=$cobro->getfianza() ? 'SI' : 'NO'?></td>         
                        <td><?=number_format($cobro->getparteImporteFianza(), 2, ',', '.');?>€</td>                  
                        <td><?=$cobro->getbanco()?></td>         
                        <td><?=$cobro->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_cobro_alquiler/<?=$cobro->getidCobro()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_cobro_alquiler/<?=$cobro->getidCobro()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este cobro?');">   
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                </tr>    
                <?php endforeach ;?>   
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Suma: <?=number_format($totalCobros, 2, ',', '.')?>€</p>
    </div>
    <!--Formulario nuevo gasto-->
    <button type="button" class="boton_link small" id="boton_form_gasto" onclick="mostrar('gasto')">+</button>
    <form action="<?= DIRECTORIO ?>nuevo_gasto_alquiler" method="post" id = "gasto" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Crear Gasto</legend>
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
                    <button type="submit" class="boton_submit" onclick="return validarTablaEnteros([form.importe])">Guardar</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="gasto[alquiler]"  id="alquiler" value="<?=$alquiler->getid()?>">
        </fieldset>
    </form>
    <!--listado gastos-->
    <p class="titulo_sec">Gastos</p>
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
                <?php $totalGastos = 0; ?>
                <?php foreach($gastos as $gasto) :?>
                    <tr>
                        <?php $totalGastos += $gasto->getimporte();?> 
                        <td><?=formatea_fecha($gasto->getfecha())?></td>         
                        <td><?=number_format($gasto->getimporte(), 2, ',', '.');?>€</td>         
                        <td><?=$gasto->gettipo()?></td>
                        <td><?=$gasto->getpagaOtro() ? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getpagado() ? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_gasto_alquiler/<?=$gasto->getidGasto()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_gasto_alquiler/<?=$gasto->getidGasto()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este gasto?');">   
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                    </tr>    
                <?php endforeach ;?>   
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Suma: <?=number_format($totalGastos, 2, ',', '.')?>€</p>
    </div> 
<?php endif;?>
<script>
    $(document).ready(function() {
        
        /* para controlar el guardado del formulario */
        var formularioModificado = false;
        $('#nuevoAlquiler').one('change', e => {
            formularioModificado = true;
            var botonGuardarForm = document.getElementById('botonGuardar');
            botonGuardarForm.classList.remove('disable');
            botonGuardarForm.disabled = false;
        });
        /* cuando se cierra la ventana el evento beforeunload y unloas, no puede usar alert, ni confirm, solo se puede mostrar el diálogo nativo del navegado */
        window.addEventListener('beforeunload', e =>{
            let botonClick = e.explicitOriginalTarget;/* explicitOriginalTarget me devuelve el elemento deo DOM que ha originado el evento salir de la ventana */
            if ((botonClick.id != "botonGuardar") && (formularioModificado == true)){/* si no pulsado guardar y se ha modificado entro en el if y el navegador avisa al usuario*/
                e.preventDefault(); 
                e.returnValue = ""; // Obligatorio para que el navegador muestre el diálogo
            }
        });
        /* boton de salir del formulario */
        document.getElementById('salir').addEventListener('click', e=>{
            if (formularioModificado == true){
                Swal.fire({
                    title: 'Atencion datos no guardados',
                    text: 'El formulario alquiler no se ha guardado, desea salir sin guardar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formularioModificado = false;
                            window.location.href='<?= DIRECTORIO ?>alquileres?num_pagina=1';                            
                        }
                }); //Swal
            } else {
                window.location.href='<?= DIRECTORIO ?>alquileres?num_pagina=1';
                }
        });
        /* desplegable vehiculo con jQuery Ajax */
        selectAjaxVehiculos(document.getElementById('select_vehiculo')); 
        selectAjaxEntidades(document.getElementById('select_cliente'));

    });
</script>