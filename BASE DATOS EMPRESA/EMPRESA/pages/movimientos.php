<div class="container mt-4">
    <div class="row">
        <div class="col-md-7">
            <form action="<?= DIRECTORIO ?>movimientos" method="get" class="d-flex">
                <?php
                    $enviaActual = $_GET['envia'] ?? '';
                    foreach ($entidades as $entidad){
                        $listaEntidades[$entidad->getId()] = $entidad->getNombre();
                    }
                ?>
                <select name="envia" class="form-select" id="selectEnvia">
                    <option disabled value = "" <?= $enviaActual == '' ? 'selected' : '' ?>></option>
                    <?php foreach ($listaEntidades as $id => $entidad): ?> 
                        <option value="<?= $id?>" <?= $id == $enviaActual ? 'selected' : '' ?>><?= $entidad ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
                    $recibeActual = $_GET['recibe'] ?? '';
                ?>
                <select name="recibe" class="form-select" id="selectRecibe">
                    <option disabled value = "" <?= $recibeActual == '' ? 'selected' : '' ?>></option>
                    <?php foreach ($listaEntidades as $id => $entidad): ?> 
                        <option value="<?= $id?>" <?= $id == $recibeActual ? 'selected' : '' ?>><?= $entidad ?></option>
                    <?php endforeach; ?>
                </select>                
                <input type="search" name="vehiculo_id" class="form-control me-1" id="floatingInput" placeholder="vehiculo/concepto" value="<?= $_GET['vehiculo_id'] ?? ''?>">
                <button type="submit" class="boton_submit">Buscar</button>  
            </form>
        </div>
        <div class="col-md-1"> 
             <input type="button" class="boton_link" value = "Analizar" onclick="window.location.href='<?= DIRECTORIO ?>analisis_movimientos';">
        </div>
        <div class="col-md-2"> 
             <input type="button" class="boton_link" value = "Resumen" onclick="window.location.href='<?= DIRECTORIO ?>deuda_empresas';">
        </div>
        <div class="col-md-1">
            <input type="button" class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nuevo_movimiento';"> 
        </div>
    </div>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <table class="table table-hover table-striped medio">
            <thead>
                <tr>
                <th class="etiqueta" scope="col">Fecha</th>
                <th class="etiqueta" scope="col">Envia</th>
                <th class="etiqueta" scope="col">Recibe</th>
                <th class="etiqueta" scope="col">Concepto</th>
                <th class="etiqueta" scope="col">Envia</th>
                <th class="etiqueta" scope="col">Devuelve</th>
                <th class="etiqueta" scope="col">Debe</th>
                <th class="etiqueta" scope="col">Vehiculo</th>
                <th class="etiqueta" scope="col">Propietario</th>
                <th class="etiqueta" scope="col">Observaciones</th>
                <th class="etiqueta" scope="col">Finalizado</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach($movimientos as $movimiento) :?>
                <tr>
                    <?php $total += $movimiento->getdiferencia(); ?>
                    <td><?=formatea_fecha($movimiento->getfecha())?></td>
                    <td><?=$movimiento->getenviaInfo()->getNombre()?></td>
                    <td><?=$movimiento->getrecibeInfo()->getNombre()?></td>
                    <td class = "info" title="<?=$movimiento->getconcepto()?>"><?=$movimiento->getconcepto()?></td>
                    <td><?=number_format($movimiento->gettotalEntrega(), 2, ',', '.')?>€</td>
                    <td><?=number_format($movimiento->gettotalDevolucion(), 2, ',', ',')?>€</td>
                    <td><?=number_format($movimiento->getdiferencia(), 2, ',', '.')?>€</td>
                    <td><?=$movimiento->getvehiculoInfo()?->getMarca_modelo() ?? ''?></td> <!-- si getvehiculoInfo() es null se va al ?? y devuelve ''-->
                    <td><?=$movimiento->getvehiculoInfo()?->getdatos_propietario()?->getNombre() ?? ''?></td><!-- si getvehiculoInfo() o getdatos_propietario() es null se va al ?? y devuelve ''-->
                    <td class = "info" title="<?=$movimiento->getobservaciones()?>"><?=$movimiento->getobservaciones()?></td><!--con title aparece el texto completo al poner el raton encima del campo observaciones-->
                    <td><?=$movimiento->getterminado() ? 'SI' : 'NO'?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?= DIRECTORIO ?>nuevo_movimiento/<?=$movimiento->getidMovimiento()?>" role="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= DIRECTORIO ?>borrar_movimiento/<?=$movimiento->getidMovimiento()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar este movimiento?');"> 
                              <i class="bi bi-trash"></i>
                            </a><!--se abre en niva ventana con  target="_blank" rel="noopener noreferrer"-->
                            <a href="<?= DIRECTORIO ?>detalles_movimiento/<?=$movimiento->getidMovimiento()?>"  target="_blank" rel="noopener noreferrer" class= "btn btn-sm btn-outline-primary"> 
                              <i class="bi bi-eye"></i>
                            </a>    
                        </div>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row mb-3">       
            <div class="col-md-5"></div>
            <div class="col-md-2">
                <p class = "etiqueta">Suma: <?=number_format($total, 2, ',', '.')?>€</p>
            </div>
        </div>
        <div class="row mb-3">       
            <div class="col-md-2"> <em class="etiqueta">Movimientos: <?=count($movimientos)?></em></div>
            <!--todo esto que sigue es para la paginacion-->
             <?php if (isset($_GET['num_pagina'])) :?>
                <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
                <?php $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;?><!--calculo numero de pagina siguiente-->
                <?php $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;?><!--calculo numero de pagina atras-->
                <div class="col-md-4"><a href="/mis_pruebas/movimientos?num_pagina=<?=$num_pagina_atras?>">[Atras</a>
                <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$num_pagina_sig?>">Siguiente]</a>
                <a href="<?= DIRECTORIO ?>movimientos?num_pagina=1">[Inicio</a>
                <a href="<?= DIRECTORIO ?>movimientos?num_pagina=<?=$numPaginas?>">Fin]</a></div>
            <?php endif ;?>
        </div>  
    </div>
</div>
<!-- los numeros despues de las letras son los id de cada empresa para poner ese id en el name de la lista desplegable -->
<div>
    <table class="table table-hover table-striped fino">
        <thead>
        </thead>
        <tbody>
                <tr>
                    <td>
                        <ul>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=2&recibe=1" id = "2_1">World a Stelar</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=2&recibe=3" id = "2_3">World a Universo</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=2&recibe=33" id = "2_33">World a Martin</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=2&recibe=32" id = "2_32">World a Magna</a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=3&recibe=1" id = "3_1">Universo a Stelar</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=3&recibe=2" id = "3_2">Universo a World</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=3&recibe=33" id = "3_33">Universo a Martin</a>
                            </li>
                        </ul>    
                    </td>
                    <td>
                        <ul>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=1&recibe=3" id = "1_3">Stelar a Universo</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=1&recibe=2" id = "1_2">Stelar a World</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=1&recibe=33" id = "1_33">Stelar a Martin</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=1&recibe=32" id = "1_32">Stelar a Magna</a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=32&recibe=1" id = "32_1">Magna a Stelar</a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=33&recibe=1" id = "33_1">Martin a Stelar</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=33&recibe=2" id = "33_2">Martin a World</a>
                            </li>
                            <li>
                                <a href = "<?= DIRECTORIO ?>movimientos?envia=33&recibe=3" id = "33_3">Martin a Universo</a>
                            </li>
                        </ul>
                    </td>
                </tr>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
        $('#selectEnvia').select2({
            placeholder: "Buscar envia",
            allowClear: true,
            width: '100%'
        });
        $('#selectRecibe').select2({
            placeholder: "Buscar recibe",
            allowClear: true,
            width: '100%'
        });
    });
</script>