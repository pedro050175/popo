<?php
namespace models;

require_once "Funciones.php";

class Devolucion{

    function __construct (private ?int $idDevolucion, private ?string $fecha, private ?float $importe, private ?string $bancoEnvia, private ?string $bancoRecibe, 
                            private ?string $observaciones, private ?int $movimiento){} 
 
    public function getidDevolucion(): ?int {
        return $this->idDevolucion;
    }
    public function getfecha(): ?string {
        return $this->fecha;
    }
    public function getimporte(): ?float {
        return $this->importe;
    }
    public function getbancoEnvia(): ?string {
        return $this->bancoEnvia;
    }
    public function getbancoRecibe(): ?string {
        return $this->bancoRecibe;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public function getmovimiento(): ?int {
        return $this->movimiento;
    }
    public static function fromArray(array $data): Devolucion {
        return new Devolucion ($data['idDevolucion']??null, $data['fecha']??null, $data['importe']??null, $data['bancoEnvia']??null, $data['bancoRecibe']??null, $data['observaciones']??null,
                                $data['movimiento']??null);  
    }
}