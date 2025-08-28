<?php
require_once "autoloader.php";
require_once "config.php";
require_once "Funciones.php";

use lib\Router;
use controllers\EntidadController;
use controllers\VehiculoController;
use controllers\FotoController;
use controllers\GastoVehiculoController;

//Cuando da error en el router "índice array no existe" y sale mensaje "función nula" es problema de rutas relativas de los href, la ruta del href que se usa como segundo índice en el array routes no coincide con la que se ha añadido a routes con add
//Rutas de Entidades
Router::add('GET', '/detalles_entidad/:id', function($entidadId) {return (new EntidadController())->detalles_entidad($entidadId);});
Router::add('GET', '/borrar/:id', function($entidadId){return (new EntidadController())->delete($entidadId);});
Router::add('GET', '/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);}); 
Router::add('POST', '/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});
//file_put_contents("log.txt", $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
//Rutas de Vehiculos

Router::add('GET', '/detalles_vehiculo/:id', function($vehiculoId) {return (new VehiculoController())->detalles_vehiculo($vehiculoId);});
Router::add('GET', '/borrar_vehiculo/:id', function($id_vehiculo){return (new VehiculoController())->delete($id_vehiculo);});
Router::add('GET', '/nuevo_vehiculo/:id', function($id_vehiculo) {return (new VehiculoController())->edit($id_vehiculo);}); 
Router::add('POST', '/nuevo_vehiculo', function () {return (new VehiculoController())->save();});
Router::add('GET', '/nuevo_vehiculo', function() {return (new VehiculoController())->add();});
Router::add('GET', '/vehiculos', function () {return (new VehiculoController())->list();});
//Rutas de fotos vehiculo
Router::add('GET', '/borrar_foto_vehiculo/:id', function($id_foto){return (new FotoController())->delete($id_foto);});
Router::add('GET', '/editar_foto/:id', function($id_foto) {return (new FotoController())->edit($id_foto);}); 
Router::add('POST', '/nueva_foto', function () {return (new FotoController())->save();});
//Rutas de gastos vehiculo
Router::add('GET', '/borrar_gasto_vehiculo/:id', function($id_gasto){return (new GastoVehiculoController())->delete($id_gasto);});
Router::add('GET', '/editar_gasto_vehiculo/:id', function($id_gasto) {return (new GastoVehiculoController())->edit($id_gasto);}); 
Router::add('POST', '/nuevo_gasto_vehiculo', function () {return (new GastoVehiculoController())->save();});
//Rutas de cuotas vehiculo
//Router::add('POST', '/nueva_cuota_vehiculo', function () {return (new CuotaVehiculoController())->save();});



Router::dispatch();

?>