<?php
namespace models;
use models\Entidad;
use models\Vehiculo;
require_once "Funciones.php";

class Movimiento {

    function __construct (private ?int $idMovimiento, private ?int $envia, private ?int $recibe, private ?string $fecha, private ?string $concepto, private ?int $vehiculo, 
                          private ?string $observaciones, private ?float $totalEntrega, private ?float $totalDevolucion, private ?float $diferencia,
                          private ?Entidad $enviaInfo=null, private ?Entidad $recibeInfo=null, private ?Vehiculo $vehiculoInfo=null){}
 
    public function getenviaInfo(): ?Entidad {
        return $this->enviaInfo;
    }
    public function getrecibeInfo():?Entidad {
        return $this->recibeInfo;
    } 
    public function getvehiculoInfo():?Vehiculo {
        return $this->vehiculoInfo;
    } 
    public function getidMovimiento():?int {
        return $this->idMovimiento;
    } 
    public function getenvia():?int {
        return $this->envia;
    } 
    public function getrecibe():?int {
        return $this->recibe;
    } 
    public function getfecha():?string {
        return $this->fecha;
    } 
    public function getconcepto():?string {
        return $this->concepto;
    } 
    public function getvehiculo():?int {
        return $this->vehiculo;
    } 
    public function getobservaciones():?string {
        return $this->observaciones;
    } 
     public function gettotalEntrega():?float {
        return $this->totalEntrega;
    }
    public function gettotalDevolucion():?float {
        return $this->totalDevolucion;
    }
    public function getdiferencia():?float {
        return $this->diferencia;
    }    
    public static function fromArray(array $data): Movimiento {
        $modelo_envia = duplicar_tabla (CAMPOS_ENTIDAD_ENVIA, $data);//para leer datos de la entidad que envia
        $modelo_recibe = duplicar_tabla(CAMPOS_ENTIDAD_RECIBE, $data);//para leer datos de la entidad que recibe
        $modelo_propietario = duplicar_tabla(CAMPOS_ENTIDAD_PROPIETARIO, $data);//para leer datos de la entidad que es propietaria del vehiculo
        $modelo_vehiculo = duplicar_tabla(CAMPOS_VEHICULO, $data);//para leer datos del vehiculo 
        $modelo = duplicar_tabla(CAMPOS_MOVIMIENTO, $data);
        //var_dump($data);
        $propietario = new Entidad($modelo_propietario['id_entidad'], $modelo_propietario['CIF_DNI'], $modelo_propietario['nombrePropietario'], $modelo_propietario['Observaciones'], $modelo_propietario['Direccion'], $modelo_propietario['Telefono'], $modelo_propietario['Email']);
        $envia = new Entidad ($modelo_envia['id_entidad'], $modelo_envia['CIF_DNI'], $modelo_envia['nombreEnvia'], $modelo_envia['Observaciones'], $modelo_envia['Direccion'], $modelo_envia['Telefono'], $modelo_envia['Email']);
        $recibe = new Entidad ($modelo_recibe['id_entidad'], $modelo_recibe['CIF_DNI'], $modelo_recibe['nombreRecibe'], $modelo_recibe['Observaciones'], $modelo_recibe['Direccion'], $modelo_recibe['Telefono'], $modelo_recibe['Email']);
        $vehiculo = new Vehiculo($modelo_vehiculo['id_vehiculo'], $modelo_vehiculo['Matricula'], $modelo_vehiculo['Bastidor'], $modelo_vehiculo['Marca_modelo'], $modelo_vehiculo['Km'], $modelo_vehiculo['Fecha_matricula'], $modelo_vehiculo['Observaciones'], $modelo_vehiculo['Combustible'], 
                            $modelo_vehiculo['Fecha_itv'], $modelo_vehiculo['Estado'], $modelo_vehiculo['Clase'], $modelo_vehiculo['propietario'], $modelo_vehiculo['Prox_itv'], $propietario);
        return new Movimiento ($modelo['idMovimiento'], $modelo['envia'], $modelo['recibe'], $modelo['fecha'], $modelo['concepto'], $modelo['vehiculo'], $modelo['observaciones'], 
                               $modelo['totalEntregas'], $modelo['totalDevoluciones'], $modelo['diferencia'], $envia, $recibe, $vehiculo); 
    }
}