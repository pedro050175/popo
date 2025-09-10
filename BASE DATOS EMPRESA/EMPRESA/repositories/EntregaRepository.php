<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Entrega;

class EntregaRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    
    public function entregasMovimiento(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM entregas WHERE movimiento=:id ORDER BY fecha";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Entrega {
        return ($entrega = $this->conexionPDO->extraer_registro()) ? Entrega::fromArray($entrega):null;
    }
    public function extraer_todos(): ?array {
        $entregas = [];
        $entregasData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($entregasData as $entrega){
            $entregas[] = Entrega::fromArray($entrega);
        }
        return $entregas;
    }
    public function create (array $entrega):void{

        $parametros = [
            ':fecha' => $entrega['fecha'],
            ':importe' => $entrega['importe'],
            ':bancoEnvia' => $entrega['bancoEnvia'],
            ':bancoRecibe' => $entrega['bancoRecibe'],
            ':observaciones' => $entrega['observaciones'], 
            ':movimiento' => $entrega['movimiento'], 
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO entregas (fecha, importe, bancoEnvia, bancoRecibe, observaciones, movimiento) VALUES 
                                    (:fecha, :importe, :bancoEnvia, :bancoRecibe, :observaciones, :movimiento)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function update (array $entrega): void{ 

        $parametros = [
            ':idEntrega' => $entrega['idEntrega'],
            ':fecha' => $entrega['fecha'],
            ':importe' => $entrega['importe'],
            ':bancoEnvia' => $entrega['bancoEnvia'],
            ':bancoRecibe' => $entrega['bancoRecibe'],
            ':observaciones' => $entrega['observaciones'], 
            ':movimiento' => $entrega['movimiento'], 
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE entregas SET fecha = :fecha, importe = :importe, bancoEnvia = :bancoEnvia, bancoRecibe = :bancoRecibe, observaciones  = :observaciones, movimiento = :movimiento
                                        WHERE idEntrega = :idEntrega";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Entrega {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM entregas WHERE idEntrega=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM entregas WHERE idEntrega=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}