<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\EntidadController;

//OJO con usar rutas que lleven : o = porque en el router puede hacer varias veces el tratamiento de la url para conseguir el 2º indice 
Router::add('GET', '/pages/borrar/:id', function($entidadId){return (new EntidadController())->delete($entidadId);});
Router::add('GET', '/pages/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);}); 
Router::add('POST', '/pages/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/pages/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});
Router::add('GET', '/entidades=campo_ord', function ($campo_ord) {return (new EntidadController())->list($campo_ord);});
//file_put_contents("log.txt", $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);

Router::dispatch();

?>