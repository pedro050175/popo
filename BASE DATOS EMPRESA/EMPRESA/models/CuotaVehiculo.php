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
        $modelo_propietario = duplicar_tabla (CAMPOS_ENTIDAD, $data);
        $modelo = duplicar_tabla(CAMPOS_CUOTA_VEHICULO, $data);

        $propietario = new Entidad ($modelo_propietario['id_entidad'], $modelo_propietario['CIF_DNI'], $modelo_propietario['Nombre'], $modelo_propietario['Observaciones'], 
                                    $modelo_propietario['Direccion'], $modelo_propietario['Telefono'], $modelo_propietario['Email']);
        return new CuotaVehiculo ($modelo['idCuota'], $modelo['inicio'], $modelo['duracion'], $modelo['id_vehiculo'], $modelo['tipo'], $modelo['cuota'], $modelo['totalPagar'], $modelo['pagoFinal'], 
                          $modelo['entrada'], $modelo['fianza'], $modelo['km'], $modelo['kmAno'], $modelo['financiera'], $modelo['id_entidad'], $modelo['observaciones'], $propietario);  
    }

}
