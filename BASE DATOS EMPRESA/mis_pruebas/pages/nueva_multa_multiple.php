
<div class="mensajeGuardar" id = "mensajeAJAX"></div>
<div class="row">
    <div class="col">
        <h5 class="titulo_prin">Nueva Multa Multiple</h5>
    </div>
    <div class="col text-end">  
        <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>multas?num_pagina=1';">   
        <button type="button" class="boton_submit" id = "guardar">Guardar Multas</button>
    </div>
</div>
<div>
    <table class = "tabla_resumen" id = "multas">
        <thead>
            <tr>
                <th>Expediente</th>
                <th>Fecha</th>
                <th>Fecha notifi.</th>
                <th>Vehiculo</th>
                <th>Importe</th>
                <th>Identificar</th>
                <th>Lugar</th>
                <th>Conductor</th>
                <th>Comentarios</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody id = "body">
            <tr>
                <td><input type="text" name="expediente" class="form-control" placeholder="expediente" value=""></td>
                <td><input type="date" name="fecha" class="form-control" placeholder="Fecha" value = ""> </td>
                <td><input type="date" name="fechaNotificacion" class="form-control" placeholder="Fecha notificacion" value = ""> </td>
                <?php
                    foreach ($vehiculos as $vehiculo){
                        $listaVehiculos[$vehiculo->getId()] = $vehiculo->getMarca_modelo(). ' ' .$vehiculo->getMatricula() . ' ' .$vehiculo->getBastidor();//con la variable $entidades creo un array asociativo ['id']=Nombre
                    }
                ?>
                <td>
                    <select name="vehiculo" 
                    class="form-select" id="select_vehiculo" 
                    required
                    oninvalid="this.setCustomValidity('Por favor selecciona un vehiculo')"
                    oninput="this.setCustomValidity('')"><!--esto hay que ponerlo para que al seleccionar un valor se entere de que has seleccionado y no de error otra vez-->
                    <option value = "" selected disabled >--Selecc. opcion--</option><!--hay que ponerle value="" para que el required funcione, asi el navegador entiende que si no se elije nada el valor es "" y te avisa, sino se pone, no tiene ningun valor y no avisa-->
                    <?php foreach ($listaVehiculos as $id => $vehiculo): ?>
                        <option value="<?= $id?>"><?= $vehiculo ?></option>
                        <?php endforeach; ?>
                    </select>     
                </td>
                <td><input class="form-control" type="text" name="importe" placeholder="importe" value = ""></td>
                <td><input class="cuadro_text" type="checkbox" name="identificar" ><!--si estoy editando existe multa evalua Multa ($multa->getteMulta()==1) ? 'checked' : '', por eso esta todo entre () y si no estoy editando pone '' que son los : '' del final--></td>
                <td><input type="text" name="lugar" class="form-control" placeholder="lugar" value=""></td>
                <td><input type="text" name="conductor" class="form-control" placeholder="conductor" value=""></td>
                <td><input type="text" name="comentarios" class="form-control" placeholder="comentarios" id = "comentarios" value=""></td>
            </tr>
        </tbody>
    </table>
</div>
<div>
    <button type="button" class="boton_submit nueva-duplicar" id = "nueva">Nueva Multa</button>
    <button type="button" class="boton_submit nueva-duplicar" id = "duplicar">Duplicar Multa</button>
</div>

<script>
    $(document).ready(function() {
        $('#select_vehiculo').select2({
            placeholder: "Buscar vehiculo",
            allowClear: true,
            width: '100%'
        });/* select2 añade etiquetas div al select con id prpios, con lo que si duplico una fila se duplican esas etiquetas y el select2 falla porque tiene div con id repetidos */
        document.querySelector('tbody tr input[name="expediente"]').focus();/* foco en campo expediente de la 1º fila */
        /* EVENTO GUARDAR */
        document.getElementById('guardar').addEventListener('click', () => {
            let multas = document.getElementById('multas');
            let filasMultas = [];
            let i = 0;
            let error = false;
            let expediente, fecha, fechaNotificacion, vehiculo, importe, identificar, lugar, conductor, comentarios;
            multas.querySelectorAll('tbody tr').forEach(function(elemento){
                fecha = elemento.querySelector('input[name="fecha"]').value;
                vehiculo = elemento.querySelector('select[name="vehiculo"]').value;
                if ((fecha != '') && (vehiculo != '')) {/* fecha y vehiculo no pueden estar vacios en la tabla mysql */
                    expediente = elemento.querySelector('input[name="expediente"]').value;
                    fechaNotificacion = elemento.querySelector('input[name="fechaNotificacion"]').value;
                    importe = elemento.querySelector('input[name="importe"]').value;
                    identificar = elemento.querySelector('input[name="identificar"]').checked;
                    lugar = elemento.querySelector('input[name="lugar"]').value;
                    conductor = elemento.querySelector('input[name="conductor"]').value;
                    comentarios = elemento.querySelector('input[name="comentarios"]').value;
                    filasMultas[i] = [expediente, fecha, fechaNotificacion, vehiculo, importe, identificar, lugar, conductor, comentarios];
                    i++;
                }else {
                        error = true;
                    }
            });/* end forEach */
            /*para guardar multas creadas */
            let zonaMensaje = document.getElementById("mensajeAJAX");
            if ((filasMultas.length > 0) && (!error)) {
                fetch('/mis_pruebas/guardar_multas_multiple', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({filasMultas: filasMultas})
                })
                .then(response => {
                        return response.text();/* esto tiene que estar para que los datos lleguen a data. El cuerpo viene en un stream y tienes que procesarlo usando: response.text() → si devuelves texto */
                })
                .then(data => { 
                    zonaMensaje.classList.add("exito");
                    zonaMensaje.innerHTML = data;
                    mensaje("mensajeAJAX");/* le paso el nombre del id, en la funcion mensaje sacara el elementoById */
                })
                .catch(error => {
                    zonaMensaje.classList.add("error");
                    zonaMensaje.innerHTML = error;
                    mensaje("mensajeAJAX");
                });
            } else {  
                zonaMensaje.classList.add("error");
                zonaMensaje.innerHTML = "Error, fecha o vehiculo vacio";
                mensaje("mensajeAJAX");
                }

        });
        /* EVENTOS DUPLICAR Y NUEVA */
        document.querySelectorAll('.nueva-duplicar').forEach(boton => { /* seleccion los dos botones porque son de la misma clase nueva-duplicar y los dos hacen casi lo mismo. Capturo evento
            focus porque asi, al pulsar tecla Tab en comentarios (al ser el ultimo campo de la tabla salta al boton Nueva Multa) salta al boton Nueva Multa y me crea una fila en blanco, 
            y si pincho con el raton en el boton tmb se genera evento focus */
            boton.addEventListener("focus", function(){
                /* cojo la 1º fila del tbody */
                let fila = document.querySelector("tbody tr:first-child");
                
                /* al select de la fila que usamos para clonar hay que quitarle la funcion de jquery select2 para que al duplicar no lo tenga, de lo contrario se duplican las listas desplegables en la nueva fila 
                y deja de funcionar select2 de jQuery en la fila original. No se pude borrar de la fila duplicada porque cuando se clona aun no esta en el DOM. ver explicacion del world */
                let selectOriginal = fila.querySelector('select'); 
                $(selectOriginal).select2('destroy'); /*destruyo el select2 y dejo el select limpio */
                let filaDuplicada = fila.cloneNode(true); /* con true se le dice que clone el contenido de la fila, sino solo crea una fila vacia */
                $('#select_vehiculo').select2({/* despues de duplicar le aplico el select2 a la fila original*/
                    placeholder: "Buscar vehiculo",
                    allowClear: true,
                    width: '100%'
                });
                /* otra forma de hacerlo sin tener que destruir el select2 de la fila original y volver a crearlo es con esto:
                    selectClonado.outerHTML = selectOriginal.outerHTML;); y despues volver a coger el select de la linea Duplicada porque el que tenia se ha cambiado al hacer la asignacion, asi que se hace
                    let selectNuevo = filaDuplicada.querySelector('select');
                    selectNuevo.setAttribute('id', nuevoId); o hacerlo todo en una unica instruccion: selectClonado.outerHTML = selectOriginal.outerHTML.replace(/id="[^"]+"/, `id="${nuevoId}"`);
                */
                /* agrego el boton de borrar fila a la fila duplicada, lleva una clase borrar-fila para que el evento click sobre la tabla la localice y la borre */
                let tdBorrar = document.createElement('td');
                tdBorrar.innerHTML = `<a class="btn btn-sm btn-outline-danger borrar-fila"><i class="bi bi-trash"></i></a>`;
                filaDuplicada.appendChild(tdBorrar);

                let selectDuplicado = filaDuplicada.querySelector('select');
                let tabla = document.getElementById("multas");
                let numeroFilas = parseInt(tabla.rows.length);  
                /*filaDuplicada.setAttribute("id", `${numeroFilas}`); no le pongo id porque al poder borrar filas los id pierden la utilidad, y se pueden duplicar*/
    
                let nuevoId = `select${numeroFilas}`;
                selectDuplicado.setAttribute("id", nuevoId);
                
                // Limpia todos los inputs y selects de la nueva fila si se pulso añadir
                if (this.id == "nueva"){
                    filaDuplicada.querySelectorAll("input, select").forEach(el => {
                        if (el.tagName === "SELECT") {
                            el.selectedIndex = 0; // primera opción
                        } else if (el.type === "text") {
                            el.value = ""; // vacía los campos de texto o numéricos
                            }else if (el.type === "checkbox") {/* un checkbox tiene un value que es el valor que nos daria la propiedad value si esta marcado, pero el value no controla el marcado, 
                                es decir, para controlar el marcado hay que usar la propiedad checked, value solo nos dara el valor que le pongamos al campo en value */
                                    el.checked = false;
                                }else if (el.type === "date"){
                                    el.value = 0;
                                    }
                    });
                } else { /* si se pulso duplicar le tengo que asiganar el valor del select original al duplicado, porque el método clona el HTML que se carga inicialmente pero si se elige un coche eso no se actualiza en el HTML, no clona los cambios de los elementos */
                        selectDuplicado.value = selectOriginal.value;
                }
                let tablaBody = tabla.querySelector("tbody"); /* la nueva fila hay que insertarla en el body, tmb podria haberlo seleccionado asi document.querySelector("#multas tbody"); 
                o si le pongo un id="body" a tbody podria hacerlo con document.getElementById("body") */
                tablaBody.append(filaDuplicada);  /* añado la nueva fila a la tabla */
                tablaBody.querySelector('tr:last-child input[name="expediente"]').focus();/* foco en campo expediente de la ultima fila */
                $(`#${nuevoId}`).select2({/* aplico el select2 al select de la nueva fila que tiene id = nuevoId */
                    placeholder: "Buscar vehiculo",
                    allowClear: true,
                    width: '100%'
                });
            });/* addEventListener("click" */
        });/* forEach(boton  */
        /* con esto se captura evento para detectar pulsacion de TAB en el campo comentarios, OJO hay que poner true para anular bootstrap. Solo funcionaria para la 1º fila, a las filas
        añadidas habria que meterles el evento igual que se les mete el select2 de jquery. Es mas sencillo capturando el evento focus del boton Nueva multa que esta justo despues de comentarios*/
        /* document.querySelector('#multas tbody tr:last-child input[name="comentarios"]').addEventListener("keydown", e => {
           if (e.key === "Tab") {}
        }, true); */

        /*EVENTO BORRAR capturo click sobre la tabla, cada vez que se pincha sobre cualquier sitio de la tabla viene aqui */
        document.getElementById('multas').addEventListener('click', function(e) {
            if (e.target.closest('.borrar-fila')) {/* comprueba que pincho sobre un elemento de la clase borrar-fila. •	e.target es el elemento exacto del DOM que disparó el evento. */
                e.target.closest('tr').remove();/* closest('tr') busca el primer ancestro <tr> del botón y lo borra conb remove */
            }
        });/* getElementById('multas') */
    });/* ready */
</script>