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
    if (!validar_entero_campo_number (formulario.kilometros)){
        alert ("Kilometros mal escritos");
        return false;
    };
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
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
function validarCuotas(formulario){
    if (!validar_entero_campo_texto (formulario.cuota)) {
        return false;
    }
    if (!validar_entero_campo_texto (formulario.totalPagar)) {
        return false;
    }
    if (!validar_entero_campo_texto (formulario.pagoFinal)) {
        return false;
    }
    if (!validar_entero_campo_texto (formulario.entrada)) {
        return false;
    }
    if (!validar_entero_campo_texto (formulario.fianza)) {
        return false;
    }
    if (!validar_entero_campo_number (formulario.km)){
        return false;
    };
    if (!validar_entero_campo_number (formulario.kmAno)){
        return false;
    };
    return true;    
}
function validar_entero_campo_texto (campo) { //valida campos de formulariotipo text
    
    let cadena = campo.value;
    cadena = cadena.replace(',', '.');//cambio la coma por un punto ya que en sql el decimal es el punto
    if ((cadena<0) || (isNaN(cadena)) ){//compruebo que no sea negativo y que no tenga letras o simbolos
        alert ("Valor erroneo")
        campo.value="";
        return false;
    }
    campo.value=cadena;
    return true;
}

function mostrarMenuVehiculo(menu){//para acceder a elementos de la pagina se usa document
    //oculto todos y luego solo activo el que se llame menu
    divGastos = document.getElementById("gastos").hidden = true;    
    divFotos = document.getElementById("fotos").hidden = true;
    divFotos = document.getElementById("cuotas").hidden = true;
    divFotos = document.getElementById(menu).hidden = false;
}