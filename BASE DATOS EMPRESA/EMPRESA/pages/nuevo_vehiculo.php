<form action="<?= DIRECTORIO ?>nuevo_vehiculo" method="post">
    <?php if (isset($vehiculo)) :?>
    <input type="hidden" name="data[vehiculo][id_vehiculo]" id='id_vehiculo' value="<?=$vehiculo->getId()?>">
    <?php endif;?>      
<div class="container mt-1">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($vehiculo)) ? 'Modificar' : 'Nuevo'?> Vehiculo</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>vehiculos?num_pagina=1';">   
                <button type="submit" class="boton_submit" onclick="validarFechas(this.form);return false"> <?= (isset($vehiculo)) ? 'Guardar' : 'Crear' ?></button>
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
    <div class="col-md-4">
        <div class="form-floating mb-1">
            <input type="text" name="data[vehiculo][Observaciones]" class="form-control" id="Observaciones" placeholder="Observaciones" value="<?=(isset($vehiculo))?$vehiculo->getObservaciones():''?>">
            <label for="Observaciones">Observaciones</label>
        </div>
    </div>           
</div>
</form>
<!--Menu--> 
<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4 botones">
        <button class="boton_menu" onclick="mostrarMenuVehiculo('fotos')">Fotos</button>
        <button class="boton_menu" onclick="mostrarMenuVehiculo('gastos')">Gastos</button>        
        <button class="boton_menu" onclick="mostrarMenuVehiculo('gastos')">Cuotas</button>        
    </div>
</div>
<?php if (isset($vehiculo)) :?>
<!--FOTOS-->
<div class=contenedor id="fotos">
<!-- formulario para nueva fotos -->
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
                <div class="col-md-4">
                    <label class="etiqueta" for="destacada">Destacada:</label>&nbsp&nbsp&nbsp&nbsp<input class="cuadro_text" type="checkbox" name="foto[destacada]" id="destacada">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit">Guardar Foto</button>
                </div>
            </div>
            <input type="hidden" name="foto[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo">
            <label class="etiqueta" for="descripcion">Descripcion:&nbsp</label>
            <input size=100 class="cuadro_text" type="text" name="foto[descripcion]" id="descripcion" placeholder="Descripción"><br/>
        </fieldset>
    </form>
    <!--listado fotos-->
    <p class="titulo_sec">Fotos</p>
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
                                <!-- estoy en /mis_pruebas/nuevo_vehiculo con ..subo un directorio y voy a /mis_pruebas/ y añado /borrar_foto... y me quedo en /mis_pruebas/borrar_foto_vehiculo-->
                                <a href="../borrar_gasto_vehiculo/<?=$foto->getid()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta foto?');"> 
                                <!--?vehiculo=<?=$vehiculo->getId()?> esto es para pasar en la URL la el numero de vehiculo que estamos editando y al borrar la foto poder cargar el mismo vehiculo -->  
                                <i class="bi bi-trash"></i>
                                </a>   
                            </div>
                        </td>
                    </tr>   
                <?php endforeach ;?>      
            </tbody>
        </table>            
    </div>
</div>
<!--GASTOS-->
<div class=contenedor id="gastos">
    <!--Formulario nuevo gasto--> 
    <form action="<?= DIRECTORIO ?>nuevo_gasto_vehiculo" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nuevo Gasto</legend>
            <div class="row">
                <div class="col-md-4">
                    <label for="tipo" class="etiqueta">Tipo:</label> 
                    <input size=40 class="cuadro_text" type="text" name="gasto[tipo]" id="tipo" required placeholder="Tipo">
                </div>        
                <div class="col-md-4">
                    <label class="etiqueta" for="importe" >Importe:</label>&nbsp
                    <input class="cuadro_text" type="number" name="gasto[importe]" id="importe" placeholder="Importe">
                </div>
                <div class="col-md-4">
                    <label class="etiqueta" for="fecha" >Fecha:</label>&nbsp
                    <input class="cuadro_text" type="date" name="gasto[fecha]" id="fecha" placeholder="Fecha" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="paga_otro" >Paga otro:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[paga_otro]" id="paga_otro">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="pagado" >Pagado:</label>&nbsp
                    <input class="cuadro_text" type="checkbox" name="gasto[pagado]" id="pagado">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="comentarios" >Comentarios:</label>&nbsp
                    <input size=60 class="cuadro_text" type="text" name="gasto[comentarios]" id="comentarios" placeholder="Comentarios">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit">Guardar Gasto</button>
                </div>
            </div>
            <input type="hidden" name="gasto[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo">
        </fieldset>
    </form>
    <!-- Formulario para buscar gastos-->
    <form action="<?= DIRECTORIO ?>nuevo_vehiculo/<?=$vehiculo->getId()?>" method="get" class="d-flex">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Buscar</legend>   
            <div class="row">
                <div class="col-md-2">
                    <input type="search" name="buscar_tipo" class="cuadro_text" id="buscar_tipo" placeholder="Buscar tipo">
                </div>
                <div class="col-md-2">
                    <label for="fecha_inicio" class="etiqueta">Inicio:</label>
                    <input type="date" name="fecha_inicio" class="cuadro_text" id="fecha_inicio" placeholder="Fecha inicio">
                </div>
                <div class="col-md-2">
                    <label for="fecha_fin" class="etiqueta">Fin:</label>
                    <input type="date" name="fecha_fin" class="cuadro_text" id="fecha_fin" placeholder="Fecha fin">
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit">Buscar</button>
                </div>
            </div>
            </fieldset>
        </form>
        
    <!--listado Gastos-->
    <p class="titulo_sec">Gastos</p>
    <div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Tipo</th>
                    <th class="etiqueta" scope="col">Importe</th>
                    <th class="etiqueta" scope="col"><a href="<?= DIRECTORIO ?>nuevo_vehiculo/<?=$vehiculo->getId()?>?ordenar=fecha">Fecha</a></th>
                    <th class="etiqueta" scope="col">Paga otro</th>
                    <th class="etiqueta" scope="col">Pagado</th>
                    <th class="etiqueta" scope="col">Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalGastos = 0; ?>
                <?php foreach($gastos as $gasto) :?>
                    <tr>
                        <?php $totalGastos += $gasto->getImporte();?> 
                        <td><?=$gasto->getTipo()?></td>
                        <td><?=number_format($gasto->getImporte(), 2, ',', '.');?>€</td>         
                        <td><?=formatea_fecha($gasto->getFecha())?></td>         
                        <td><?=$gasto->getPaga_otro() ? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getPagado() ? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getComentarios()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_gasto_vehiculo/<?=$gasto->getId_gasto()?>?vehiculo=<?=$vehiculo->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_gasto_vehiculo/<?=$gasto->getid_gasto()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta foto?');"> 
                                <!--?vehiculo=<?=$vehiculo->getId()?> esto es para pasar en la URL la el numero de vehiculo que estamos editando y al borrar la foto poder cargar el mismo vehiculo -->  
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
</div>
<div class=contenedor id="cuotas">


    <!--Formulario nueva cuota--> 
    <form action="<?= DIRECTORIO ?>nueva_cuota_vehiculo" method="post">
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva Cuota</legend>
            <div class="row">
            <?php
                $tipoCuotas = ['Renting', 'Financiado'];
            ?>
            <div class="col-md-3">  
                <div class="form-floating mb-1">
                    <select name="cuota[tipo]" class="form-select" id="tipo">
                        <option disabled = 'selected'>--Seleccione combustible--</option> 
                        <?php foreach ($tipoCuotas as $tipo): ?>
                            <option><?= $opcion ?></option>
                        <?php endforeach; ?>
                    </select> 
                    <label for="tipo">Tipo cuota</label>
                </div>
            </div>
            <div class="col-md-4">
                <label class="inicio" for="importe" >Fecha inicio:</label>&nbsp
                <input class="cuadro_text" type="date" name="cuota[inicio]" id="inicio" placeholder="Fecha inicio">
            </div>
            <div class="col-md-4">
                <label class="etiqueta" for="duracion" >Duracion:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[duracion]" id="duracion" placeholder="Meses">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="cuota" >Cuota:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[cuota]" id="cuota">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="totalPagar" >Total pagar:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[totalPagar]" id="totalPagar">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="pagoFinal" >Pago final:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[pagoFinal]" id="pagoFinal">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="entrada" >Entrada:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[entrada]" id="entrada">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="fianza" >Fianza:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[fianza]" id="fianza">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="km" >Kilometros:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[km]" id="km">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="kmAno" >Km año:</label>&nbsp
                <input class="cuadro_text" type="number" name="cuota[kmAno]" id="kmAno">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="financiera" >Financiera:</label>&nbsp
                <input class="cuadro_text" type="text" name="cuota[financiera]" id="financiera">
            </div>

            <div class="col-md-3">
                <label for="select-titular-cuota" class="form-label">Titular</label>
                <div class="form-floating mb-3">
                    <select name="cuota[titular]" class="form-select" id="select-titular-cuota">
                        <option disabled='selected'>--Selecc. opcion--</option>
                        <?php foreach ($listapropietarios as $id => $propietario): ?>
                            <option value="<?= $id?>" <?= $id == $propietarioActual ? 'selected' : '' ?>><?= $propietario ?></option>
                            <?php endforeach; ?>
                        </select> 
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="etiqueta" for="observaciones" >Observaciones:</label>&nbsp
                <input size=60 class="cuadro_text" type="text" name="cuota[observaciones]" id="observaciones" placeholder="observaciones">
            </div>
            <div class="col-md-2">
                <button type="submit" class="boton_submit">Guardar Cuota</button>
            </div>
        </div>
        <input type="hidden" name="cuota[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo">
    </fieldset>
</form>  
    <!--listado Gastos-->
    <p class="titulo_sec">Cuotas</p>
    <div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="etiqueta" scope="col">Tipo</th>
                    <th class="etiqueta" scope="col">Inicio</th>
                    <th class="etiqueta" scope="col">Duracion</th>
                    <th class="etiqueta" scope="col">Cuota</th>
                    <th class="etiqueta" scope="col">Total pagar</th>
                    <th class="etiqueta" scope="col">Pago final</th>
                    <th class="etiqueta" scope="col">Entrada</th>
                    <th class="etiqueta" scope="col">Fianza</th>
                    <th class="etiqueta" scope="col">Kilometros</th>
                    <th class="etiqueta" scope="col">Km Año</th>
                    <th class="etiqueta" scope="col">Financiera</th>
                    <th class="etiqueta" scope="col">Titular</th>
                    <th class="etiqueta" scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cuotas as $cuota) :?>
                    <tr>
                        <td><?=$cuota->gettipo()?></td>
                        <td><?=formatea_fecha($cuota->getinicio())?></td>
                        <td><?=$cuota->getduracion()?></td>
                        <td><?=number_format($cuota->getcuota(), 2, ',', '.');?>€</td>         
                        <td><?=number_format($cuota->gettotalPagar(), 2, ',', '.');?>€</td>         
                        <td><?=number_format($cuota->getpagoFinal(), 2, ',', '.');?>€</td>         
                        <td><?=number_format($cuota->getentrada(), 2, ',', '.');?>€</td>         
                        <td><?=number_format($cuota->getfianza(), 2, ',', '.');?>€</td> 
                        <td><?=$cuota->getkm()?></td>
                        <td><?=$cuota->getkmAno()?></td>
                        <td><?=$cuota->getfinanciera()?></td>
                        <td><?=$cuota->getdatos_propietario()->getNombre()?></td>         
                        <td><?=$cuota->getobservaciones()?></td>         
                        <td><div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>editar_cuota_vehiculo/<?=$cuota->getidCuota()?>?vehiculo=<?=$vehiculo->getId()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="../borrar_cuota_vehiculo/<?=$gasto->getidCuota()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta cuota?');"> 
                                <!--?vehiculo=<?=$vehiculo->getId()?> esto es para pasar en la URL la el numero de vehiculo que estamos editando y al borrar la foto poder cargar el mismo vehiculo -->  
                                <i class="bi bi-trash"></i>
                            </a>   
                            </div>
                        </td>
                    </tr>    
                <?php endforeach ;?>   
            </tbody>
        </table>            
    </div> 
</div>


<?php endif;?>
<script>
    $(document).ready(function() {
        $('#select-propietario').select2({
            placeholder: "Buscar propietario",
            allowClear: true,
            width: '100%'
        });
    
    mostrarMenuVehiculo('fotos');//al cargar muestro solo las fotos
    });
</script>

