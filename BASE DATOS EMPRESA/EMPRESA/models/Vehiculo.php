<?php
namespace models;

class Vehiculo {

    function __construct (private int $id_vehiculo, private ?string $Matricula, private ?string $Bastidor, private string $Marca_modelo, private ?int $Km, private ?string $Fecha_matricula, 
                            private ?string $Observaciones, private ?string $Combustible, private ?string $Fecha_itv, private ?string $Estado, private ?string $Clase, private ?int $propietario, private ?string $Prox_itv){}
 
    public function getId(): int {
        return $this->id_vehiculo;
    }
    public function setId(int $id) {
        $this->id_vehiculo = $id;
    }
    public function getMatricula(): ?string {
        return $this->Matricula;
    }
    public function setMatricula(string $matricula) {
        $this->Matricula = $matricula;
    }
    public function getBastidor(): ?string {
        return $this->Bastidor;
    }
    public function setBastidor(string $bastidor) {
        $this->Bastidor = $bastidor;
    }
    public function getMarca_modelo(): string {
        return $this->Marca_modelo;
    }
    public function setMarca_modelo(string $marca_modelo) {
        $this->Marca_modelo = $marca_modelo;
    }
    public function getKm(): ?int {
        return $this->Km;
    }
    public function setKm(int $km) {
        $this->Km = $km;
    }
    public function getFecha_matricula(): ?string {
        return $this->Fecha_matricula;
    }
    public function setFecha_matricula(string $fecha_matricula) {
        $this->Fecha_matricula = $fecha_matricula;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function setObservaciones(string $observaciones) {
        $this->Observaciones = $observaciones;
    }
    public function getCombustible(): ?string {
        return $this->Combustible;
    }
    public function setCombustible(string $combustible) {
        $this->Combustible = $combustible;
    }
    public function getFecha_itv(): ?string {
        return $this->Fecha_itv;
    }
    public function setFecha_itv(string $fecha_itv) {
        $this->Fecha_itv = $fecha_itv;
    }
    public function getEstado(): ?string {
        return $this->Estado;
    }
    public function setEstado(string $estado) {
        $this->Estado = $estado;
    }
    public function getClase(): ?string {
        return $this->Clase;
    }
    public function setClase(string $clase) {
        $this->Clase = $clase;
    }
    public function getpropietario(): ?string {
        return $this->propietario;
    }
    public function setpropietario(string $propietario) {
        $this->propietario = $propietario;
    }
    public function getProx_itv(): ?string {
        return $this->Prox_itv;
    }
    public function setProx_itv(string $Prox_itv) {
        $this->propietario = $Prox_itv;
    }

    public static function fromArray(array $data): Vehiculo {
        $modelo = duplicar_tabla(CAMPOS_VEHICULO, $data);
        return new Vehiculo ($data['id_vehiculo'], $data['Matricula'], $data['Bastidor'], $data['Marca_modelo'], $data['Km'], $data['Fecha_matricula'], $data['Observaciones'], $data['Combustible'], 
                            $data['Fecha_itv'], $data['Estado'], $data['Clase'], $data['propietario'], $data['Prox_itv']); 
         
    }

}


