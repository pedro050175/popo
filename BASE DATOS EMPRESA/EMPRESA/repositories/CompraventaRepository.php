<?php

namespace repositories;
use lib\BaseDatosPDO;
use models\Compraventa;


class CompraventaRepository{
    
    private BaseDatosPDO $conexionPDO;
    private int $numPaginas;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
        $this->numPaginas = 1;
    }
    public function setnumpaginas(int $paginas){
        $this->numPaginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->numPaginas;
    }

    public function findAll(): ?array {
        /* se pagina con los campos de busqueda tamb */
        $desplazamiento = 0;
        $this->numPaginas = numeroPaginas("SELECT COUNT(*) as num_filas FROM compraventas");
        $num_pagina = $_GET['num_pagina'] ?? 1;
        if (($num_pagina) <= $this->numPaginas) {
            $numPagina = intval($num_pagina);
            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
        }
        /*si no se envia formulario con submit los campos no existen, y se se envia los campos vacios vienen con ''*/
        $empresa = $_GET['empresa'] ?? ''; //si no existe se carga con '' 
        $coche = $_GET['coche'] ?? '';
        $compraA = $_GET['compraA'] ?? '';
        $vendeA = $_GET['vendeA'] ?? '';
        $trimestre = $_GET['trimestre'] ?? 0;
    
        $compraDesde = $_GET['compraDesde'] ?? '';
        $compraHasta = $_GET['compraHasta'] ?? '';

        $vendeDesde = $_GET['vendeDesde'] ?? '';
        $vendeHasta = $_GET['vendeHasta'] ?? '';

        $compraDesde = $compraDesde != '' ? $compraDesde : '1900-01-01'; // si no escribe en la fecha de inicio tomo la fecha 1900-01-01 como inicial
        $compraHasta = $compraHasta != '' ? $compraHasta : date("Y-m-d");
        
        $vendeDesde = $vendeDesde != '' ? $vendeDesde : '1900-01-01'; 
        $vendeHasta = $vendeHasta != '' ? $vendeHasta : date("Y-m-d");
        $this->conexionPDO->consulta("SELECT CV.*, C.Nombre AS nombreComprador, V.Nombre AS nombreVendedor, 
                                                E.Nombre AS nombreEmpresa, VV.Marca_modelo, VV.Matricula, VV.Bastidor 
                                        FROM compraventas CV
                                        LEFT JOIN entidad C ON CV.compraA = C.id_entidad 
                                        LEFT JOIN entidad V ON CV.vendeA = V.id_entidad 
                                        LEFT JOIN entidad E ON CV.empresa = E.id_entidad 
                                        LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo 
            WHERE E.Nombre LIKE '%$empresa%' AND (VV.Marca_modelo LIKE '%$coche%' OR VV.Matricula LIKE '%$coche%'
                    OR VV.Bastidor LIKE '%$coche%') AND C.Nombre LIKE '%$compraA%' AND V.Nombre LIKE '%$vendeA%'
                    AND CV.fechaCompra BETWEEN '$compraDesde' AND '$compraHasta'
                    AND CV.fechaVenta BETWEEN '$vendeDesde' AND '$vendeHasta'
                    AND CV.trimestre >= '$trimestre' 
                                        LIMIT $desplazamiento, ".FILAS_PAGINA); 
    /* CV.trimestre >= '$trimestre' esto es una filigrana, una casilla de verificacion CV sera 1 si esta marcada y sino lo esta aqui no llega nada
    pero yo le asigono 0, si la incluyo en el SELECT de esta forma CV.trimestre=$trimestre o veo los trimestre=1 o =0 pero no ambos, 
    no es como un campo text que si esta vacio '' compara con %''% que equivale a verlos todos como el * en msdos. 
    Lo soluciono con >= que si no marco la CV tendra valor 0 y en el SELECT cojo los mayores o iguales que 0, es decir
    todos, y si marco la CV solo se veran los que tiene valor 1*/                          
        return $this->extraer_todos();
    }
    public function extraer_registro(): ?Compraventa {
        return ($compraventa = $this->conexionPDO->extraer_registro()) ? Compraventa::fromArray($compraventa):null;
    }
    public function extraer_todos(): ?array {
        $compraventas = [];
        $compraventaData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($compraventaData as $data){
            $compraventas[] = Compraventa::fromArray($data);
        }
        return $compraventas;
    }
    public function save (array $compraventa): string {
        if (isset($compraventa['id_compraventa'])) {
            $this->update($compraventa);
            return $compraventa['id_compraventa']; //devuelvo el id del movimiento para regresar a la pagina con el movimiento que se acaba de actualizar
        } else { return $this->create($compraventa);} //devuelvo el id del moim creado para regresar a la pagina con el movimiento que se acaba de actualizar
    }
    public function create (array $data):string{
        
        $parametros = [
            ':fechaCompra'=> $data['fechaCompra'],
            ':precioCompraReal' => $data['precioCompraReal'],
            ':precioCompraDeclarado' => $data['precioCompraDeclarado'],
            ':fechaFactComp' => $data['fechaFactComp'],
            ':nodeclaraComp' => (isset($data['nodeclaraComp'])) ? 1 : 0,
            ':impuestoCompra' => $data['impuestoCompra'],
            ':compraA' => $data['compraA'] ?? '',
            ':anuladaCompra' => (isset($data['anuladaCompra'])) ? 1 : 0,
            ':vehiculo' => $data['vehiculo'],
            ':reserva' => (isset($data['reserva'])) ? 1 : 0,
            ':comercialVenta' => $data['comercialVenta'],
            ':fechaVenta'=> $data['fechaVenta'],
            ':precioVentaReal' => $data['precioVentaReal'],
            ':precioVentaDeclarado' => $data['precioVentaDeclarado'],
            ':fechaFactVent' => $data['fechaFactVent'],
            ':nodeclaraVent' => (isset($data['nodeclaraVent'])) ? 1 : 0,
            ':impuestoVenta' => $data['impuestoVenta'],
            ':vendeA' => $data['vendeA'] ?? '',
            ':anuladaVenta' => (isset($data['anuladaVenta'])) ? 1 : 0,
            ':observaciones' => $data['observaciones'],
            ':trimestre' => (isset($data['trimestre'])) ? 1 : 0,
            ':empresa' => $data['empresa']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO compraventas (fechaCompra, precioCompraReal, precioCompraDeclarado, fechaFactComp, nodeclaraComp, impuestoCompra, compraA, anuladaCompra, vehiculo, reserva, 
                                            comercialVenta, fechaVenta, precioVentaReal, precioVentaDeclarado, fechaFactVent, nodeclaraVent, impuestoVenta, vendeA, anuladaVenta, observaciones, trimestre, empresa) VALUES 
                                         (:fechaCompra, :precioCompraReal, :precioCompraDeclarado, :fechaFactComp, :nodeclaraComp, :impuestoCompra, :compraA, :anuladaCompra, :vehiculo, :reserva, 
                                            :comercialVenta, :fechaVenta, :precioVentaReal, :precioVentaDeclarado, :fechaFactVent, :nodeclaraVent, :impuestoVenta, :vendeA, :anuladaVenta, :observaciones, :trimestre, :empresa)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al movimiento creado
    }
    public function update (array $data): void{ 
        $parametros = [
            ':id_compraventa'=> $data['id_compraventa'],
            ':fechaCompra'=> $data['fechaCompra'],
            ':precioCompraReal' => $data['precioCompraReal'],
            ':precioCompraDeclarado' => $data['precioCompraDeclarado'],
            ':fechaFactComp' => $data['fechaFactComp'],
            ':nodeclaraComp' => (isset($data['nodeclaraComp'])) ? 1 : 0,
            ':impuestoCompra' => $data['impuestoCompra'],
            ':compraA' => $data['compraA'] ?? '',
            ':anuladaCompra' => (isset($data['anuladaCompra'])) ? 1 : 0,
            ':vehiculo' => $data['vehiculo'],
            ':reserva' => (isset($data['reserva'])) ? 1 : 0,
            ':comercialVenta' => $data['comercialVenta'],
            ':fechaVenta'=> $data['fechaVenta'],
            ':precioVentaReal' => $data['precioVentaReal'],
            ':precioVentaDeclarado' => $data['precioVentaDeclarado'],
            ':fechaFactVent' => $data['fechaFactVent'],
            ':nodeclaraVent' => (isset($data['nodeclaraVent'])) ? 1 : 0,
            ':impuestoVenta' => $data['impuestoVenta'],
            ':vendeA' => $data['vendeA'] ?? '',
            ':anuladaVenta' => (isset($data['anuladaVenta'])) ? 1 : 0,
            ':observaciones' => $data['observaciones'],
            ':trimestre' => (isset($data['trimestre'])) ? 1 : 0,
            ':empresa' => $data['empresa']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE compraventas SET fechaCompra=:fechaCompra, precioCompraReal=:precioCompraReal, precioCompraDeclarado=:precioCompraDeclarado, fechaFactComp=:fechaFactComp, nodeclaraComp=:nodeclaraComp, 
                                        impuestoCompra=:impuestoCompra, compraA=:compraA, anuladaCompra=:anuladaCompra, vehiculo=:vehiculo, reserva=:reserva, comercialVenta=:comercialVenta, 
                                        fechaVenta=:fechaVenta, precioVentaReal=:precioVentaReal, precioVentaDeclarado=:precioVentaDeclarado, fechaFactVent=:fechaFactVent, nodeclaraVent=:nodeclaraVent,
                                        impuestoVenta=:impuestoVenta, vendeA=:vendeA, anuladaVenta=:anuladaVenta, observaciones=:observaciones, trimestre=:trimestre, empresa=:empresa
                                     WHERE id_compraventa = :id_compraventa";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Compraventa {/*leo tmb datos de tablas relacionadas para que esta funcion read me sirva para ver los detalles de una compraventa */
        $this->conexionPDO->consulta("SELECT CV.*, C.Nombre AS nombreComprador, V.Nombre AS nombreVendedor, 
                                                E.Nombre AS nombreEmpresa, VV.Marca_modelo, VV.Matricula, VV.Bastidor 
                                        FROM compraventas CV
                                        LEFT JOIN entidad C ON CV.compraA = C.id_entidad 
                                        LEFT JOIN entidad V ON CV.vendeA = V.id_entidad 
                                        LEFT JOIN entidad E ON CV.empresa = E.id_entidad 
                                        LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo
                                            WHERE (id_compraventa=$id)");        
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM compraventas WHERE (id_compraventa=$id)");
    }
}