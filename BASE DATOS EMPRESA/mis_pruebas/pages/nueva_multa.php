<?php if (!empty($_GET['mensaje'])): ?>
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>
<form action="<?= DIRECTORIO ?>nueva_multa" method="post">
    <?php if (isset($multa)) :?>
        <input type="hidden" name="data[idMulta]" id='id' value="<?=$multa->getidMulta()?>">
    <?php endif;?> 
      
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($multa)) ? 'Mofificar ' : 'Nueva '?>Multa</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" id = "salir">   
                <button type="submit" class="boton_submit disable" disabled onclick = "return validarMulta(this.form)" id = "botonGuardar"> <?= (isset($multa)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($multa)) ? 'hidden' : ''?>>Limpiar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[expediente]" class="form-control" id="expediente" placeholder="expediente" value="<?=(isset($multa))?quitaEspecialChar($multa->getexpediente()):''?>">
                    <label for="expediente">Expediente</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fecha]" class="form-control" id="fecha" required placeholder="Fecha" value="<?=(isset($multa))?$multa->getfecha():''?>"> 
                    <label for="fecha">Fecha</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaNotificacion]" class="form-control" id="fechaNotificacion" onchange="actualizaVencimiento(this.form)" required placeholder="Fecha Notificacion" value="<?=(isset($multa))?$multa->getfechaNotificacion():''?>"> 
                    <label for="fecha">Fecha notificacion</label>
                </div>
            </div>
            <?php
                $vehiculoActual = isset($multa) ? $multa->getvehiculo() : '';//estoy editando
                if ($vehiculoActual != ''){
                    $vehiculoActualMostrar =  htmlspecialchars($multa->getvehiculoInfo()->getMarca_modelo().' '.$multa->getvehiculoInfo()->getMatricula().' '. $multa->getvehiculoInfo()->getBastidor());    
                }else $vehiculoActualMostrar = '';
            ?>
            <div class="col-md-3">
                <label for="select_vehiculo" class="form-label">Vehiculo</label><!--label fuera del floating para que no se solape con el cuadro de texto -->
                <option value = ""></option>
                <select name="data[vehiculo]" 
                        class="form-select" id="select_vehiculo" 
                        required
                        data-placeholder = "Vehiculo multado"
                        oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                        oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                    <option value = ""></option>
                    <option value = <?= $vehiculoActual ?> selected><?= $vehiculoActualMostrar ?></option>
                </select>     
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[importe]" id="importe" placeholder="importe" value = "<?= (isset($multa))?$multa->getimporte():''?>">
                    <label for="importe">Importe</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[importePagado]" id="importePagado" placeholder="importe Pagado" value = "<?= (isset($multa))?$multa->getimportePagado():''?>">
                    <label for="importePagado">Imp. Pagado</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaPago]" class="form-control" id="fechaPago" placeholder="fechaPago" value="<?=(isset($multa))?$multa->getfechaPago():''?>"> 
                    <label for="fecha">Fecha Pago</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating mb-1">
                    <input type="text" name="data[pagaDesde]" class="form-control" id="pagaDesde" placeholder="paga Desde" value="<?=(isset($multa))?quitaEspecialChar($multa->getpagaDesde()):''?>">
                    <label for="pagaDesde">Paga Desde</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[vencimiento]" class="form-control" id="vencimiento" placeholder="vencimiento" value="<?=(isset($multa))?$multa->getvencimiento():''?>"> 
                    <label for="vencimiento">Vencimiento</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <label class="etiqueta" for="identificar" >Identificar</label>
                <input class="cuadro_text" type="checkbox" name="data[identificar]" id="identificar" <?=isset($multa) ? (($multa->getidentificar()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe multa evaluaMulta ($multa->getteMulta()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaIdentificada]" class="form-control" id="fechaIdentificada" placeholder="fechaIdentificada" value="<?=(isset($multa))?$multa->getfechaIdentificada():''?>"> 
                    <label for="fechaIdentificada">Fecha Identificada</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[conductorIdentificado]" class="form-control" id="conductorIdentificado" placeholder="conductor Identificado" value="<?=(isset($multa))?quitaEspecialChar($multa->getconductorIdentificada()):''?>">
                    <label for="conductorIdentificado">Conductor Identificado</label>
                </div>
            </div>
            <div class="col-md-1">
                <label class="etiqueta" for="terminada" >Terminada</label>
                <input class="cuadro_text" type="checkbox" name="data[terminada]" id="terminada" <?=isset($multa) ? (($multa->getterminada()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe multa evaluaMulta ($multa->getteMulta()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[lugar]" class="form-control" id="lugar" placeholder="lugar" value="<?=(isset($multa))?quitaEspecialChar($multa->getlugar()):''?>">
                    <label for="lugar">Lugar</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[conductor]" class="form-control" id="conductor" placeholder="conductor" value="<?=(isset($multa))?quitaEspecialChar($multa->getconductor()):''?>">
                    <label for="conductor">Conductor</label>
                </div>
            </div>
             <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[importeCobrado]" id="importeCobrado" placeholder="importeCobrado" value = "<?= (isset($multa))?$multa->getimporteCobrado():''?>">
                    <label for="importeCobrado">importe Cobrado</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[comentarios]" class="form-control" id="comentarios" placeholder="comentarios" value="<?=(isset($multa))?quitaEspecialChar($multa->getcomentarios()):''?>">
                    <label for="comentarios">Comentarios</label>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        mensaje("mensaje");        /* para mostrar el mensaje de guardado correctamente de arriba */
        var estadoFormulario = { modificado: false };
        guardarDatos(document.forms[0], '<?= DIRECTORIO ?>multas?num_pagina=1', estadoFormulario);
        selectAjaxVehiculos(document.getElementById('select_vehiculo'));
    });
</script>