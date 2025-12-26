<label class="titulo_prin">Ampliacion</label>
<div>
    <form action="<?= DIRECTORIO ?>nueva_ampliacion_alquiler" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar ampliacion</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fechaInicio" class="etiqueta">Fecha inicio:</label> 
                    <input size=40 class="cuadro_text" type="date" name="ampliacion[fechaInicio]" id="fechaInicio" value="<?=$ampliacion->getfechaInicio()?>" required>
                </div>
                <div class="col-md-3">
                    <label for="dias" class="etiqueta">Dias:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[dias]" id="dias" onchange = "actualizaFechaFin(this.form)" placeholder="dias" value="<?=$ampliacion->getdias()?>">
                </div>         
                <div class="col-md-3">
                    <label for="fechaFin" class="etiqueta">Fecha fin:</label> 
                    <input size=40 class="cuadro_text" type="date" name="ampliacion[fechaFin]" id="fechaFin" value="<?=$ampliacion->getfechaFin()?>">
                </div>               
               <div class="col-md-3">
                    <label for="kilometros" class="etiqueta">Kilometros:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[kilometros]" id="kilometros" placeholder="kilometros" value="<?=$ampliacion->getkilometros()?>">
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="precio" >Precio:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[precio]" id="precio" placeholder="precio" value="<?=$ampliacion->getprecio()?>" required>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="comisionComercial" >Comision Comercial:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[comisionComercial]" id="comisionComercial" onchange="actualizaGanancia(this.form)" placeholder="Comision Comercial" value="<?=$ampliacion->getcomisionComercial()?>" >
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="ganancia" >Ganancia:</label>
                    <input class="cuadro_text" type="texto" name="ampliacion[ganancia]" id="ganancia" placeholder="ganancia" value="<?=$ampliacion->getganancia()?>" >
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="Observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="ampliacion[observaciones]" id="Observaciones" placeholder="Observaciones" value="<?=quitaEspecialChar($ampliacion->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validarTablaEnteros([form.dias, form.precio, form.ganancia, form.comisionComercial])">Guardar</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_alquiler/<?=$ampliacion->getalquiler()?>';"><!--regreso al alquiler que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
            <input type="hidden" name="ampliacion[alquiler]"  id="alquiler" value="<?=$ampliacion->getalquiler()?>">
            <input type="hidden" name="ampliacion[idAmpliacion]" id="idAmpliacion" value="<?=$ampliacion->getidAmpliacion()?>">
       </fieldset>
    </form>
</div>