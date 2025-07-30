<form action="/mis_pruebas/pages/nuevo_vehiculo" method="post">
    <?php if (isset($vehiculo)) :?>
    <input type="hidden" name="data[vehiculo][id_vehiculo]" value="<?=$vehiculo->getId()?>">
    <?php endif;?>    
    <!--<p><?// sleep(3); echo "hola";?></p> hay que poner comentarios para html y tmb comentarios para el codigo incrustado PHP -->  
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h4><?= (isset($vehiculo)) ? 'Modificar' : 'Nuevo'?> Vehiculo</h4>
            </div>
            <div class="col text-end">  
                <a href="/mis_pruebas/vehiculos" role="button" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"> <?= (isset($vehiculo)) ? 'Guardar' : 'Crear' ?></button>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Marca_modelo]" class="form-control" id="floatingInput" placeholder="Marca_modelo" value="<?=(isset($vehiculo))?$vehiculo->getMarca_modelo():''?>" required> 
            <label for="floatingInput">Marca y modelo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Matricula]" class="form-control" id="floatingInput" placeholder="Matricula" value="<?=(isset($vehiculo))?$vehiculo->getMatricula():''?>">
            <label for="floatingInput">Matrícula</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Bastidor]" class="form-control" id="floatingInput" placeholder="Bastidor" value="<?=(isset($vehiculo))?$vehiculo->getBastidor():''?>">
            <label for="floatingInput">Bastidor</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" name="data[vehiculo][Km]" class="form-control" id="floatingInput" placeholder="Kilometros" value="<?=(isset($vehiculo))?$vehiculo->getKm():''?>">
            <label for="floatingInput">Kilometros actuales</label>
        </div>
        <div class="form-floating mb-3">
            <input type="date" name="data[vehiculo][Fecha_matricula]" class="form-control" id="floatingInput" placeholder="Fecha_matricula" value="<?=(isset($vehiculo))?$vehiculo->getFecha_matricula():''?>">
            <label for="floatingInput">Fecha matricula </label>
        </div>
        <?php
            $combustibleActual = isset($vehiculo) ? $vehiculo->getCombustible() : '';
            $opciones = ['Gasolina', 'Diesel', 'Hibrido', 'Electrico'];
        ?>  
            <div class="form-floating mb-3">
                <select name="data[vehiculo][Combustible]" class="form-select" id="floatingInput">
                    <option disabled <?= $combustibleActual === '' ? 'selected' : '' ?>>Selecciona tipo de combustible</option>

                <?php foreach ($opciones as $opcion): ?>
                    <option value="<?= $opcion ?>" <?= $opcion === $combustibleActual ? 'selected' : '' ?>>
                    <?= $opcion ?>
                    </option>
                <?php endforeach; ?>
                
                </select> 
                <label for="floatingInput">Combustible</label>
            </div>
            <div class="form-floating mb-3">
            <input type="date" name="data[vehiculo][Fecha_itv]" class="form-control" id="floatingInput" placeholder="Fecha_itv" value="<?=(isset($vehiculo))?$vehiculo->getFecha_itv():''?>">
            <label for="floatingInput">Fecha itv</label> 
        </div>
        <div class="form-floating mb-3">
            <input type="date" name="data[vehiculo][Prox_itv]" class="form-control" id="floatingInput" placeholder="Prox_itv" value="<?=(isset($vehiculo))?$vehiculo->getProx_itv():''?>">
            <label for="floatingInput">Proxima itv</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Estado]" class="form-control" id="floatingInput" placeholder="Estado" value="<?=(isset($vehiculo))?$vehiculo->getEstado():''?>">
            <label for="floatingInput">Estado</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Clase]" class="form-control" id="floatingInput" placeholder="Clase" value="<?=(isset($vehiculo))?$vehiculo->getClase():''?>">
            <label for="floatingInput">Clase vehiculo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" name="data[vehiculo][propietario]" class="form-control" id="floatingInput" placeholder="propietario" value="<?=(isset($vehiculo))?$vehiculo->getpropietario():''?>">
            <label for="floatingInput">Propietario</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[vehiculo][Observaciones]" class="form-control" id="floatingInput" placeholder="Observaciones" value="<?=(isset($vehiculo))?$vehiculo->getObservaciones():''?>">
            <label for="floatingInput">Observaciones</label>
        </div>
    </div>
</form>
