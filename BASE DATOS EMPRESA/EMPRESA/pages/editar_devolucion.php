<label class="titulo_prin">Devolucion</label>
    <form action="<?= DIRECTORIO ?>nueva_devolucion" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar devolución</legend>
            <div class="row">
                  <div class="col-md-4">
                    <label class="etiqueta" for="fecha">Fecha:</label>
                    <input class="cuadro_text" type="date" name="devolucion[fecha]" id="fecha" value="<?=$devolucion->getfecha()?>" required>
                </div>       
                <div class="col-md-4">
                    <label class="etiqueta" for="importe">Importe:</label>
                    <input class="cuadro_text" type="texto" name="devolucion[importe]" id="importe" placeholder="Importe" value="<?=$devolucion->getimporte()?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_envia">Banco Envia:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[bancoEnvia]" id="banco_envia" placeholder="Banco Envia" value="<?=quitaEspecialChar($devolucion->getbancoEnvia())?>">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_recibe">Banco recibe:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[bancoRecibe]" id="banco_recibe" placeholder="Banco recibe" value="<?=quitaEspecialChar($devolucion->getbancoRecibe())?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label class="etiqueta" for="Observaciones">Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[observaciones]" id="observaciones" placeholder="Observaciones" value="<?=quitaEspecialChar($devolucion->getobservaciones())?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar devolución</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_movimiento/<?=$devolucion->getMovimiento()?>';"><!--regreso al movimiento que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->
                </div>
            </div>
                <input type="hidden" name="devolucion[movimiento]"  id="movimiento" value="<?=$devolucion->getMovimiento()?>">
                <input type="hidden" name="devolucion[idDevolucion]" id="id_devolucion" value="<?=$devolucion->getidDevolucion()?>">
        </fieldset>
    </form>