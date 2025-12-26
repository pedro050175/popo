const DIRECTORIO = '/mis_pruebas/'
function validarTablaEnteros(tablaEnteros) { //valida campos de formulario tipo text
    
    for (let i=0; i<tablaEnteros.length; i++){
        if (!validar_campo (tablaEnteros[i])) {
        return false;
        }
    }
    return true;
}
function validar_campo(campo){
    if (campo.type === "text")
        return validar_entero_campo_text(campo);
    else if (campo.type === "number") return validar_entero_campo_number(campo); 
}
function validar_entero_campo_text (campo) { //valida campos de formulario tipo text
    var cadena = campo.value;
    cadena = cadena.replace(',', '.');//cambio la coma por un punto ya que en sql el decimal es el punto
    if ((isNaN(cadena)) ){//permito que sea negativo hay importes que pueden serlo, y numero con tipo text lo he usado para importes
    //  compruebo que no tenga letras o simbolos
        alert ("Valor erroneo");
        campo.value="";
        return false;
    }
    campo.value=cadena;
    return true;
}
function validar_entero_campo_number (campo) { //valida campos de formulariotipo number, se usa para cantidades, como km
    let valor = Number(campo.value);
    if (!Number.isInteger(valor)) {// Verifica si es un número entero válido
        alert("No escriba letras, punto, coma, o simbolos");
        campo.value = ""; // limpiar campo
        return false;
    } // Verifica si es negativo
    if (valor < 0) {
        alert("No puede ser negativo");
        campo.value = 0;
        return false;
    }
    return true;
}
function fechasMenorMayor(fechaMenor, fechaMayor){//comprueba si la fechaMenor es menor que fechaMayor
    let fecha1 = new Date(fechaMenor);
    let fecha2 = new Date(fechaMayor);
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comparar el mismo tipo de datos
    if (fecha2<fecha1){
      return false;
    }
    return true;  
}
function tooltip(){
  const tooltip = document.createElement('div');
  tooltip.className = 'tooltip-popup';
  document.body.appendChild(tooltip);
  document.querySelectorAll('.tooltip-cell').forEach(cell => {
    cell.addEventListener('mouseenter', e => {
      const text = cell.dataset.tooltip;
      if (!text) return;
      tooltip.textContent = text;
      tooltip.classList.add('show');
      const rect = cell.getBoundingClientRect();
      const tooltipHeight = tooltip.offsetHeight;
      const top = rect.top - tooltipHeight - 8 < 0
        ? rect.bottom + 8 + window.scrollY
        : rect.top + window.scrollY - tooltipHeight - 8;
      tooltip.style.top = `${top}px`;
      tooltip.style.left = `${rect.left + window.scrollX}px`;
    });
    cell.addEventListener('mousemove', e => {
      tooltip.style.left = `${e.pageX + 12}px`;
      tooltip.style.top = `${e.pageY - tooltip.offsetHeight - 10}px`;
    });
    cell.addEventListener('mouseleave', () => {
      tooltip.classList.remove('show');
    });
  });
}
function mensaje(mensaje){/* hace que aparecezca y desaparezca un texto con efectos*/
  let zonaMensaje = document.getElementById(mensaje);
        if (zonaMensaje){ /* si no existe es porque la pagina no tiene mensaje para mostrar*/
            zonaMensaje.classList.add("mostrar"); /* añade la clase mostrar quedando class="mensajeGuardar mostrar" */
            //con zonaMensaje.style.opacity = 1; tmb se podria haber modificado directamente el atributo opacity del div en lugar de modificar la clase del div, pero modificando la clase hay mas posibilidades de cambiar otros atributos
            setTimeout(()=>{
                //y aqui tmb directamente se modifica el atributo zonaMensaje.style.opacity = 0;
                zonaMensaje.classList.remove("mostrar");// Espera 2.5s y luego inicia la animación de desvanecimiento
            }, 2500);/* OJo que setTimeOut es asincrono, mientras espera los 2500 sigue ejecutando y carga el evento de transitioned, y al terminar la transicion de 0 a 1
            opacity ya se dispara el evento transitionend por eso hay que poner el if dentro para que no ejecute zonaMensaje.style.display = "none" al pasar de 0 a 1*/
            // Evento final de transicion= ocultar. Podria haber puesto en la regla .mesnajeGuardar (display: "none") y asi se oculta despues de quitarle .mostrar a la clase
            /* ojo con este addEvenListener("transitionend" , cada vez que se llame a esta funcion se crea un nuevo, si se llama 5 veces se crean 5 eventos.
            Solucion 1 poniendo esto { once: true }(abajo esta puesto se crea y se elimina cada vez, pero se sigue perdiendo tiempo en crearlo
            Opción 2: Mover el addEventListener fuera de la función, que se haga fuera de aqui solo una vez
            Opción 3: Antes de registrar un listener, comprobar si ya está registrado: 
                if (!zonaMensaje._listenerAdded) {
                    zonaMensaje.addEventListener("transitionend", handler);
                    zonaMensaje._listenerAdded = true; 
            Asi que lo anulo 
            zonaMensaje.addEventListener("transitionend", () => {
                sino se pone el if el evento se dispara tmb al hacer zonaMensaje.classList.add("mostrar"); y al terminar esa transcion lo oculta
                con el if, solo se oculta si antes se ha mostrado. Tmb se podira haber puesto asi:
                    if (getComputedStyle(zonaMensaje).opacity === "0") {
                       zonaMensaje.style.display = "none";
                    } se consulta el style en lugar de la clase
                if (!zonaMensaje.classList.contains("mostrar")) {
                    zonaMensaje.style.display = "none"; esto no hay que hacerlo, habria que quitar todo el evento de transicion ya que el 
                     mensaje se oculta al quitarle la clase mostrar. Si se pone esto oculta algo que ya se ha ocultado y ademas impide que se
                     pueda volver a mostrar el mensaje si se llamara de nuevo a esta funcion porque se le ha puesto el display a none.
                     Dejo el evento porque es interesante tenerlo en cuenta, el cargar un evento de transicion
                }
            }, { once: true } );*/        
        }
}
function diaMesConCero(dia){
    if (dia<10) {
        return ('0' + dia);
    }
    return dia;
}
function igualValor(campo1, campo2){
    campo2.value = campo1.value;
}
function exportarTablaExcel(tableId, filaName = 'excel'){
    let table = document.getElementById(tableId);
    /* se puede hacer asi, pero esta forma es mas antigua
    let html = "\ufeff" + table.outerHTML.replace(/ /g, '%20');reemplaza espacios que hay en el HTML entre etiquetas, por %20 
    let url = 'data:application/vnd.ms-excel;charset=utf-8,' + html; 
    let link = document.createElement('a');
    link.href = url*/
    /* mas moderno=> HTML completo del archivo Excel*/
    const html = `
        <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body>
            ${table.outerHTML}
        </body>
        </html>
    `;
    // Crear un Blob con el contenido HTML
    const blob = new Blob([html], {
        type: "application/vnd.ms-excel;charset=utf-8"
    });
    /* creo un link */
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filaName + '.xls';
    link.click();
    // Liberar el objeto URL
    URL.revokeObjectURL(link.href);
}
/* esta funcion contrala el guardado de los datos del formulario.Como parametros se le pasa elemento formulario(no el id ni el nombre), 
una cadena con la ruta donde ir al salir de la pagina y la variable que indica si se han cambiado datos en el formulario.
Requisitos para que funcione: boton para salir  de la pagina => id="salir"; boton para gurardar los datos => id="botonGuardar". En HTML se
deja el onclick de guardar para que valide el formulario y el onclick de salir se quita ya que se captura aqui. Ponerle al boton
guardar la clase class="boton_submit disable" y el atributo disabled*/
function guardarDatos(formulario, rutaDespues, estado){
    /* evento change del formulario */
    $(formulario).one('change', e => {
        estado.modificado = true;
        var botonGuardarForm = document.getElementById('botonGuardar');
        botonGuardarForm.classList.remove('disable');
        botonGuardarForm.disabled = false;
    });
    /* evento salida de pagina */
    window.addEventListener('beforeunload', e =>{
        let botonClick = e.explicitOriginalTarget;/* explicitOriginalTarget me devuelve el elemento deo DOM que ha originado el evento salir de la ventana */
        if ((botonClick.id != "botonGuardar") && (estado.modificado == true)){/* si no pulsado guardar y se ha modificado entro en el if y el navegador avisa al usuario*/
            e.preventDefault(); 
            e.returnValue = ""; // Obligatorio para que el navegador muestre el diálogo
        }
    });
    /* evento boton salir de la pagina */
    document.getElementById('salir').addEventListener('click', e=>{
        if (estado.modificado == true){
            Swal.fire({
                title: 'Atencion datos no guardados',
                text: 'El formulario alquiler no se ha guardado, desea salir sin guardar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        estado.modificado = false;
                        window.location.href = rutaDespues;                            
                    }
            }); //Swal
        } else {
            window.location.href = rutaDespues;
            }
    });
}
function selectAjaxVehiculos(select){
    /* hay que pasarle el objeto select que se quiere convertir a select2 */
    $(select).select2({
        /* usa el data-placeholder definido en el select */
        placeholder: select.dataset.placeholder || 'Buscar...', //tmb se puede poner asi: $(select).data('placeholder') 
        minimumInputLength: 3, //empieza a buscar a partir de 3 caracteres
        language: {/* con esto se personalizan los mensajes */
            inputTooShort: function (args) {
                const remaining = args.minimum - args.input.length;
                return `Introduzca ${remaining} carácteres para iniciar la busqueda`;
            },
            searching: function () {
                return 'Buscando vehículos...';
            },
            noResults: function () {/* este mensaje solo se muestra si PHP devuelve un array vacio [], si devuelve null no se muestra */
                return 'No se encontraron vehículos';
            }
        },
        allowClear: true, /* El usuario puede borrar la selección */
        ajax: {
            url: DIRECTORIO + 'buscar_vehiculos_select',
            dataType: 'json',
            delay: 500,//tiempo entre consultas 
            data: function (params) {
                return { buscar: params.term };//texto escrito en el select por el usuario, se envia como parametro en $_GET['buscar']
            },
            processResults: function (data) {
                /* con esto me aseguro de devolver una array con datos o uno vacio [], no es del todo necesario
                pero asi es mas seguro y el mensaje noResults aparece, porque si le lleva un null no aparece (tmb 
                lo controlo en PHP que devuelve un [] si no encuentra datos) */
                if (!Array.isArray(data)) {//Array.isArray() es una funcion de JS, devuelve true si data es un array
                   return { results: [] };
                }
                return { results: data };
            },
            cache: true
        }, 
        templateResult: formatVehiculoResult,
        templateSelection: formatVehiculoSelection    
    });
        /* esta funcion es para controlar que muestra el select cuando se pincha en el (desplegado)*/
    function formatVehiculoResult(vehiculo){
        //cuando select muestra Buscando....
        if (vehiculo.loading){
            return vehiculo.text; //text es el campo text que se pasa en json
        }
        /* se usa $(`..`) pk templateResult espera un nodo DOM o un objeto jQuery, con $() convierte el HTML string en obt jQuery*/
        return $(`
                <div><strong>${vehiculo.Marca_modelo}</strong><br>
                    <small>
                        Matrícula: ${vehiculo.Matricula},  
                        Bastidor: ${vehiculo.Bastidor}
                    </small>
                </div>
                `);
    }
    /* esta funcion es para controlar que muestra el select cuando no se pincha en el (reposo)*/
    function formatVehiculoSelection(vehiculo){
        //cuando el select esta vacio tengo que hacer return vehiculo.text
        /* ver explicacion de mi word */
        if (!vehiculo.Marca_modelo){ //si el select aun no ha cargado nada con ajax el campo Marca_modelo no existe entonces return text para mostrar lo que el select original tiene en el HTML
            return vehiculo.text;//valor de option del select
        }
        /* si hay datos ajax pues los muestro */
        return `${vehiculo.Marca_modelo}, ${vehiculo.Matricula}, ${vehiculo.Bastidor}`;
    }
    /* al pinchar se dispara este evento para añadir un placeholder dentro del cuadro de busqueda
    este placeholder no elimna el que ya aparece antes de pinchar que esta definido en el select*/
    $(select).on('select2:open', function () {
        const input = document.querySelector(
            '.select2-container--open .select2-search__field'
        );
        if (input) {
            input.placeholder = 'Marca, matrícula o bastidor';
        }
    });
}
function selectAjaxEntidades(select){
    /* hay que pasarle el objeto select que se quiere convertir a select2, requisito: que el select tenga un data-placeholder */
    $(select).select2({
        /* usa el data-placeholder definido en el select */
        placeholder: select.dataset.placeholder || 'Buscar...', //tmb se puede poner asi: $(select).data('placeholder') 
        minimumInputLength: 3, //empieza a buscar a partir de 3 caracteres
        language: {/* con esto se personalizan los mensajes */
            inputTooShort: function (args) {
                const remaining = args.minimum - args.input.length;
                return `Introduzca ${remaining} carácteres para iniciar la busqueda`;
            },
            searching: function () {
                return 'Buscando datos...';
            },
            noResults: function () {/* este mensaje solo se muestra si PHP devuelve un array vacio [], si devuelve null no se muestra */
                return 'No se encontraron datos';
            }
        },
        allowClear: true, /* El usuario puede borrar la selección */
        ajax: {
            url: DIRECTORIO + 'buscar_entidades_select',
            dataType: 'json',
            delay: 700,//tiempo entre consultas 
            data: function (params) {
                return { buscar: params.term };//texto escrito en el select por el usuario, se envia como parametro en $_GET['buscar']
            },
            processResults: function (data) {
                /* con esto me aseguro de devolver una array con datos o uno vacio [], no es del todo necesario
                pero asi es mas seguro y el mensaje noResults aparece, porque si le lleva un null no aparece (tmb 
                lo controlo en PHP que devuelve un [] si no encuentra datos) */
                if (!Array.isArray(data)) {//Array.isArray() es una funcion de JS, devuelve true si data es un array
                   return { results: [] };
                }
                return { results: data };
            },
            cache: true
        }, 
        templateResult: formatVehiculoResult,
        templateSelection: formatVehiculoSelection    
    });
        /* esta funcion es para controlar que muestra el select cuando se pincha en el (desplegado)*/
    function formatVehiculoResult(entidad){
        //cuando select muestra Buscando....
        if (entidad.loading){
            return entidad.text; //text es el campo text que se pasa en json
        }
        /* se usa $(`..`) pk templateResult espera un nodo DOM o un objeto jQuery, con $() convierte el HTML string en obt jQuery*/
        return $(`<div><i>${entidad.text}</i></div>`);
    }
    /* esta funcion es para controlar que muestra el select cuando no se pincha en el (reposo)*/
    function formatVehiculoSelection(entidad){
        //cuando el select esta vacio tengo que hacer return vehiculo.text
        /* ver explicacion de mi word */
        if (!entidad.Marca_modelo){ //si el select aun no ha cargado nada con ajax el campo Marca_modelo no existe entonces return text para mostrar lo que el select original tiene en el HTML
            return entidad.text;//valor de option del select
        }
        /* si hay datos ajax pues los muestro */
        return `${entidad.text}`;
    }
    /* al pinchar se dispara este evento para añadir un placeholder dentro del cuadro de busqueda
    este placeholder no elimna el que ya aparece antes de pinchar que esta definido en el select*/
    $(select).on('select2:open', function () {
        const input = document.querySelector(
            '.select2-container--open .select2-search__field'
        );
        if (input) {
            input.placeholder = 'Nombre empresa/persona';
        }
    });
}
/* para copiar un texto al portapapeles, OJO si se ejecuta paso a pase con devtool debugger del navegador
da error lo bloquea el navegador, ya no existe “activación del usuario” a ojos del navegador, aunque el origen haya sido un clic. */
function copy(cuadroTexto){
    let texto = document.getElementById(cuadroTexto).value;
    if (texto.length>0) {
        navigator.clipboard.writeText(texto);
    }
}
function copyLink(link){
    /* OJO si se ejecuta paso a pase con devtool debugger del navegador
da error lo bloquea el navegador */
    if (link.length>0) {
            navigator.clipboard.writeText(link);
        }  
}