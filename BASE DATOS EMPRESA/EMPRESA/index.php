<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\EntidadController;

Router::add('GET', '/pages/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);});
Router::add('POST', '/pages/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/pages/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});

Router::dispatch();

?>