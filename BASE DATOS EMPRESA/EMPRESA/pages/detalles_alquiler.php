<spam class = "etiqueta_desplazada blue">Alquiler de <?= $alquiler->getvehiculoInfo()->getMarca_modelo()?></spam> 
<div class = "bloque-movimiento"> 
    <table class = "mi_tabla">
        <caption>Alquiler inicial</caption>
        <thead>
            <tr>
                <th class="etiqueta">Cliente</th>
                <th class="etiqueta">Contrato</th>
                <th class="etiqueta">Comision</th>
                <th class="etiqueta">Fecha</th>
                <th class="etiqueta">Precio</th>
                <th class="etiqueta">Dias</th>
                <th class="etiqueta">Empresa</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td><?=$alquiler->getclienteInfo()->getNombre()?></td>
                    <td><?=$alquiler->getcontrato()?></td>
                    <td><?=number_format($alquiler->getcomisionComercial(), 2, ',', '.')?>€</td>
                    <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                    <td><?=number_format($alquiler->getprecio(), 2, ',', '.')?>€</td>
                    <td><?=$alquiler->getdias()?>€</td>
                    <td><?=$alquiler->getempresaInfo()->getNombre()?></td> 
                </tr>
        </tbody>
    </table>
    <p></p>
    <!--Ampliaciones-->
    <div class = "contenedor-tablas">
        <?php $totalAmpliaciones = $alquiler->getprecio(); //ampliaciones se inicia con el precio del alquiler y va sumando precio de ampliaciones
            $totalDias = $alquiler->getdias();  //dias se inicia con los dias del alquiler y va sumando dias de ampliaciones
            //IMPORTANTE inicializar aqui estos contadores porque si los pongo dentro del if y no existen ampliaciones, no se incian y mas abajo en la resta de importe - gastos para calcular el benicio del alquiler daria error 
        ?>
        <?php if (!empty($ampliaciones)) :?>
            <table class = "mi_tabla w400" >
                <caption>Alquiler+Ampliaciones</caption>
                <colgroup>
                    <col style="width: 100px;">
                    <col style="width: 100px;">
                    <col style="width: 100px;">
                    <col style="width: 80px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Comision</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                        <th>Dias</th>
                    </tr>
                    <tr><!--esto es para que los datos del alquiler salgan en la tabla ampliaciones en la 1º fila-->
                        <td><?=number_format($alquiler->getcomisionComercial(), 2, ',', '.')?>€</td>
                        <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                        <td><?=number_format($alquiler->getprecio(), 2, ',', '.')?>€</td>
                        <td><?=$alquiler->getdias()?></td> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ampliaciones as $ampliacion) :?>
                        <tr>
                            <?php $totalAmpliaciones += $ampliacion->getprecio();
                                    $totalDias += $ampliacion->getdias()
                            ?>
                            <td><?= number_format($ampliacion->getcomisionComercial(), 2, ',', '.');?>€</td>
                            <td><?= formatea_fecha($ampliacion->getfechaInicio())?></td>
                            <td><?= number_format($ampliacion->getprecio(), 2, ',', '.');?>€</td>
                            <td><?= $ampliacion->getdias()?></td>
                        </tr>
                    <?php endforeach ;?>
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td><?=number_format($totalAmpliaciones, 2, ',', '.')?>€</td>
                        <td><?=$totalDias?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif ;?>
        <!--Cobros-->
        <?php $totalCobros = 0; ?> <!--//IMPORTANTE inicializar aqui el contador, si no hay gastos no entra y no existiria el contador y daria error -->   
        <?php if (!empty($cobros)) :?>
            <table class = "mi_tabla" >
                <caption>Cobros</caption>
                <colgroup>
                    <col style="width: 100px;">
                    <col style="width: 100px;">
                    <col style="width: 300px;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="etiqueta" scope="col">Fecha</th>
                        <th class="etiqueta" scope="col">Importe</th>
                        <th class="etiqueta" scope="col">Facturado</th>
                        <th class="etiqueta" scope="col">Facturado a</th>
                        <th class="etiqueta" scope="col">Contrato Hacienda</th>
                        <th class="etiqueta" scope="col">Fianza</th>
                        <th class="etiqueta" scope="col">Parte importe fianza</th>
                        <th class="etiqueta" scope="col">Banco</th>
                        <th class="etiqueta" scope="col">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cobros as $cobro) :?>
                        <tr>
                            <?php $totalCobros += $cobro->getimporte();?> 
                            <td><?=formatea_fecha($cobro->getfecha())?></td>         
                            <td><?=number_format($cobro->getimporte(), 2, ',', '.');?>€</td>         
                            <td><?=$cobro->getfacturado() ? 'SI' : 'NO'?></td>         
                            <td><?=$cobro->getfacturadoA()?></td>         
                            <td><?=$cobro->getcontratoHacienda()?></td>         
                            <td><?=$cobro->getfianza() ? 'SI' : 'NO'?></td>         
                            <td><?=number_format($cobro->getparteImporteFianza(), 2, ',', '.');?>€</td>                  
                            <td><?=$cobro->getbanco()?></td>         
                            <td><?=$cobro->getobservaciones()?></td> 
                        </tr>
                    <?php endforeach ;?>
                    <tr>
                        <td>Total</td>
                        <td><?=number_format($totalCobros, 2, ',', '.')?>€</td>
                    </tr>
                </tbody>
            </table>
        <?php endif ;?>
            <!--Gastos-->
        <?php $totalGastos = 0; ?> <!--//IMPORTANTE inicializar aqui el contador, si no hay gastos no entra y no existiria el contador y daria error -->   
        <?php if (!empty($gastos)) :?>
            <table class = "mi_tabla" >
                <caption>Gastos</caption>
                <colgroup>
                    <col style="width: 100px;">
                    <col style="width: 100px;">
                    <col style="width: 300px;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gastos as $gasto) :?>
                        <tr>
                            <?php $totalGastos += $gasto->getimporte();?>
                            <td><?= formatea_fecha($gasto->getfecha())?></td>
                            <td><?= number_format($gasto->getimporte(), 2, ',', '.');?>€</td>
                            <td><?= $gasto->gettipo()?></td>
                        </tr>
                    <?php endforeach ;?>
                    <tr>
                        <td>Total</td>
                        <td><?=number_format($totalGastos, 2, ',', '.')?>€</td>
                    </tr>
                </tbody>
            </table>
        <?php endif ;?>
    </div>         
</div>
  