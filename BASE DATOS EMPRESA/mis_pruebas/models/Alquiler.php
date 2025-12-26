<?php
namespace models;
use models\Vehiculo;
use models\Entidad;
require_once "Funciones.php";

class Alquiler {
    
    function __construct (private ?int $id_alquiler, private ?string $contrato, private ?int $vehiculo, private ?int $cliente, private ?string $fechaInicio, private ?string $fechaFin, private ?int $kilometros,
    private ?int $kmInicio, private ?int $kmFin, private ?int $dias, private ?int $precio, private ?int $precioKm, private ?int $fianza, private ?int $fianzaDevuelta, private ?string $comercial, 
    private ?int $empresa, private ?string $ciudad, private ?string $entrega, private ?int $comisionComercial, private ?int $ganancia, private ?string $observaciones,  private ?string $estado, 
    private ?float $sumaPrecio, private ?float $sumaDias, private ?float $sumaKilometros, private ?float $sumaGanancia, private ?float $sumaComisionComercial,  private ?string $carpeta, private ?float $sumaCobros,  
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
    public function getsumaPrecio(): ?float {
        return $this->sumaPrecio;
    }
    public function getsumaDias(): ?float {
        return $this->sumaDias;
    }
    public function getsumaKilometros(): ?float {
        return $this->sumaKilometros;
    }
    public function getsumaGanancia(): ?float {
        return $this->sumaGanancia;
    }
    public function getsumaCobros(): ?float {
        return $this->sumaCobros;
    }
    public function getsumaComisionComercial(): ?float {
        return $this->sumaComisionComercial;
    }
    public function getcarpeta (): ?string {
        return $this->carpeta;
    }
    public static function fromArray(array $data): Alquiler {
        $vehiculo = null;
        $cliente = null;
        $empresa = null;
        //solo se crean objetos para meter dentro de alquiler si en el SELECT se lee algun campo que pertenece a una tabla relacionada con alquiler
        if (isset($data['Marca_modelo'])){
            $vehiculo = new Vehiculo ($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, 
                                    $data['Fecha_matricula']??null, $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null,
                                    $data['Clase']??null, $data['propietario']??null, $data['Prox_itv']??null);
        }
        if (isset($data['Nombre'])){
            $cliente = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['Nombre']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                    $data['Telefono']??null, $data['Email']??null);
        }
        if (isset($data['nombreEmpresa'])){
            $empresa = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreEmpresa']??null, $data['Observaciones']??null, $data['Direccion']??null,
                                    $data['Telefono']??null, $data['Email']??null);
        }
        return new Alquiler ($data['id_alquiler']??null, $data['contrato']??null, $data['vehiculo']??null, $data['cliente']??null, $data['fechaInicio']??null, $data['fechaFin']??null, 
                            $data['kilometros']??null, $data['kmInicio']??null, $data['kmFin']??null, $data['dias']??null, $data['precio']??null, $data['precioKm']??null, 
                            $data['fianza']??null, $data['fianzaDevuelta']??null, $data['comercial']??null, $data['empresa']??null, $data['ciudad']??null, $data['entrega']??null,
                            $data['comisionComercial']??null, $data['ganancia']??null, $data['observaciones']??null, $data['estado']??null,  $data['sumaPrecio']??null, 
                            $data['sumaDias']??null, $data['sumaKilometros']??null, $data['sumaGanancia']??null, $data['sumaComisionComercial']??null, $data['carpeta']??null, 
                            $data['sumaCobros']??null, $vehiculo, $cliente, $empresa); 
    }
}