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