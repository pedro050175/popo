<?php
namespace models;
use models\Vehiculo;
use models\Entidad;

require_once "Funciones.php";

class Compraventa {
    public function getvehiculoInfo(): ?Vehiculo {
        return $this->vehiculoInfo;
    }
    public function getcompraAInfo(): ?Entidad {
        return $this->compraAInfo;
    }
    public function getempresaInfo(): ?Entidad {
        return $this->empresaInfo;
    }
    public function getvendeAInfo(): ?Entidad {
        return $this->vendeAInfo;
    }
    public function getid_compraventa(): ?int{
        return $this->id_compraventa;
    }
    public function getfechaCompra(): ?string{
        return $this->fechaCompra;
    }
    public function getprecioCompraReal(): ?float{
        return $this->precioCompraReal;
    }
    public function getprecioCompraDeclarado(): ?float{
        return $this->precioCompraDeclarado;
    }
    public function getfechaFactComp(): ?string{
        return $this->fechaFactComp;
    }
    public function getnodeclaraComp(): ?int{
        return $this->nodeclaraComp;
    }
    public function getimpuestoCompra(): ?string{
        return $this->impuestoCompra;
    }
    public function getcompraA(): ?int{
        return $this->comprador;
    }
    public function getanuladaCompra(): ?int{
        return $this->anuladaCompra;
    }
    public function getvehiculo(): ?int{
        return $this->vehiculo;
    }
    public function getreserva(): ?int{
        return $this->reserva;
    }
    public function getcomercialVenta(): ?string{
        return $this->comercialVenta;
    }
    public function getfechaVenta(): ?string{
        return $this->fechaVenta;
    }
    public function getprecioVentaReal(): ?float{
        return $this->precioVentaReal;
    }
    public function getprecioVentaDeclarado(): ?float{
        return $this->precioVentaDeclarado;
    }
    public function getfechaFactVenta(): ?string{
        return $this->fechaFactVent;
    }
    public function getnodeclaraVenta(): ?int{
        return $this->nodeclaraVent;
    }
    public function getimpuestoVenta(): ?string{
        return $this->impuestoVenta;
    }
    public function getvendeA(): ?int{
        return $this->vendedor;
    }
    public function getanuladaVenta(): ?int{
        return $this->anuladaVenta;
    }
    public function getobservaciones(): ?string{
        return $this->observaciones;
    }
    public function gettrimestre(): ?int{
        return $this->trimestre;
    }
    public function getempresa(): ?int{
        return $this->empresa;
    }
    function __construct(private ?int $id_compraventa, private ?string $fechaCompra, private ?float $precioCompraReal, private ?float $precioCompraDeclarado, private ?string $fechaFactComp, private ?int $nodeclaraComp, 
                        private ?string $impuestoCompra, private ?int $comprador, private ?int $anuladaCompra, private ?int $vehiculo, private ?int $reserva, private ?string $comercialVenta, private ?string $fechaVenta, 
                        private ?float $precioVentaReal, private ?float $precioVentaDeclarado, private ?string $fechaFactVent, private ?int $nodeclaraVent, private ?string $impuestoVenta, private ?int $vendedor, 
                        private ?int $anuladaVenta, private ?string $observaciones, private ?int $trimestre, private ?int $empresa, private ?Vehiculo $vehiculoInfo = null, private ?Entidad $compraAInfo = null, 
                        private ?Entidad $vendeAInfo = null, private ?Entidad $empresaInfo = null) {
    }
    public static function fromArray(array $data): Compraventa {
        $vehiculo = null;
        $comprador = null;
        $vendedor = null;
        $empresa = null;
        //solo se crean objetos para meter dentro de alquiler si en el SELECT se lee algun campo que pertenece a una tabla relacionada con alquiler
        if (isset($data['Marca_modelo'])){
            $vehiculo = new Vehiculo ($data['id_vehiculo']??null, $data['Matricula']??null, $data['Bastidor']??null, $data['Marca_modelo']??null, $data['Km']??null, 
                                    $data['Fecha_matricula']??null, $data['Observaciones']??null, $data['Combustible']??null, $data['Fecha_itv']??null, $data['Estado']??null,
                                    $data['Clase']??null, $data['propietario']??null, $data['Prox_itv']??null);
        }
        if (isset($data['nombreComprador'])){
            $comprador = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreComprador']??null, $data['Observaciones']??null, $data['Direccion']??null, 
                                    $data['Telefono']??null, $data['Email']??null);
        }
        if (isset($data['nombreVendedor'])){
            $vendedor = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreVendedor']??null, $data['Observaciones']??null, $data['Direccion']??null,
                                    $data['Telefono']??null, $data['Email']??null);
        }
        if (isset($data['nombreEmpresa'])){
            $empresa = new Entidad($data['id_entidad']??null, $data['CIF_DNI']??null, $data['nombreEmpresa']??null, $data['Observaciones']??null, $data['Direccion']??null,
                                    $data['Telefono']??null, $data['Email']??null);
        }
        return new Compraventa ($data['id_compraventa']??null, $data['fechaCompra']??null, $data['precioCompraReal']??null, $data['precioCompraDeclarado']??null, $data['fechaFactComp']??null, $data['nodeclaraComp']??null, 
                            $data['impuestoCompra']??null, $data['compraA']??null, $data['anuladaCompra']??null, $data['vehiculo']??null, $data['reserva']??null, $data['comercialVenta']??null, 
                            $data['fechaVenta']??null, $data['precioVentaReal']??null, $data['precioVentaDeclarado']??null, $data['fechaFactVent']??null, $data['nodeclaraVent']??null, $data['impuestoVenta']??null,
                            $data['vendeA']??null, $data['anuladaVenta']??null, $data['observaciones']??null, $data['trimestre']??null, $data['empresa']??null, $vehiculo, $comprador, $vendedor, 
                            $empresa); 
    }
}
?>