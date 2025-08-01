<?php
namespace models;
use models\Vehiculo;
use lib\duplicar_tabla;
require_once "Funciones.php";

class Alquiler {
    
    function __construct (private int $id_alquiler, private string $Contrato, private int $id_vehiculo, private int $Cliente, private string $Fecha_inicio, private ?string $Fecha_fin, private ?int $Kilometros,
    private ?int $Km_inicio, private ?int $Km_fin, private ?string $Dias, private ?int $Precio, private ?int $Precio_km, private ?int $id_comercial, private ?int $Empresa, private ?string $Ciudad, 
    private ?string $Entrega, private ?int $Comision_comercial, private ?int $Ganancia, private ?string $Observaciones, private ?Vehiculo $vehiculo = null){}

    public function getVehiculo(): ?Vehiculo {
        return $this->vehiculo;
    }
    public function setVehiculo(Vehiculo $vehiculo) {
        $this->vehiculo = $vehiculo;
    }
    public function getId(): int {
        return $this->id_alquiler;
    }
    public function setId(int $id) {
        $this->id_alquiler = $id;
    }
    public function getContrato(): string {
        return $this->Contrato;
    }
    public function setContrato(string $contrato){
        $this->Contrato = $contrato;
    }
    public function getid_vehiculo(): int {
        return $this->id_vehiculo;
    }
    public function setid_vehiculo(int $vehiculo) {
        $this->id_vehiculo = $vehiculo;
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
    public function setKilometros(?int $km){
        $this->Kilometros = $km;
    }
    public function getKm(): ?int {
        return $this->Kilometros;
    }
    public function setKm_inicio (?int $km_inicio) {
        $this->Km_inicio = $km_inicio;
    }
    public function getKm_inicio (): ?int {
        return $this->Km_inicio;
    }
    public function setKm_fin (?int $km_fin){
        $this->Km_fin = $km_fin;
    }
    public function getKm_fin (): ?int {
        return $this->Km_fin;
    }
    public function setDias (?int $dias) {
        $this->Dias = $dias;
    }
    public function getDias (): ?int {
        return $this->Dias;
    }
    public function setPrecio (?int $precio) {
        $this->Precio = $precio;
    }
    public function getPrecio (): ?int {
        return $this->Precio;
    } 
    public function setPrecio_km (?int $precio) {
        $this->Precio_km = $precio;
    }
    public function getPrecio_km (): ?int {
        return $this->Precio_km;
    }
    public function setComercial (?int $comercial) {
        $this->id_comercial = $comercial;
    }
    public function getComercial (): ?int {
        return $this->id_comercial;
    }
    public function setEmpresa (?int $empresa) {
        $this->Empresa = $empresa;
    }
    public function getEmpresa (): ?int {
        return $this->Empresa;
    }
    public function setCiudad (?string $ciudad) {
        $this->Ciudad = $ciudad;
    }
    public function getCiudad (): ?string {
        return $this->Ciudad;
    }
    public function setEntrega (?string $entrega) {
        $this->Entrega = $entrega;
    }
    public function getEntrega (): ?string {
        return $this->Entrega;
    }
    public function setComision_comercial (?int $comision) {
        $this->Comision_comercial = $comision;
    }
    public function getComision_comercial (): ?int {
        return $this->Comision_comercial;
    }
    public function setGanancia (?int $ganancia) {
        $this->Ganancia = $ganancia;
    }
    public function getGanancia(): ?int {
        return $this->Ganancia;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function setObservaciones(?string $Observaciones) {
        $this->Observaciones = $Observaciones;
    }
    public static function fromArray(array $data): Alquiler {
        $modelo = duplicar_tabla (CAMPOS_ALQUILER, $data);
        $modelo_vehiculo = duplicar_tabla (CAMPOS_VEHICULO, $data);
        $vehiculo = new Vehiculo ($modelo_vehiculo['id_vehiculo'], $modelo_vehiculo['Matricula'], $modelo_vehiculo['Bastidor'], $modelo_vehiculo['Marca_modelo'], $modelo_vehiculo['Km'], 
              $modelo_vehiculo['Fecha_matricula'], $modelo_vehiculo['Observaciones'], $modelo_vehiculo['Combustible'], $modelo_vehiculo['Fecha_itv'], $modelo_vehiculo['Estado'],
              $modelo_vehiculo['Clase'], $modelo_vehiculo['propietario'], $modelo_vehiculo['Prox_itv']);
        return new Alquiler ($modelo['id_alquiler'], $modelo['Contrato'], $modelo['id_vehiculo'], $modelo['Cliente'], $modelo['Fecha_inicio'], $modelo['Fecha_fin'], $modelo['Kilometros'],
        $modelo['Km_inicio'], $modelo['Km_fin'], $modelo['Dias'], $modelo['Precio'], $modelo['Precio_km'], $modelo['id_comercial'], $modelo['Empresa'],
        $modelo['Ciudad'], $modelo['Entrega'], $modelo['Comision_comercial'], $modelo['Ganancia'], $modelo['Observaciones'], $vehiculo); 
       
        /* $vehiculo = new Vehiculo ($data['id_vehiculo'], $data['Matricula'], $data['Bastidor'], $data['Marca_modelo'], $data['Km'], $data['Fecha_matricula'], $data['Observaciones'], $data['Combustible'], 
                            $data['Fecha_itv'], $data['Estado'], $data['Clase'], $data['propietario']); */
        /* return new Alquiler ($data['id_alquiler'], $data['Contrato'], $data['id_vehiculo'], $data['Cliente'], $data['Fecha_inicio'], $data['Fecha_fin'], $data['Kilometros'],
        $data['Km_inicio'], $data['Km_fin'], $data['Dias'], $data['Precio'], $data['Precio_km'], $data['id_comercial'], $data['Empresa'],
        $data['Ciudad'], $data['Entrega'], $data['Comision_comercial'], $data['Ganancia'], $data['Observaciones'], $vehiculo); */  
    }
}