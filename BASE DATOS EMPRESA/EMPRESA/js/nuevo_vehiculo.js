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
        alert ("Valor erroneo")
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
function mostrarMenuVehiculo(menu, opciones){//para acceder a elementos de la pagina se usa document
    //oculto todos y luego solo activo el que se llame menu
    for (let opcion of opciones){
        document.getElementById(opcion).hidden = true;    
    }
    document.getElementById(menu).hidden = false; 
}