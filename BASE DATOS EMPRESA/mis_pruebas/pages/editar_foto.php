<label class="titulo_prin">Foto</label>
<form action="<?= DIRECTORIO ?>nueva_foto" method="post">
    <fieldset class="mi-fieldset">
    <legend class="mi-legend">Editar Foto</legend>
        <div class="row">
            <div class="col-md-2">
                <label class="etiqueta" for="destacada">Destacada:</label>  
                <input type="checkbox" name="foto[destacada]" id="destacada" <?=($foto->getdestacada()) ? 'checked' :''?> >
            </div>
            <div class="col-md-6">
                <label class="etiqueta" for="descripcion">Descripcion: </label>
                <input  type="text" size="75" name="foto[descripcion]" id="descripcion" value="<?=quitaEspecialChar($foto->getdescripcion())?>">
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="boton_submit">Guardar</button>
            <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_vehiculo/<?=$foto->getid_vehiculo()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->  
        </div>
        <input type="hidden" name="foto[id_vehiculo]" value="<?=$foto->getid_vehiculo()?>" id="id_vehiculo">
        <input type="hidden" name="foto[id]" value="<?=$foto->getid()?>" id="id_gasto">
</fieldset>
</form>
