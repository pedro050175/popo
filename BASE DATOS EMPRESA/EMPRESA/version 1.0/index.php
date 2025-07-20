<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\EntidadController;

//Cuando da error en eo router "índice array no existe" y sale mensaje "función nula" es problema de rutas relativas de los href, la ruta del href que se usa como segundo índice en el array routes no coincide con la que se ha añadido a routes con add
Router::add('GET', '/pages/borrar/:id', function($entidadId){return (new EntidadController())->delete($entidadId);});
Router::add('GET', '/pages/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);}); 
Router::add('POST', '/pages/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/pages/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});
//file_put_contents("log.txt", $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);

Router::dispatch();

?>