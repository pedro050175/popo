<form action="/mis_pruebas/pages/nuevo_vehiculo" method="post">
    <?php if (isset($vehiculo)) :?>
    <input type="hidden" name="data[vehiculo][id_vehiculo]" value="<?=$vehiculo->getId()?>">
    <?php endif;?>    
    <!--<p><?// sleep(1); echo "hola";?></p> hay que poner comentarios para html y tmb comentarios para el codigo incrustado PHP -->  
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5><?= (isset($vehiculo)) ? 'Modificar' : 'Nuevo'?> Vehiculo</h5>
            </div>
            <div class="col text-end">  
                <a href="/mis_pruebas/vehiculos" role="button" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"> <?= (isset($vehiculo)) ? 'Guardar' : 'Crear' ?></button>
            </div>
        </div>
<div class="row">
    <div class="col-md-4">    
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Marca_modelo]" class="form-control" id="floatingInput" placeholder="Marca_modelo" value="<?=(isset($vehiculo))?$vehiculo->getMarca_modelo():''?>" required> 
            <label for="floatingInput">Marca y mode</label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Matricula]" class="form-control" id="floatingInput" placeholder="Matricula" value="<?=(isset($vehiculo))?$vehiculo->getMatricula():''?>">
            <label for="floatingInput">Matrícula</label>
        </div>
    </div>
    <div class="col-md-3">   
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Bastidor]" class="form-control" id="floatingInput" placeholder="Bastidor" value="<?=(isset($vehiculo))?$vehiculo->getBastidor():''?>">
            <label for="floatingInput">Bastidor</label>
        </div>
    </div>
    <div class="col-md-2"> 
        <div class="form-floating mb-1">
            <input type="number" name="data[vehiculo][Km]" class="form-control" id="floatingInput" placeholder="Kilometros" value="<?=(isset($vehiculo))?$vehiculo->getKm():''?>">
            <label for="floatingInput">Kilometros</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Fecha_matricula]" class="form-control" id="floatingInput" placeholder="Fecha_matricula" value="<?=(isset($vehiculo))?$vehiculo->getFecha_matricula():''?>">
            <label for="floatingInput">Fecha matricula </label>
        </div>
    </div>    
        <?php
            $combustibleActual = isset($vehiculo) ? $vehiculo->getCombustible() : '';
            $combustibleActual= $CombustibleActual ?? ''; //si hago editar y en la tabla SQL hay un NULL en el foreach selecciona el 1º de la lista cuando no es cierto, es NULL
            $opciones = ['Gasolina', 'Diesel', 'Hibrido', 'Electrico'];
        ?>
    <div class="col-md-3">  
        <div class="form-floating mb-1">
            <select name="data[vehiculo][Combustible]" class="form-select" id="floatingInput">
        <!--disable es para que salga en gris y no pueda ser elegido como opcion el mensaje, pero si no elijen una opcion y le da a crear no enviaria nada en el POST, por eso se pone value='' para que al menos envie ''-->    
        <!-- el mensaje es un elemento de la lista mas y se comporta como tal por eso hay que llevar cuidado con los atributos que le damos-->
                <option disabled <?= $combustibleActual === '' ? 'selected' : '' ?>>--Seleccione combustible--</option> <!--si combustible ==='' (crear vehiculo)->"selected" el mesanje se muestra-->
       
                <?php foreach ($opciones as $opcion): ?>
<!--<option <1ºphp(para asignar valor)value=elemento_tabla><2ºphp(para ver si se muestra por defecto)si el elemen de la tabla==combustible ->'selected' este elem. se muestra por defec, sino ->'' -->
    <!--para crear siempre sera selected el mensaje, porque en el foreach nunca se dara la igualdad option==combustibleactual, y si es update se dara la igualdad para uno de los elemen que sera el selectd para mostrar por defecto-->
                    <option value="<?= $opcion ?>" <?= $opcion === $combustibleActual ? 'selected' : '' ?>><?= $opcion ?><!--si no pongo el atributo value por fecto value = al element de la lista elejido-->
                    </option>
                <?php endforeach; ?>
            </select> 
                <label for="floatingInput">Combustible</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Fecha_itv]" class="form-control" id="floatingInput" placeholder="Fecha_itv" value="<?=(isset($vehiculo))?$vehiculo->getFecha_itv():''?>">
            <label for="floatingInput">Fecha itv</label> 
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Prox_itv]" class="form-control" id="floatingInput" placeholder="Prox_itv" value="<?=(isset($vehiculo))?$vehiculo->getProx_itv():''?>">
            <label for="floatingInput">Proxima itv</label>
        </div>
    </div>
</div>
<?php
    $estadoActual = isset($vehiculo) ? $vehiculo->getEstado() : '';
    $estadoActual= $estadoActual ?? '';
    $estados = ['Usado', 'Nuevo'];
?>
<div class="row">
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <select name="data[vehiculo][Estado]" class="form-select" id="floatingInput">
                <option disabled <?= $estadoActual === '' ? 'selected' : '' ?>>--Selecc. estado--</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?= $estado ?>" <?= $estado === $estadoActual ? 'selected' : '' ?>><?= $estado ?></option>
                <?php endforeach; ?>
            </select> 
            <label for="floatingInput">Estado</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Clase]" class="form-control" id="floatingInput" placeholder="Clase" value="<?=(isset($vehiculo))?$vehiculo->getClase():''?>">
            <label for="floatingInput">Clase vehiculo</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="number" name="data[vehiculo][propietario]" class="form-control" id="floatingInput" placeholder="propietario" value="<?=(isset($vehiculo))?$vehiculo->getpropietario():''?>">
            <label for="floatingInput">Propietario</label>
        </div>
    </div>
</div>   
<div class="col-md-6">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Observaciones]" class="form-control" id="floatingInput" placeholder="Observaciones" value="<?=(isset($vehiculo))?$vehiculo->getObservaciones():''?>">
            <label for="floatingInput">Observaciones</label>
        </div>
    </div>           
</div>
</form>
