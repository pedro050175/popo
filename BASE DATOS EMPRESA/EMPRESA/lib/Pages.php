<?php
namespace lib;

class Pages {
    public function render (string $pageName, ?array $params = null): void {//$pageName es la pagina html que va a mostrar los datos y a la cual se los pasamos, $params es un array con todos los datos de la consulta select
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value; //usando el indice asociativo de la tabla de datos, crea variable con el nombre del indice y le asigna el valor que contiene esa posicion de la tabla
            }
        }
         require_once "pages/header.php";
         require_once "pages/$pageName.php";
         require_once "pages/footer.php";

    }
}