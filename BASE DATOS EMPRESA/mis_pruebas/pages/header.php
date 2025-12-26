<?php
/*este codigo es para cuando se edita una foto, gasto o cuota despues al volver a la pag nuevo_vehiculo que cargue el menu que se acaba de usar, lo pordria hacer en el metodo edit de cada 
controller como he hecho en los metodos save y delete, pero el metodo edit, a diferencia de los otros nombrados, si carga pagina y puedo usarlo aqui, y asi uso diferentes modos*/
    $currentPath = $_SERVER['REQUEST_URI'];
    if (str_contains($currentPath, 'foto')) { 
        setcookie('menuVehiculo', 'fotos', time()+600, "/");//muy importante poner la / para que este disponible en todas las paginas de la aplicacion y localhost para que tmb este disponible en todo el dominio
        }else if (str_contains($currentPath, 'cuota')) {
            setcookie('menuVehiculo', 'cuotas', time()+600, "/");
            }else if (str_contains($currentPath, 'gasto')) {
                setcookie('menuVehiculo', 'gastos', time()+600, "/");

            }  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Entidad</title>   
    <meta charset="utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico"><!--para el icono de la pagina, si no se lo pongo da un error en consola de java-->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- pluing modales modernos usado en compraventas para la modificacion de tri "acciones"-->
    <!-- jQuery UI (HAY QUE PONERLO DESPUES DEL ENLACE A jQuery) -->
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.min.js" integrity="sha256-AlTido85uXPlSyyaZNsjJXeCs07eSv3r43kyCVc8ChI=" crossorigin="anonymous"></script> 
    <!-- CSS de jQuery UI -->
    <link href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=DIRECTORIO?>css/estilos.css?v=<?= filemtime(dirname(__DIR__).'/css/estilos.css')?>" rel="stylesheet" type="text/css">
    <!--en los src o href usar ruta absoluta para que no de fallos con las diferentes URL, ya que si se pone ruta relativa solo funciona. 
    _DIR_ contiene la ruta del directorio del archivo donde esta escrita esta linea,es decir, la ruta de header.php, (no contiene la ruta de index.php), contiene /mis_pruebas/pages. 
    Filename necesita la ruta entera, incluida la ruta del servidor de linux /srv/www/api/mis_pruebas/css/estilos.css, no es como los href que usan buscar los archivos en relacion a
    la ruta de index.php. asi que como header.php esta en /pages, tengo que salir de /pages para darle la ruta correcta de estilos.css a filemtime(), con dirname() se sube un nivel,
    salgo de /pages. con $_SERVER['DOCUMENT_ROOT'] tmb tendria la ruta. Tmb podria haber subido un nivel con /../css/estilos.css   
    hay que tener en cuenta que el servidor php trabaja 
    con la carpeta mis_pruebas. el contenedor de PHP mapea /srv/www/api con mi carpeta www en el PC, todo lo que hago en www se compia a api. 
    Segun que URL estemos ,pe. si estoy editando una entidad tengo esta ruta http://localhost:8000/mis_pruebas/nueva_entidad/1 y si estoy en el listado de entidades tengo esta http://localhost:8000/mis_pruebas/entidades?num_pagina=1
    y el header.php busca la hoja css usando la URL no usa la ubicacion del archivo que se carga en el navegador si no la URL -->
    <!--filemtime(__DIR__ . '/css/estilos.css') lo uso para añadir la fecha en segundos de la ultima modificacion al nombre del css y asi cada vez que se modifique el css obliga al navegador a recargarlo 
    y no usar el de cache antiguo, si no hago eso tngo que pulsar CTRL-F5 para forzar a cargar-->
    
    <!-- mis archivos JS -->
    <script src="<?=DIRECTORIO?>/js/nuevo_vehiculo.js" type="text/javascript"></script>
    <script src="<?=DIRECTORIO?>/js/movimientos.js" type="text/javascript"></script>
    <script src="<?=DIRECTORIO?>/js/alquileres.js" type="text/javascript"></script>
    <script src="<?=DIRECTORIO?>/js/compraventa.js" type="text/javascript"></script>
    <script src="<?=DIRECTORIO?>/js/general.js" type="text/javascript"></script>
    <script src="<?=DIRECTORIO?>/js/multa.js" type="text/javascript"></script>
    
</head>
<body>
    <?php
// Detectar la ruta actual
    $currentPath = $_SERVER['REQUEST_URI'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">MENU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'vehiculos') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>vehiculos?num_pagina=1" aria-current="page">Vehiculos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'entidad') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>entidades?num_pagina=1" aria-current="page">Entidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'movimiento') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>movimientos?num_pagina=1" aria-current="page">Movimientos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'alquiler') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>alquileres?num_pagina=1" aria-current="page">Alquileres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'compraventa') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>compraventas?num_pagina=1" aria-current="page">Compra-Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'multa') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>multas?num_pagina=1" aria-current="page">Multas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= str_contains($currentPath, 'seguro') ? 'active' : '' ?>" href="<?= DIRECTORIO ?>seguros?num_pagina=1" aria-current="page">Seguros</a>
                    </li>
                    <li>
                        <img width = "70" height="40" src = "<?=DIRECTORIO?>/images/logo_world.jpg">
                    </li>
                </ul>
            </div>
        </div>
    </nav> <!--no cierra el body porque el body lo completa el codigo de fichero php que se carga a continuacion del header en la clase Pages -->