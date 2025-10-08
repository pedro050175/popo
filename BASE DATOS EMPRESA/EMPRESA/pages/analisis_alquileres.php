<?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
<?php endif; ?>
<form action="<?= DIRECTORIO ?>analisis_alquileres" method="get" class="d-flex">
    <fieldset class="mi-fieldset">
    <legend class="mi-legend">Analisis coche</legend>
    <div class = bloque-movimiento>
        <div class="row">
            <div class="col-md-3">
                <label for="desde" class="etiqueta">Desde:</label>
                <input type="date" name="desde" class="cuadro_text" id="desde" value = "<?= $_GET['desde'] ?? ''?>" required>
            </div>
            <div class="col-md-3">
                <label for="hasta" class="etiqueta">Hasta:</label>
                <input type="date" name="hasta" class="cuadro_text" id="hasta" value = "<?= $_GET['hasta'] ?? ''?>" required>
            </div>
            <?php
                $vehiculoActual = $_GET['cocheId'] ?? '';
                foreach ($vehiculos as $vehiculo){
                    $listaVehiculos[$vehiculo->getId()] = $vehiculo->getMarca_modelo(). ' ' .$vehiculo->getMatricula() . ' ' .$vehiculo->getBastidor();//con la variable $entidades creo un array asociativo ['id']=Nombre
                }
            ?>            
            <div class="col-md-4">
                <label for="select_vehiculo" class="form-label">Vehiculo</label><!--label fuera del floating para que no se solape con el cuadro de texto -->
                <div class="form-floating mb-1">
                    <select name="cocheId[]" multiple
                            class="form-select" id="select_vehiculo" 
                            required
                            oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                            oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                        
                        <?php foreach ($listaVehiculos as $id => $vehiculo): ?><!--el id es un numero y $_GET['cocheId'] es un string y en la comparacion ($id === $vehiculoActual) === dice igual valor y tipo con lo que nucan son iguales hay que poner solo ==--> 
                            <option value="<?= $id?>" <?= $id == $vehiculoActual ? 'selected' : '' ?>><?= $vehiculo ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>alquileres?num_pagina=1';">
                <button type="reset" class="boton_link">Borrar</button>
                <button type="submit" class="boton_link" onclick = "validaFechas(this.form.desde.value, this.form.hasta.value)">Analizar</button>
                <button type="button" class="boton_link" id = "botonMeses">Por meses</button>
            </div>
        </div>
    </div>
    </fieldset>
</form>
<?php $totalAlquileres = 0;
      $totalGastosAlquileres = 0;
?>
<?php if (!empty($alquileres)) :?>
    <spam class = "etiqueta_desplazada blue">Alquileres de <?= $alquileres[0]->getvehiculoInfo()->getMarca_modelo()?></spam> 
    <?php foreach ($alquileres as $alquiler):?>
        <div class = "bloque-movimiento">
            <?php
                $totalAlquileres += $alquiler->getprecio()+$alquiler->getsumaPrecio(); //precio alquiler actual + precio de todas las ampliaciones
                $alquilerActual = $alquiler->getid();
            ?> 
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
                <?php if (!empty($ampliaciones[$alquilerActual])) :?>
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
                            <?php foreach ($ampliaciones[$alquilerActual] as $ampliacion) :?>
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
                    <!--Gastos-->
                <?php $totalGastos = 0; ?> <!--//IMPORTANTE inicializar aqui el contador, si no hay gastos no entra y no existiria el contador y daria error -->   
                <?php if (!empty($gastos[$alquilerActual])) :?>
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
                            <?php foreach ($gastos[$alquilerActual] as $gasto) :?>
                                <tr>
                                    <?php $totalGastos += $gasto->getimporte();?>
                                    <td><?= formatea_fecha($gasto->getfecha())?></td>
                                    <td><?= number_format($gasto->getimporte(), 2, ',', '.');?>€</td>
                                    <td><?= $gasto->gettipo()?></td>
                                </tr>
                            <?php endforeach ;?>
                            <?php $totalGastosAlquileres += $totalGastos; ?>
                            <tr>
                                <td>Total</td>
                                <td><?=number_format($totalGastos, 2, ',', '.')?>€</td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif ;?>
            </div>
            <p>Beneficio de este alquiler: <?=number_format($totalAmpliaciones-$totalGastos, 2, ',', '.')?>€</p>                
        </div>
    <?php endforeach ;?>
    <table class = "tabla_resumen" >
        <caption>Resumen</caption>
        <thead>
            <tr>
                <th>Total Alquileres</th>
                <th>Total Gastos</th>
                <th>Total Beneficio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> <?= number_format($totalAlquileres,2,',','.')?>€</td>
                <td> <?= number_format($totalGastosAlquileres,2,',','.')?>€</td>
                <td> <?= number_format($totalAlquileres-$totalGastosAlquileres,2,',','.')?>€</td>
            </tr>
        </tbody>
    </table>
<?php endif ;?>

<div id="contenidoMeses"></div>

<script>
    document.getElementById("botonMeses").addEventListener("click", function(){
        const cont = document.getElementById("contenidoMeses");
        if (cont.style.display === "none" || cont.style.display === "") {//si no esta visible ejecuto todo
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            var cocheIds = new Array;
            var selectVehiculo = document.getElementById("select_vehiculo");
            for (var i=0; i<selectVehiculo.length; i++){
                if (selectVehiculo.options[i].selected){
                    cocheIds.push(selectVehiculo.options[i].value);
                }
            }
            console.log (cocheIds); 
            let okFechas = validaFechas(desde, hasta);
            if (desde && hasta && cocheIds.length > 0 && okFechas){//compruebo que hayan datos if (desde) equivale a (desde!="")
                //fetch('/mis_pruebas/total_alquileres_vehiculo?desde=' + desde + '&hasta=' + hasta + '&coche= ' + coche) para un solo coche metodo GET, paso datos en la URL 
                fetch('/mis_pruebas/total_alquileres_vehiculo', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        desde: desde,
                        hasta: hasta,
                        cocheIds: cocheIds
                    })
                })
                .then(response => {
                        console.log("Respuesta HTTP:", response.status);
                        return response.text()
                    })
                .then(data => {
                    console.log("Contenido recibido:", data);
                    cont.innerHTML = data;
                    cont.style.display = "block"; //muestro los datos
                    document.getElementById("botonMeses").innerText = "Ocultar datos";//cambio el texto del boton
                })
                .catch(error => {
                    console.error("Error en fetch:", error);
                    document.getElementById("contenidoMeses").innerHTML = "Error: " + error;
                });
            }
        }else {// Si ya está visible → lo ocultamos
                cont.style.display = "none";
                document.getElementById("botonMeses").innerText = "Mostrar datos";
            }
    });

    $(document).ready(function() {
        $('#select_vehiculo').select2({
            placeholder: "Buscar vehiculo",
            allowClear: true,
            width: '100%'
        });
    });
</script>