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
    //del formulario lee en formato aaaa-mm-dd. new Date(aaaa-mm-dd) crea la variable tipo Date y asi comprar el mismo tipo de datos
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