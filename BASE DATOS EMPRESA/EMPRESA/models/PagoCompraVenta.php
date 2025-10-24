<?php
namespace models;
require_once "Funciones.php";
class PagoCompraventa {
    function __construct(private ?int $idPago, private ?string $fecha, private ?int $compraventa, private ?float $importe, private ?string $banco, private ?string $observaciones){}

    public function getidPago(): ?int {
        return $this->idPago;
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
    public static function fromArray(array $data): PagoCompraventa {
        return new PagoCompraventa ($data['idPago']??null, $data['fecha']??null, $data['compraventa']??null, $data['importe']??null, $data['banco']??null, $data['observaciones']??null); 
    }
}