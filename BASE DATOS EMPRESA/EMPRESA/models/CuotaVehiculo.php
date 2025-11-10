<?php
namespace models;
use models\Entidad;
require_once "Funciones.php";

class CuotaVehiculo {
    function __construct(private ?int $idCuota, private ?string $inicio, private ?int $duracion, private ?int $id_vehiculo, private ?string $tipo, private ?float $cuota, private ?float $totalPagar,
    private ?float $pagoFinal, private ?float $entrada, private ?float $fianza, private ?int $km, private ?int $kmAno, private ?string $financiera, private ?int $id_entidad, private ?string $observaciones,
    private ?Entidad $datos_propietario=null){}
        
    public function getdatos_propietario(): ?Entidad {
        return $this->datos_propietario;
    }
    public function getidCuota(): ?int {
        return $this->idCuota;
    }
    public function getinicio(): ?string {
        return $this->inicio;
    }
    public function getduracion(): ?int {
        return $this->duracion;
    }
    public function getid_vehiculo(): ?int {
        return $this->id_vehiculo;
    }
    public function gettipo(): ?string {
        return $this->tipo;
    }
    public function getcuota(): ?float {
        return $this->cuota;
    }
    public function gettotalPagar(): ?float {
        return $this->totalPagar;
    }
    public function getpagoFinal(): ?float {
        return $this->pagoFinal;
    }
    public function getentrada(): ?float {
        return $this->entrada;
    }
    public function getfianza(): ?float {
        return $this->fianza;
    }
    public function getkm(): ?int {
        return $this->km;
    }
    public function getkmAno(): ?int {
        return $this->kmAno;
    }
    public function getfinanciera(): ?string {
        return $this->financiera;
    }
    public function getid_entidad(): ?int {
        return $this->id_entidad;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public static function fromArray(array $data): CuotaVehiculo {
//solo se crean objetos para meter dentro de cuota si en el SELECT se lee algun campo que pertenece a una tabla diferente de cuota
        $propietario = null;
        if (isset($data['Nombre'])){
            $propietario = new Entidad ($data['id_entidad']??null, $data['CIF_DNI']??null, $data['Nombre']??null, $data['Observaciones']??null, 
            $data['Direccion']??null, $data['Telefono']??null, $data['Email']??null);
        }
        return new CuotaVehiculo ($data['idCuota']??null, $data['inicio']??null, $data['duracion']??null, $data['id_vehiculo']??null, $data['tipo']??null, $data['cuota']??null, 
                                    $data['totalPagar']??null, $data['pagoFinal']??null, $data['entrada']??null, $data['fianza']??null, $data['km']??null, $data['kmAno']??null, 
                                    $data['financiera']??null, $data['id_entidad']??null, $data['observaciones']??null, $propietario);  
    }

}
