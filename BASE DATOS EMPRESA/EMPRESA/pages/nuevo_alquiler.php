<form action="<?= DIRECTORIO ?>nuevo_alquiler" method="post">
    <?php if (isset($alquiler)) :?>
    <input type="hidden" name="data[id]" id='id' value="<?=$alquiler->getid()?>">
    <?php endif;?>      
<div class="container mt-1">
    <div class="row">
        <div class="col">
            <h5 class="titulo_prin"><?= (isset($alquiler)) ? 'Modificar ' : 'Nuevo '?>alquiler</h5>
        </div>
        <div class="col text-end">  
            <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>alquileres?num_pagina=1';">   
            <button type="submit" class="boton_submit" onclick = "return validarAlquiler(this.form)"> <?= (isset($alquiler)) ? 'Guardar' : 'Crear' ?></button>
            <button type="reset" class="boton_submit" <?= (isset($alquiler)) ? 'hidden' : ''?>>Borrar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">    
            <div class="form-floating mb-1">
                <p><strong>Id: <?=(isset($alquiler)) ? $alquiler->getid():''?></strong></p> 
            </div>
        </div>
        <div class="col-md-2">    
            <div class="form-floating mb-1">
                <input type="date" name="data[fechaInicio]" class="form-control" id="fechaInicio" placeholder="Fecha inicio" value="<?=(isset($alquiler))?$alquiler->getfechaInicio():''?>" required> 
                <label for="fechaIncio">Fecha inicio</label>
            </div>
        </div>
        <div class="col-md-2"> 
            <div class="form-floating mb-1">
                <input type="date" name="data[fechaFin]" class="form-control" id="fechaFin" placeholder="Fecha fin" value="<?=(isset($alquiler))?$alquiler->getfechaFin():''?>"> 
                <label for="fechaFin">Fecha fin</label>
            </div>
        </div>
        <div class="col-md-2"> 
            <div class="form-floating mb-1">
                <input type="text" name="data[contrato]" class="form-control" id="contrato" placeholder="Contrato" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getcontrato()):''?>" required>
                <label for="contrato">Contrato</label>
            </div>
        </div>
    </div>
        <?php
            $vehiculoActual = isset($alquiler) ? $alquiler->getvehiculo() : '';//estoy editando un alquiler
            $vehiculoActual = $vehiculoActual!=0 ? $vehiculoActual : '';//getvehiculo devuelve un numero, si no existe el vehiculo devuelve un 0 (CAMPOS_alquiler lo pone a cero)
            foreach ($vehiculos as $vehiculo){
                $listaVehiculos[$vehiculo->getId()] = $vehiculo->getMarca_modelo(). ' ' .$vehiculo->getMatricula() . ' ' .$vehiculo->getBastidor();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
    <div class="row">            
        <div class="col-md-4">
            <label for="select_ehiculo" class="form-label">Vehiculo</label>
            <div class="form-floating mb-3">
                <select name="data[vehiculo]" 
                        class="form-select" id="select_vehiculo" 
                        required
                        oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                        oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                    <option value = "" disabled <?= $vehiculoActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option><!--hay que ponerle value="" para que el required funcione, asi el navegador entiende que si no se elije nada el valor es "" y te avisa, sino se pone, no tiene ningun valor y no avisa-->
                    <?php foreach ($listaVehiculos as $id => $vehiculo): ?>
                        <option value="<?= $id?>" <?= $id === $vehiculoActual ? 'selected' : '' ?>><?= $vehiculo ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="data[kilometros]" id="kilometros" placeholder="Kilometros" value = "<?=(isset($alquiler))? $alquiler->getkilometros() : ''?>">
                <label for="kilometros">Kilometros:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="data[kmInicio]" id="kmInicio" placeholder="Km inicio" value = "<?= (isset($alquiler))?$alquiler->getkmInicio():''?>">
                <label for="kmInicio">Km inicio:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="data[kmFin]" id="kmFin" placeholder="Km fin" value = "<?= (isset($alquiler))?$alquiler->getkmFin():''?>">
                <label for="kmFin">Km fin:</label>&nbsp
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="data[dias]" id="dias" placeholder="Dias" value = "<?= (isset($alquiler))?$alquiler->getdias():''?>">
                <label for="dias">Dias:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-2">
                <input class="form-control" type="text" name="data[precio]" id="precio" placeholder="Precio" value = "<?= (isset($alquiler))?$alquiler->getprecio():''?>">
                <label for="precio">Precio:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="data[precioKm]" id="precioKm" placeholder="Precio km" value = "<?= (isset($alquiler))?$alquiler->getprecioKm():''?>">
                <label for="precioKm">Precio km:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="data[fianza]" id="fianza" placeholder="Fianza" value = "<?= (isset($alquiler))?$alquiler->getfianza():''?>">
                <label for="fianza">Fianza:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="data[fianzaDevuelta]" id="fianzaDevuelta" placeholder="comercial" value = "<?= (isset($alquiler))?$alquiler->getfianzaDevuelta():''?>">
                <label for="fianzaDevuelta">Fianza Devuelta:</label>&nbsp
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-floating mb-1">
                <input type="text" name="data[comercial]" class="form-control" id="comercial" placeholder="Comercial" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getcomercial()):''?>">
                <label for="comercial">Comercial</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="data[comisionComercial]" id="comisionComercial" placeholder="Comision €:" value = "<?= (isset($alquiler))?$alquiler->getcomisionComercial():''?>">
                <label for="comisionComercial">Comision €:</label>&nbsp
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="data[ganancia]" id="ganancia" placeholder="Ganancia" value = "<?= (isset($alquiler))?$alquiler->getganancia():''?>">
                <label for="ganancia">Ganancia:</label>&nbsp
            </div>
        </div>
        <?php
            $clienteActual = isset($alquiler) ? $alquiler->getempresa() : '';//estoy editando un alquiler
            $clienteActual = $clienteActual!=0 ? $clienteActual : '';
            foreach ($entidades as $entidad){
                $lista[$entidad->getId()] = $entidad->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
            }
        ?>
        <div class="col-md-3">
            <label for="select_cliente" class="form-label">Cliente</label>
            <div class="form-floating mb-3">
                <select name="data[cliente]" class="form-select" id="select_cliente" 
                        required
                        oninvalid="document.getElementById('clienteError').style.display='block';"
                        oninput="document.getElementById('clienteError').style.display='none';">
                    <option value = "" disabled <?= $clienteActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($lista as $id => $entidad): ?>
                        <option value="<?= $id?>" <?= $id == $clienteActual ? 'selected' : '' ?>><?= $entidad ?></option>
                    <?php endforeach; ?>
                </select> 
                <div id="clienteError" style="color: red; display: none; font-size: 0.9em;">
                    Por favor selecciona un cliente.
                </div>
            </div>
        </div>
    </div>
        <?php
            $empresaActual = isset($alquiler) ? $alquiler->getempresa() : '';//estoy editando un alquiler
            $empresaActual = $empresaActual!=0 ? $empresaActual : '';
        ?>
    <div class="row">
        <div class="col-md-3">
            <label for="select_empresa" class="form-label">Empresa que alquila</label>
            <div class="form-floating mb-3">
                <select name="data[empresa]" class="form-select" id="select_empresa" required>
                    <option value = "" disabled <?= $empresaActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($lista as $id => $entidad): ?>
                        <option value="<?= $id?>" <?= $id == $empresaActual ? 'selected' : '' ?>><?= $entidad ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-1">
                <input type="text" name="data[ciudad]" class="form-control" id="ciudad" placeholder="Ciudad" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getciudad()):''?>">
                <label for="ciudad">Ciudad</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-1">
                <input type="text" name="data[entrega]" class="form-control" id="entrega" placeholder="Entrega" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getentrega()):''?>">
                <label for="entrega">Entrega</label>
            </div>
        </div>
        <?php
            $estadoActual = isset($alquiler) ? $alquiler->getestado() : '';
            $estadoActual = $estadoActual ?? '';
            $estados = ['Sin entregar', 'Entregado', 'Terminado', 'Cancelado', ''];
        ?>    
        <div class="col-md-2">
            <div class="form-floating mb-1">
                <select name="data[estado]" class="form-select" id="estado">
                    <option disabled <?= $estadoActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                    <?php foreach ($estados as $opcion): ?>
                        <option value="<?= $opcion ?>" <?= $opcion === $estadoActual ? 'selected' : '' ?>><?= $opcion ?></option>
                    <?php endforeach; ?>
                </select> 
                <label for="estado">Estado</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-floating mb-1">
                <input type="text" name="data[observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($alquiler))?quitaEspecialChar($alquiler->getobservaciones()):''?>">
                <label for="observaciones">Observaciones</label>
            </div>
        </div>
    </div> 
   
</div>
</form>

<?php if (isset($alquiler)) :?>
    <!--Formulario nueva ampliacion-->

    <button type="button" class="boton_link small" id="boton_form_ampliacion" onclick="mostrar('ampliacion')">+</button>
    <form action="<?= DIRECTORIO ?>nueva_ampliacion_alquiler" method="post" id="ampliacion" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva ampliacion</legend>
            <div class="row">
                <div class="col-md-3">
                    <label for="fechaInicio" class="etiqueta">Fecha inicio:</label> 
                    <input size=40 class="cuadro_text" type="date" name="ampliacion[fechaInicio]" id="fechaInicio" required>
                </div>        
                <div class="col-md-3">
                    <label for="fechaFin" class="etiqueta">Fecha fin:</label> 
                    <input size=40 class="cuadro_text" type="date" name="ampliacion[fechaFin]" id="fechaFin">
                </div>        
                <div class="col-md-3">
                    <label for="dias" class="etiqueta">Dias:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[dias]" id="dias" placeholder="dias">
                </div>        
                <div class="col-md-3">
                    <label for="kilometros" class="etiqueta">Kilometros:</label> 
                    <input class="cuadro_text" type="number" name="ampliacion[kilometros]" id="kilometros" placeholder="kilometros">
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="precio" >Precio:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="ampliacion[precio]" id="precio" placeholder="precio" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="ganancia" >Ganancia:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="ampliacion[ganancia]" id="ganancia" placeholder="ganancia">
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="comisionComercial" >Comision Comercial:</label>&nbsp
                    <input class="cuadro_text" type="texto" name="ampliacion[comisionComercial]" id="comisionComercial" placeholder="Comision Comercial" >
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="Observaciones" >Observaciones:</label>
                    <input size=60 class="cuadro_text" type="text" name="ampliacion[observaciones]" id="Observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit" onclick="return validar_entero_campo_text(form.importe)">Guardar</button>
                    <button type="reset" class="boton_submit">Borrar</button>
                </div>
            </div>
            <input type="hidden" name="ampliacion[alquiler]"  id="alquiler" value="<?=$alquiler->getid()?>">
        </fieldset>
    </form>

    <!--listado ampliaciones-->
<p class="titulo_sec">Ampliaciones</p>
<div>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="etiqueta" scope="col">Fecha inicio</th>
                <th class="etiqueta" scope="col">Fecha fin</th>
                <th class="etiqueta" scope="col">Dias</th>
                <th class="etiqueta" scope="col">Kilometros</th>
                <th class="etiqueta" scope="col">Precio</th>
                <th class="etiqueta" scope="col">Ganancia</th>
                <th class="etiqueta" scope="col">Comision</th>
                <th class="etiqueta" scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach($ampliaciones as $ampliacion) :?>
                <tr>
                    <?php $total += $ampliacion->getprecio();?> 
                    <td><?=formatea_fecha($ampliacion->getfechaInicio())?></td>
                    <td><?=formatea_fecha($ampliacion->getfechaFin())?></td>
                    <td><?=$ampliacion->getdias();?>€</td>         
                    <td><?=$ampliacion->getkilometros();?></td>         
                    <td><?=number_format($ampliacion->getprecio(), 2, ',', '.');?>€</td>         
                    <td><?=number_format($ampliacion->getganancia(), 2, ',', '.');?>€</td>         
                    <td><?=number_format($ampliacion->getcomisionComercial  (), 2, ',', '.');?>€</td>                 
                    <td><?=$ampliacion->getobservaciones()?></td>         
                    <td><div class="btn-group" role="group">
                        <a href="<?= DIRECTORIO ?>editar_ampliacion_alquiler/<?=$ampliacion->getidAmpliacion()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../borrar_ampliacion_alquiler/<?=$ampliacion->getidAmpliacion()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta ampliacion?');">  
                            <i class="bi bi-trash"></i>
                        </a>   
                        </div>
                    </td>
            </tr>    
            <?php endforeach ;?>    
        </tbody>
    </table> 
    <p class='etiqueta_desplazada'> Suma: <?=number_format($total+$alquiler->getprecio(), 2, ',', '.')?>€</p>   
</div>
    <!--listado cobros-->
<p class="titulo_sec">Cobros</p>
    <div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Fecha</th>
                    <th class="etiqueta" scope="col">Importe</th>
                    <th class="etiqueta" scope="col">Facturado</th>
                    <th class="etiqueta" scope="col">Facturado a</th>
                    <th class="etiqueta" scope="col">Contrato Hacienda</th>
                    <th class="etiqueta" scope="col">Fianza</th>
                    <th class="etiqueta" scope="col">Parte importe fianza</th>
                    <th class="etiqueta" scope="col">Banco</th>
                    <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalCobros = 0; ?>
                <?php foreach($cobros as $cobro) :?>
                    <tr>
                        <?php $totalCobros += $cobro->getimporte();?> 
                        <td><?=formatea_fecha($cobro->getfecha())?></td>         
                        <td><?=number_format($cobro->getimporte(), 2, ',', '.');?>€</td>         
                        <td><?=$cobro->getfacturado() ? 'SI' : 'NO'?></td>         
                        <td><?=$cobro->getfacturadoA()?></td>         
                        <td><?=$cobro->getfianza() ? 'SI' : 'NO'?></td>         
                        <td><?=number_format($cobro->getparteImporteFianza(), 2, ',', '.');?>€</td>                  
                        <td><?=$cobro->getbanco()?></td>         
                        <td><?=$cobro->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_cobro_alquiler/<?=$cobro->getidCobro()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_cobro_alquiler/<?=$cobro->getidCobro()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este cobro?');">   
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                </tr>    
                <?php endforeach ;?>   
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Suma: <?=number_format($totalCobros, 2, ',', '.')?>€</p>
    </div>

    <!--listado gastos-->
<p class="titulo_sec">Gastos</p>
<div>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="etiqueta" scope="col">Tipo</th>
                <th class="etiqueta" scope="col">Importe</th>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Paga otro</th>
                <th class="etiqueta" scope="col">Pagado</th>
                <th class="etiqueta" scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalGastos = 0; ?>
            <?php foreach($gastos as $gasto) :?>
                <tr>
                    <?php $totalGastos += $gasto->getimporte();?> 
                    <td><?=$gasto->gettipo()?></td>
                    <td><?=number_format($gasto->getimporte(), 2, ',', '.');?>€</td>         
                    <td><?=formatea_fecha($gasto->getfecha())?></td>         
                    <td><?=$gasto->getpagaOtro() ? 'SI' : 'NO'?></td>         
                    <td><?=$gasto->getpagado() ? 'SI' : 'NO'?></td>         
                    <td><?=$gasto->getobservaciones()?></td>         
                    <td><div class="btn-group" role="group">
                        <a href="<?= DIRECTORIO ?>editar_gasto_alquiler/<?=$gasto->getidGasto()?>?alquiler=<?=$alquiler->getid()?>" role="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../borrar_gasto_alquiler/<?=$gasto->getidGasto()?>?alquiler=<?=$alquiler->getid()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este gasto?');">   
                            <i class="bi bi-trash"></i>
                        </a>   
                        </div>
                    </td>
                </tr>    
            <?php endforeach ;?>   
        </tbody>
    </table>            
    <p class='etiqueta_desplazada'> Suma: <?=number_format($totalGastos, 2, ',', '.')?>€</p>
</div> 
<?php endif;?>
<script>
    $(document).ready(function() {
        $('#select_vehiculo').select2({
            placeholder: "Buscar vehiculo",
            allowClear: true,
            width: '100%'
        });
        $('#select_empresa').select2({
            placeholder: "Buscar empresa",
            allowClear: true,
            width: '100%'
        });
        $('#select_cliente').select2({
            placeholder: "Buscar cliente",
            allowClear: true,
            width: '100%'
        });
    });
</script>