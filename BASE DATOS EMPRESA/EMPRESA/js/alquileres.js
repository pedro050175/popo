function validarAlquiler (formulario){//para acceder a elmentos del formulario se usa this.form
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