<label class="titulo_prin">Cobro</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_cobro_compraventa" method="post">
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
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nueva_compraventa/<?=$cobro->getcompraventa()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="cobro[compraventa]"  id="compraventa" value="<?=$cobro->getcompraventa()?>">
            <input type="hidden" name="cobro[idCobro]" id="idCobro" value="<?=$cobro->getidCobro()?>">
        </fieldset>
    </form>
</div>