const opciones_menu = new Array ("fotos", "gastos", "cuotas"); /*array con nombres de secciones para ver o ocultar*/
//dos maneras de crear un array. Lo declaro como const porque no voy a cambiar su contenido, aunque con el metodo .push si me dejaria añadir elementos porque es un arrary, si fuera una variable simple no me dejaria
const botones = ["boton_fotos", "boton_gastos", "boton_cuotas"];//array con botones de menu para cambiarle el color

function validarDatos (formulario){//para acceder a elmentos del formulario se usa this.form
    const fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0);//elimina la hora y asi comprara solo fecha

    let fechaMatricula = new Date(formulario.Fecha_matricula.value);
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comprar el mismo tipo de datos
    if (fechaMatricula>fechaActual){
        alert ("Fecha matricula erronea");
        return false;
    }
    let fechaItv = new Date(formulario.Fecha_itv.value);
    if (fechaItv>fechaActual){
        alert ("Fecha itv erronea");
        return false;
    }
    let fechaProxItv = new Date(formulario.Prox_itv.value);
    if (fechaProxItv<fechaActual){
        alert ("Fecha itv erronea");
        return false;
    }
    if (!validar_campo (formulario.kilometros)){
        alert ("Kilometros mal escritos");
        return false;
    };
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
}

function validarCuotas(formulario){
    if (!validar_campo (formulario.cuota)) {
        return false;
    }
    if (!validar_campo (formulario.duracion)) {
        return false;
    }
    if (!validar_campo (formulario.totalPagar)) {
        return false;
    }
    if (!validar_campo (formulario.pagoFinal)) {
        return false;
    }
    if (!validar_campo (formulario.entrada)) {
        return false;
    }
    if (!validar_campo (formulario.fianza)) {
        return false;
    }
    if (!validar_campo (formulario.km)){
        return false;
    };
    if (!validar_campo (formulario.kmAno)){
        return false;
    };
    return true;    
}
function validar_campo(campo){
    if (campo.type === "text")
        return validar_entero_campo_text(campo);
    else if (campo.type === "number") return validar_entero_campo_number(campo); 
}
function validar_entero_campo_text (campo) { //valida campos de formulariotipo text
    var cadena = campo.value;
    cadena = cadena.replace(',', '.');//cambio la coma por un punto ya que en sql el decimal es el punto
    if ((cadena<0) || (isNaN(cadena)) ){//compruebo que no sea negativo y que no tenga letras o simbolos
        alert ("Valor erroneo");
        campo.value="";
        return false;
    }
    campo.value=cadena;
    return true;
}
function validar_entero_campo_number (campo) { //valida campos de formulariotipo number
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
function mostrarMenuVehiculo(menu){//para acceder a elementos de la pagina se usa document
    //oculto todos y luego solo activo el que se llame menu
    for (let opcion of opciones_menu){
        document.getElementById(opcion).hidden = true;    
    }
    document.getElementById(menu).hidden = false; 
    var expiracion = new Date();
    expiracion.setTime(expiracion.getTime()+300*1000);
    creacionCookie("menuVehiculo", menu, expiracion, "/")//cambio valor de la cookie asi al salir de la pagina y entrar recuerda el ultimo menu usado
    /* let boton = event.target; event.target me devuelve el elemento que ha generado el evento, no lo uso porque solo me sirve para poner en azul, pero el resto de botones no los puedo poner en naranja, al final tengo que consultar el estado del resto de botones
    boton.style.color = "blue"; */
    color_boton_menu();
}
function color_boton_menu(){//viendo como esta el MENU puedo saber que boton poner en azul, esta funcion se llama cada vez que se carga la pagina
    //var cookie = leerCookie("menuVehiculo"); podria consultar aqui la cookie y no haria falta comprobar el estado de opciones_menu, porque ya se que menu esta seleccionado. Y sino existe la cookie porque es la 1º vez que se entra pues pongo azul fotos.
    for (i=0; i<opciones_menu.length; i++){
        if (document.getElementById(opciones_menu[i]).hidden == true){//si el menu esta oculto hidden ==true pongo el color del boton en naranja
            document.getElementById(botones[i]).style = "color: rgb(223, 94, 3)";
        }else{//sino esta oculto lo pongo en azul
            document.getElementById(botones[i]).style.color = "blue";
            }    
    }
}
function mostrar_formulario(form){
    if (document.getElementById(form).hidden == true) {
        document.getElementById(form).hidden=false;
    }else {
        document.getElementById(form).hidden=true;
        }
}
function creacionCookie(nombre, valor, expiracion, ruta, dominio, seguridad){
        document.cookie = nombre + ' = ' + valor + ' ' + ((expiracion == undefined) ? '' : ('; expires=' + expiracion.toGMTString())) + 
        ((ruta == undefined) ? '' : ('; path=' + ruta)) + ((dominio == undefined) ? '' : ('; domain =' + dominio)) + ((seguridad == true) ? ';seguridad': '');
}
function leerCookie(nombre){
    if (document.cookie.length == 0) { return null;}
    else {
        var tabElementos = document.cookie.split(";");
        var posicionIgual = tabElementos[0].indexOf("=", 0);
        var nombrecookie = tabElementos[0].substring(0, posicionIgual);
        var valor = tabElementos[0].substring(posicionIgual+1);
        if (nombrecookie == nombre) { 
            return valor;
        } else return null;
    }
}