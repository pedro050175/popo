<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\EntidadController;

static  $numeroveces=0;


Router::add('GET', '/pages/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});

Router::dispatch();
$numeroveces ++;
echo "numero veces que paso por index: $numeroveces";
?>