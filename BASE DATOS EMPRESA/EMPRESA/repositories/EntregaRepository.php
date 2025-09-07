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
}