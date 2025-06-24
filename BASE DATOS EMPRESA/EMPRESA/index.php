<?php
require_once "autoloader.php";
require_once "config.php";

use lib\Router;
use controllers\ContactosController;

Router::add('GET', '/entidad', function () { return (new ContactosController())->list();});
Router::dispatch();
?>