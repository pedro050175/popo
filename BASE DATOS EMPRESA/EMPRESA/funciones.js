function validarFechas (formulario){
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
    formulario.submit();
}
function mostrarFotos(){

}
function mostrarGastos{
    
}