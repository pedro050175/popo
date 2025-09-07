<?php
namespace models;

require_once "Funciones.php";

class Entrega {

    function __construct (private ?int $idEntrega, private ?string $fecha, private ?float $importe, private ?string $bancoEnvia, private ?string $bancoRecibe, 
                            private ?string $observaciones, private ?int $movimiento){} 
 
    public function getidEntrega(): ?int {
        return $this->idEntrega;
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
    public static function fromArray(array $data): Entrega {
        $modelo = duplicar_tabla (CAMPOS_ENTREGA, $data); 
        return new Entrega ($modelo['idEntrega'], $modelo['fecha'], $modelo['importe'], $modelo['bancoEnvia'], $modelo['bancoRecibe'], $modelo['observaciones'], $modelo['movimiento']); 
    }

}