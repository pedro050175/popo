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
    public function getsumaCobros(): ?float{
        return $this->sumaCobros;
    }
    public function getsumaPagos(): ?float{
        return $this->sumaPagos;
    }
    public function getsumaGastos(): ?float{
        return $this->sumaGastos;
    }
    public function getkmCompra(): ?int{
        return $this->kmCompra;
    }
    public function getkmVenta(): ?int{
        return $this->kmVenta;
    }
    public function getclausulasVenta(): ?string{
        return $this->clausulasVenta;
    }
    public function getformaPagoCompra(): ?string{
        return $this->formaPagoCompra;
    }
    public function getformaPagoVenta(): ?string{
        return $this->formaPagoVenta;
    }
    public function IVA(): ?float{/* el IVA se calcula con precio declarado */
		if ($this->precioVentaDeclarado > 0){ /* si hay venta */
			$diferencia = $this->precioVentaDeclarado - $this->precioCompraDeclarado;
			if ($this->impuestoCompra=='REBU' || $this->impuestoCompra=='IVA'){/* si es REBU o IVA es el iva de la diferencia */
				return ivaDeValorSinIVA($diferencia);
			} else if ($this->impuestoCompra == 'NETO' && $this->impuestoVenta == 'NETO') { //se compra neto y se vende neto es el iva de la diferencia
                        return ivaDeValorSinIVA($diferencia);
                    } else return ivaDeValorConIVA($this->precioVentaDeclarado);/* si compra neto y vende con IVA => iva del precio de venta */
		} else if ($this->impuestoCompra=='IVA'){ /* si no hay venta y se ha comprado con IVA es el iva de la compra con signo negativo porque me desgrabo*/
            return (ivaDeValorConIVA($this->precioCompraDeclarado*(-1)));
            } else return 0; /* si no hay venta y compra REBU o NETO IVA 0 (no desgraba) */
    }
    public function beneficio(): ?float{/* beneficio se calcula con precio Real */
        /* sino hay venta beneficio es cero */
        return ($this->precioVentaReal > 0 ? $this->precioVentaReal - $this->precioCompraReal - $this->sumaGastos : 0);
    }
    public function beneficioMenosIVA(): ?float{
        return ($this->beneficio()-$this->IVA());
    }
    function __construct(private ?int $id_compraventa, private ?string $fechaCompra, private ?float $precioCompraReal, private ?float $precioCompraDeclarado, private ?string $fechaFactComp, private ?int $nodeclaraComp, 
                        private ?string $impuestoCompra, private ?int $comprador, private ?int $anuladaCompra, private ?int $vehiculo, private ?int $reserva, private ?string $comercialVenta, private ?string $fechaVenta, 
                        private ?float $precioVentaReal, private ?float $precioVentaDeclarado, private ?string $fechaFactVent, private ?int $nodeclaraVent, private ?string $impuestoVenta, private ?int $vendedor, 
                        private ?int $anuladaVenta, private ?string $observaciones, private ?int $trimestre, private ?int $empresa, private ?float $sumaCobros, private ?float $sumaPagos, private ?float $sumaGastos,
                        private ?int $kmCompra, private ?int $kmVenta, private ?string $clausulasVenta, private ?string $formaPagoCompra, private ?string $formaPagoVenta,
                        private ?Vehiculo $vehiculoInfo = null, private ?Entidad $compraAInfo = null, private ?Entidad $vendeAInfo = null, private ?Entidad $empresaInfo = null) {
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
        if (isset($data['nombreCompra'])){
            $comprador = new Entidad($data['id_entidad']??null, $data['CIF_DNICompra']??null, $data['nombreCompra']??null, $data['ObservacionesCompra']??null, $data['DireccionCompra']??null, 
                                    $data['Telefono']??null, $data['Email']??null);
        }
        /* OJO con array_key_exists, en cuanto exista el campo nombreVendedor en la consulta se crea el objeto entidad, da igual que el valor en la BBDD sea null, 
        si $data[nombreVendedor]=null se crea la entidad con lo que en la pagina HTML no necesito poner el ? en $compraventa->getcompraAInfo()?->getNombre() por si
        getcompraAInfo() es null, nunca lo sera si en el SELECT esta el campo nombreVendedor. De esta forma siempre crea objetos enteros de entidades con todas las lineas leidas en el SELECT
        aunque las compraventas no tengan un un comprador o vendedor
        Totalmente diferente es si pongo isset($data[nombreVendedor]), evalua si existe y no es null, de esta forma si el valor de $data[nombreVendedor] es null no creara el objeto entidad
        pero entonces $compraventa->getcompraAInfo() sera null para los movimientos que no tienen coche, y si que hay que poner el ? $compraventa->getcompraAInfo()?->getNombre()
        En resumen es mas eficiente poner isset pero obliga a poner el ? en la pagina HTML.
        Claro esta que solo ocurre en campos que no son required en la pagina*/
        if (array_key_exists('nombreVende', $data)){
            $vendedor = new Entidad($data['id_entidad']??null, $data['CIF_DNIVende']??null, $data['nombreVende']??null, $data['ObservacionesVende']??null, $data['DireccionVende']??null,
                                    $data['Telefono']??null, $data['Email']??null);
        }
        if (isset($data['nombreEmpresa'])){
            $empresa = new Entidad($data['id_entidad']??null, $data['CIF_DNIEmpresa']??null, $data['nombreEmpresa']??null, $data['ObservacionesEmpresa']??null, $data['DireccionEmpresa']??null,
                                    $data['Telefono']??null, $data['Email']??null);
        }
        return new Compraventa ($data['id_compraventa']??null, $data['fechaCompra']??null, $data['precioCompraReal']??null, $data['precioCompraDeclarado']??null, $data['fechaFactComp']??null, $data['nodeclaraComp']??null, 
                            $data['impuestoCompra']??null, $data['compraA']??null, $data['anuladaCompra']??null, $data['vehiculo']??null, $data['reserva']??null, $data['comercialVenta']??null, 
                            $data['fechaVenta']??null, $data['precioVentaReal']??null, $data['precioVentaDeclarado']??null, $data['fechaFactVent']??null, $data['nodeclaraVent']??null, $data['impuestoVenta']??null,
                            $data['vendeA']??null, $data['anuladaVenta']??null, $data['observaciones']??null, $data['trimestre']??null, $data['empresa']??null, $data['sumaCobros']??null, $data['sumaPagos']??null,
                            $data['sumaGastos']??0, $data['kmCompra']??0, $data['kmVenta']??0, $data['clausulasVenta']??'', $data['formaPagoCompra']??'', $data['formaPagoVenta']??'', $vehiculo, $comprador, $vendedor, $empresa); 
    }
}
?>