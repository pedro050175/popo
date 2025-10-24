<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\CobroCompraventa;

class CobroCompraventaRepository{
    private BaseDatosPDO $conexionPDO;
    public function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }

    public function cobrosCompraventa(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM cobroscomven WHERE compraventa=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?CobroCompraventa {
        return ($datos = $this->conexionPDO->extraer_registro()) ? CobroCompraventa::fromArray($datos):null;
    }
    public function extraer_todos(): ?array {
        $cobros = [];
        $datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($datos as $data){
            $cobros[] = CobroCompraventa::fromArray($data);
        }
        return $cobros;
    }
    public function read (int $id): ?CobroCompraventa {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM cobroscomven WHERE idCobro=:id";
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
        $sql = "INSERT INTO cobroscomven (fecha, compraventa, importe, banco, observaciones) VALUES 
                                           (:fecha, :compraventa, :importe, :banco, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $pago): void{ 
        //var_dump($gasto['id_vehiculo']);
        $parametros = [
            ':id' => $pago['idCobro'],
            ':fecha' => $pago['fecha'],
            ':compraventa' => $pago['compraventa'],
            ':importe' => $pago['importe'],
            ':banco' => $pago['banco'],       
            ':observaciones' => $pago['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE cobroscomven SET fecha = :fecha, compraventa = :compraventa, importe = :importe, banco = :banco, observaciones = :observaciones  WHERE idCobro = :id";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM cobroscomven WHERE idCobro=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}


?>