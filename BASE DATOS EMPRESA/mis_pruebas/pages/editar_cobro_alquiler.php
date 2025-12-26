<label class="titulo_prin">Cobro</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_cobro_alquiler" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar cobro</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="cobro[fecha]" id="fecha" value="<?=$cobro->getfecha()?>" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="texto" name="cobro[importe]" id="importe" placeholder="Importe" value="<?=$cobro->getimporte()?>" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="facturado" >Facturado:</label>
                    <input class="cuadro_text" type="checkbox" name="cobro[facturado]" id="facturado" <?=($cobro->getfacturado()) ? 'checked' : ''?>>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="facturadoA" >Facturado A:</label>
                    <input class="cuadro_text" type="text" name="cobro[facturadoA]" id="facturadoA" placeholder="Facturado A" value="<?=quitaEspecialChar($cobro->getfacturadoA())?>">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="contratoHacienda" >Contrato Hacienda:</label>
                    <input class="cuadro_text" type="text" name="cobro[contratoHacienda]" id="contratoHacienda" placeholder="Contrato Hacienda" value="<?=quitaEspecialChar($cobro->getcontratoHacienda())?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="fianza" >Fianza:</label>
                    <input class="cuadro_text" type="checkbox" name="cobro[fianza]" id="fianza" <?=($cobro->getfianza()==1) ? 'checked' : ''?>>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="parteImporteFianza" >Parte Importe fianza:</label>
                    <input class="cuadro_text" type="texto" name="cobro[parteImporteFianza]" id="parteImporteFianza" placeholder="No dejarlo vacio" value="<?=$cobro->getparteImporteFianza()?>">
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="banco" >Banco:</label>
                    <input class="cuadro_text" type="text" name="cobro[banco]" id="banco" placeholder="Banco" value="<?=quitaEspecialChar($cobro->getbanco())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[observaciones]" id="observaciones" placeholder="observaciones" value="<?=quitaEspecialChar($cobro->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_alquiler/<?=$cobro->getalquiler()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="cobro[alquiler]"  id="alquiler" value="<?=$cobro->getalquiler()?>">
            <input type="hidden" name="cobro[idCobro]" id="idCobro" value="<?=$cobro->getidCobro()?>">
        </fieldset>
        <span>Si la fianza va en el mismo cobro que el alquiler se pondra facturado cuando facture la parte que es de alquiler y ya no se computa en pagos sin facturar. 
            Y si la fianza va en un cobro ella sola, HAY QUE PONER en "PARTE_IMPORTE_FIANZA" EL COBRO, no dejarlo vacio, y no se pone facturado nunca, 
            se resta ella misma porque es un cobro = x y cantidad de fianza = x y en el total sin facturar computa como 0</span>
    </form>
</div>