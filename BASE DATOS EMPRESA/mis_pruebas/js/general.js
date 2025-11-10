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
function fechasMenorMayor(fechaMenor, fechaMayor){//comprueba si la fechaMenor es menor que fechaMayor
    let fecha1 = new Date(fechaMenor);
    let fecha2 = new Date(fechaMayor);
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comparar el mismo tipo de datos
    if (fecha2<fecha1){
      return false;
    }
    return true;  
}
function tooltip(){
  const tooltip = document.createElement('div');
  tooltip.className = 'tooltip-popup';
  document.body.appendChild(tooltip);
  document.querySelectorAll('.tooltip-cell').forEach(cell => {
    cell.addEventListener('mouseenter', e => {
      const text = cell.dataset.tooltip;
      if (!text) return;
      tooltip.textContent = text;
      tooltip.classList.add('show');
      const rect = cell.getBoundingClientRect();
      const tooltipHeight = tooltip.offsetHeight;
      const top = rect.top - tooltipHeight - 8 < 0
        ? rect.bottom + 8 + window.scrollY
        : rect.top + window.scrollY - tooltipHeight - 8;
      tooltip.style.top = `${top}px`;
      tooltip.style.left = `${rect.left + window.scrollX}px`;
    });
    cell.addEventListener('mousemove', e => {
      tooltip.style.left = `${e.pageX + 12}px`;
      tooltip.style.top = `${e.pageY - tooltip.offsetHeight - 10}px`;
    });
    cell.addEventListener('mouseleave', () => {
      tooltip.classList.remove('show');
    });
  });
}
function mensaje(mensaje){
  let zonaMensaje = document.getElementById(mensaje);
        if (zonaMensaje){ /* si no existe es porque la pagina no tiene mensaje para mostrar*/
            zonaMensaje.classList.add("mostrar"); /* añade la clase mostrar quedando class="mensajeGuardar mostrar" */
            //con zonaMensaje.style.opacity = 1; tmb se podria haber modificado directamente el atributo opacity del div en lugar de modificar la clase del div, pero modificando la clase hay mas posibilidades de cambiar otros atributos
            setTimeout(()=>{
                //y aqui tmb directamente se modifica el atributo zonaMensaje.style.opacity = 0;
                zonaMensaje.classList.remove("mostrar");// Espera 2.5s y luego inicia la animación de desvanecimiento
            }, 2500);/* OJo que setTimeOut es asincrono, mientras espera los 2500 sigue ejecutando y carga el evento de transitioned, y al terminar la transicion de 0 a 1
            opacity ya se dispara el evento transitionend por eso hay que poner el if dentro para que no ejecute zonaMensaje.style.display = "none" al pasar de 0 a 1*/
            // Evento final de transicion= ocultar. Podria haber puesto en la regla .mesnajeGuardar (display: "none") y asi se oculta despues de quitarle .mostrar a la clase
            zonaMensaje.addEventListener("transitionend", () => {
                /* sino se pone el if el evento se dispara tmb al hacer zonaMensaje.classList.add("mostrar"); y al terminar esa transcion lo oculta
                con el if, solo se oculta si antes se ha mostrado. Tmb se podira haber puesto asi:
                    if (getComputedStyle(zonaMensaje).opacity === "0") {
                       zonaMensaje.style.display = "none";
                    } se consulta el style en lugar de la clase*/
                if (!zonaMensaje.classList.contains("mostrar")) {
                    /*zonaMensaje.style.display = "none"; esto no hay que hacerlo, habria que quitar todo el evento de transicion ya que el 
                     mensaje se oculta al quitarle la clase mostrar. Si se pone esto oculta algo que ya se ha ocultado y ademas inpide que se
                     pueda volver a mostrar el mensaje si se llamara de nuevo a esta funcion porque se le ha puesto el display a none.
                     Dejo el evento porque es interesante tenerlo en cuenta, el cargar un evento de transicion*/ 
                }
            });        
        }
}
function diaMesConCero(dia){
    if (dia<10) {
        return ('0' + dia);
    }
    return dia;
}