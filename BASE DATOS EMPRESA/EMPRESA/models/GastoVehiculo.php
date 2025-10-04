<?php
namespace models;
require_once "Funciones.php";

class GastoVehiculo {

    function __construct(private ?int $id_gasto, private ?string $tipo, private ?float $Importe, private ?string $Fecha, private ?int $Paga_otro, private ?string $Comentarios, 
    private ?int $id_vehiculo, private ?int $pagado){}
    
    public function getId_gasto(): ?int {
        return $this->id_gasto;
    }
    public function getTipo(): ?string {
        return $this->tipo;
    }
    public function getImporte(): ?float {
        return $this->Importe;
    }
    public function getFecha(): ?string {
        return $this->Fecha;
    }
    public function getPaga_otro(): ?int {
        return $this->Paga_otro;
    }
    public function getComentarios(): ?string {
        return $this->Comentarios;
    }
    public function getId_vehiculo(): ?int {
        return $this->id_vehiculo;
    }
    public function getPagado(): ?int {
        return $this->pagado;
    }
    public static function fromArray(array $data): GastoVehiculo {
        return new GastoVehiculo ($data['id_gasto']??null, $data['tipo']??null, $data['Importe']??null, $data['Fecha']??null, $data['Paga_otro']??null, $data['Comentarios']??null, 
                                    $data['id_vehiculo']??null, $data['pagado']??null); 
    }
}