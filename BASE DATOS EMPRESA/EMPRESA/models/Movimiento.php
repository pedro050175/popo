<?php
namespace models;
use models\Entidad;
use models\Vehiculo;
require_once "Funciones.php";

class Movimiento {

    function __construct (private ?int $idMovimiento, private ?int $envia, private ?int $recibe, private ?string $fecha, private ?string $concepto, private ?int $vehiculo, private ?string $observaciones,
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
    public static function fromArray(array $data): Movimiento {
        $modelo_propietario = duplicar_tabla (CAMPOS_ENTIDAD, $data);
        $modelo = duplicar_tabla(CAMPOS_VEHICULO, $data);
        //var_dump($data);
        $propietario = new Entidad ($modelo_propietario['id_entidad'], $modelo_propietario['CIF_DNI'], $modelo_propietario['Nombre'], $modelo_propietario['Observaciones'], $modelo_propietario['Direccion'], $modelo_propietario['Telefono'], $modelo_propietario['Email']);
        return new Vehiculo ($modelo['id_vehiculo'], $modelo['Matricula'], $modelo['Bastidor'], $modelo['Marca_modelo'], $modelo['Km'], $modelo['Fecha_matricula'], $modelo['Observaciones'], $modelo['Combustible'], 
                            $modelo['Fecha_itv'], $modelo['Estado'], $modelo['Clase'], $modelo['propietario'], $modelo['Prox_itv'], $propietario); 
         
    }
}