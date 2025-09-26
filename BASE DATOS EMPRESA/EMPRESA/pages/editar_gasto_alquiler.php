<label class="titulo_prin">&nbsp&nbsp&nbsp&nbspGasto</label>
<div>
    <form action="<?= DIRECTORIO ?>nuevo_gasto_alquiler" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar Gasto</legend>
            <div class="row">
                <div class="col-md-4">
                    <label for="fecha" class="etiqueta">Fecha:</label> 
                    <input class="cuadro_text" type="text" name="gasto[fecha]" id="fecha" value="<?=$gasto->getfecha()?>" required>
                </div>        
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="gasto[importe]" id="importe" placeholder="Importe" value="<?=$gasto->getimporte()?>" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="facturado" >Facturado:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[facturado]" id="facturado" <?=($gasto->getfacturado()) ? 'checked' : ''?>>
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="facturadoA" >Facturado A:</label>
                    <input size=60 class="cuadro_text" type="text" name="gasto[facturadoA]" id="facturadoA" placeholder="Facturado A" value="<?=quitaEspecialChar($gasto->getfacturadoA())?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="pagado" >Pagado:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[pagado]" id="pagado" <?=($gasto->getPagado()==1) ? 'checked' : ''?>>
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="comentarios" >Comentarios:</label>
                    <input size=60 class="cuadro_text" type="text" name="gasto[comentarios]" id="comentarios" placeholder="Comentarios" value="<?=quitaEspecialChar($gasto->getComentarios())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar Gasto</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_vehiculo/<?=$gasto->getId_vehiculo()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="gasto[id_vehiculo]"  id="id_vehiculo" value="<?=$gasto->getId_vehiculo()?>">
            <input type="hidden" name="gasto[id_gasto]" id="id_gasto" value="<?=$gasto->getId_gasto()?>">
        </fieldset>
    </form>
</div>