<?php if (!empty($_GET['mensaje'])): ?>
    <div class = "mensajeGuardar <?=htmlspecialchars($_GET['tipo'] ?? '')?>" id = "mensaje">
        <?= htmlspecialchars($_GET['mensaje']) ?>
    </div>
<?php endif; ?>
<form action="<?= DIRECTORIO ?>nuevo_seguro" method="post" id = "nuevoSeguro">
    <?php if (isset($seguro)) :?>
        <input type="hidden" name="data[idSeguro]" id='idSeguro' value="<?=$seguro->getidSeguro()?>">
    <?php endif;?> 
      
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($seguro)) ? 'Modificar ' : 'Nuevo '?>Seguro</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" id = "salir">    
                <button type="submit" class="boton_submit disable" id ="botonGuardar" disabled onclick = "return validarTablaEnteros([this.form.importe])"> <?= (isset($seguro)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($seguro)) ? 'hidden' : ''?>>Limpiar</button>
            </div>
        </div>
        <div class="row">
            <?php
                $vehiculoActual = isset($seguro) ? ($seguro->getvehiculo() != 0 ? $seguro->getvehiculo() : '' ) : '';
                //las funciones que devuelven un int si hay un '' devuelve 0 en lugar de ''
                if ($vehiculoActual != ''){
                    $vehiculoActualMostrar =  htmlspecialchars($seguro->getvehiculoInfo()->getMarca_modelo().' '.$seguro->getvehiculoInfo()->getMatricula().' '. $seguro->getvehiculoInfo()->getBastidor());
                }else $vehiculoActualMostrar = '';
            ?>
            <div class="col-md-3">
                <label class="form-label">Vehiculo</label>
                <select name="data[vehiculo]" class="form-select" id="select_vehiculo" data-placeholder = "Vehiculo asegurado" style="width: 100%">
                    <option value = ""></option>
                    <option value = <?= $vehiculoActual ?> selected><?= $vehiculoActualMostrar ?></option>
                </select> 
            </div>
            <div class="col-md-3">
                <div class="form-floating mb-1">
                    <input type="text" name="data[otroRiesgo]" class="form-control" id="otroRiesgo" placeholder="otroRiesgo" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getotroRiesgo()):''?>">
                    <label for="otroRiesgo">Otro Riesgo</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[poliza]" class="form-control" id="poliza" placeholder="poliza" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getpoliza()):''?>">
                    <label for="observaciones">Poliza</label>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                $tomadorActual = isset($seguro) ? $seguro->gettomador() : '';//estoy editando
                //$clienteActual = $clienteActual!=0 ? $clienteActual : ''; si el campo no es obligatorio hay que poner esto
                foreach ($empresas as $empresa){
                    $listaEmpresas[$empresa->getId()] = $empresa->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
                }
            ?>
            <div class="col-md-3">
                <label for="select_tomador" class="form-label">Tomador</label>
                <select name="data[tomador]" class="form-select" id="select_tomador" 
                        required>
                    <option value = "" disabled <?= $tomadorActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($listaEmpresas as $id => $empresa): ?>
                        <option value="<?= $id?>" <?= $id == $tomadorActual ? 'selected' : '' ?>><?= $empresa ?></option>
                    <?php endforeach; ?>
                </select>     
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input class="form-control" type="text" name="data[importe]" id="importe" placeholder="importe" value = "<?= (isset($seguro))?$seguro->getimporte():''?>">
                    <label for="importe">Importe</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fecha]" class="form-control" id="fecha" placeholder="Fecha" value="<?=(isset($seguro))?$seguro->getfecha():''?>"> 
                    <label for="fecha">Fecha</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[vencimiento]" class="form-control" id="vencimiento" placeholder="vencimiento" value="<?=(isset($seguro))?$seguro->getvencimiento():''?>"> 
                    <label for="vencimiento">Vencimiento</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[periodo]" class="form-control" id="periodo" placeholder="periodo" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getperiodo()):''?>">
                    <label for="periodo">Periodo</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[cuentaBanco]" class="form-control" id="cuentaBanco" placeholder="cuentaBanco" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getcuentaBanco()):''?>">
                    <label for="cuentaBanco">Cuenta Banco</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[compania]" class="form-control" id="compania" placeholder="compania" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getcompania()):''?>">
                    <label for="compañia">Compañia</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[mediador]" class="form-control" id="mediador" placeholder="mediador" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getmediador()):''?>">
                    <label for="mediador">Mediador</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <label class="etiqueta" for="baja" >Baja</label>
                <input class="cuadro_text" type="checkbox" name="data[baja]" id="baja" <?=isset($seguro) ? (($seguro->getbaja()==1) ? 'checked' : '') : '' ?>>
                <!--si estoy editando existe seguro evalua esto ($seguro->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="date" name="data[fechaBaja]" class="form-control" id="fechaBaja" placeholder="fechaBaja" value="<?=(isset($seguro))?$seguro->getfechaBaja():''?>"> 
                    <label for="fechaBaja">Fecha Baja</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating mb-1">
                    <input type="text" name="data[motivoBaja]" class="form-control" id="motivoBaja" placeholder="motivoBaja" value="<?=(isset($seguro))?$seguro->getmotivoBaja():''?>"> 
                    <label for="motivoBaja">Motivo Baja</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-1">
                    <input type="text" name="data[comentarios]" class="form-control" id="comentarios" placeholder="comentarios" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getcomentarios()):''?>">
                    <label for="comentarios">Observaciones</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[ultimoCambio]" class="form-control" id="ultimoCambio" placeholder="ultimoCambio" value="<?=(isset($seguro))?quitaEspecialChar($seguro->getultimoCambio()):''?>">
                    <label for="ultimoCambio">Ultimo cambio</label>
                </div>
            </div>
        </div>   
    </div>
</form>
<script>
    $(document).ready(function() {
        /* select con AJAX de jQuery version inicial, en general.js esta la version full */
        $('#select_vehiculo').select2({
            /* usa el data-placeholder definido en el select */
            placeholder: $(this).data('placeholder') || 'Buscar...',
            minimumInputLength: 3, //empieza a buscar a partir de 3 caracteres
            allowClear: true,
            ajax: {
                url: '<?= DIRECTORIO ?>buscar_vehiculos_select',
                dataType: 'json',
                delay: 500,//tiempo entre consultas 
                data: function (params) {
                    return { buscar: params.term };//texto escrito en el select por el usuario, se envia como parametro en $_GET['buscar']
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            }, 
            templateResult: formatVehiculoResult,
            templateSelection: formatVehiculoSelection    
        });
        /* esta funcion es para controlar que muestra el select cuando se pincha en el (desplegado)*/
        function formatVehiculoResult(vehiculo){
            //cuando select muestra Buscando....
            if (vehiculo.loading){
                return vehiculo.text; //text es el campo text que se pasa en json
            }
            return $(`
                    <div><strong>${vehiculo.Marca_modelo}</strong><br>
                        <small>
                            Matrícula: ${vehiculo.Matricula},  
                            Bastidor: ${vehiculo.Bastidor}
                        </small>
                    </div>
                    `);
        }
        /* esta funcion es para controlar que muestra el select cuando no se pincha en el (reposo)*/
        function formatVehiculoSelection(vehiculo){
            //cuando el select esta vacio tengo que hacer return vehiculo.text
            /* ver explicacion de mi word */
            if (!vehiculo.Marca_modelo){ //si el select aun no ha cargado nada con ajax el campo Marca_modelo no existe entonces return text para mostrar lo que el select original tiene en el HTML
                return vehiculo.text;//valor de option del select
            }
            /* si hay datos ajax pues los muestro */
            return `${vehiculo.Marca_modelo}, ${vehiculo.Matricula}, ${vehiculo.Bastidor}`;
        }
        /*para controlar el gardar formulario */
        var estadoFormulario = { modificado: false };
        guardarDatos(document.forms[0], '<?= DIRECTORIO ?>seguros?num_pagina=1', estadoFormulario); 
    });
</script>