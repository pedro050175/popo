function validarCompraventa (formulario){//para acceder a elmentos del formulario se usa this.form
    if (!fechasMenorMayor(formulario.fechaFactComp.value, formulario.fechaFactVent.value)){
        return confirm("Fecha de venta antes que fecha de compra, desea mantenerlo asi?");
    }
    let precioCompra = Number(formulario.precioCompraDeclarado.value); 
    let precioVenta = Number(formulario.precioVentaDeclarado.value); 
    if (precioCompra>precioVenta && precioVenta != 0){
        return confirm("Precio de venta inferior al de compra,  desea mantenerlo asi?");
    }
    if (!validarTablaEnteros([formulario.precioCompraReal, formulario.precioCompraDeclarado, formulario.precioVentaReal, formulario.precioVentaDeclarado])){
            return false;
    }
    let impCompra = formulario.impuestoCompra.value;
    let impVenta = formulario.impuestoVenta.value;
    if (precioVenta != 0 && precioCompra != 0) {
        if ((impCompra == "IVA" && impVenta!= "IVA") || (impCompra == "REBU" && impVenta!= "REBU")){
            alert ("Impuesto de compra diferente a impusto de venta");
            return false;
        }
    }
    let compraA = formulario.select_compraA.value; 
    let vendeA = formulario.select_vendeA.value; 
    let empresa = formulario.select_empresa.value; 
    if (compraA == vendeA && compraA!=''){
        alert ("\"Compra\" a y \"vende a\" no pueden ser iguales");
        return false;
    }
    if ((empresa == compraA) || (empresa == vendeA)){
        alert ("La empresa no puede ser la misma que \"Compra\" o \"Vende a\"");
        return false;
    }  
    return true; //al devolver true al regresar al formulario se hace el submit, si se devuelve false no se hace submit
}