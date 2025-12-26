<form action="<?= DIRECTORIO ?>nuevo_movimiento" method="post" id = "hola">
<?php if (isset($movimiento)) :?>    
        <input type="hidden" name="data[movimiento][idMovimiento]" id='id_movimiento' value="<?= $movimiento->getidMovimiento()?>"><!--no se puede poner aqui (isset($movimiento) ? $movimiento->getidMovimiento() : '' porque se crearia la variable data[movimiento][idMovimiento] cuando es un nuevo movimiento y el repository lo detectaria como una edicion de un mov existente-->
<?php endif ;?>          
<div class="container mt-1">
    <div class="row">
        <div class="col">
            <h5 class="titulo_prin"><?= (isset($movimiento)) ? 'Modificar ' : 'Nuevo '?>Movimiento</h5>
        </div>
        <div class="col text-end">  <!--en un onclick en cuanto se hace un return no sigue ejecutando instrucciones p.e no puedo mostrar un mensaje con return confirm('') y luego hacer algo mas, lo que venga despues no se ejecuta-->
            <input type="button" class="boton_link" id = "salir" value = "Salir">   
            <button type="submit" class="boton_submit disable" onclick = "return comprobarEntidades(this.form)" id = "botonGuardar" disabled> <?= (isset($movimiento)) ? 'Guardar' : 'Crear' ?></button>
            <button type="reset" class="boton_submit" <?= (isset($movimiento)) ? 'hidden' : ''?>>Limpiar</button>
            <button type="button" class="boton_submit" <?= (isset($movimiento)) ? '' : 'hidden'?> id = "eliminar" >Eliminar</button> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">    
            <div class="form-floating mb-1">
                <input type="date" name="data[movimiento][fecha]" class="form-control" id="fecha" placeholder="Fecha" value="<?=(isset($movimiento))?$movimiento->getfecha():''?>" required> 
                <label for="fecha">Fecha</label>
            </div>
        </div>
        <?php
            $enviaActual = isset($movimiento) ? $movimiento->getenvia() : '';//estoy editando un movimiento
            foreach ($empresas as $empresa){
                $listaEmpresas[$empresa->getId()] = $empresa->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
        <div class="col-md-3">
            <label for="select-envia" class="form-label">Envia</label>
            <div class="form-floating mb-1">
                <select  name="data[movimiento][envia]" class="form-select" id="select_envia" required>
                    <option value="" disabled <?= $enviaActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option><!--hay que ponerle value="" para que el required funcione, asi el navegador entiende que si no se elije nada el valor es "" y te avisa, sino se pone, no tiene ningun valor y no avisa-->
                    <?php foreach ($listaEmpresas as $id => $empresa): ?>
                        <option value="<?= $id?>" <?= $id == $enviaActual ? 'selected' : '' ?>><?= $empresa ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <?php
            $recibeActual = isset($movimiento) ? $movimiento->getrecibe() : '';//estoy editando un movimiento
        ?>
        <div class="col-md-3">
            <label for="select-recibe" class="form-label">Recibe</label>
            <div class="form-floating mb-1">
                <select name="data[movimiento][recibe]" class="form-select" id="select_recibe" required>
                    <option value="" disabled <?= $recibeActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($listaEmpresas as $id => $empresa): ?>
                        <option value="<?= $id?>" <?= $id == $recibeActual ? 'selected' : '' ?>><?= $empresa ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
    </div> 
    <div class="row">  
        <div class="col-md-4">
            <div class="form-floating mb-1">
                <input type="text" name="data[movimiento][concepto]" class="form-control" id="concepto" placeholder="Concepto" value="<?=(isset($movimiento))?quitaEspecialChar($movimiento->getconcepto()):''?>" required>
                <label for="concepto">Concepto</label>
            </div>
        </div>           
        <div class="col-md-6">
            <div class="form-floating mb-1">
                <input type="text" name="data[movimiento][observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($movimiento))?quitaEspecialChar($movimiento->getobservaciones()):''?>">
                <label for="concepto">Observaciones</label>
            </div>
        </div>  
    </div>
    <div class="row">
        <?php
            $vehiculoActual = isset($movimiento) ? $movimiento->getvehiculo() : '';//estoy editando un movimiento
            $vehiculoActual = $vehiculoActual!=0 ? $vehiculoActual : '';//getvehiculo devuelve un numero (int), si no existe el vehiculo devuelve un 0 (CAMPOS_MOVIMIENTO lo pone a cero)
            if ($vehiculoActual != ''){
                    $vehiculoActualMostrar =  htmlspecialchars($movimiento->getvehiculoInfo()->getMarca_modelo().' '.$movimiento->getvehiculoInfo()->getMatricula().' '. $movimiento->getvehiculoInfo()->getBastidor());    
                }else $vehiculoActualMostrar = '';
        ?>
        <div class="col-md-6">
            <label for="select-vehiculo" class="form-label">Vehiculo</label>
            <div class="form-floating mb-1">
                <select name="data[movimiento][vehiculo]" class="form-select" id="select_vehiculo" data-placeholder = "Movim. pago vehiculo" style="width: 100%">
                    <option value=""></option>
                    <option value = <?= $vehiculoActual ?> selected><?= $vehiculoActualMostrar ?></option>
                </select> 
            </div>
        </div>
        <!-- esto es para mostrar un cuadro de texto con el nombre, matricula, bastidor del coche para poder seleccionarlo y Copiar Pegar, ya que en la lista despleg no me deja seleccionar y copiar.
         Lo cargo con el coche que hay seleccionado en la lista desplegable, tengo que comprobar que haya un vehiculo en la lista despleg -->
        <div class="col-md-4">
            <input size = 40 type="text" id="copiaVehiculo" value = "<?=isset($movimiento) ? ($vehiculoActual!='' ? $vehiculoActualMostrar : '') : '' ?>"><!--si existe movimiento=>($vehiculoActual!='' ? $listaVehiculos[$vehiculoActual] : '') compuebo si $vehiculoActual no es '' porque puede ser que el movimiento no tenga vehiculo-->
        </div>         
        <div class="col-md-2">
            <label class="etiqueta" for="terminado" >Finalizado:</label>
            <input class="cuadro_text" type="checkbox" name="data[movimiento][terminado]" id="terminado" <?=isset($movimiento) ? (($movimiento->getterminado()==1) ? 'checked' : '') : '' ?>><!--si estoy editando existe movimiento evalua esto ($movimiento->getterminado()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final-->
        </div>         
    </div>
</div>
</form>
<?php if (isset($movimiento)) :?>
    <!--Entrega formulario-->
    <button type="button" class="boton_link small" id="boton_form_entrega" onclick="mostrar('entrega')">+</button>
    <form action="<?= DIRECTORIO ?>nueva_entrega" method="post" id="entrega" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva entrega</legend>
            <div class="row">       
                <div class="col-md-6">
                    <label class="etiqueta" for="fecha" >Fecha:</label>
                    <input class="cuadro_text" type="date" name="entrega[fecha]" id="entrega_fecha" placeholder="Fecha" required>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="text" name="entrega[importe]" id="entrega_importe" placeholder="Importe" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_envia" >Banco envia:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[bancoEnvia]" id="entrega_banco_envia" placeholder="Banco envia">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_recibe" >Banco envia:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[bancoRecibe]" id="entrega_banco_recibe" placeholder="Banco recibe">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="entrega[observaciones]" id="entrega_observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="boton_submit" id = "guardarEntrega">Guardar entrega</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div> 
            <input type="hidden" name="entrega[movimiento]" value="<?=$movimiento->getidMovimiento()?>" id="id_movimiento">
        </fieldset>
    </form>

    <!--Entregas listado-->
    <div class="container mt-1"><!--esto desplaza a la derecha un poco todo lo que haya dentro, tablas, etiquetas etc-->
        <div id = "entregas">
            <table class = "mi_tabla w400" >
                <caption>Entregas</caption>
                <colgroup>
                    <col style="width: 80px;">
                    <col style="width: 90px;">
                    <col style="width: 120px;">
                    <col style="width: 120px;">
                    <col style="width: 140px;">
                    <col style="width: 80px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Banco Envia</th>
                        <th>Banco Recibe</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalEntrega = 0; ?>
                    <?php foreach ($entregas as $entrega) :?>
                        <tr>
                            <td><?= formatea_fecha($entrega->getfecha())?></td>
                            <td><?= number_format($entrega->getimporte(), 2, ',', '.');?>€</td>
                            <td><?= $entrega->getbancoEnvia()?></td>
                            <td><?= $entrega->getbancoRecibe()?></td>
                            <td><?= $entrega->getobservaciones()?></td>
                            <?php $totalEntrega += $entrega->getimporte();?>
                            <td><div class="btn-group" role="group">
                                <a href="<?= DIRECTORIO ?>editar_entrega/<?=$entrega->getidEntrega()?>?movimiento=<?=$movimiento->getidMovimiento()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="../borrar_entrega/<?=$entrega->getidEntrega()?>?movimiento=<?=$movimiento->getidMovimiento()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta entrega?');">
                                    <i class="bi bi-trash"></i>
                                </a>   
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ;?>
                    <tr>
                        <td>Suma:</td>
                        <td><?=number_format($totalEntrega, 2, ',', '.')?>€</td>
                    </tr>
                </tbody>
            </table>
        
        </div>
    </div>
    <!--Devolucion formulario-->
    <button type="button" class="boton_link small" id="boton_form_devolucion" onclick="mostrar('devolucion')">+</button>
    <form action="<?= DIRECTORIO ?>nueva_devolucion" method="post" id="devolucion" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva devolucion</legend>
            <div class="row">       
                <div class="col-md-6">
                    <label class="etiqueta" for="fecha" >Fecha:</label>
                    <input class="cuadro_text" type="date" name="devolucion[fecha]" id="devolucion_fecha" placeholder="Fecha" required>
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="text" name="devolucion[importe]" id="devolucion_importe" placeholder="Importe" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_envia" >Banco envia:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[bancoEnvia]" id="devolucion_banco_envia" placeholder="Banco envia">
                </div> 
                <div class="col-md-6">
                    <label class="etiqueta" for="banco_recibe" >Banco recibe:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[bancoRecibe]" id="devolucion_banco_recibe" placeholder="Banco recibe">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label class="etiqueta" for="observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="devolucion[observaciones]" id="devolucion_observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="boton_submit" id = "guardarDevolucion" >Guardar devolución</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
                </div>
            </div>
            <input type="hidden" name="devolucion[movimiento]" value="<?=$movimiento->getidMovimiento()?>" id="id_movimiento">
        </fieldset>
    </form>
    <!--Devoluciones listado-->
    <div class="container mt-1">
        <div id = "devoluciones">
            <table class = "mi_tabla w400" >
                <caption>Devoluciones</caption>
                <colgroup>
                    <col style="width: 80px;">
                    <col style="width: 90px;">
                    <col style="width: 120px;">
                    <col style="width: 120px;">
                    <col style="width: 140px;">
                    <col style="width: 80px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Banco Envia</th>
                        <th>Banco Recibe</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalDevolucion = 0; ?>
                    <?php foreach ($devoluciones as $devolucion) :?>
                        <tr>
                            <td><?= formatea_fecha($devolucion->getfecha())?></td>
                            <td><?= number_format($devolucion->getimporte(), 2, ',', '.');?>€</td>
                            <td><?= $devolucion->getbancoEnvia()?></td>
                            <td><?= $devolucion->getbancoRecibe()?></td>
                            <td><?= $devolucion->getobservaciones()?></td>
                            <?php $totalDevolucion += $devolucion->getimporte();?>
                            <td><div class="btn-group" role="group">
                                <a href="<?= DIRECTORIO ?>editar_devolucion/<?=$devolucion->getidDevolucion()?>?movimiento=<?=$movimiento->getidMovimiento()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="../borrar_devolucion/<?=$devolucion->getidDevolucion()?>?movimiento=<?=$movimiento->getidMovimiento()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta devolucion?');">
                                    <i class="bi bi-trash"></i>
                                </a>   
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ;?>
                    <tr>
                        <td>Suma:</td>
                        <td><?=number_format($totalDevolucion, 2, ',', '.')?>€</td>
                    </tr>
                </tbody>
            </table>
            <p class='etiqueta'><strong>Diferencia entregas - devoluciones: <?=number_format(($totalEntrega-$totalDevolucion), 2, ',', '.')?>€</strong></p>
        </div>
    </div>
<?php endif ;?>
<script>
    $(document).ready(function() {
        /* desplegable vehiculo con jQuery Ajax */
        selectAjaxVehiculos(document.getElementById('select_vehiculo'));
        /*para controlar el gardar formulario */
        var estadoFormulario = { modificado: false };
        guardarDatos(document.forms[0], '<?= DIRECTORIO ?>movimientos?num_pagina=1', estadoFormulario);
        /*esto de abajo equivale a poner en el boton submit esto: onclick= "escribirLocalStorage('entrega'); return validar_entero_campo_text(form.entrega_importe)"*/
        var form = document.getElementById("entrega");
        var boton = document.getElementById("guardarEntrega");//al evento onclick del boton guardarEntrega le asigna la llamada a la funcion escribirLocalStorege y validar_entero
        boton.addEventListener("click", function (event) {
            escribirLocalStorage("entrega");//escribe en locastorage para saber que la proxima vez tiene que mostrar el formulario entrega
            if (!validar_entero_campo_text(form.entrega_importe)) {
                event.preventDefault(); // evita que se envíe el form
            }
        });
        var form2 = document.getElementById("devolucion");
        var boton2 = document.getElementById("guardarDevolucion");
        boton2.addEventListener("click", function (event) {//event es el parametro de la funcion y es el evento "click"
            escribirLocalStorage("devolucion");
            if (!validar_entero_campo_text(form2.devolucion_importe)) {
                return false;//event.preventDefault(); // evita que se envíe el form
            }
        });
        mostrarEntregaDevolucion();//cada vez que carga el la pagina comprueba si hay que mostrar el form entregas o devoluciones
        //aunque se puede hacer eso eliminar.addEventListener("click", ... no es una buena practica, hay navegadores que no lo soportan, o si este script estuviera en el HEAD no reconoceria eliminar porque aun no se ha cargado el HTML 
        document.getElementById("eliminar").addEventListener("click", function (event) {
            if (confirm('Estas seguro que quieres borrar este movimiento?')){
                window.location.href='<?= DIRECTORIO ?>borrar_movimiento/<?= isset($movimiento) ? $movimiento->getidMovimiento() : ''?>'; 
            } else {
                event.preventDefault();
                }
        });
    });
</script>
