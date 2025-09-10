<label class="titulo_prin">&nbsp&nbsp&nbsp&nbspEntrega</label>
    <form action="<?= DIRECTORIO ?>nueva_entrega" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar entrega</legend>
            <div class="row">
                  <div class="col-md-4">
                    <label class="etiqueta" for="fecha">Fecha:</label>&nbsp
                    <input class="cuadro_text" type="date" name="entrega[fecha]" id="fecha" value="<?=$entrega->getfecha()?>" required>
                </div>       
                <div class="col-md-4">
                    <label class="etiqueta" for="importe">Importe:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="entrega[importe]" id="importe" placeholder="Importe" value=<?=$entrega->getimporte()?> required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_envia">Banco Envia:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[bancoEnvia]" id="banco_envia" placeholder="Banco Envia" value="<?=quitaEspecialChar($entrega->getbancoEnvia())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_recibe">Banco recibe:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[bancoRecibe]" id="banco_recibe" placeholder="Banco recibe" value="<?=quitaEspecialChar($entrega->getbancoRecibe())?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label class="etiqueta" for="Observaciones">Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[observaciones]" id="observaciones" placeholder="Observaciones" value="<?=quitaEspecialChar($entrega->getobservaciones())?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar entrega</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_movimiento/<?=$entrega->getMovimiento()?>';"><!--regreso al movimiento que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
                <input type="hidden" name="entrega[movimiento]"  id="movimiento" value="<?=$entrega->getMovimiento()?>">
                <input type="hidden" name="entrega[idEntrega]" id="id_entrega" value="<?=$entrega->getidEntrega()?>">
        </fieldset>
    </form>
