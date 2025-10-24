<label class="titulo_prin">Gasto</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_gasto_compraventa" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar Gasto</legend>
            <div class="row">
                <div class="col-md-7">
                    <label class="etiqueta" for="tipo" >Tipo:</label>
                    <input size = "80" class="cuadro_text" type="text" name="gasto[tipo]" id="tipo" placeholder="Tipo" value="<?=quitaEspecialChar($gasto->gettipo())?>" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="texto" name="gasto[importe]" id="importe" placeholder="Importe" value="<?=$gasto->getimporte()?>" required>
                </div>
                <div class="col-md-3">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="text" name="gasto[fecha]" id="fecha" value="<?=$gasto->getfecha()?>" required>
                </div>        
                
                <div class="col-md-2">
                    <label class="etiqueta" for="pagaOtro" >Paga Otro:</label>
                    <input class="cuadro_text" type="checkbox" name="gasto[pagaOtro]" id="pagaOtro" <?=($gasto->getpagaOtro()) ? 'checked' : ''?>>
                </div>
                
                <div class="col-md-2">
                    <label class="etiqueta" for="pagado" >Pagado:</label>
                    <input class="cuadro_text" type="checkbox" name="gasto[pagado]" id="pagado" <?=($gasto->getpagado()==1) ? 'checked' : ''?>>
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="gasto[observaciones]" id="observaciones" placeholder="Observaciones" value="<?=quitaEspecialChar($gasto->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nueva_compraventa/<?=$gasto->getcompraventa()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="gasto[compraventa]"  id="compraventa" value="<?=$gasto->getcompraventa()?>">
            <input type="hidden" name="gasto[idGasto]" id="idGasto" value="<?=$gasto->getidGasto()?>">
        </fieldset>
    </form>
</div>