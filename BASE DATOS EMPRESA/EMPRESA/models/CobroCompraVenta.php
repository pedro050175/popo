<?php
namespace models;
require_once "Funciones.php";
class CobroCompraventa {
    function __construct(private ?int $idCobro, private ?string $fecha, private ?int $compraventa, private ?float $importe, private ?string $banco, private ?string $observaciones){}

    public function getidCobro(): ?int {
        return $this->idCobro;
    }
    public function getfecha(): ?string {
        return $this->fecha;
    }
    public function getcompraventa(): ?int {
        return $this->compraventa;
    }
    public function getimporte(): ?float {
        return $this->importe;
    }
    public function getbanco(): ?string {
        return $this->banco;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public static function fromArray(array $data): CobroCompraventa {
        return new CobroCompraventa ($data['idCobro']??null, $data['fecha']??null, $data['compraventa']??null, $data['importe']??null, $data['banco']??null, $data['observaciones']??null); 
    }
}