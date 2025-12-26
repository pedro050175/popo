<?php   
namespace models;
use models\Vehiculo;
use models\Entidad;
require_once "Funciones.php";

class Seguro {
    function __construct(private ?int $idSeguro, private ?string $poliza, private ?int $vehiculo, private ?string $otroRiesgo, private ?float $importe, private ?string $fecha, private ?string $vencimiento, 
                            private ?string $periodo, private ?string $tomador, private ?string $cuentaBanco, private ?string $compania, private ?string $mediador, private ?string $fechaBaja, 
                            private ?string $motivoBaja, private ?int $baja, private ?string $comentarios, private ?string $ultimoCambio, private ?Vehiculo $vehiculoInfo = null, private ?Entidad $tomadorInfo = null){}    
    public function getvehiculoInfo(): ?Vehiculo {
        return $this->vehiculoInfo;
    }
    public function gettomadorInfo(): ?Entidad {
        return $this->tomadorInfo;
    }
    public function getidSeguro(): ?int {
        return $this->idSeguro;
    }
    public function getpoliza(): ?string {
        return $this->poliza;
    }
    public function getvehiculo(): ?int {
        return $this->vehiculo;
    }
    public function getotroRiesgo(): ?string {
        return $this->otroRiesgo;
    }
    public function getimporte(): ?float {
        return $this->importe;
    }
    public function getfecha(): ?string {
        return $this->fecha;
    }
    public function getvencimiento(): ?string {
        return $this->vencimiento;
    }
    public function getperiodo(): ?string {
        return $this->periodo;
    }
    public function gettomador(): ?string {
        return $this->tomador;
    }
    public function getcuentaBanco(): ?string {
        return $this->cuentaBanco;
    }
    public function getcompania(): ?string {
        return $this->compania;
    }
    public function getmediador(): ?string {
        return $this->mediador;
    }
    public function getfechaBaja(): ?string {
        return $this->fechaBaja;
    }
    public function getmotivoBaja(): ?string {
        return $this->motivoBaja;
    }
    public function getbaja(): ?int {
        return $this->baja;
    }
    public function getcomentarios(): ?string {
        return $this->comentarios;
    }
    public function getultimoCambio(): ?string {
        return $this->ultimoCambio;
    }
    public static function fromArray (array $data): Seguro{
        $vehiculo = null;
        $entidad = null;
        //solo se crean objetos para meter dentro de alquiler si en el SELECT se lee algun campo que pertenece a una tabla relacionada con alquiler
        if (isset($data['Marca_modelo'])){
            $vehiculo = new Vehiculo ($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, 
                                    $data['Fecha_matricula']??null, $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null,
                                    $data['Clase']??null, $data['propietario']??null, $data['Prox_itv']??null);
        }
        if (isset($data['Nombre'])){
            $entidad = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['Nombre']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                    $data['Telefono']??null, $data['Email']??null);
        }
        return new Seguro ($data['idSeguro']??null, $data['poliza']??null, $data['vehiculo']??null, $data['otroRiesgo']??null, $data['importe']??null, $data['fecha']??null, $data['vencimiento']??null, $data['periodo']??null, 
                            $data['tomador']??null, $data['cuentaBanco']??null, $data['compania']??null, $data['mediador']??null, $data['fechaBaja']??null, $data['motivoBaja']??null, $data['baja']??null, 
                            $data['comentarios']??null, $data['ultimoCambio']??null, $vehiculo, $entidad);
    }
}
?>