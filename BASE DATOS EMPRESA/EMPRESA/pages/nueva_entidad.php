<form method="post">
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Nueva Entidad</h2>
            </div>
            <div class="col text-end">  
                <a href="/mis_pruebas/entidades" role="button" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Nombre]" class="form-control" id="floatingInput" placeholder="Nombre">
            <label for="floatingInput">Nombre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Apellidos]" class="form-control" id="floatingInput" placeholder="Apellidos">
            <label for="floatingInput">Apellidos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][CIF_DNI]" class="form-control" id="floatingInput" placeholder="CIF_DNI">
            <label for="floatingInput">CIF_DNI</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Direccion]" class="form-control" id="floatingInput" placeholder="Direccion">
            <label for="floatingInput">Direccion</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Telefono]" class="form-control" id="floatingInput" placeholder="Telefono">
            <label for="floatingInput">Telefono</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="data[entidad][Email]" class="form-control" id="floatingInput" placeholder="Email">
            <label for="floatingInput">Email</label>
        </div>
    </div>
</form>