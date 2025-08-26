<div class="container mt-4">
    <div class="col text-end">  
        <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>vehiculos?num_pagina=1';">   
    </div>
    <div class="card bg-white text-dark border">
        <div class="card-header bg-light text-dark border-bottom">
                <h4 class="titulo_prin"><i class="bi bi-car-front-fill me-2"></i>Información del Vehículo</h4>
        </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Id: </strong><?=$vehiculo->getId()?></div>
            </div>
            <div class="col-md-10">
                <div class="border p-2 rounded"><strong>Marca y Modelo: </strong><?=$vehiculo->getMarca_modelo()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Matrícula: </strong><?=$vehiculo->getMatricula()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><strong>Bastidor: </strong><?=$vehiculo->getBastidor()?></div>
            </div>
            <div class="col-md-4">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Fecha 1º matrícula: </strong><?=formatea_fecha($vehiculo->getFecha_matricula())?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Kilometros: </strong><?=$vehiculo->getKm()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Combustible: </strong><?=$vehiculo->getCombustible()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Fecha ITV: </strong><?=formatea_fecha($vehiculo->getFecha_itv())?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><i class="bi bi-calendar-check"></i> <strong>Prox. ITV: </strong><?=formatea_fecha($vehiculo->getProx_itv())?></div>
            </div>
        </div>
        <div class="row mb-3">        
            <div class="col-md-2">
                <div class="border p-2 rounded"><strong>Estado: </strong><?=$vehiculo->getEstado()?></div>
            </div>
            <div class="col-md-3">
                <div class="border p-2 rounded"><strong>Clase: </strong><?=$vehiculo->getClase()?></div>
            </div>
            <div class="col-md-6">
                <div class="border p-2 rounded"><strong>Propietario: </strong><?=$vehiculo->getdatos_propietario()->getNombre()?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="border p-2 rounded"><strong>Observaciones: </strong><?=$vehiculo->getObservaciones()?></div>
            </div>
        </div>                 
    </div>
</div>
    <div class="btn-group">
        <a href="<?= DIRECTORIO ?>nuevo_vehiculo/<?=$vehiculo->getId()?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
    </div>
</div>
<!--Fotos-->
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
                            $foto->getdestacada() ? $w = 150 : $w = 100;
                            $foto->getdestacada() ? $h = 100 : $h = 70;
                        ?>
                        <td><?=$foto->geturl()?></td>
                        <td><?=$foto->getdescripcion()?></td>
                        <td><img src="<?=FOTOS_VEHICULOS_SERVIDOR.$foto->nombre_foto_server()?>" width="<?=$w?>" height="<?=$h?>" alt=<?= rawurlencode($foto->nombre_foto_server())?>></td><!--rawurlencode sirve para cambiar los espacios por %20. si el nombre de la imagen lleva espacio daria error si no se usa rawurlencode, eso hace falta si pongo la ruta sin "ruta", si la pongo entre comillas no hace falt usar rawurlencode-->
                <!--he puesto un src con "" y sin rawurlencode y otro sin "" y con rawurlencode-->            
                    </tr>
                <?php endforeach ;?>     
            </tbody>
    </table>            
</div> 
<!--Gastos-->
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
                        <td><?=$gasto->getPaga_otro()? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getPagado()? 'SI' : 'NO'?></td>         
                        <td><?=$gasto->getComentarios()?></td>         
                    </tr>    
                <?php endforeach ;?>   
            </tbody>
    </table>  
    <p class='etiqueta_desplazada'> Suma: <?=number_format($totalGastos, 2, ',', '.')?>€</p>          
</div> 

    
        


