<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\PagoCompraventa;

class PagoCompraventaRepository{
    private BaseDatosPDO $conexionPDO;
    public function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }

    public function pagosCompraventa(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM pagoscomven WHERE compraventa=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?PagoCompraventa {
        return ($datos = $this->conexionPDO->extraer_registro()) ? PagoCompraventa::fromArray($datos):null;
    }
    public function extraer_todos(): ?array {
        $pagos = [];
        $datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($datos as $data){
            $pagos[] = PagoCompraventa::fromArray($data);
        }
        return $pagos;
    }
    public function read (int $id): ?PagoCompraventa {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM pagoscomven WHERE idPago=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function create (array $pago):void{
        
        $parametros = [
            ':fecha' => $pago['fecha'],
            ':compraventa' => $pago['compraventa'],
            ':importe' => $pago['importe'],
            ':banco' => $pago['banco'],       
            ':observaciones' => $pago['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO pagoscomven (fecha, compraventa, importe, banco, observaciones) VALUES 
                                           (:fecha, :compraventa, :importe, :banco, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $pago): void{ 
        //var_dump($gasto['id_vehiculo']);
        $parametros = [
            ':id' => $pago['idPago'],
            ':fecha' => $pago['fecha'],
            ':compraventa' => $pago['compraventa'],
            ':importe' => $pago['importe'],
            ':banco' => $pago['banco'],       
            ':observaciones' => $pago['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE pagoscomven SET fecha = :fecha, compraventa = :compraventa, importe = :importe, banco = :banco, observaciones = :observaciones  WHERE idPago = :id";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM pagoscomven WHERE idPago=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}


?>