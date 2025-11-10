<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\CuotaVehiculo;

class CuotaVehiculoRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function cuotas_vehiculo(int $id): ?array {/*para mostrar listado necesito leer el nombre de la entidad por eso lo incluyo en el select consa que notengo que hacer para editar*/
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

    public function create (array $cuota):void{

        $parametros = [
            ':inicio' => $cuota['inicio'],
            ':duracion' => $cuota['duracion'],
            ':id_vehiculo' => $cuota['id_vehiculo'],
            ':tipo' => ($cuota['tipo'] ?? ''),
            ':cuota' => $cuota['cuota'], 
            ':totalPagar' => $cuota['totalPagar'], 
            ':pagoFinal' => $cuota['pagoFinal'], 
            ':entrada' => $cuota['entrada'], 
            ':fianza' => $cuota['fianza'], 
            ':km' => $cuota['km'], 
            ':kmAno' => $cuota['kmAno'], 
            ':financiera' => $cuota['financiera'],       
            ':id_entidad' => $cuota['titular'] ?? '',     
            ':observaciones' => $cuota['observaciones']      
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO cuotasvehiculo (inicio, duracion, id_vehiculo, tipo, cuota, totalPagar, pagoFinal, entrada, fianza, km, kmAno, financiera, id_entidad, observaciones) VALUES 
                                           (:inicio, :duracion, :id_vehiculo, :tipo, :cuota, :totalPagar, :pagoFinal, :entrada, :fianza, :km, :kmAno, :financiera, :id_entidad, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $cuota): void{ 

        $parametros = [
            ':idCuota' => $cuota['idCuota'],
            ':inicio' => $cuota['inicio'],
            ':duracion' => $cuota['duracion'],
            ':id_vehiculo' => $cuota['id_vehiculo'],
            ':tipo' => $cuota['tipo'] ?? '',
            ':cuota' => $cuota['cuota'], 
            ':totalPagar' => $cuota['totalPagar'], 
            ':pagoFinal' => $cuota['pagoFinal'], 
            ':entrada' => $cuota['entrada'], 
            ':fianza' => $cuota['fianza'], 
            ':km' => $cuota['km'], 
            ':kmAno' => $cuota['kmAno'], 
            ':financiera' => $cuota['financiera'],       
            ':id_entidad' => $cuota['titular'] ?? null,     
            ':observaciones' => $cuota['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE cuotasvehiculo SET inicio = :inicio, duracion = :duracion, id_vehiculo = :id_vehiculo, tipo = :tipo, cuota  = :cuota, totalPagar = :totalPagar, pagoFinal = :pagoFinal, 
                                        entrada = :entrada, fianza = :fianza, km = :km, kmAno = :kmAno, financiera = :financiera, id_entidad = :id_entidad, observaciones = :observaciones
                                        WHERE idCuota = :idCuota";
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?CuotaVehiculo {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM cuotasvehiculo WHERE idCuota=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM cuotasvehiculo WHERE idCuota=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}