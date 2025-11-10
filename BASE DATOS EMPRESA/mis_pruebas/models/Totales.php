<?php
namespace models;

require_once "Funciones.php";

class Totales{

    function __construct (private ?float $totalEntrega, private ?float $totalDevolucion, private ?float $diferencia){}

    public function gettotalEntrega():?float {
        return $this->totalEntrega;
    }
    public function gettotalDevolucion():?float {
        return $this->totalDevolucion;
    }
    public function getdiferencia():?float {
        return $this->diferencia;
    }
    public static function fromArray(array $data): Totales {
        $modelo = duplicar_tabla (CAMPOS_TOTALES, $data);
        return new Totales ($modelo['totalEntrega'], $modelo['totalDevolucion'], $modelo['diferencia']);
    }
}