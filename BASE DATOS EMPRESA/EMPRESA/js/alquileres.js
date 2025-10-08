function validarAlquiler (formulario){//para acceder a elmentos del formulario se usa this.form
    
    /* let fechaInicio = new Date(formulario.fechaInicio.value);
    let fechaFin = new Date(formulario.fechaFin.value); */
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comprar el mismo tipo de datos
    if (!fechasMenorMayor(formulario.fechaInicio.value, formulario.fechaFin.value)){
        alert ("Fecha fin erronea");
        return false;
    }
    if (!validarTablaEnteros([formulario.kilometros, formulario.kmInicio, formulario.kmFin, formulario.dias, formulario.precio, formulario.precioKm, 
                            formulario.fianza, formulario.fianzaDevuelta, formulario.comisionComercial, formulario.ganancia])){
            return false;
    }
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
}
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
function validaFechas(desde, hasta){
    if (desde=="" || hasta==""){//que no esten vacias
        alert ("Introduzca fechas");
        return false;
    }
    if (!fechasMenorMayor(desde, hasta)){//que la 1º sea menos que la 2º
        alert ("Fecha fin erronea");
        return false;
    }
    let añoDesde = desde.slice(0,4);//extrae el año, 1º cadena de 4caracteres  (posi inicial, posicion final) 
    let añoHasta = hasta.substr(0,4);//extrae (posicion inicial, logitud cadena)
    if (añoDesde!=añoHasta){//que sean fechas del mismo año
        alert ("Error fechas con diferente año");
        return false;
    }
    return true;
}
function fechasMenorMayor(fechaMenor, fechaMayor){//comprueba si la fechaMenor es menor que fechaMayor
    let fecha1 = new Date(fechaMenor);
    let fecha2 = new Date(fechaMayor);
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comprar el mismo tipo de datos
    if (fecha2<fecha1){
        return false;
    }
    return true;  
}