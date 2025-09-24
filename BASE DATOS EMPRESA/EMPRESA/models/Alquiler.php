<?php
namespace models;
use models\Vehiculo;
use models\Entidad;
require_once "Funciones.php";

class Alquiler {
    
    function __construct (private ?int $id_alquiler, private ?string $contrato, private ?int $vehiculo, private ?int $cliente, private ?string $fechaInicio, private ?string $fechaFin, private ?int $kilometros,
    private ?int $kmInicio, private ?int $kmFin, private ?string $dias, private ?int $precio, private ?int $precioKm, private ?int $fianza, private ?int $fianzaDevuelta, private ?string $comercial, 
    private ?int $empresa, private ?string $ciudad, private ?string $entrega, private ?int $comisionComercial, private ?int $ganancia, private ?string $observaciones,  private ?string $estado, 
    private ?Vehiculo $vehiculoInfo = null, private ?Entidad $clienteInfo =null, private ?Entidad $empresaInfo = null){}

    public function getvehiculoInfo(): ?Vehiculo {
        return $this->vehiculoInfo;
    }
    public function getclienteInfo(): ?Entidad {
        return $this->clienteInfo;
    }
    public function getempresaInfo(): ?Entidad {
        return $this->empresaInfo;
    }
    public function getid(): ?int {
        return $this->id_alquiler;
    }
    public function getcontrato(): ?string {
        return $this->contrato;
    }
    public function getvehiculo(): ?int {
        return $this->vehiculo;
    }
    public function getcliente(): ?int {
        return $this->cliente;
    }
    public function getfechaInicio(): ?string {
        return $this->fechaInicio;
    }
    public function getfechaFin(): ?string {
        return $this->fechaFin;
    }
    public function getkilometros(): ?int {
        return $this->kilometros;
    }
    public function getkmInicio (): ?int {
        return $this->kmInicio;
    }
    public function getkmFin (): ?int {
        return $this->kmFin;
    }
    public function getdias (): ?int {
        return $this->dias;
    }
    public function getprecio (): ?int {
        return $this->precio;
    } 
    public function getprecioKm (): ?int {
        return $this->precioKm;
    }
    public function getfianza (): ?int {
        return $this->fianza;
    }
    public function getfianzaDevuelta (): ?int {
        return $this->fianzaDevuelta;
    }
    public function getcomercial (): ?string {
        return $this->comercial;
    }
    public function getempresa (): ?int {
        return $this->empresa;
    }
    public function getciudad (): ?string {
        return $this->ciudad;
    }
    public function getentrega (): ?string {
        return $this->entrega;
    }
    public function getcomisionComercial (): ?int {
        return $this->comisionComercial;
    }
    public function getganancia(): ?int {
        return $this->ganancia;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public function getestado(): ?string {
        return $this->estado;
    }
    public static function fromArray(array $data): Alquiler {
        $modelo = duplicar_tabla (CAMPOS_ALQUILER, $data);
        $modelo_vehiculo = duplicar_tabla (CAMPOS_VEHICULO, $data);
        $modelo_cliente = duplicar_tabla (CAMPOS_ENTIDAD, $data);
        $modelo_empresa = duplicar_tabla (CAMPOS_EMPRESA_ALQUILER, $data);
        $vehiculo = new Vehiculo ($modelo_vehiculo['id_vehiculo'], $modelo_vehiculo['Matricula'], $modelo_vehiculo['Bastidor'], $modelo_vehiculo['Marca_modelo'], $modelo_vehiculo['Km'], 
              $modelo_vehiculo['Fecha_matricula'], $modelo_vehiculo['Observaciones'], $modelo_vehiculo['Combustible'], $modelo_vehiculo['Fecha_itv'], $modelo_vehiculo['Estado'],
              $modelo_vehiculo['Clase'], $modelo_vehiculo['propietario'], $modelo_vehiculo['Prox_itv']);
        $cliente = new Entidad($modelo_cliente['id_entidad'], $modelo_cliente['CIF_DNI'], $modelo_cliente['Nombre'], $modelo_cliente['Observaciones'], $modelo_cliente['Direccion'], $modelo_cliente['Telefono'], $modelo_cliente['Email']);
        $empresa = new Entidad($modelo_empresa['id_entidad'], $modelo_empresa['CIF_DNI'], $modelo_empresa['nombreEmpresa'], $modelo_empresa['Observaciones'], $modelo_empresa['Direccion'], $modelo_empresa['Telefono'], $modelo_empresa['Email']);
        return new Alquiler ($modelo['id_alquiler'], $modelo['contrato'], $modelo['vehiculo'], $modelo['cliente'], $modelo['fechaInicio'], $modelo['fechaFin'], $modelo['kilometros'],
        $modelo['kmInicio'], $modelo['kmFin'], $modelo['dias'], $modelo['precio'], $modelo['precioKm'], $modelo['fianza'], $modelo['fianzaDevuelta'], $modelo['comercial'], $modelo['empresa'],
        $modelo['ciudad'], $modelo['entrega'], $modelo['comisionComercial'], $modelo['ganancia'], $modelo['observaciones'], $modelo['estado'], $vehiculo, $cliente, $empresa); 
    }
}