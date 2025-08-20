
<label class="titulo_prin">&nbsp&nbsp&nbsp&nbspFoto</label>
    
<?php $destacada = $foto->getdestacada()?>
<form action="<?= DIRECTORIO ?>nueva_foto" method="post">
    <fieldset class="mi-fieldset">
    <legend class="mi-legend">Editar Foto</legend>
        <div class="row">
            <div class="col-md-2">
                <label class="etiqueta" for="destacada">Destacada:</label>  
                <input type="checkbox" name="foto[destacada]" id="destacada" <?=(isset($destacada))? 'checked' :''?> >
            </div>
            <div class="col-md-6">
                <label class="etiqueta" for="descripcion">Descripcion: </label>
                <input  type="text" size="75" name="foto[descripcion]" id="descripcion" value="<?=$foto->getdescripcion()?>">
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="boton_submit">Guardar</button>
        </div>
        <input type="hidden" name="foto[id_vehiculo]" value="<?=$foto->getid_vehiculo()?>" id="id_veviculo">
        <input type="hidden" name="foto[id]" value="<?=$foto->getid()?>" id="id">
</fieldset>
</form>
