<p class="titulo_prin">&nbsp&nbsp&nbsp&nbspCuota</p>
<div>
    <form action="<?= DIRECTORIO ?>nueva_cuota_vehiculo" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Editar Cuota</legend>
            <?php
                $cuota_actual = $cuota->gettipo();
                $tipoCuota = ['Renting', 'Financiado'];
            ?>
            <div class="row">  
                <div class="col-md-3">
                    <select name="cuota[tipo]" class="form-select" id="tipo" required>
                        <option value="" disabled>--Seleccione tipo--</option> 
                        <?php foreach ($tipoCuota as $opcion): ?>
                            <option value="<?= $opcion ?>" <?= $opcion === $cuota_actual ? 'selected' : ''?>><?= $opcion ?></option>
                        <?php endforeach; ?>
                    </select> 
                    <label for="tipo">Tipo cuota</label>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Fecha inicio:</label>
                    <input class="cuadro_text" type="date" name="cuota[inicio]" id="inicio" placeholder="Fecha inicio" value = "<?= $cuota->getinicio()?>">
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="duracion" >Duracion:</label>
                    <input class="cuadro_text" type="number" name="cuota[duracion]" id="duracion" placeholder="Meses" value = "<?= $cuota->getduracion()?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label class="etiqueta" for="cuota" >Cuota:</label>
                    <input class="cuadro_text" type="text" name="cuota[cuota]" id="cuota" value = "<?= $cuota->getcuota()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="totalPagar" >Total pagar:</label>
                    <input class="cuadro_text" type="text" name="cuota[totalPagar]" id="totalPagar" value = "<?= $cuota->gettotalPagar()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="pagoFinal" >Pago final:</label>
                    <input class="cuadro_text" type="text" name="cuota[pagoFinal]" id="pagoFinal" value = "<?= $cuota->getpagoFinal()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="entrada" >Entrada:</label>
                    <input class="cuadro_text" type="text" name="cuota[entrada]" id="entrada" value = "<?= $cuota->getentrada()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="fianza" >Fianza:</label>
                    <input class="cuadro_text" type="text" name="cuota[fianza]" id="fianza" value = "<?= $cuota->getfianza()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="km" >Kilometros:</label>
                    <input class="cuadro_text" type="number" name="cuota[km]" id="km" value = "<?= $cuota->getkm()?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label class="etiqueta" for="kmAno" >Km año:</label>&nbsp
                    <input class="cuadro_text" type="number" name="cuota[kmAno]" id="kmAno" value = "<?= $cuota->getkmAno()?>">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="financiera" >Financiera:</label>&nbsp
                    <input class="cuadro_text" type="text" name="cuota[financiera]" id="financiera" value = "<?=quitaEspecialChar($cuota->getfinanciera())?>">
                </div>
                <?php
                    $titularActual = $cuota->getid_entidad();
                    foreach ($entidades as $entidad){
                        $listaTitulares[$entidad->getId()] = $entidad->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
                    }
                ?>
                <div class="col-md-3">
                    <label for="select-titular-cuota" class="etiqueta">Titular</label>
                    <div class="form-floating mb-3">
                        <select name="cuota[titular]" class="form-select" id="select-titular-cuota" required>
                            <option value="" disabled>--Selecc. opcion--</option><!--hay que poner value="" para que el required funcione, de lo contrario si deja enviar sin elegir nada -->
                            <?php foreach ($listaTitulares as $id => $titular): ?>
                                <option value="<?= $id?>" <?= $titularActual == $id ? 'selected' : ''?>><?=$titular?></option><!--OJO comparar con el $id no con el $titular-->
                            <?php endforeach; ?>
                        </select> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>&nbsp
                    <input size=80 class="cuadro_text" type="text" name="cuota[observaciones]" id="observaciones" placeholder="Observaciones" value = "<?=quitaEspecialChar($cuota->getobservaciones())?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validarCuotas(this.form)">Guardar Cuota</button>
                    <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_vehiculo/<?=$cuota->getid_vehiculo()?>';"><!--regreso al vehiculo que estaba con DIRECTORIO/nuevo_vehiculo/$foto->getid_vehiculo()-->  
                </div>
            </div>
            <input type="hidden" name="cuota[id_vehiculo]" value="<?=$cuota->getid_vehiculo()?>" id="id_veviculo">
            <input type="hidden" name="cuota[idCuota]" value="<?=$cuota->getidCuota()?>" id="id_cuota">
        </fieldset>
    </form>  
</div>
<script>
    $(document).ready(function() {
        $('#select-titular-cuota').select2({
            placeholder: "Buscar titular",
            allowClear: true,
            width: '100%'
        });
    });
</script>