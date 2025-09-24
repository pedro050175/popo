function comprobarEntidades(formulario){
    if (formulario.select_envia.value == formulario.select_recibe.value){
        alert ("La entidad que envia no puede ser la misma que recibe");
        return false;
    } else return true;
}
function escribirLocalStorage(formulario){
     //en el localstorage guardo nombre de variable: formulario y valor forulario, p.e. si formulario=entregas guardo entregas con valor entregas 
    if (typeof localStorage != undefined){
        localStorage.setItem(formulario, formulario);
        hora = new Date();//guardo la fecha y hora actual para controlar la caducidad de las variables de local storage
        localStorage.setItem("hora", hora);
    }
}
function existeEnLocalStorage(variable){//me dice si existe la variable 
    var menuLeido = localStorage.getItem(variable);
    if (menuLeido != null) {//no puedo comparar menuLeido con variable porque en el caso de existe("hora") me va a leer una fecha y al comprar la fecha leida con "hora" y me dira que no existe "hora" 
        return true;
    }else return false;
}
function leerLocaStorage(variable){//lee el valor de la variable en el local Storage
    var valor = "";
    if (typeof localStorage != undefined){
        valor = localStorage.getItem(variable);
        return valor;
    }
}
function mostrarEntregaDevolucion(){//si existe la variable en el local storage muestro el menu
    if (existeEnLocalStorage("hora")){
        var hora = new Date(leerLocaStorage("hora")); // compruebo la hora de la ultima vez que se escribio en el local storage
        var horaActual = new Date();
        hora = hora.getTime();//lo paso a milisegundos
        horaActual = horaActual.getTime();
        if ((horaActual-hora) > 300000){ //han pasado mas de 5 min (JS mide el tiempo en milisegundos 300000=300 seg) desde la ultima vez que se uso el formualrio entrega o devolucion
            borrarLocalStorage();
        }
    }
    if (existeEnLocalStorage("entrega")){
        mostrar('entrega');//esta funcion esta en el JS nuevo_vehiculo
    }
    if (existeEnLocalStorage("devolucion")) {
        mostrar('devolucion');
    }
}
function borrarLocalStorage(){
    localStorage.clear();
}