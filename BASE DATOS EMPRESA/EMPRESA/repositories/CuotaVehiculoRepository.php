<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\CuotaVehiculo;

class CuotaVehiculoRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function cuotas_vehiculo(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT C.*, Nombre FROM cuotasvehiculo as C LEFT JOIN entidad as E ON C.id_entidad=E.id_entidad WHERE C.id_vehiculo=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?CuotaVehiculo {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? CuotaVehiculo::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $cuotas = [];
        $cuotaData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($cuotaData as $data){
            $cuotas[] = CuotaVehiculo::fromArray($data);
        }
        return $cuotas;
    }
}