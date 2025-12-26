<form action="<?= DIRECTORIO ?>nuevo_vehiculo" method="post">
    <?php if (isset($vehiculo)) :?>
    <input type="hidden" name="data[vehiculo][id_vehiculo]" id='id_vehiculo' value="<?=$vehiculo->getId()?>">
    <?php endif;?>      
    <div class="container mt-1"><!--esto desplaza a la derecha un poco todo lo que haya dentro, tablas, etiquetas etc-->
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($vehiculo)) ? 'Modificar' : 'Nuevo'?> Vehiculo</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" id = "salir">   
                <button type="submit" class="boton_submit disable" disabled id = "botonGuardar" onclick="return validarDatos(this.form)"> <?= (isset($vehiculo)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($vehiculo)) ? 'hidden' : ''?>>Limpiar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">    
                <div class="form-floating mb-1">
                    <input type="text" name="data[vehiculo][Marca_modelo]" class="form-control" id="marcaModelo" placeholder="Marca_modelo" value="<?=(isset($vehiculo))?quitaEspecialChar($vehiculo->getMarca_modelo()):''?>" required> 
                    <label for="Marca_modelo">Marca y modelo</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating mb-1">
                    <input type="text" name="data[vehiculo][Matricula]" class="form-control" id="Matricula" placeholder="Matricula" value="<?=(isset($vehiculo))?quitaEspecialChar($vehiculo->getMatricula()):''?>">
                    <label for="Matricula">Matrícula</label>
                </div>
            </div>
            <div class="col-md-3">   
                <div class="form-floating mb-1">
                    <input type="text" name="data[vehiculo][Bastidor]" class="form-control" id="Bastidor" placeholder="Bastidor" value="<?=(isset($vehiculo))?quitaEspecialChar($vehiculo->getBastidor()):''?>">
                    <label for="Bastidor">Bastidor</label>
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="form-floating mb-1">
                    <input type="number" name="data[vehiculo][Km]" class="form-control" id="kilometros" placeholder="Kilometros" value="<?=(isset($vehiculo))?$vehiculo->getKm():''?>">
                    <label for="kilometros">Kilometros</label>
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
                            <option value="<?= $opcion ?>" <?= $opcion === $estadoActual ? 'selected' : ''?>><?= $opcion ?></option>
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
                $propietarioActual = $propietarioActual!=0 ? $propietarioActual : '';
                if ($propietarioActual != ''){
                        $propietarioMostrar =  htmlspecialchars($vehiculo->getdatos_propietario()->getNombre());    
                    }else $propietarioMostrar = '';
            ?>
            <div class="col-md-3">
                <label for="select-propietario" class="form-label">Propietario</label>
                <div class="form-floating mb-1">
                    <select name="data[vehiculo][propietario]" class="form-select" id="select-propietario" data-placeholder = "Buscar propietario...">
                        <option value =""></option>
                            <option value="<?= $propietarioActual?>" <?= $id == $propietarioMostrar ? 'selected' : '' ?>><?= $propietario ?></option>
                    </select> 
                </div>
            </div>
        </div>   
        <div class="col-md-4">
            <div class="form-floating mb-1">
                <input type="text" name="data[vehiculo][Observaciones]" class="form-control" id="Observaciones" placeholder="Observaciones" value="<?=(isset($vehiculo))?quitaEspecialChar($vehiculo->getObservaciones()):''?>">
                <label for="Observaciones">Observaciones</label>
            </div>
        </div>           
    </div>
</form>

<?php if (isset($vehiculo)) :?>
<!--Menu--> 
<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4 botones">                          
        <button type="button" class="boton_menu" id="boton_fotos"  onclick="mostrarMenuVehiculo('fotos')">Fotos</button>
        <button type="button" class="boton_menu" id="boton_gastos" onclick="mostrarMenuVehiculo('gastos')">Gastos</button>        
        <button type="button" class="boton_menu" id="boton_cuotas" onclick="mostrarMenuVehiculo('cuotas')">Cuotas</button>  
        <?php $menuMostrar = $_COOKIE["menuVehiculo"] ?? 'fotos'?> <!--la 1º vez muestra menu fotos. esto se controla directamente sobre el atributo hidden de del div correspondiente a cada seccion-->     
    </div> 
</div>
<!--FOTOS-->
<div class=contenedor id="fotos" <?= $menuMostrar!="fotos" ? "hidden" : '' ?>>
    <button type="button" class="boton_link small" id="boton_form_fotos" onclick="mostrar('form_fotos')">+</button>
<!-- formulario para nueva fotos -->
    <form action="<?= DIRECTORIO ?>nueva_foto" method="post" enctype="multipart/form-data" id = "form_fotos" hidden>
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
                    <label class="etiqueta" for="destacada">Destacada:</label><input class="cuadro_text" type="checkbox" name="foto[destacada]" id="destacada">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="boton_submit">Guardar Foto</button>
                </div>
            </div>
            <input type="hidden" name="foto[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo">
            <label class="etiqueta" for="descripcion">Descripcion: </label>
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
                                <a href="../borrar_foto_vehiculo/<?=$foto->getid()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta foto?');"> 
                                <!--?vehiculo=<?=$vehiculo->getId()?> esto es para pasar en la URL la el numero de vehiculo que estamos editando y al borrar la foto poder cargar el mismo vehiculo -->  
                                <i class="bi bi-trash"></i>
                                </a>   
                                <a href="<?= DIRECTORIO ?>fotos_vehiculo/<?=$foto->nombre_foto_server()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i>
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
<div class=contenedor id="gastos" <?= $menuMostrar!="gastos" ? "hidden" : '' ?>>
    <button type="button" class="boton_link small" id="boton_form_fotos" onclick="mostrar('form_gastos')">+</button>
    <!--Formulario nuevo gasto--> 
    <form action="<?= DIRECTORIO ?>nuevo_gasto_vehiculo" method="post" id = "form_gastos" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nuevo Gasto</legend>
            <div class="row">
                <div class="col-md-4">
                    <label for="tipo" class="etiqueta">Tipo:</label> 
                    <input size=40 class="cuadro_text" type="text" name="gasto[tipo]" id="tipo" placeholder="Tipo" required>
                </div>        
                <div class="col-md-3">
                    <label class="etiqueta" for="importe" >Importe:</label>
                    <input class="cuadro_text" type="text" name="gasto[importe]" id="importe" placeholder="Importe" required>
                </div>
                <div class="col-md-3">
                    <label class="etiqueta" for="fecha" >Fecha:</label>
                    <input class="cuadro_text" type="date" name="gasto[fecha]" id="fecha" placeholder="Fecha" required>
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="paga_otro" >Paga otro:</label>
                    <input class="cuadro_text" type="checkbox" name="gasto[paga_otro]" id="paga_otro">
                </div>
                <div class="col-md-2">
                    <label class="etiqueta" for="pagado" >Pagado:</label>
                    <input class="cuadro_text" type="checkbox" name="gasto[pagado]" id="pagado">
                </div>
                <div class="col-md-6">
                    <label class="etiqueta" for="comentarios" >Comentarios:</label>
                    <input size=60 class="cuadro_text" type="text" name="gasto[comentarios]" id="comentarios" placeholder="Comentarios">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="boton_submit" onclick= "return validar_entero_campo_text(form.importe)" >Guardar Gasto</button>
                    <button type="reset" class="boton_submit">Limpiar</button>
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
        <table class="table table-hover table-striped fina">
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
                    <tr><!-- gastos del vehiculo -->
                        <?php $totalGastos += $gasto->getImporte();?> 
                        <td><?=$gasto->getTipo()?></td>
                        <td><?=number_format($gasto->getImporte(), 2, ',', '.');?>€</td>         
                        <td><?=formatea_fecha($gasto->getFecha())?></td>         
                        <td><?=$gasto->getpaga_otro() ? 'SI' : 'NO'?></td>         
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
                <tr>
                    <td colspan="6">Gastos Compra-Ventas(para editar o borrar vaya al menu compraventa correspondiente)</td>
                </tr>
                <?php foreach($gastosCompraventa as $gasto) :?>
                    <tr><!-- gastos de las compraventas del vehiculo -->
                        <?php $totalGastos += $gasto->getimporte();?> 
                        <td><?=$gasto->gettipo()?></td>
                        <td><?=number_format($gasto->getimporte(), 2, ',', '.');?>€</td>         
                        <td><?=formatea_fecha($gasto->getfecha())?></td>         
                        <td><?=$gasto->getpagaOtro() ? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getpagado() ? 'SI' : 'NO'?></td> 
                        <td><?=$gasto->getobservaciones()?></td>   
                        <td></td>     
                    </tr>    
                <?php endforeach ;?>
            </tbody>
        </table>            
        <p class='etiqueta_desplazada'> Suma: <?=number_format($totalGastos, 2, ',', '.')?>€</p>
    </div> 
</div>
<div class=contenedor id="cuotas" <?= $menuMostrar!="cuotas" ? "hidden" : '' ?>>
    <!--Formulario nueva cuota--> 
    <button type="button" class="boton_link small" id="boton_form_fotos" onclick="mostrar('form_cuotas')">+</button>
    <form action="<?= DIRECTORIO ?>nueva_cuota_vehiculo" method="post" id = "form_cuotas" hidden>
        <fieldset class="mi-fieldset">
            <legend class="mi-legend">Nueva Cuota</legend>
            <div class="row">
            <?php
                $tipoCuota = ['Renting', 'Financiado'];
            ?>
            <div class="col-md-3">  
                <div class="form-floating mb-1">
                    <select name="cuota[tipo]" class="form-select" id="tipo" required>
                        <option value="" disabled selected >--Seleccione tipo--</option> 
                        <?php foreach ($tipoCuota as $opcion): ?>
                            <option value="<?= $opcion ?>"><?= $opcion ?></option>
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
                <input class="cuadro_text" type="text" name="cuota[cuota]" id="cuota">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="totalPagar" >Total pagar:</label>&nbsp
                <input class="cuadro_text" type="text" name="cuota[totalPagar]" id="totalPagar">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="pagoFinal" >Pago final:</label>&nbsp
                <input class="cuadro_text" type="text" name="cuota[pagoFinal]" id="pagoFinal">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="entrada" >Entrada:</label>&nbsp
                <input class="cuadro_text" type="text" name="cuota[entrada]" id="entrada">
            </div>
            <div class="col-md-2">
                <label class="etiqueta" for="fianza" >Fianza:</label>&nbsp
                <input class="cuadro_text" type="text" name="cuota[fianza]" id="fianza">
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
            <div class="col-md-4">
                <label for="select-titular-cuota" class="etiqueta">Titular</label>
                <div class="form-floating mb-3">
                    <select name="cuota[titular]" class="form-select" 
                        id="select-titular-cuota" data-placeholder = "Titular cuota..." required>
                        <option value="">--</option><!--hay que poner value="" para que el required funcione, de lo contrario si deja enviar sin elegir nada -->
                </div>
            </div>
            <div class="col-md-4">
                <label class="etiqueta" for="observaciones" >Observaciones:</label>&nbsp
                <input size=80 class="cuadro_text" type="text" name="cuota[observaciones]" id="observaciones" placeholder="observaciones">
            </div>
            <div class="col-md-4">
                <button type="submit" class="boton_submit" onclick="return validarCuotas(this.form)">Guardar Cuota</button>
                <button type="reset" class="boton_submit">Limpiar</button>
            </div>
            </div>
            <input type="hidden" name="cuota[id_vehiculo]" value="<?=$vehiculo->getId()?>" id="id_veviculo">
            <!--<button type="button" onclick="validarCuotas(this.form)">Validar datos</button> OJO al boton hay que ponerle typpe boton porque si no se poner por defecto se comporta como un submit-->
        </fieldset>
    </form>  
    <!--listado Cuotas-->
    <p class="titulo_sec">Cuotas</p>
    
    <div>
        <table class="table table-hover table-striped fina">
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
                            <a href="../borrar_cuota_vehiculo/<?=$cuota->getidCuota()?>?vehiculo=<?=$vehiculo->getId()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta cuota?');"> 
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
<script>
    color_boton_menu();//para poner en azul el boton del MENU que se haya activado al consultar la cookie. No lo puedo hacer junto al scritp de abajo porque cuando es nuevo vehiculo, como no carga la parte 
    //de los MENU la funciona color_boton_menu da error al no encontrar los id de los menu y entonces tampoco no aplica la funci9n busqueda a los selectores de titular y propietario
</script>
<?php endif;?>
<script>
    $(document).ready(function() {

        selectAjaxEntidades(document.getElementById('select-propietario'));
        let cuota = document.getElementById('select-titular-cuota');
        if (cuota != null) {
            selectAjaxEntidades(cuota);
        }
            /* $('#select-titular-cuota').select2({
            placeholder: "Buscar titular",
            allowClear: true,
            width: '100%'
        }); */
        /*para controlar el gardar formulario */
        var estadoFormulario = { modificado: false };
        guardarDatos(document.forms[0], '<?= DIRECTORIO ?>vehiculos?num_pagina=1', estadoFormulario);
        document.getElementById('marcaModelo').focus();
    });
</script>

