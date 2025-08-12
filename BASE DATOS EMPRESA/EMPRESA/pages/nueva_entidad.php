<div id="error-message" class="alert alert-danger d-none" role="alert"></div> <!-- para mostrar mensaje de error en la pagina HTML al guardar con Nombre vacio-->

<form action="/mis_pruebas/pages/nueva_entidad" method="post">
    <?php if (isset($entidad)) :?>
    <input type="hidden" name="data[entidad][id_entidad]" value="<?=$entidad->getId()?>" id="id_entidad">
    <?php endif;?>    
    <!--<p><?// sleep(3); echo "hola";?></p> hay que poner comentarios para html y tmb comentarios para el codigo incrustado PHP -->  
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h5><?= (isset($entidad)) ? 'Modificar' : 'Nueva'?> Entidad</h5>
            </div>
            <div class="col text-end">  
                <a href="/mis_pruebas/entidades?num_pagina=1" role="button" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"> <?= (isset($entidad)) ? 'Guardar' : 'Crear' ?></button>
            </div>
        </div>
<div class="row">
    <div class="col-md-6">       
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Nombre]" class="form-control" id="Nombre" placeholder="Nombre" value="<?=(isset($entidad))?$entidad->getNombre():''?>"> 
            <label for="floatingInput">Nombre</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][CIF_DNI]" class="form-control" id="CIF_DNI" placeholder="CIF_DNI" value="<?=(isset($entidad))?$entidad->getCIF_DNI():''?>" required>
            <label for="floatingInput">CIF_DNI</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6"> 
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Direccion]" class="form-control" id="Direccion" placeholder="Direccion" value="<?=(isset($entidad))?$entidad->getDireccion():''?>">
            <label for="floatingInput">Direccion</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Telefono]" class="form-control" id="Telefono" placeholder="Telefono" value="<?=(isset($entidad))?$entidad->getTelefono():''?>">
            <label for="floatingInput">Telefono</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Email]" class="form-control" id="Email" placeholder="Email" value="<?=(isset($entidad))?$entidad->getEmail():''?>">
            <label for="floatingInput">Email</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Observaciones]" class="form-control" id="Observaciones" placeholder="Observaciones" value="<?=(isset($entidad))?$entidad->getObservaciones():''?>">
            <label for="floatingInput">Observaciones</label>
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
