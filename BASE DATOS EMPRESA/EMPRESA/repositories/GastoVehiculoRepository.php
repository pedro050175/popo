<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\GastoVehiculo;

class GastoVehiculoRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    
    public function gastos_vehiculo(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastosvehiculo WHERE id_vehiculo=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?GastoVehiculo {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? GastoVehiculo::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $gastos = [];
        $gastoData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($gastoData as $data){
            $gastos[] = GastoVehiculo::fromArray($data);
        }
        return $gastos;
    }

    public function create (array $gasto):void{
        
        $parametros = [
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':paga_otro' => (isset($gasto['paga_otro'])) ? 1 : 0,
            ':comentarios' => $gasto['comentarios'], 
            ':id_vehiculo' => $gasto['id_vehiculo'],       
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0      
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO gastosvehiculo (tipo, Importe, Fecha, Paga_otro, Comentarios, id_vehiculo, pagado) VALUES 
                                           (:tipo,:importe,:fecha,:paga_otro,:comentarios,:id_vehiculo,:pagado)"; 
        $ok = $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $gasto): void{ 
        $parametros = [
            ':id_gasto' => $gasto['id_gasto'],
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':paga_otro' => (isset($gasto['paga_otro'])) ? 1 : 0,
            ':comentarios' => $gasto['comentarios'], 
            ':id_vehiculo' => $gasto['id_vehiculo'],       
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE gastosvehiculo SET tipo = :tipo, importe = :importe, fecha = :fecha, paga_otro = :paga_otro, comentarios = :comentarios, id_vehiculo = :id_vehiculo, pagado = :pagado WHERE id_gasto = :id_gasto";
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?GastoVehiculo {
        $parametros = [':id_gasto' => $id];
        $sql = "SELECT * FROM gastosvehiculo WHERE id_gasto=:id_gasto";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM gastosvehiculo WHERE id_gasto=:id"; 
        $ok = $this->conexionPDO->consulta($sql, $parametros);
    }
}