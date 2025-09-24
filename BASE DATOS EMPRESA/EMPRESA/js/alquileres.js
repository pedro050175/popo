function validarAlquiler (formulario){//para acceder a elmentos del formulario se usa this.form
    
    let fechaInicio = new Date(formulario.fechaInicio.value);
    let fechaFin = new Date(formulario.fechaFin.value);
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comprar el mismo tipo de datos
    if (fechaFin<fechaInicio){
        alert ("Fecha fin erronea");
        return false;
    }
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
}