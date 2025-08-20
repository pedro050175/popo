<form action="<?= DIRECTORIO ?>nuevo_vehiculo" method="post">
    <?php if (isset($vehiculo)) :?>
    <input type="hidden" name="data[vehiculo][id_vehiculo]" value="<?=$vehiculo->getId()?>">
    <?php endif;?>      
    <div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($vehiculo)) ? 'Modificar' : 'Nuevo'?> Vehiculo</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>vehiculos?num_pagina=1';">   
                <button type="submit" class="boton_submit"> <?= (isset($vehiculo)) ? 'Guardar' : 'Crear' ?></button>
            </div>
        </div>
<div class="row">
    <div class="col-md-4">    
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Marca_modelo]" class="form-control" id="Marca_modelo" placeholder="Marca_modelo" value="<?=(isset($vehiculo))?$vehiculo->getMarca_modelo():''?>" required> 
            <label for="Marca_modelo">Marca y modelo</label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Matricula]" class="form-control" id="Matricula" placeholder="Matricula" value="<?=(isset($vehiculo))?$vehiculo->getMatricula():''?>">
            <label for="Matricula">Matrícula</label>
        </div>
    </div>
    <div class="col-md-3">   
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Bastidor]" class="form-control" id="Bastidor" placeholder="Bastidor" value="<?=(isset($vehiculo))?$vehiculo->getBastidor():''?>">
            <label for="Bastidor">Bastidor</label>
        </div>
    </div>
    <div class="col-md-2"> 
        <div class="form-floating mb-1">
            <input type="number" name="data[vehiculo][Km]" class="form-control" id="Kilometros" placeholder="Kilometros" value="<?=(isset($vehiculo))?$vehiculo->getKm():''?>">
            <label for="Kilometros">Kilometros</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Fecha_matricula]" class="form-control" id="Fecha_matricula" placeholder="Fecha_matricula" value="<?=(isset($vehiculo))?$vehiculo->getFecha_matricula():''?>">
            <label for="Fecha_matricula">Fecha matricula </label>
        </div>
    </div>    
    <?php
        $combustibleActual = isset($vehiculo) ? $vehiculo->getCombustible() : '';
        $combustibleActual= $combustibleActual ?? ''; //si hago editar y en la tabla SQL hay un NULL en el foreach selecciona el 1º de la lista cuando no es cierto, es NULL
        $combustibles = ['Gasolina', 'Diesel', 'Hibrido', 'Electrico'];
    ?>
    <div class="col-md-3">  
        <div class="form-floating mb-1">
            <select name="data[vehiculo][Combustible]" class="form-select" id="Combustible">
        <!--disable es para que salga en gris y no pueda ser elegido como opcion el mensaje, pero si no elijen una opcion y le da a crear no enviaria nada en el POST, por eso se pone value='' para que al menos envie ''-->    
        <!-- el mensaje es un elemento de la lista mas y se comporta como tal por eso hay que llevar cuidado con los atributos que le damos-->
                <option disabled <?= $combustibleActual === '' ? 'selected' : '' ?>>--Seleccione combustible--</option> <!--si combustible ==='' (crear vehiculo)->"selected" el mesanje se muestra-->
       
                <?php foreach ($combustibles as $opcion): ?>
<!--<option <1º(asignar valor)value=elemento_tabla><2º(ver si se muestra por defecto)si el elemen de la tabla==combustible ->'selected' este elem. se muestra por defec, sino ->'' -->
    <!--para crear siempre sera selected el mensaje, porque en el foreach nunca se dara la igualdad option==combustibleactual, y si es update se dara la igualdad para uno de los elemen que sera el selectd para mostrar por defecto-->
                    <option value="<?= $opcion ?>" <?= $opcion === $combustibleActual ? 'selected' : '' ?>><?= $opcion ?><!--si no pongo el atributo value por fecto value = al element de la lista elejido-->
                    </option>
                <?php endforeach; ?>
            </select> 
                <label for="Combustible">Combustible</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Fecha_itv]" class="form-control" id="Fecha_itv" placeholder="Fecha_itv" value="<?=(isset($vehiculo))?$vehiculo->getFecha_itv():''?>">
            <label for="Fecha_itv">Fecha itv</label> 
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="date" name="data[vehiculo][Prox_itv]" class="form-control" id="Prox_itv" placeholder="Prox_itv" value="<?=(isset($vehiculo))?$vehiculo->getProx_itv():''?>">
            <label for="Prox_itv">Proxima itv</label>
        </div>
    </div>
</div>
<div class="row">
    <?php
        $estadoActual = isset($vehiculo) ? $vehiculo->getEstado() : ''; 
        $estadoActual = $estadoActual ?? '';//si el estado es null porque aun no se ha insertado un estado en la BBDD me seleccion el 1º de la lista: Usado asi que si es NULL lo cambio a '' 
        $estados = ['Usado', 'Nuevo'];// le he preguntado a la IA y no hay otra forma de hacerlo es un problema del navegador, porque PHP no marca ninguna opcion con selected antes de enviarlo la pagina al navegador si no hay ninguna opcion con selected muestra la 1º de la lista
    ?>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <select name="data[vehiculo][Estado]" class="form-select" id="Estado" autocomplete="off">
                <option disabled <?= $estadoActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                <?php foreach ($estados as $opcion): ?>
                    <option value="<?= $opcion ?>" <?= $opcion === $estadoActual ? 'selected' : '' ?>><?= $opcion ?></option>
                <?php endforeach; ?>
            </select> 
            <label for="Estado">Estado</label>
        </div>
    </div>
    <?php
        $claseActual = isset($vehiculo) ? $vehiculo->getClase() : '';
        $claseActual = $claseActual ?? '';
        $clases = ['Turismo', 'Furgoneta', 'Moto', 'Camion'];
    ?>    
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <select name="data[vehiculo][Clase]" class="form-select" id="Clase">
                <option disabled <?= $claseActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                <?php foreach ($clases as $opcion): ?>
                    <option value="<?= $opcion ?>" <?= $opcion === $claseActual ? 'selected' : '' ?>><?= $opcion ?></option>
                <?php endforeach; ?>
            </select> 
            <label for="Clase">Clase vehiculo</label>
        </div>
    </div>
    <?php
        $propietarioActual = isset($vehiculo) ? $vehiculo->getpropietario() : '';//estoy editando un vehiculo
        foreach ($entidades as $entidad){
            $listapropietarios[$entidad->getId()] = $entidad->getNombre();//con la variable $entidades creo un array asociativo ['id']=Nombre
        }
    ?>

    <div class="col-md-3">
        <label for="select-propietario" class="form-label">Propietario</label>
        <div class="form-floating mb-3">
            <select name="data[vehiculo][propietario]" class="form-select" id="select-propietario">
                <option disabled <?= $propietarioActual === '' ? 'selected' : '' ?>>--Selecc. opcion--</option>
                <?php foreach ($listapropietarios as $id => $propietario): ?>
                    <option value="<?= $id?>" <?= $id == $propietarioActual ? 'selected' : '' ?>><?= $propietario ?></option>
                    <?php endforeach; ?>
                </select> 
        </div>
    </div>
</div>   
<div class="col-md-6">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Observaciones]" class="form-control" id="Observaciones" placeholder="Observaciones" value="<?=(isset($vehiculo))?$vehiculo->getObservaciones():''?>">
            <label for="Observaciones">Observaciones</label>
        </div>
    </div>           
</div>
<!-- formulario para nuevas fotos -->
</form>

<?php if (isset($vehiculo)) :?>
    
<div>
    <form action="<?= DIRECTORIO ?>nueva_foto" method="post" enctype="multipart/form-data">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva Foto</legend>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <div class="row">
                <div class="col-md-6">
                    <label for="foto" class="etiqueta">Foto:</label> 
                    <input size="100" class="cuadro_text" type="file" name="imagen" id="foto" required>
                    <em class="etiqueta_mini">Foto menor de 2MB</em>
                </div>        
                <div class="col-md-2">
                    <label class="etiqueta" for="destacada" >Destacada:</label>&nbsp&nbsp&nbsp&nbsp<input class="cuadro_text" type="checkbox" name="foto[destacada]" id="destacada">
                </div>
            </div>
            <input type="hidden" name="foto[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo"><br/>
            <label class="etiqueta" for="descripcion">Descripcion:&nbsp</label>
            <input size=100 class="cuadro_text" type="text" name="foto[descripcion]" id="descripcion" placeholder="Descripción"><br/><br/>
            <button type="submit" class="boton_submit">Guardar Foto</button>
        </fieldset>
    </form>
</div>
<div>
    <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Nombre</th>
                    <th class="etiqueta" scope="col">Descripcion</th>
                    <th class="etiqueta" scope="col">Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fotos as $foto) :?>
                    <tr>
                        <?php                            
                            $foto->getdestacada() ? $w = 80 : $w = 45;
                            $foto->getdestacada() ? $h = 40 : $h = 35;
                        ?>
                        <td><?=$foto->geturl()?></td>
                        <td><?=$foto->getdescripcion()?></td>
                        <td><img src="<?=FOTOS_VEHICULOS_SERVIDOR.$foto->nombre_foto_server()?>" width="<?=$w?>" height="<?=$h?>" alt=<?= rawurlencode($foto->nombre_foto_server())?>></td><!--rawurlencode sirve para cambiar los espacios por %20. si el nombre de la imagen lleva espacio daria error si no se usa rawurlencode, eso hace falta si pongo la ruta sin "ruta", si la pongo entre comillas no hace falt usar rawurlencode-->
                <!--he puesto un src con "" y sin rawurlencode y otro sin "" y con rawurlencode-->            
                        <td>
                        <div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_foto/<?=$foto->getid()?>?vehiculo=<?=$vehiculo->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- estoy en /mis_pruebas/pages/nuevo_vehiculo con ..subo un directorio y voy a /mis_pruebas/pages/ y añado /borrar_foto... y me quedo en /mis_pruebas/pages/borrar_foto_vehiculo-->
                            <a href="../borrar_foto_vehiculo/<?=$foto->getid()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta foto?');"> 
                            <!--?vehiculo=<?=$vehiculo->getId()?> esto es para pasar en la URL la el numero de vehiculo que estamos editando y al borrar la foto poder cargar el mismo vehiculo -->  
                            <i class="bi bi-trash"></i>
                            </a>   
                        </div>
                    </td>   
                <?php endforeach ;?>      
            </tbody>
    </table>            
</div> 
<?php endif;?>

<script>
    $(document).ready(function() {
        $('#select-propietario').select2({
            placeholder: "Buscar propietario",
            allowClear: true,
            width: '100%'
        });
    });
</script>

