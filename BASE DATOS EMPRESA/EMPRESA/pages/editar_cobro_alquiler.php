<label class="titulo_prin">&nbsp&nbsp&nbsp&nbspGasto</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_cobro_alquiler" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar cobro</legend>
            <div class="row">
                <div class="col-md-4">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="text" name="cobro[fecha]" id="fecha" value="<?=$cobro->getfecha()?>" required>
                </div>        
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="cobro[importe]" id="importe" placeholder="Importe" value="<?=$cobro->getimporte()?>" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="facturado" >Facturado:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="cobro[facturado]" id="facturado" <?=($cobro->getfacturado()) ? 'checked' : ''?>>
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="facturadoA" >Facturado A:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[facturadoA]" id="facturadoA" placeholder="Facturado A" value="<?=quitaEspecialChar($cobro->getfacturadoA())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="contratoHacienda" >Contrato Hacienda:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[contratoHacienda]" id="contratoHacienda" placeholder="Contrato Hacienda" value="<?=quitaEspecialChar($cobro->getcontratoHacienda())?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="fianza" >Fianza:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="cobro[fianza]" id="fianza" <?=($cobro->getfianza()==1) ? 'checked' : ''?>>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="parteImporteFianza" >Parte Importe fianza:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="cobro[parteImporteFianza]" id="parteImporteFianza" placeholder="parteImporteFianza" value="<?=$cobro->getparteImporteFianza()?>" required>
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="banco" >Banco:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[banco]" id="banco" placeholder="Banco" value="<?=quitaEspecialChar($cobro->getbanco())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="cobro[observaciones]" id="observaciones" placeholder="observaciones" value="<?=quitaEspecialChar($cobro->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar Gasto</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_vehiculo/<?=$cobro->getId_vehiculo()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="cobro[alquiler]"  id="alquiler" value="<?=$cobro->getalquiler()?>">
            <input type="hidden" name="cobro[idCobro]" id="idCobro" value="<?=$cobro->getidCobro()?>">
        </fieldset>
    </form>
</div>