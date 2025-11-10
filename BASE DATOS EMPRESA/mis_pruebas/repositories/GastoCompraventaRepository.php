<?php
namespace repositories;
use lib\BaseDatosPDO;
use models\GastoCompraventa;

class GastoCompraventaRepository{
    private BaseDatosPDO $conexionPDO;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function gastosCompraventa(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastoscompraventa WHERE compraventa=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?GastoCompraventa {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? GastoCompraventa::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $gastos = [];
        $Datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($Datos as $data){
            $gastos[] = GastoCompraventa::fromArray($data);
        }
        return $gastos;
    }
    public function read (int $id): ?GastoCompraventa {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastoscompraventa WHERE idGasto=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function gastosVehiculoCompraventa(int $id){
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastoscompraventa
                WHERE compraventa IN (SELECT id_compraventa FROM compraventas
                            WHERE vehiculo =:id)";
        
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();
    }
    public function create (array $gasto):void{
        
        $parametros = [
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':pagaOtro' => (isset($gasto['pagaOtro'])) ? 1 : 0,
            ':compraventa' => $gasto['compraventa'],
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0,
            ':observaciones' => $gasto['observaciones']       
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO gastoscompraventa (tipo, Importe, fecha, pagaOtro, compraventa, pagado, observaciones) VALUES 
                                           (:tipo, :importe, :fecha, :pagaOtro, :compraventa, :pagado, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $gasto): void{ 
        $parametros = [
            ':id' => $gasto['idGasto'],
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':pagaOtro' => (isset($gasto['pagaOtro'])) ? 1 : 0,
            ':compraventa' => $gasto['compraventa'],
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0,
            ':observaciones' => $gasto['observaciones']       
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE gastoscompraventa SET tipo = :tipo, importe = :importe, fecha = :fecha, pagaOtro = :pagaOtro, compraventa = :compraventa,  pagado = :pagado, observaciones = :observaciones WHERE idGasto = :id";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM gastoscompraventa WHERE idGasto=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}

?>