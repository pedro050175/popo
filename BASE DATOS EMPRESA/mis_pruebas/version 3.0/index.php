<?php
require_once "autoloader.php";
require_once "config.php";
require_once "Funciones.php";

use lib\Router;
use controllers\EntidadController;
use controllers\VehiculoController;

//Cuando da error en el router "índice array no existe" y sale mensaje "función nula" es problema de rutas relativas de los href, la ruta del href que se usa como segundo índice en el array routes no coincide con la que se ha añadido a routes con add
//Rutas de Entidades
Router::add('GET', '/pages/detalles_entidad/:id', function($entidadId) {return (new EntidadController())->detalles_entidad($entidadId);});
Router::add('GET', '/pages/borrar/:id', function($entidadId){return (new EntidadController())->delete($entidadId);});
Router::add('GET', '/pages/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);}); 
Router::add('POST', '/pages/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/pages/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});
//file_put_contents("log.txt", $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
//Rutas de Vehiculos

Router::add('GET', '/pages/detalles_vehiculo/:id', function($vehiculoId) {return (new VehiculoController())->detalles_vehiculo($vehiculoId);});
Router::add('GET', '/pages/borrar_vehiculo/:id', function($id_vehiculo){return (new VehiculoController())->delete($id_vehiculo);});
Router::add('GET', '/pages/nuevo_vehiculo/:id', function($id_vehiculo) {return (new VehiculoController())->edit($id_vehiculo);}); 
Router::add('POST', '/pages/nuevo_vehiculo', function () {return (new VehiculoController())->save();});
Router::add('GET', '/pages/nuevo_vehiculo', function() {return (new VehiculoController())->add();});
Router::add('GET', '/vehiculos', function () {return (new VehiculoController())->list();});




Router::dispatch();

?>