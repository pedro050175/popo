<div><h5><strong>Editar Foto</strong></h5></div>
<?php $destacada = $foto->getdestacada()?>
<form action="/mis_pruebas/pages/nueva_foto" method="post">
    
    Destacada: <input type="checkbox" name="foto[destacada]" id="destacada" <?=(isset($destacada))? 'checked' :''?> ><br/>
    <input type="hidden" name="foto[id]" value="<?=$foto->getid()?>" id="id"><br/>
    Descripcion: <input  type="text" size="100" name="foto[descripcion]" id="descripcion" value="<?=$foto->getdescripcion()?>"><br/><br/>
    <input type="hidden" name="foto[id_vehiculo]" value="<?=$foto->getid_vehiculo()?>" id="id_veviculo"><br/>
    <button type="submit">Guardar</button>
</form>