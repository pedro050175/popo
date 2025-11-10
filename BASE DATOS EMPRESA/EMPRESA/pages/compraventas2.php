<div>    
    <form action = "<?=DIRECTORIO?>compraventas" method="GET">
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="boton_submit">Buscar</button>   
            </div>  
            <div class="col-md-6">
                <input type="button"  class="boton_link" value = "Nuevo" onclick="window.location.href='<?= DIRECTORIO ?>nueva_compraventa';"> 
                <button type="button" class="boton_submit" id = "analizar">Analizar Trim.</button>
                <button type="button" class="boton_submit" id = "añadir">Añadir a Trim.</button>
                <button type="button" class="boton_submit" id = "sacar">Sacar de Trim.</button>
            </div>
        </div>
        <div class = "botones">
            <div class="col-md-2">    
                <input type="search" name="empresa" class="cuadro_text" id="empresa" placeholder="Empresa" value="<?= $_GET['empresa'] ?? ''?>">
            </div>
            <div class="col-md"><!-- al quitarle el numero a col-md se pegan mas los cuadros de buscar -->
                <input type="search" name="coche" class="cuadro_text" id="coche" placeholder="Coche/Matr/Bast" value="<?= $_GET['coche'] ?? ''?>">
            </div>
            <div class="col-md-4">    
                <input type="search" name="compraA" class="cuadro_text" id="compraA" placeholder="Compra a" value="<?= $_GET['compraA'] ?? ''?>">
                <input type="date" name="compraDesde" class="cuadro_text" id="compraDesde" value="<?= $_GET['compraDesde'] ?? ''?>">
                <input type="date" name="compraHasta" class="cuadro_text" id="compraHasta" value="<?= $_GET['compraHasta'] ?? ''?>">
            </div>
            <div class="col-md-0">    
                <label class = "etiqueta_mini" >Tri</label>
                <!--value="1" es para que $_GET['trimestre']=1 si esta marcado. si existe $_GET['trimestre'] es que ya se marco en una busqueda anterior, pues lo marco con checked -->
                <input type="checkbox" name="trimestre" class="cuadro_text" id="trimestre" value = "1" <?= isset($_GET['trimestre']) ? ($_GET['trimestre'] == 1 ? 'checked' : '') : ''?>>
            </div>
            <div class="col-md-4">   
                <input type="search" name="vendeA" class="cuadro_text" id="vendeA" placeholder="Vende a" value="<?= $_GET['vendeA'] ?? ''?>">
                <input type="date" name="vendeDesde" class="cuadro_text" id="vendeDesde" value="<?= $_GET['vendeDesde'] ?? ''?>">
                <input type="date" name="vendeHasta" class="cuadro_text" id="vendeHasta" value="<?= $_GET['vendeHasta'] ?? ''?>">
            </div>
        </div>
        <input type="hidden" name="num_pagina" class="cuadro_text" value="1">
    </form>
</div>
<form action = "<?=DIRECTORIO?>actualizaCompraventas" method="POST" id = "formActualiza">
    <input type = "hidden" name = "accion" value = "" id = "accion">
    <table class="table table-hover table-striped fina">
        <thead>
            <tr>    
                <th></th>
                <th style = "background: #c478f7ff; text-align: center;" colspan="3">Coche</th>
                <th style = "background: #8178f7ff; text-align: center;" colspan="8">Compra</th>
            </tr>
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th></th>

                <th style = "background: #78f79eff; text-align: center;" colspan="8">Venta</th>
            </tr>
            <tr>
                <td>X</td>
                <th scope="col">Empresa</th>
                <th scope="col">Vehiculo</th>
                <th scope="col">Matricula</th>
                <th scope="col">Bastidor</th>
                <th scope="col">Compra a</th>
                <th scope="col">Fecha</th>
                <th scope="col">Precio</th>
                <th scope="col">Precio.decla</th>
                <th scope="col">Fe.fact</th>
                <th scope="col">Impto.</th>
                <th scope="col">Declara</th>
                <th scope="col">Anulada</th>
                <th scope="col">Comercial venta</th>
                <th scope="col">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compraventas as $compraventa):?>
                <tr>
                    <td><input type = "checkbox" name = "actualiza[<?=$compraventa->getid_compraventa()?>]" id = <?=$compraventa->getid_compraventa()?>></td>
                    <td style="color: blue"><?=$compraventa->getempresaInfo()->getNombre()?></td>
                    <td class="tooltip-cell info" data-tooltip="<?=$compraventa->getvehiculoInfo()->getMarca_modelo()?> Km:<?=$compraventa->getvehiculoInfo()->getKm()?> Fecha:<?=$compraventa->getvehiculoInfo()->getFecha_matricula()?>">
                        <?=$compraventa->getvehiculoInfo()->getMarca_modelo()?>
                    </td>
                    <td><?=$compraventa->getvehiculoInfo()->getMatricula()?></td>
                    <td class="tooltip-cell info" data-tooltip="<?=$compraventa->getvehiculoInfo()->getBastidor()?>"><?=$compraventa->getvehiculoInfo()->getBastidor()?></td>
                    <td style="color: #8178f7ff"><?=$compraventa->getcompraAInfo()?->getNombre() ?? ''?></td>
                    <td><?=formatea_fecha($compraventa->getfechaCompra())?></td>
                    <td class="tooltip-cell info" data-tooltip="Pagos: <?=number_format($compraventa->getsumaPagos(), 2, ',', '.')?>€"><strong><?=number_format($compraventa->getprecioCompraReal(), 2, ',', '.')?>€</strong></td>
                    <td><?=number_format($compraventa->getprecioCompraDeclarado(), 2, ',', '.')?>€</td>
                    <td><?=formatea_fecha($compraventa->getfechaFactComp())?></td>
                    <td style="<?=$compraventa->getimpuestoCompra()=='NETO' ? 'color: #ff0000ff' : ''?>"><?=$compraventa->getimpuestoCompra()?></td>
                    <td><?=$compraventa->getnodeclaraComp() ? '--' : 'SI'?></td>
                    <td><?=$compraventa->getanuladaCompra() ? 'SI' : 'NO'?></td>
                    <td><?=$compraventa->getcomercialVenta()?></td>
                    <td class="tooltip-cell info" data-tooltip="<?= htmlspecialchars($compraventa->getobservaciones()) ?>">
                            <?= htmlspecialchars($compraventa->getobservaciones()) ?>              
                    </td>
                </tr>
                <tr>
                    <td class="tooltip-cell info" data-tooltip="Benef-IVA: <?=number_format($compraventa->beneficioMenosIVA(), 2, ',', '.')?>€">Benef-Gast</td>
                    <td style="<?=$compraventa->beneficio()<0 ? 'color: #f70000ff' : 'color: #4f33eeff'?>"><?=number_format($compraventa->beneficio(), 2, ',', '.')?>€</td>
                    <td>IVA</td>
                    <td style="<?=$compraventa->IVA()<0 ? 'color: #f70000ff' : 'color: #4f33eeff'?>"><?=number_format($compraventa->IVA(), 2, ',', '.')?>€</td>
                    <td style="color: #10b141ff"><?=$compraventa->getvendeAInfo()->getNombre() ?? ''?></td>
                    <td><?=formatea_fecha($compraventa->getfechaVenta())?></td>
                    <td class="tooltip-cell info" data-tooltip="Cobros: <?=number_format($compraventa->getsumaCobros(), 2, ',', '.')?>€"><strong><?=number_format($compraventa->getprecioVentaReal(), 2, ',', '.')?>€</strong></td>
                    <td><?=number_format($compraventa->getprecioVentaDeclarado(), 2, ',', '.')?>€</td>
                    <td><?=formatea_fecha($compraventa->getfechaFactVenta())?></td>
                    <td><?=$compraventa->getimpuestoVenta()?></td>
                    <td><?=$compraventa->getnodeclaraVenta() ? '--' : 'SI'?></td>
                    <td><?=$compraventa->getanuladaVenta() ? 'SI' : 'NO'?></td>
                    <td>Tri <input type = "checkbox" disabled <?=$compraventa->gettrimestre() ? 'checked': ''?>></td>

                    <td style="color: #b11010ff">Gast:<?=number_format($compraventa->getsumaGastos(), 2, ',', '.')?>€</td>
                    <td>
                    <div class="btn-group" role="group">
                        <a href="<?= DIRECTORIO ?>nueva_compraventa/<?=$compraventa->getid_compraventa()?>" role="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= DIRECTORIO ?>borrar_compraventa/<?=$compraventa->getid_compraventa()?>" class= "btn btn-sm btn-outline-danger" onclick="return confirm('Estas seguro que quieres borrar esta compra venta?');"> 
                        <i class="bi bi-trash"></i> 
                        </a>   
                    </div>
                    </td>  
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<div class="row mb-3">       
    <div class="col-md-2"> <em class="etiqueta">Compra ventas: <?=count($compraventas)?></em></div>
    <!--todo esto que sigue es para la paginacion-->
    <!-- en esta parte es donde se controla que no nos pasemos en el numero de pagina cuando le damos a siguiente o atras. El controller 
        o repository no necesita controlar eso, a el se le llegara una num_pagina valido en el $_GET -->
    <div class="col-md-6"> <em class="etiqueta">Pagina: <?=$_GET['num_pagina']?> de: <?= $numPaginas?></em></div>    
    <?php 
        $_GET['num_pagina'] < $numPaginas ? $num_pagina_sig = strval(intval($_GET['num_pagina']+1)) : $num_pagina_sig = 1;
    ?><!--calculo numero de pagina siguiente-->
    <?php 
        $_GET['num_pagina'] > 1 ? $num_pagina_atras = strval(intval($_GET['num_pagina'])-1) : $num_pagina_atras = 1;
    ?><!--calculo numero de pagina atras-->
    <!-- estoy paginando con los campos de busqueda -->
    <div class="col-md-4">
        <a href="/mis_pruebas/compraventas?num_pagina=<?=$num_pagina_atras?>&empresa=<?= $_GET['empresa'] ?? ''?>&coche=<?= $_GET['coche'] ?? ''?>&compraA=<?= $_GET['compraA'] ?? ''?>&compraDesde=<?= $_GET['compraDesde'] ?? ''?>&compraHasta=<?= $_GET['compraHasta'] ?? ''?>&vendeA=<?= $_GET['vendeA'] ?? ''?>&vendeDesde=<?= $_GET['vendeDesde'] ?? ''?>&vendeHasta=<?= $_GET['vendeHasta'] ?? ''?>&trimestre=<?=$_GET['trimestre'] ?? 0?>">[Atras</a>
        <a href="<?= DIRECTORIO ?>compraventas?num_pagina=<?=$num_pagina_sig?>&empresa=<?= $_GET['empresa'] ?? ''?>&coche=<?= $_GET['coche'] ?? ''?>&compraA=<?= $_GET['compraA'] ?? ''?>&compraDesde=<?= $_GET['compraDesde'] ?? ''?>&compraHasta=<?= $_GET['compraHasta'] ?? ''?>&vendeA=<?= $_GET['vendeA'] ?? ''?>&vendeDesde=<?= $_GET['vendeDesde'] ?? ''?>&vendeHasta=<?= $_GET['vendeHasta'] ?? ''?>&trimestre=<?=$_GET['trimestre'] ?? 0?>">Siguiente]</a>
        <a href="<?= DIRECTORIO ?>compraventas?num_pagina=1&empresa=<?= $_GET['empresa'] ?? ''?>&coche=<?= $_GET['coche'] ?? ''?>&compraA=<?= $_GET['compraA'] ?? ''?>&compraDesde=<?= $_GET['compraDesde'] ?? ''?>&compraHasta=<?= $_GET['compraHasta'] ?? ''?>&vendeA=<?= $_GET['vendeA'] ?? ''?>&vendeDesde=<?= $_GET['vendeDesde'] ?? ''?>&vendeHasta=<?= $_GET['vendeHasta'] ?? ''?>&trimestre=<?=$_GET['trimestre'] ?? 0?>">[Inicio</a>
        <a href="<?= DIRECTORIO ?>compraventas?num_pagina=<?=$numPaginas?>&empresa=<?= $_GET['empresa'] ?? ''?>&coche=<?= $_GET['coche'] ?? ''?>&compraA=<?= $_GET['compraA'] ?? ''?>&compraDesde=<?= $_GET['compraDesde'] ?? ''?>&compraHasta=<?= $_GET['compraHasta'] ?? ''?>&vendeA=<?= $_GET['vendeA'] ?? ''?>&vendeDesde=<?= $_GET['vendeDesde'] ?? ''?>&vendeHasta=<?= $_GET['vendeHasta'] ?? ''?>&trimestre=<?=$_GET['trimestre'] ?? 0?>">Fin]</a>
    </div>
    <p class = "etiqueta">IVA negativo: se desgraba, positivo a pagar. Benef-Gast positivo es que se gana (se vende mas caro que se compra), negativo se pierde. Meter solo los gastos propios de la compraventa, para sacar estadisticas solo de la compraventa. Si el coche es para alquiler meter los gastos de la compraventa en gastos de coche para que se tengan en cuenta en las estadisticas de alquileres, por ejemplo el pago de una entrada</p>
</div>  
<script>
$(document).ready(function() {
    if (document.getElementById("empresa").value!=""){
        document.getElementById("empresa").focus();
    }
    if (document.getElementById("coche").value!=''){
        document.getElementById("coche").focus();
    }
    if (document.getElementById("compraA").value!=""){
        document.getElementById("compraA").focus();
    }
    if (document.getElementById("vendeA").value!=""){
        document.getElementById("vendeA").focus();
    }
    tooltip();
    
    document.getElementById("analizar").addEventListener("click", function(){
        let nuevaVentana = window.open("", "_blank", "width=,height=800");
        fetch('/mis_pruebas/analisis_compraventas_tri')
        .then(response => {
                return response.text();
        })
        .then(data => {
            nuevaVentana.document.write(data);
            nuevaVentana.document.close(); /* indica que has terminado, y el navegador puede mostrar la página completa. es necesario para algunos navegadores */
            /* tooltip se llama al final de la pagina que se carga. Pero si no se pudiera se prodria hacer desde aqui de varias formas interesantes, ver Word explicaciones*/
        })
        .catch(error => {
            cont.innerHTML = "Error: " + error;
        }); 
    });
    document.getElementById("añadir").addEventListener("click", function(){
        let accion = document.getElementById("accion");
        accion.value = "añadirTri";
        let formulario = document.getElementById("formActualiza");
        formulario.submit();
    });
});
</script>