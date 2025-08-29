let cadena = 1.025;
let cadenaPunto = cadena.replace('.', ''); 
    if ((campo.value<0) || (isNaN(campo.value)) ){
        alert ("Valor erroneo")
        campo.value=0;
        return false;
    }