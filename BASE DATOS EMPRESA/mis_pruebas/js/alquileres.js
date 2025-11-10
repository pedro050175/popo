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
function actualizaGanancia(form){
    form.ganancia.value = form.precio.value - form.comisionComercial.value;
}
function actualizaFechaFin(formulario){
    let fecha = new Date(formulario.fechaInicio.value);
    let fechaMili = fecha.getTime();/* paso a milisegundos para poder dumarle o restarle tiempo, tiene que ser en milisegundos */
    let diasAlquiler = formulario.dias.value;
    let diasMili = diasAlquiler*24*60*60*1000; /* dias en milisegundos */
    let fechaFin = new Date(fechaMili + diasMili); /* sumo las dos fechas en milis y lo convierto en una fecha formato "fecha+hora". Tengo que pasarlo a formato yyyy-m-dd */ 
    let fechaVencimientoString = ''; 
    /* voy extrayendo partes de la fecha y concatenando hasta obtener el formato yyyy-mm-dd */
    fechaVencimientoString += fechaFin.getFullYear() + '-';
    fechaVencimientoString += fechaFin.getMonth()+1 + '-';
    fechaVencimientoString += diaMesConCero(fechaFin.getDate());
    formulario.fechaFin.value = fechaVencimientoString;  
}