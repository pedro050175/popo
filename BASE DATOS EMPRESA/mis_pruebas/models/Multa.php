<?php
namespace models;
use models\Vehiculo;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

require_once "Funciones.php";

class Multa {
    function __construct(private ?int $idMulta, private ?string $expediente, private ?string $fecha, private ?float $importe, private ?float $importePagado, 
                        private ?string $fechaPago, private ?string $pagaDesde, private ?bool $identificar, private ?string $fechaIdentificada,
                        private ?string $vencimiento, private ?int $vehiculo, private ?string $lugar, private ?float $importeCobrado, private ?string $conductor, 
                        private ?string $conductorIdentificada, private ?bool $terminada, private ?string $comentarios, private ?string $fechaNotificacion, private ?Vehiculo $vehiculoInfo = null){
    }
    public function getidMulta (): ?int {
        return $this->idMulta;
    }
    public function getexpediente (): ?string {
        return $this->expediente;
    }
    public function getfecha (): ?string {
        return $this->fecha;
    }
    public function getfechaNotificacion (): ?string {
        return $this->fechaNotificacion;
    }
    public function getimporte (): ?float {
        return $this->importe;
    }
    public function getimportePagado (): ?float {
        return $this->importePagado;
    }
    public function getfechaPago (): ?string {
        return $this->fechaPago;
    }
    public function getpagaDesde (): ?string {
        return $this->pagaDesde;
    }
    public function getidentificar (): ?bool {
        return $this->identificar;
    }
    public function getfechaIdentificada (): ?string {
        return $this->fechaIdentificada;
    }
    public function getvencimiento (): ?string {
        return $this->vencimiento;
    }
    public function getvehiculo (): ?int {
        return $this->vehiculo;
    }
    public function getlugar (): ?string {
        return $this->lugar;
    }
    public function getimporteCobrado (): ?float {
        return $this->importeCobrado;
    }
    public function getconductor (): ?string {
        return $this->conductor;
    }
    public function getconductorIdentificada (): ?string {
        return $this->conductorIdentificada;
    }
    public function getterminada (): ?bool {
        return $this->terminada;
    }
    public function getcomentarios (): ?string {
        return $this->comentarios;
    }
    public function getvehiculoInfo (): ?Vehiculo {
        return $this->vehiculoInfo;
    }
    /* devuelve true si la multa no esta terminada y esta proxima a vencimiento */
    public function caducada (): bool{
        return ((!$this->terminada && fechaProxHoy($this->vencimiento, 5)) ? true : false);
    /*si no esta terminada comprueba se la fecha de hoy esta proxima al vencimiento */
       /* if (!$this->terminada){   
           return fechaProxHoy($this->vencimiento, 5);
       }
       return false; */
    }
    public static function fromArray(array $data): Multa {
        $vehiculo = null;
        //solo se crean objetos para meter dentro de movimiento si en el SELECT se lee algun campo que pertenece a una tabla diferente de movimientos
        if (array_key_exists('Marca_modelo', $data)){//compruebo si existe el campo Marca_modelo porque en el SELECT no leo envia (vehiculo), solo leo Marca_modelo
            $vehiculo = new Vehiculo($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, 
                                $data['Fecha_matricula']??null, $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null, 
                                $data['Clase']??null, $data['propietario']??null, $data['Prox_itv']??null);
        }
        return new Multa ($data['idMulta']??null, $data['expediente']??null, $data['fecha']??null, $data['importe']??null, $data['importePagado']??null, 
                        $data['fechaPago']??null, $data['pagaDesde']??null, $data['identificar']??null, $data['fechaIdentificada']??null,
                        $data['vencimiento']??null, $data['vehiculo']??null, $data['lugar']??null, $data['importeCobrado']??null, $data['conductor']??null,
                        $data['conductorIdentificada']??null, $data['terminada']??null, $data['comentarios']??null, $data['fechaNotificacion']??null, $vehiculo); 
    }
}
?>