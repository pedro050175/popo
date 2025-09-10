<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Devolucion;

class DevolucionRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    
    public function devolucionesMovimiento(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM devoluciones WHERE movimiento=:id ORDER BY fecha";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Devolucion {
        return ($devolucion = $this->conexionPDO->extraer_registro()) ? Devolucion::fromArray($devolucion):null;
    }
    public function extraer_todos(): ?array {
        $devoluciones = [];
        $devolucionesData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($devolucionesData as $devolucion){
            $devoluciones[] = Devolucion::fromArray($devolucion);
        }
        return $devoluciones;
    }
    public function create (array $devolucion):void{

        $parametros = [
            ':fecha' => $devolucion['fecha'],
            ':importe' => $devolucion['importe'],
            ':bancoEnvia' => $devolucion['bancoEnvia'],
            ':bancoRecibe' => $devolucion['bancoRecibe'],
            ':observaciones' => $devolucion['observaciones'], 
            ':movimiento' => $devolucion['movimiento'], 
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO devoluciones (fecha, importe, bancoEnvia, bancoRecibe, observaciones, movimiento) VALUES 
                                    (:fecha, :importe, :bancoEnvia, :bancoRecibe, :observaciones, :movimiento)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function update (array $devolucion): void{ 

        $parametros = [
            ':idDevolucion' => $devolucion['idDevolucion'],
            ':fecha' => $devolucion['fecha'],
            ':importe' => $devolucion['importe'],
            ':bancoEnvia' => $devolucion['bancoEnvia'],
            ':bancoRecibe' => $devolucion['bancoRecibe'],
            ':observaciones' => $devolucion['observaciones'], 
            ':movimiento' => $devolucion['movimiento'], 
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE devoluciones SET fecha = :fecha, importe = :importe, bancoEnvia = :bancoEnvia, bancoRecibe = :bancoRecibe, observaciones  = :observaciones, movimiento = :movimiento
                                        WHERE idDevolucion = :idDevolucion";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Devolucion {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM devoluciones WHERE idDevolucion=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM devoluciones WHERE idDevolucion=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}