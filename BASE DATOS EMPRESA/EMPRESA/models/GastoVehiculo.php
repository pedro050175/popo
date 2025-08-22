<?php
namespace models;
require_once "Funciones.php";

class GastoVehiculo {

    function __construct(private ?int $id_gasto, private ?string $tipo, private ?float $Importe, private ?string $Fecha, private ?int $Paga_otro, private ?string $Comentarios, private ?int $id_vehiculo, private ?int $pagado){}
    
    public function setid_gasto(?int $id) {
        $this->id_gasto = $id;
    }
    public function getid(): ?int {
        return $this->id_gasto;
    }
    public function settipo(?string $tipo) {
        $this->tipo = $tipo;
    }
    public function gettipo(): ?string {
        return $this->tipo;
    }
    public function setImporte(?float $importe) {
        $this->Importe = $importe;
    }
    public function getimporte(): ?float {
        return $this->Importe;
    }
    public function setFecha(?string $fecha) {
        $this->Fecha = $fecha;
    }
    public function getFecha(): ?string {
        return $this->Fecha;
    }
    public function setPaga_otro(?int $Paga_otro) {
        $this->Paga_otro = $Paga_otro;
    }
    public function getPaga_otro(): ?int {
        return $this->Paga_otro;
    }
    public function setComentarios(?string $Comentarios) {
        $this->Comentarios = $Comentarios;
    }
    public function getComentarios(): ?string {
        return $this->Comentarios;
    }
    public function setid_vehiculo(?int $id_vehiculo) {
        $this->id_vehiculo = $id_vehiculo;
    }
    public function getid_vehiculo(): ?int {
        return $this->Paga_otro;
    }
    public function setpagado(?int $pagado) {
        $this->pagado = $pagado;
    }
    public function getpagado(): ?int {
        return $this->pagado;
    }
    public static function fromArray(array $data): GastoVehiculo {
        
        $modelo = duplicar_tabla(CAMPOS_GASTO_VEHICULO, $data);
        //var_dump($data);
        return new GastoVehiculo ($modelo['id_gasto'], $modelo['tipo'], $modelo['Importe'], $modelo['Fecha'], $modelo['Paga_otro'], $modelo['Comentarios'], $modelo['id_vehiculo'], $modelo['pagado']); 
    }
}