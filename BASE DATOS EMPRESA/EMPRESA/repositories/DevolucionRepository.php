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
}