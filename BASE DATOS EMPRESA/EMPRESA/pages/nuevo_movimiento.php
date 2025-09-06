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
            <input type="text" name="data[movimiento][concepto]" class="form-control" id="concepto" placeholder="Concepto" value="<?=(isset($movimiento))?$movimiento->getconcepto():''?>" required>
            <label for="concepto">Concepto</label>
        </div>
    </div>           
    
    <div class="col-md-4">
        <div class="form-floating mb-1">
            <input type="text" name="data[movimiento][observaciones]" class="form-control" id="observaciones" placeholder="Observaciones" value="<?=(isset($movimiento))?$movimiento->getobservaciones():''?>">
            <label for="concepto">Observaciones</label>
        </div>
    </div> 
    <?php
        $vehiculoActual = isset($movimiento) ? $movimiento->getvehiculo() : '';//estoy editando un movimiento
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
                    <option value="<?= $id?>" <?= $id == $vehiculoActual ? 'selected' : '' ?>><?= $vehiculo ?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>          
</div>
</form>


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