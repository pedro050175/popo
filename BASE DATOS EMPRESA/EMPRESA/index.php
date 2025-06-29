<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\EntidadController;


$entidades = (new EntidadController())->list();
// var_dump($entidades);
// Router::add('GET', '/entidad', function () { return (new EntidadController())->list();});

// Router::dispatch();
?>