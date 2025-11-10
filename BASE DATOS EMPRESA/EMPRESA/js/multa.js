function validarMulta (formulario){//para acceder a elmentos del formulario se usa this.form
    if (!fechasMenorMayor(formulario.fecha.value, formulario.vencimiento.value)){
        return confirm("Fecha de vencimiento antes que fecha de multa, desea mantenerlo asi?");
    }
    if (!validarTablaEnteros([formulario.importe, formulario.importePagado, formulario.importeCobrado])){
            return false;
    }  
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
}
function actualizaVencimiento(formulario){
    let fechaMulta = new Date(formulario.fecha.value);
    let fechaMultaMili = fechaMulta.getTime();/* paso a milisegundos para poder dumarle o restarle tiempo, tiene que ser en milisegundos */
    let dias20Mili = 20*24*60*60*1000; /* 20 dias en milisegundos */
    let fechaVencimiento = new Date(fechaMultaMili + dias20Mili); /* sumo las dos fechas en milis y lo convierto en una fecha formato "fecha+hora". Tengo que pasarlo a formato yyyy-m-dd */ 
    let fechaVencimientoString = ''; 
    /* voy extrayendo partes de la fecha y concatenando hasta obtener el formato yyyy-mm-dd */
    fechaVencimientoString += fechaVencimiento.getFullYear() + '-';
    fechaVencimientoString += fechaVencimiento.getMonth()+1 + '-';
    fechaVencimientoString += diaMesConCero(fechaVencimiento.getDate()); /* a los dias 1-9 le pongo un 0 delante porque getDate me da el dia sin el cero */
    formulario.vencimiento.value = fechaVencimientoString;  
}