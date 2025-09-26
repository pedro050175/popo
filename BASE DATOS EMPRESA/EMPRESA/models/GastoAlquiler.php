<?php
namespace models;
require_once "Funciones.php";

class GastoAlquiler{
    function __construct(private ?int $idGasto, private ?string $tipo, private ?float $importe, private ?string $fecha, private ?int $pagaOtro, private ?int $alquiler, private ?int $pagado, private ?string $observaciones){}
    
    
    public function getidGasto(): ?int {
        return $this->idGasto;
    }
    public function gettipo(): ?string {
        return $this->tipo;
    }
    public function getimporte(): ?float {
        return $this->importe;
    }
    public function getfecha(): ?string {
        return $this->fecha;
    }
    public function getpagaOtro(): ?int {
        return $this->pagaOtro;
    }
    public function getalquiler(): ?int {
        return $this->alquiler;
    }
    public function getpagado(): ?int {
        return $this->pagado;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public static function fromArray(array $data): GastoAlquiler {
        
        $modelo = duplicar_tabla(CAMPOS_GASTO_ALQUILER, $data);
        //var_dump($data);
        return new GastoAlquiler ($modelo['idGasto'], $modelo['tipo'], $modelo['importe'], $modelo['fecha'], $modelo['pagaOtro'], $modelo['alquiler'],  $modelo['pagado'], $modelo['observaciones']); 
    }


}
