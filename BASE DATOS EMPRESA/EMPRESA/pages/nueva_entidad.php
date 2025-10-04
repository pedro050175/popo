<div id="error-message" class="alert alert-danger d-none" role="alert"></div> <!-- para mostrar mensaje de error en la pagina HTML al guardar con Nombre vacio-->

<form action="<?= DIRECTORIO ?>nueva_entidad" method="post">
    <?php if (isset($entidad)) :?>
    <input type="hidden" name="data[entidad][id_entidad]" value="<?=$entidad->getId()?>" id="id_entidad">
    <?php endif;?>    
    <!--<p><?// sleep(3); echo "hola";?></p> hay que poner comentarios para html y tmb comentarios para el codigo incrustado PHP -->  
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h5 class="titulo_prin"><?= (isset($entidad)) ? 'Modificar' : 'Nueva'?> Entidad</h5>
            </div>
            <div class="col text-end">  
                <input type="button" class="boton_link" value = "Salir" onclick="window.location.href='<?= DIRECTORIO ?>entidades?num_pagina=1';">
                <button type="submit" class="boton_submit"> <?= (isset($entidad)) ? 'Guardar' : 'Crear' ?></button>
                <button type="reset" class="boton_submit" <?= (isset($entidad)) ? 'hidden' : ''?>>Borrar</button>
            </div>
        </div>
<div class="row">
    <div class="col-md-6">       
        <div class="form-floating mb-1">
            <input type="text" name="data[entidad][Nombre]" class="form-control" id="Nombre" placeholder="Nombre" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getNombre()):''?>"> 
            <label for="Nombre">Nombre</label><!--la propiedad for en los label asocia la etiqueta con el cuadro usando el nombre del id del cuadro de esta forma
            al pinchar en la etiqueta el cursor se coloca en el input. Tmb se podria hacer poniendo el input entre las etiquetas label, pero boostrap pone la etiqueta fuera del input-->
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-1">
            <input type="text" name="data[entidad][CIF_DNI]" class="form-control" id="CIF_DNI" placeholder="CIF_DNI" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getCIF_DNI()):''?>" required>
            <label for="CIF_DNI">CIF_DNI</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6"> 
        <div class="form-floating mb-1">
            <input type="text" name="data[entidad][Direccion]" class="form-control" id="Direccion" placeholder="Direccion" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getDireccion()):''?>">
            <label for="Direccion">Direccion</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-1">
            <input type="tel" name="data[entidad][Telefono]" pattern="[0-9+ ]{9,15}" class="form-control" id="Telefono" placeholder="Telefono" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getTelefono()):''?>">
            <!--pattern es una expresion regular para valirdar se puede aplcar a campos type email, search, text-->
            <label for="Telefono">Telefono</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-floating mb-1">
            <input type="email" name="data[entidad][Email]" class="form-control" multiple id="Email" placeholder="Email" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getEmail()):''?>">
            <label for="Email">Email</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-1">
            <input type="text" name="data[entidad][Observaciones]" class="form-control" id="Observaciones" placeholder="Observaciones" value="<?=(isset($entidad))?quitaEspecialChar($entidad->getObservaciones()):''?>">
            <label for="Observaciones">Observaciones</label>
        </div>
    </div>
</div>
</div>
</form>
<!-- Esto es JS para mostrar mensaje de error en la pagina al guardar con Nombre vacio, este codigo va junto al que se pone al principio de la pagina-->
<script> 
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const errorBox = document.getElementById("error-message");

    form.addEventListener("submit", function(e) {
        const nombreInput = form.querySelector('input[name="data[entidad][Nombre]"]');
        if (nombreInput.value.trim() === "") {
            e.preventDefault();

            errorBox.textContent = "El campo Nombre no puede estar vacío.";
            errorBox.classList.remove("d-none");
            nombreInput.focus();
        } else {
            // Ocultar mensaje si todo está bien
            errorBox.classList.add("d-none");
        }
    });
});
</script>
<!-- Esto es JS para mostrar mensaje de error en en una ventana emergente al guardar con Nombre vacio, no necesita la linea del principio del formulario
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    form.addEventListener("submit", function(e) {
        const nombreInput = form.querySelector('input[name="data[entidad][Nombre]"]');
        if (nombreInput.value.trim() === "") {
            alert("El campo Nombre no puede estar vacío.");
            nombreInput.focus();
            e.preventDefault();
        }
    });
});
</script>-->
