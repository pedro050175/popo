<!-- los gastos del vehiculo y los gastos de las compraventas del vehiculo se tienen en cuenta para calcular el beneficio del vehiculo, los gastos del alquiler
 no se tienen en cuenta porque asi se ha hecho desde siempre ya que hay se menten gastos que no son para el analisis total sino para los inversores -->
<?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
<?php endif; ?>
<form action="<?= DIRECTORIO ?>analisis_alquileres" method="get" class="d-flex" id="formAnalizar">
    <fieldset class="mi-fieldset">
    <legend class="mi-legend">Analisis coche</legend>
    <div class = bloque-movimiento>
         <div class="col-md-2">
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>alquileres?num_pagina=1';">
            </div>
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
            <div class="col-md-5">
                <label for="select_vehiculo" class="etiqueta">Vehiculo</label><!--label fuera del floating para que no se solape con el cuadro de texto -->
                <div class="form-floating mb-1">
                    <select name="cocheId" multiple
                            class="form-select" id="select_vehiculo" 
                            required
                            oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                            oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                        
                        <?php foreach ($listaVehiculos as $id => $vehiculo): ?><!--el id es un numero y $_GET['cocheId'] es un string y en la comparacion ($id === $vehiculoActual) === dice igual valor y tipo con lo que nucan son iguales hay que poner solo ==--> 
                            <option value="<?= $id?>" <?= $id == $vehiculoActual ? 'selected' : '' ?>><?= $vehiculo ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
                <spam class="etiqueta_mini">La lista solo muestra vehiculos que tienen alquileres</spam>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" id = "ocultarAnalisis">Ocultar =></button>
                <button type="submit" class="boton_link" id = "botonAnalisis">Alquileres</button>
                <button type="button" class="boton_link" id = "exportarExcelPHP" title="Exportar a Excel los alquileres de un vehiculo entre las fechas elegidas"><i class="bi bi-file-earmark-spreadsheet"></i></button>
                <i class="etiqueta_mini">Muestra alquileres entre fechas del 1º vehiculo seleccionado en la lista</i>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="boton_link" id = "botonMeses">Total alquileres</button>
                <spam class="etiqueta_mini">Muestra todos los vehiculos seleccionados en la lista (la lista solo muestra vehiculos que tienen alquileres)</spam>
                <button type="button" class="boton_link" id = "botonGastosVehiculo">Gastos vehiculo</button><i class="etiqueta_mini">Totales</i>
            </div>
        </div>
    </div>
    </fieldset>
</form>
<div id="contenidoGastosVehiculo" class="bloque-flotante"></div><!-- aqui van los gastos del vehiculo cargados con fetch -->
<?php 
    $totalAlquileres = 0;
    $totalGastosAlquileres = 0;
?>
<?php if (!empty($alquileres)) :?>
<div id = "datosAnalisis">    
    <spam class = "etiqueta_desplazada blue">Alquileres de <?= $alquileres[0]->getvehiculoInfo()->getMarca_modelo()?></spam> 
    <?php foreach ($alquileres as $alquiler):?>
        <div class = "bloque-movimiento">
            <?php
                $totalAlquileres += $alquiler->getganancia()+$alquiler->getsumaGanancia(); //Esto suma todos los alquileres de esas fechas. ganancia del alquiler actual + ganancia de todas las ampliaciones
                $alquilerActual = $alquiler->getid();//usamos la ganancia porque es lo que importa en el analisis
            ?> 
            <table class = "mi_tabla">
                <caption>Alquiler inicial</caption>
                <thead>
                    <tr>
                        <th class="etiqueta">Cliente</th>
                        <th class="etiqueta">Fecha</th>
                        <th class="etiqueta">Ganancia</th>
                        <th class="etiqueta">Dias</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><!--muestro un alquiler-->
                        <td><?=$alquiler->getclienteInfo()->getNombre()?></td>
                        <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                        <td><?=number_format($alquiler->getganancia(), 2, ',', '.')?>€</td>
                        <td><?=$alquiler->getdias()?></td> 
                    </tr>
                </tbody>
            </table>
            <!--Ampliaciones-->
            <?php $totalAmpliacionesMasAlquiler = $alquiler->getganancia(); //ampliaciones se inicia con el precio del alquiler y va sumando precio de ampliaciones
                $totalDias = $alquiler->getdias();  //dias se inicia con los dias del alquiler y va sumando dias de ampliaciones
                //IMPORTANTE inicializar aqui estos contadores porque si los pongo dentro del if y no existen ampliaciones, no se incian y mas abajo en la resta de importe - gastos para calcular el benicio del alquiler daria error 
            ?>
            <?php if (!empty($ampliaciones[$alquilerActual])) :?>
                <table class = "mi_tabla azul w400" >
                    <caption>Alquiler+Ampliaciones</caption>
                    <colgroup>
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Ganancia</th>
                            <th>Dias</th>
                        </tr>
                        <tr><!--esto es para que los datos del alquiler salgan en la tabla ampliaciones en la 1º fila-->
                            <td><?=formatea_fecha($alquiler->getfechaInicio())?></td>
                            <td><?=number_format($alquiler->getganancia(), 2, ',', '.')?>€</td>
                            <td><?=$alquiler->getdias()?></td> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ampliaciones[$alquilerActual] as $ampliacion) :?>
                            <tr>
                                <?php $totalAmpliacionesMasAlquiler += $ampliacion->getganancia();
                                        $totalDias += $ampliacion->getdias()
                                ?>
                                <td><?= formatea_fecha($ampliacion->getfechaInicio())?></td>
                                <td><?= number_format($ampliacion->getganancia(), 2, ',', '.');?>€</td>
                                <td><?= $ampliacion->getdias()?></td>
                            </tr>
                        <?php endforeach ;?>
                        <tr>
                            <td>Total</td>
                            <td><?=number_format($totalAmpliacionesMasAlquiler, 2, ',', '.')?>€</td>
                            <td><?=$totalDias?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif ;?>
                <!--Gastos-->
            <?php $totalGastos = 0; ?> <!--//IMPORTANTE inicializar aqui el contador, si no hay gastos no entra y no existiria el contador y daria error -->   
            <?php if (!empty($gastos[$alquilerActual])) :?>
                <table class = "mi_tabla verde" >
                    <caption>Gastos del alquiler</caption>
                    <colgroup>
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 200px;">
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
            <p>Ganancia de este alquiler: <?=number_format($totalAmpliacionesMasAlquiler-$totalGastos, 2, ',', '.')?>€</p>                
        </div>
    <?php endforeach ;?>
    <table class = "tabla_resumen" >
        <caption>Resumen alquileres de las fechas <?= $alquileres[0]->getvehiculoInfo()->getMarca_modelo()?></caption>
        <thead>
            <tr>
                <th>Total Alquileres</th>
                <th>Total Gastos alquileres</th>
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
</div>
<?php endif ;?>

<div id="contenidoMeses"></div>
<div id="contenidoTotal"></div>

<script>
    /* para que flote la tabla Ojo en CSS ponerle relative o absolute. Con CSS es mas sencillo solo hay que ponerle position: fixed */
    window.addEventListener("scroll", function(){//con document.add... tmb me captura el evento
        const contenedor = document.getElementById("contenidoGastosVehiculo");
        contenedor.style.top = `${window.scrollY}px`;//le sumo el scroll que ha sufrido la pantalla
    });
     /* esto es para texto flotante en columan de totales: inversion */
    /* esto crea un codigo en capsulado que solo se ve asi mismo y sin acceso desde fuera */
    (function() {/* para entender esto ver el WORD de explicaciones */
        // Crear tooltip global si no existe
        let tooltip = document.querySelector('.tooltip-popup');//busca un elemento que se llame tooltip y lo asigna a la variable toolftip
        if (!tooltip) {//si la variable esta vacia es que no existia, pues lo crea
            tooltip = document.createElement('div');/* Crea un nuevo elemento <div> en memoria, que todavía no está en el DOM */
            tooltip.className = 'tooltip-popup';/* Le asigna la clase CSS tooltip-popup, que define estilo y comportamiento del tooltip: fondo, color..*/
            document.body.appendChild(tooltip);/* Ahora el <div> se inserta realmente en la página, como hijo directo del <body> */
        }
        /* Solo existe un único <div class="tooltip-popup"> en toda la página. No hay un <div> por celda, ni uno por 
            data-tooltip.
            Ese único div cambia su texto y posición dinámicamente según sobre qué celda pasas el ratón. */
        // Función que inicializa los listeners en las .tooltip-cell recién insertadas
        /* esta manera de declarar es para que la funcion initTooldtips() se pueda llamar desde fuera de esta capsula 
        tambien la podria haber declara en mis archivos de JS*/
        window.initTooltips = function() {
            // elige las de la clase tooltip-cell y que no tengan el atributo data-tooltip-init
            document.querySelectorAll('.tooltip-cell:not([data-tooltip-init])').forEach(cell => {
                cell.setAttribute('data-tooltip-init', '1'); 
                // marcar como inicializada escribiendo data-tooltip-init=1 en las celdas que tiene el altributo tooltip-cell
                //asignacion de eventos es todo lo de abajo
                cell.addEventListener('mouseenter', e => {/* evento raton encima */
                    /* para cada celda foreach(cell.. 
                        1.	Leer el texto que escribiste en data-tooltip dentro del <td> texto flotante.
                        2.	Si hay texto, lo pone dentro del div.tooltip-popup para mostrarlo flotando.*/
                    const text = cell.dataset.tooltip;
                    if (!text) return;
                    tooltip.textContent = text; /* aqui se asigna el contenido que se ve en la flotante 
                    mete el texto del data-toolttip en el div que crea al principio (tooltip.textConten. usa el mismo 
                    div para todas las celdas por que cada vez que me pongo sobre una se dispara el evnto en el cual
                    carga el exto de su data-tooltip en el div.tooltip. uanque hay un bucle for, no quiere decir que se 
                    carguen todos los data, sino que crea los eventos, pero hasta que no se dispara el evento no hace
                    la carga del data de la celda en el div.tooltip, el for crea todos los eventos pero luego solo se dispara uno*/
                    tooltip.classList.add('show');
                    /* getBoun... me da la posicion y tamaño de la celda */
                    const rect = cell.getBoundingClientRect();
                    /* usa el operador lógico OR (||) de JavaScript, y su significado aquí es:
        👉          “Toma tooltip.offsetHeight, y si ese valor es falsy (por ejemplo, 0, undefined, null, false, NaN o cadena vacía), entonces usa 30 como valor por defecto.” 
                    Es como el operador moderno ?? (nullish coalescing)? 
                    tooltip.offsetHeight devuelve número en píxeles, de la altura total visible del elemento*/
                    const tooltipHeight = tooltip.offsetHeight || 30;
                    /* Aquí se usa la altura del tooltip para posicionar el tooltip .*/
                    const top = rect.top - tooltipHeight - 8 < 0 ? rect.bottom + 8 + window.scrollY : rect.top + window.scrollY - tooltipHeight - 8;
                    /*top posicion arriba, bottom abajo, left izquierda. windon.scrollY tiene el valor en pixel del desplazamiento 
                    vertical de la ventana, cuando estoy arriba es 0 si bajo va incrementando */                
                    tooltip.style.top = `${top}px`;
                    tooltip.style.left = `${rect.left + window.scrollX}px`;
                });
                    /* cuando se mueve el rato lo redibuja con otras medidas */
                    cell.addEventListener('mousemove', e => {/* e es el nombre de la variable que representa al evento que ha disparado el mousemove
                         e.pageX es una propiedad del evento= posicion X del puntero respecto a toda la pagina*/
                        tooltip.style.left = `${e.pageX + 12}px`;
                        /* las {} sirve para insertar el valor de una variable (o incluso una expresión completa) dentro de un texto
                        solo funciona dentro de las llamadas template literals, que son las cadenas encerradas con backticks (`), no con comillas simples ' ni dobles "
                        Las comillas invertidas `...` permiten escribir una plantilla. ${nombre} se reemplaza automáticamente por el valor de la variable 
                        ejem: console.log(`Hola, ${nombre}!`); console.log(`La suma de ${a} + ${b} es ${a + b}`);*/
                        tooltip.style.top = `${e.pageY - tooltip.offsetHeight - 10}px`;
                    });
                    /* cuando sale de la celda lo oculta */
                    cell.addEventListener('mouseleave', () => {
                        tooltip.classList.remove('show');
                    });
            });
        };

        // Si tu página ya tiene .tooltip-cell al cargar, inicializamos
        /* esto solo sirve por si la pagina HTML tiene mas textos con flotantes, que tmb funciones, sin necesidad de esperar a que se pulse en el boton que lanza el fetch
        ya que el boton que lanza el fecth es el que llamana a initToolstips */
        document.addEventListener('DOMContentLoaded', () => {
            window.initTooltips();
        });
    })();
    /* aqui hay 2 fetch uno muestra 1 tabla los totales y ganancia por meses entre dos fechas (sin gastos, solo se descuenta la comision por eso se muestra ganancia)
     y el otro muestra 3 tablas: totales alquileres (sin fechas) y gastos del coche (no gastos de alquileres) + compraventas (con gastos compraventa)+resumen alqui/compraventas. 
    Ahora mismo solo muestra totales de todo el año que se ha elegido con las fechas, para que lo haga de 
    todos los años habria que hacer lo siguiente, no usar las fechas del formulario y hacer un for (i=2025 i<añoActual i++) y ejecutar el fetch tantas veces como años hay desde 2025 
    hasta el año actual, en cada pasada se mostraria un año entero, logicamente habria que comproner dos fechas para poder hacer la llamada, la composicion se hace con asi
    desde = i+-01-01 (2025-01-01) hasta = i+-12-31 (2025-12-31) siguiente pasada desde = i+-01-01 (2026-01-01) .... */
    document.getElementById("botonMeses").addEventListener("click", function(){
        const cont = document.getElementById("contenidoMeses");
        const contTotal = document.getElementById("contenidoTotal");
        if (cont.style.display === "none" || cont.style.display === "") {//si no esta visible hace la llamada AJAX y muestra datos, si ya esta visible los oculta, cada vez que muestra datos refresca haciendo una nueva llamada AJAX
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            var cocheIds = new Array;
            var selectVehiculo = document.getElementById("select_vehiculo");
            for (var i=0; i<selectVehiculo.length; i++){
                if (selectVehiculo.options[i].selected){
                    cocheIds.push(selectVehiculo.options[i].value);
                }
            }
            let okFechas = validaFechas(desde, hasta);
            if (desde && hasta && cocheIds.length > 0 && okFechas){//compruebo que hayan datos if (desde) equivale a (desde!="") 
                //me traigo total de ganancia por meses, entre 2 fechas, de los vehiculos elegidos. no se incluyen gastos de alquileres 
                fetch('/mis_pruebas/total_alquileres_vehiculo_fecha', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        desde: desde,
                        hasta: hasta,
                        cocheIds: cocheIds
                    })
                })
                .then(response => {
                        return response.text();/* respuesta en texto plano, Si el servidor devolviera JSON, usaría response.json()*/
                })
                .then(data => {
                    cont.innerHTML = data;
                    cont.style.display = "block"; //muestro los datos
                })
                .catch(error => {
                    cont.innerHTML = "Error: " + error;
                });
                /* ........................................................... */
                /* muestro 3 tablas, total de ganacia de todos los alquileres de los vehiculos (sin fechas) con gastos del coche no van de alquiler +compraventas del los vehiculos con gastos compraventas+resumen final alqu/compraventas*/
                fetch('/mis_pruebas/total_alquileres_vehiculos', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        cocheIds: cocheIds
                    })
                })
                .then(response => {
                        return response.text()
                })
                .then(data => {
                    contTotal.innerHTML = data;
                    contTotal.style.display = "block"; //muestro los datos
                    initTooltips();
                })
                .catch(error => {
                    contTotal.innerHTML = "Error: " + error;
                });
            }  
        }else {// Si ya está visible → lo ocultamos
                cont.style.display = "none";
                contTotal.style.display = "none";
            }
            /* SI SE PONE AQUI LO DE LAS FLOTANTES NO FUNCIONA PORQUE Los datos PHP aun no han llegado del servidor y no estan cargados en las etiquetas  <div id="contenidoMeses"></div><div id="contenidoTotal"></div> solo funciona se le pone un retarde y despues se ejecuta settimeout()*/
    });
    /* para cargar los gastos del vehiculo, tmb muestra gastos de la compraventa, se usa en la pagina gastos_cuota_vehiculo*/
    document.getElementById("botonGastosVehiculo").addEventListener("click", function(){
        const cont = document.getElementById("contenidoGastosVehiculo");
        if (cont.style.display === "none" || cont.style.display === "") {//si no esta visible hace la llamada AJAX y muestra datos, si ya esta visible los oculta, cada vez que muestra datos refresca haciendo una nueva llamada AJAX
            var cocheIds = new Array;
            var selectVehiculo = document.getElementById("select_vehiculo");
            for (var i=0; i<selectVehiculo.length; i++){/* busco en la lista desplegable el coche elegido */
                if (selectVehiculo.options[i].selected){
                    cocheIds.push(selectVehiculo.options[i].value);
                }
            }
            if (cocheIds[0]){//compruebo que haya un coche elegido
                //fetch('/mis_pruebas/total_alquileres_vehiculo?desde=' + desde + '&hasta=' + hasta + '&coche= ' + coche) para un solo coche metodo GET, paso datos en la URL 
                //me traigo total de ganancia por meses, entre 2 fechas, de los vehiculos elegidos
                fetch('/mis_pruebas/gastos_cuota_vehiculo?coche=' + cocheIds[0])
                .then(response => {
                        return response.text()/* esto tiene que estar para que los datos lleguen a data. El cuerpo viene en un stream y tienes que procesarlo usando: response.text() → si devuelves texto */
                })
                .then(data => {
                    cont.innerHTML = data;
                    cont.style.display = "block"; //muestro los datos
                    initTooltips(); /* activo flotantes */
                })
                .catch(error => {
                    cont.innerHTML = "Error: " + error;
                });
            }  else {alert ("Elija un coche");}  
        }else {// Si ya está visible → lo ocultamos
                cont.style.display = "none";
                contTotal.style.display = "none";
            }
    });
    /* para enviar formulario de alquileres de un vehiculo */
    document.getElementById("formAnalizar").addEventListener("submit", function(eventoSubmit){//capturo evento enviar del formulario
            eventoSubmit.preventDefault();//evita el envío automático
            var desde = document.getElementById("desde").value;
            var hasta = document.getElementById("hasta").value;
            let okFechas = validaFechas(desde, hasta);
            if (okFechas){
                this.submit();//envio formulario
            }
    });
    /* para exportar a Excel los alquileres de un coche entre fechas con PHP */
    document.getElementById('exportarExcelPHP').addEventListener('click', evento => {
        let miFormulario = document.getElementById('formAnalizar');
        let action = miFormulario.getAttribute('action');/* guardo el atributo action y se lo cambio para hacer submit a otra funcion del Controller diferente, 
        asi reutilizo el formulario */ 
        miFormulario.setAttribute('action', '/mis_pruebas/exportarAlquileresVehiculo');
        var desde = document.getElementById("desde").value;
        var hasta = document.getElementById("hasta").value;
        let okFechas = validaFechas(desde, hasta);
        if (okFechas){
            miFormulario.submit();
        }
        miFormulario.setAttribute('action', action); /* le vuelvo a poner la action que tenia */
    });

    document.getElementById("ocultarAnalisis").addEventListener("click", function(){
        const contenedor = document.getElementById("datosAnalisis");
        if (contenedor!=null){//cuando aun no hay datos mostrados no existe el contenedor   
            const displayActual = window.getComputedStyle(contenedor).display; //tengo que usar esta propiedad porque si uso contenedor.style.display==="none" como es una propiedad CSS 
            // cuando se carga el contenedor no existe contenedor.style.display porque no se le ha asignado todavia ningun valor, sin embargo window.getComputedStyle(contenedor).display 
            //devuelve el valor real de display aunque nose haya hecho ninguna vez style = "algo"
            if (displayActual==="none"){//si no esta visible lo muestro
                contenedor.style.display = "block";
                this.innerText = "Ocultar =>";
            } else {//lo oculto
                contenedor.style.display = "none";
                this.innerText = "Mostrar =>"
            }
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
<!-- window.addEventListener("scroll", function(){//con document.add tmb me captura el evento
        const contenedor = document.getElementById("contenidoGastosVehiculo");
        let posicion = contenedor.getBoundingClientRect(); //posicion actual del contenedor respecto a la parte visible de la ventana
        /*posicion.top; si hago que flote este valor no cambia ya que esta siempre en la misma posicion respecto a la pantalla (no el HTML), y si no flota entonces
        si que cambia ya que se va para arriba o abajo junto al HTML */
        let top = contenedor.style.top;/* esta propiedad tiene la posicion de la parte superior con respecto a los elementos del HTML, si hago que flote al hacer scroll
        este valor cambia porque se esta desplazando respecto al HTML(los demas se mueven y el no), pero si hago que no se desplaza este valor esta fijo.*/
        const estilos = getComputedStyle(contenedor);//
        console.log("computed top:", estilos.top);
        noPx = parseFloat(estilos.top);             //parseFloat(getComputedStyle(contenedor).top);
        
        console.log("estilos sin px:", noPx);
        console.log(" top:", top);
        //console.log("posicion topBound:", posicion.top);
        //console.log("posicion winY:", window.scrollY);
        contenedor.style.top = `${window.scrollY}px`;/* no se puede sumar con noPx ya que se dezplaza mas que el scroll de pantalla, si tiene style.top 10 si hago 100 scroll 
        le suma 100, tengo 110, si hago otro scroll de 100, (scrollY=200), seria style.top=110+200 =310 vemos que aumenta mas rapido que el scroll con lo que se sale hace 
        abajo rapidamente*/ 
    }); -->