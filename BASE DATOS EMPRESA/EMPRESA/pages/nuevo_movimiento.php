<form action="<?= DIRECTORIO ?>nuevo_movimiento" method="post">
    <?php if (isset($movimiento)) :?>
    <input type="hidden" name="data[movimiento][idMovimiento]" id='id_movimiento' value="<?=$movimiento->getidMovimiento()?>">
    <?php endif;?>      
<div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($movimiento)) ? 'Modificar ' : 'Nuevo '?>Movimiento</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>movimientos?num_pagina=1';">   
                <button type="submit" class="boton_submit"> <?= (isset($movimiento)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($movimiento)) ? 'hidden' : ''?>>Borrar</button>
            </div>
        </div>
    <div class="row">
        <div class="col-md-4">    
            <div class="form-floating mb-1">
                <input type="date" name="data[movimiento][fecha]" class="form-control" id="fecha" placeholder="Fecha" value="<?=(isset($movimiento))?$movimiento->getfecha():''?>" required> 
                <label for="fecha">Fecha</label>
            </div>
        </div>
        <?php
            $enviaActual = isset($movimiento) ? $movimiento->getenvia() : '';//estoy editando un movimiento
            foreach ($entidades as $entidad){
                $lista[$entidad->getId()] = $entidad->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
        <div class="col-md-3">
            <label for="select-envia" class="form-label">Envia</label>
            <div class="form-floating mb-3">
                <select name="data[movimiento][envia]" class="form-select" id="select-envia" required>
                    <option disabled <?= $enviaActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($lista as $id => $entidad): ?>
                        <option value="<?= $id?>" <?= $id == $enviaActual ? 'selected' : '' ?>><?= $entidad ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <?php
            $recibeActual = isset($movimiento) ? $movimiento->getrecibe() : '';//estoy editando un movimiento
        ?>
        <div class="col-md-3">
            <label for="select-recibe" class="form-label">Recibe</label>
            <div class="form-floating mb-3">
                <select name="data[movimiento][recibe]" class="form-select" id="select-recibe" required>
                    <option disabled <?= $recibeActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($lista as $id => $entidad): ?>
                        <option value="<?= $id?>" <?= $id == $recibeActual ? 'selected' : '' ?>><?= $entidad ?></option>
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
        
        <div class="col-md-4">
            <div class="form-floating mb-1">
                <input type="text" name="data[movimiento][observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($movimiento))?quitaEspecialChar($movimiento->getobservaciones()):''?>">
                <label for="concepto">Observaciones</label>
            </div>
        </div> 
        <?php
            $vehiculoActual = isset($movimiento) ? $movimiento->getvehiculo() : '';//estoy editando un movimiento
            $vehiculoActual = $vehiculoActual!=0 ? $vehiculoActual : '';//getvehiculo devuelve un numero, si no existe el vehiculo devuelve un 0 (CAMPOS_MOVIMIENTO lo pone a cero)
            foreach ($vehiculos as $vehiculo){
                $listaVehiculos[$vehiculo->getId()] = $vehiculo->getMarca_modelo();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
        <div class="col-md-3">
            <label for="select-vehiculo" class="form-label">Vehiculo</label>
            <div class="form-floating mb-3">
                <select name="data[movimiento][vehiculo]" class="form-select" id="select-vehiculo">
                    <option disabled <?= $vehiculoActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($listaVehiculos as $id => $vehiculo): ?>
                        <option value="<?= $id?>" <?= $id === $vehiculoActual ? 'selected' : '' ?>><?= $vehiculo ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>          
    </div>
</div>
</form>
<!--Entrega formulario-->
<button type="button" class="boton_link small" id="boton_form_entrega" onclick="mostrar('form_entrega')">+</button>
<form action="<?= DIRECTORIO ?>nueva_entrega" method="post" id="form_entrega" hidden>
    <fieldset class="mi-fieldset">
        <legend class="mi-legend">Nueva entrega</legend>
        <div class="row">       
            <div class="col-md-6">
                <label class="etiqueta" for="fecha" >Fecha:</label>&nbsp
                <input class="cuadro_text" type="date" name="entrega[fecha]" id="entrega_fecha" placeholder="Fecha" required>
            </div>
            <div class="col-md-4">
                <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                <input class="cuadro_text" type="text" name="entrega[importe]" id="entrega_importe" placeholder="Importe" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="etiqueta" for="banco_envia" >Banco envia:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="entrega[bancoEnvia]" id="entrega_banco_envia" placeholder="Banco envia">
            </div>
            <div class="col-md-6">
                <label class="etiqueta" for="banco_recibe" >Banco envia:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="entrega[bancoRecibe]" id="entrega_banco_recibe" placeholder="Banco recibe">
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <label class="etiqueta" for="observaciones" >Observaciones:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="entrega[observaciones]" id="entrega_observaciones" placeholder="Observaciones">
            </div>
            <div class="col-md-4">
                <button type="submit" class="boton_submit" onclick= "return validar_entero_campo_text(form.entrega_importe)" >Guardar entrega</button>
                <button type="reset" class="boton_submit">Borrar</button>
            </div>
        </div> 
        <input type="hidden" name="entrega[movimiento]" value="<?=$movimiento->getidMovimiento()?>" id="id_movimiento">
    </fieldset>
</form>

<!--Entregas listado-->
<div class="container mt-1"><!--esto desplaza a la derecha un poco todo lo que haya dentro, tablas, etiquetas etc-->
    <div id = "entregas">
        <table class = "mi_tabla" >
            <caption>Entregas</caption>
            <colgroup>
                <col style="width: 100px;">
                <col style="width: 120px;">
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
<button type="button" class="boton_link small" id="boton_form_devolucion" onclick="mostrar('form_devolucion')">+</button>
<form action="<?= DIRECTORIO ?>nueva_devolucion" method="post" id="form_devolucion" hidden>
    <fieldset class="mi-fieldset">
        <legend class="mi-legend">Nueva devolucion</legend>
        <div class="row">       
            <div class="col-md-6">
                <label class="etiqueta" for="fecha" >Fecha:</label>&nbsp
                <input class="cuadro_text" type="date" name="devolucion[fecha]" id="devolucion_fecha" placeholder="Fecha" required>
            </div>
            <div class="col-md-4">
                <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                <input class="cuadro_text" type="text" name="devolucion[importe]" id="devolucion_importe" placeholder="Importe" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="etiqueta" for="banco_envia" >Banco envia:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="devolucion[bancoEnvia]" id="devolucion_banco_envia" placeholder="Banco envia">
            </div> 
            <div class="col-md-6">
                <label class="etiqueta" for="banco_recibe" >Banco recibe:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="devolucion[bancoRecibe]" id="devolucion_banco_recibe" placeholder="Banco recibe">
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <label class="etiqueta" for="observaciones" >Observaciones:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="devolucion[observaciones]" id="devolucion_observaciones" placeholder="Observaciones">
            </div>
            <div class="col-md-4">
                <button type="submit" class="boton_submit" onclick= "return validar_entero_campo_text(form.devolucion_importe)" >Guardar devolución</button>
                <button type="reset" class="boton_submit">Borrar</button>
            </div>
        </div>
        <input type="hidden" name="devolucion[movimiento]" value="<?=$movimiento->getidMovimiento()?>" id="id_movimiento">
    </fieldset>
</form>
<!--Devoluciones listado-->
<div class="container mt-1">
    <div id = "devoluciones">
        <table class = "mi_tabla" >
            <caption>Devoluciones</caption>
            <colgroup>
                <col style="width: 100px;">
                <col style="width: 120px;">
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

<script>
    $(document).ready(function() {
        $('#select-recibe').select2({
            placeholder: "Buscar recibe",
            allowClear: true,
            width: '100%'
        });
    
        $('#select-envia').select2({
            placeholder: "Buscar envia",
            allowClear: true,
            width: '100%'
        });
        $('#select-vehiculo').select2({
            placeholder: "Buscar vehiculo",
            allowClear: true,
            width: '100%'
        });
    });
</script>