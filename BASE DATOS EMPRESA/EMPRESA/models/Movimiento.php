<?php
namespace models;
use models\Entidad;
use models\Vehiculo;
require_once "Funciones.php";

class Movimiento {

    function __construct (private ?int $idMovimiento, private ?int $envia, private ?int $recibe, private ?string $fecha, private ?string $concepto, private ?int $vehiculo, 
                          private ?string $observaciones, private ?float $totalEntrega, private ?float $totalDevolucion, private ?float $diferencia, private ?int $terminado,
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
    public function getterminado():?int {
        return $this->terminado;
    }    
    public static function fromArray(array $data): Movimiento {
        
        $envia = null;
        $recibe = null;
        $vehiculo = null;
        //solo se crean objetos para meter dentro de movimiento si en el SELECT se lee algun campo que pertenece a una tabla diferente de movimientos
        if (array_key_exists('nombreEnvia', $data)){//compruebo si existe el campo nombreEnvia porque en el SELECT no leo envia (id de envia), solo leo nombreEnvia
            $envia = new Entidad ($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreEnvia']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                $data['Telefono']??null, $data['Email']??null);
        }
        if (array_key_exists('nombreRecibe', $data)){//compruebo si existe el campo nombreRecibe porque en el SELECT no leo envia (id de recibe), solo leo nombreRecibe
            $recibe = new Entidad ($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreRecibe']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                $data['Telefono']??null, $data['Email']??null);
        }
        /* OJO con array_key_exists, en cuanto exista el campo Marca_modelo en la consulta se crea el objeto vehiculo, da igual que el valor en la BBDD sea null, 
        si $data[Marca_modelo]=null se crea el vehiculo con lo que en la pagina HTML no necesito poner el ? en $movimiento->getvehiculoInfo()?->getMarca_modelo() por si
        getvehiculoInfo es null, nunca lo sera si en el SELECT esta el campo MArca_modelo. De esta forma siempre crea objetos enteros de vehiculo con todas las lineas leidas en el SELECT
        aunque los movimeintos no tengan un coche
        Totalmente diferente es si pongo isset($data[Marca_modelo]), evalua si existe y no es null, de esta forma si el valor de $data[Marca_modelo] es null no creara el objeto vehiculo
        pero entonces $movimiento->getvehiculoInfo() sera null para los movimientos que no tienen coche, y si que hay que poner el ? $movimiento->getvehiculoInfo()?->getMarca_modelo().
        En resumen es mas eficiente poner isset pero obliga a poner el ? en la pagina HTML.
        Claro esta que solo ocurre en campos que no son required en la pagina, en campos required siempre va a existir y siempres se crea la entidad*/
        if (array_key_exists('Marca_modelo', $data)){//compruebo si existe el campo Marca_modelo porque en el SELECT no leo envia (vehiculo), solo leo Marca_modelo
            $propietario = null;
            if (array_key_exists('nombrePropietario', $data)){//si existe el propietario creo una entidad para el vehiculo
                $propietario = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombrePropietario']??null, $data['Observaciones']??null, $data['Direccion']??null,
                                 $data['Telefono']??null, $data['Email']??null);
            }

            $vehiculo = new Vehiculo($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, 
                                $data['Fecha_matricula']??null, $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null, 
                                $data['Clase']??null, $data['propietario']??null, $data['Prox_itv']??null, $propietario);
        }
        return new Movimiento ($data['idMovimiento']??null, $data['envia']??null, $data['recibe']??null, $data['fecha']??null, $data['concepto']??null, 
                                $data['vehiculo']??null, $data['observaciones']??null, $data['totalEntregas']??null, $data['totalDevoluciones']??null,
                                $data['diferencia']??null, $data['terminado']??null, $envia, $recibe, $vehiculo); 
    }
}