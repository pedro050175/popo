<!-- <?php if (!isset($_COOKIE['numero_pagina'])){
    setcookie("numero_pagina", "1");
}else {
    setcookie("numero_pagina", strval((intval($_COOKIE['numero_pagina'])+1))); //solo se le puede cambiar el valor reescribiendola $_COOKIE solo tiene el valor de la cookie que se lo envia el navegador del cliente al servidor de PHP y la guarada en $_COOKIE
//se puede borrar con setcookie("numero_pagina"). cualquier operacion con setcookie tiene que ser antes de cargar HTML, una vez cargado HTML solo se puede consultar a $_COOKIE
}
?> -->
<!DOCTYPE html>
<html>
<head>
    <title>Entidad</title>   
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> 
    <link href="<?=DIRECTORIO?>css/estilos.css?v=<?=filemtime(__DIR__ . '/css/estilos.css')?>" rel="stylesheet" type="text/css"><!--usar ruta absoluta para que no de fallos con las diferentes URL, ya que si se pone ruta relativa solo funciona 
    segun que URL estemos ,pe. si estoy editando una entidad tengo esta ruta http://localhost:8000/mis_pruebas/nueva_entidad/1 y si estoy en el listado de entidades tengo esta http://localhost:8000/mis_pruebas/entidades?num_pagina=1
    y el header.php busca la hoja css usando la URL no usa la ubicacion del archivo que se carga en el navegador si no la URL -->
    <!--filemtime(__DIR__ . '/css/estilos.css') lo uso para añadir la fecha en segundos de la ultima modificacion al nombre del css y asi cada vez que se modifique el css obliga al navegador a recargarlo y no usar el de cache antiguo, si no hago eso tngo que pulsar CTRL-F5 para forzar a cargar-->
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- JS de jQuery (requerido por Select2) y Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=DIRECTORIO?>funciones.js" type="text/javascript"></script>
    
</head>
<body>
    <?php
// Detectar la ruta actual
    $currentPath = $_SERVER['REQUEST_URI'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">#</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link<?= str_contains($currentPath, 'vehiculo') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>vehiculos?num_pagina=1" aria-current="page">Vehiculos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= str_contains($currentPath, 'entidad') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>entidades?num_pagina=1" aria-current="page">Entidades</a>
                </li>
            </ul>
        </div>
    </div>
    </nav> <!--no cierra el body porque el body lo completa el codigo de fichero php que se carga a continuacion del header en la clase Pages -->