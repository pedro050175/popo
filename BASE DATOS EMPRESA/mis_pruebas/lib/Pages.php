<?php
namespace lib;

class Pages {
    public function render (string $pageName, ?array $params = null): void {//$pageName es la pagina html que va a mostrar los datos y a la cual se los pasamos, $params es un array con todos los datos de la consulta select
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value; //usando el indice asociativo de la tabla de datos, crea variable con el nombre del indice y le asigna el valor que contiene esa posicion de la tabla     
            }
        }
        // Esto no son rutas de páginas para cargar, sino rutas de paginas con contenido para cargar en la página actual, desde la que se ha llamado a render
        require_once "pages/header.php";
        require_once "pages/$pageName.php";
        require_once "pages/footer.php";

    }
    public function renderNoHeader(string $pageName, ?array $params = null){//para cuando la paquina la llama con fetch no tiene que llevar header ni footer
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;      
            }
        }
        require_once "pages/$pageName.php";
    }
}