<?php
namespace models;

class Alquiler {
    
    function __construct (private int $id, private string $Contrato, private int $Vehiculo, private int $Cliente, private string $Fecha_inicio, private ?string $Fecha_fin, private ?int $km,
    private ?int $Km_inicio, private ?int $Km_fin, private ?string $Dias, private ?int $Precio, private ?int $Precio_km, private ?int $comercial, private ?int $Empresa, private ?string $Ciudad, 
    private ?string $Entrega, private ?int $Comision_comercial, private ?int $Ganancia, private ?string $Observaciones){}

    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }
    public function getContrato(): string {
        return $this->Contrato;
    }
    public function setContrato(string $contrato){
        $this->Contrato = $contrato;
    }
    public function getVehiculo(): int {
        return $this->Vehiculo;
    }
    public function setVehiculo(int $vehiculo) {
        $this->Vehiculo = $vehiculo;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function setObservaciones(?string $Observaciones) {
        $this->Observaciones = $Observaciones;
    }
    public function getCliente(): int {
        return $this->Cliente;
    }
    public function setCliente(int $cliente) {
        $this->Cliente = $cliente;
    }
    public function getFecha_inicio(): string {
        return $this->Fecha_inicio;
    }
    public function setFecha_inicio(string $fecha_inicio) {
        $this->Fecha_inicio = $fecha_inicio;
    }
    public function getFecha_fin(): ?string {
        return $this->Fecha_fin;
    }
    public function setFecha_fin(?string $fecha_fin) {
        $this->Fecha_fin = $fecha_fin;
    }
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
    public function get
    public function set
















































    public static function fromArray(array $data): Entidad {
        return new Entidad ($data['id'], $data['CIF_DNI'], $data['Nombre'], $data['Observaciones'], $data['Direccion'], $data['Telefono'], $data['Email'],); 
    }
}