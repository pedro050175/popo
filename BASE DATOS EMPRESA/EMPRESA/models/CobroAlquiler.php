<?php
namespace models;
require_once "Funciones.php";
class CobroAlquiler {
    function __construct(private ?int $idCobro, private ?string $fecha, private ?int $alquiler, private ?float $importe, private ?int $facturado, private ?string $facturadoA, 
                        private ?string $contratoHacienda, private ?int $fianza, private ?float $parteImporteFianza, private ?string $banco, private ?string $observaciones){}

    public function getidCobro(): ?int {
        return $this->idCobro;
    }
    public function getfecha(): ?string {
        return $this->fecha;
    }
    public function getalquiler(): ?int {
        return $this->alquiler;
    }
    public function getimporte(): ?float {
        return $this->importe;
    }
    public function getfacturado(): ?int {
        return $this->facturado;
    }
    public function getfacturadoA(): ?string {
        return $this->facturadoA;
    }
     public function getfianza(): ?int {
        return $this->fianza;
    }
    public function getcontratoHacienda(): ?string {
        return $this->contratoHacienda;
    }
    public function getparteImporteFianza(): ?float {
        return $this->parteImporteFianza;
    }
    public function getbanco(): ?string {
        return $this->banco;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public static function fromArray(array $data): CobroAlquiler {
        
        $modelo = duplicar_tabla(CAMPOS_COBRO_ALQUILER, $data);
        //var_dump($data);
        return new CobroAlquiler ($modelo['idCobro'], $modelo['fecha'], $modelo['alquiler'], $modelo['importe'], $modelo['facturado'], $modelo['facturadoA'], $modelo['contratoHacienda'], $modelo['fianza'],
                                    $modelo['parteImporteFianza'], $modelo['banco'], $modelo['observaciones']); 
    }
}