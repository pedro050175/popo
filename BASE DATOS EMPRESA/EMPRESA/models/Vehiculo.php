<?php
namespace models;
use models\Entidad;
require_once "Funciones.php";

class Vehiculo {

    function __construct (private ?int $id_vehiculo, private ?string $Matricula, private ?string $Bastidor, private ?string $Marca_modelo, private ?int $Km, private ?string $Fecha_matricula, 
                            private ?string $Observaciones, private ?string $Combustible, private ?string $Fecha_itv, private ?string $Estado, private ?string $Clase, private ?int $propietario,
                            private ?string $Prox_itv, private ?Entidad $datos_propietario=null){}
 
    public function getdatos_propietario(): ?Entidad {
        return $this->datos_propietario;
    }
    public function getpropietario(): ?int {
        return $this->propietario;
    }
    public function getId(): ?int {
        return $this->id_vehiculo;
    }
    public function getMatricula(): ?string {
        return $this->Matricula;
    }
    public function getBastidor(): ?string {
        return $this->Bastidor;
    }
    public function getMarca_modelo(): ?string {
        return $this->Marca_modelo;
    }
    public function getKm(): ?int {
        return $this->Km;
    }
    public function getFecha_matricula(): ?string {
        return $this->Fecha_matricula;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function getCombustible(): ?string {
        return $this->Combustible;
    }
    public function getFecha_itv(): ?string {
        return $this->Fecha_itv;
    }
    public function getEstado(): ?string {
        return $this->Estado;
    }
    public function getClase(): ?string {
        return $this->Clase;
    }
    public function getProx_itv(): ?string {
        return $this->Prox_itv;
    }
    public static function fromArray(array $data): Vehiculo {//de esta forma aunque se siguen manejando obejtos, pero los campos que no se usan van a null y antes iban con '' ó con 0 
        $propietario = null;//si el vehiculo no tiene propietario (en tabla mysql =null) $data['propietario'] existe porque se lee en el SELECT pero el valor es NULL y en el if no 
        //entra (isset(null)) con lo que $propietario=NULL, y crea el objeto vehiculo con el objeto propietario = null, luego en la pagina listado vehiculos cuando hace 
        //$vehiculo->getdatos_propietario()->getNombre(), $vehiculo->getdatos_propietario() es null con lo que null->getNombre() da error, asi que si $data['propietario'] es nulo 
        //tambien tengo que crear el objeto propietario //isset($data['propietario']) || ($data['propietario'] == null) en realidad es equivalente a "si existe la clave 'propietario' 
        //en $data", sin importar si es NULL o no. **ver en el listado vehiculos linea 49 don de se escribe el nombre del propietario del vehiculo
        //solo se crean objetos para meter dentro de movimiento si en el SELECT se lee algun campo que pertenece a una tabla diferente de movimientos
        if (array_key_exists('Nombre', $data)){//compuebo Nombre (entidad) porque es lo que realmente necesito para crear el objeto entidad, ya que ese campo pertenece a la tabla entidad,si en el SELECT leyera propietario nada mas, (campo de la tabla vehiculos) no seria necesario crear obj entidad
        //si en la consulta mysql va el campo propietario(es el id de una entidad) es porque voy a necesitar algun campo de la tabla entidades, pe. el nombre propietario 
            $propietario = new Entidad ($data['id_entidad']??null, $data['CIF_DNI']??null, $data['Nombre']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                        $data['Telefono']??null, $data['Email']??null); 
        }
        return new Vehiculo ($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, $data['Fecha_matricula']??null,
                             $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null, $data['Clase']??null, $data['propietario']??null,
                              $data['Prox_itv']??null, $propietario);    
    }
}


