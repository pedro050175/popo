<label class="titulo_prin">Pago</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_pago_compraventa" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar pago</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="date" name="pago[fecha]" id="fecha" value="<?=$pago->getfecha()?>" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="texto" name="pago[importe]" id="importe" placeholder="Importe" value="<?=$pago->getimporte()?>" required>
                </div>  
                <div class="col-md-3">
                    <label class="etiqueta" for="banco" >Banco:</label>
                    <input class="cuadro_text" type="text" name="pago[banco]" id="banco" placeholder="Banco" value="<?=quitaEspecialChar($pago->getbanco())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="pago[observaciones]" id="observaciones" placeholder="observaciones" value="<?=quitaEspecialChar($pago->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nueva_compraventa/<?=$pago->getcompraventa()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="pago[compraventa]"  id="compraventa" value="<?=$pago->getcompraventa()?>">
            <input type="hidden" name="pago[idPago]" id="idPago" value="<?=$pago->getidPago()?>">
        </fieldset>
    </form>
</div>