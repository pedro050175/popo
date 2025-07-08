<form action="/mis_pruebas/pages/nueva_entidad" method="post">
    <?php if (isset($entidad)) :?>
    <input type="hidden" name="data[entidad][id]" value="<?=$entidad->getId()?>">
    <?php endif;?>    
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2><?= (isset($entidad)) ? 'Modifircar' : 'Nuevo'?>Entidad</h2>
            </div>
            <div class="col text-end">  
                <a href="/mis_pruebas/entidades" role="button" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"> <?= (isset($entidad)) ? 'Modificar' : 'Crear' ?> </button>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Nombre]" class="form-control" id="floatingInput" placeholder="Nombre" value="<?=(isset($entidad))?$entidad->getNombre():''?>">
            <label for="floatingInput">Nombre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Apellidos]" class="form-control" id="floatingInput" placeholder="Apellidos" value="<?=(isset($entidad))?$entidad->getApellidos():''?>">
            <label for="floatingInput">Apellidos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][CIF_DNI]" class="form-control" id="floatingInput" placeholder="CIF_DNI" value="<?=(isset($entidad))?$entidad->getCIF_DNI():''?>">
            <label for="floatingInput">CIF_DNI</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Direccion]" class="form-control" id="floatingInput" placeholder="Direccion" value="<?=(isset($entidad))?$entidad->getDireccion():''?>">
            <label for="floatingInput">Direccion</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Telefono]" class="form-control" id="floatingInput" placeholder="Telefono" value="<?=(isset($entidad))?$entidad->getTelefono():''?>">
            <label for="floatingInput">Telefono</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Email]" class="form-control" id="floatingInput" placeholder="Email" value="<?=(isset($entidad))?$entidad->getEmail():''?>">
            <label for="floatingInput">Email</label>
        </div>
    </div>
</form>