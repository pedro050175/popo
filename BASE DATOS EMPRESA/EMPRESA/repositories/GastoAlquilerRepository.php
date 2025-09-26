<?php
namespace repositories;
use lib\BaseDatosPDO;
use models\GastoAlquiler;

class GastoAlquilerRepository{
    private BaseDatosPDO $conexionPDO;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function gastosAlquiler(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastosalquiler WHERE alquiler=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?GastoAlquiler {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? GastoAlquiler::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $ampliaciones = [];
        $Datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($Datos as $data){
            $ampliaciones[] = GastoAlquiler::fromArray($data);
        }
        return $ampliaciones;
    }
    public function read (int $id): ?GastoAlquiler {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM gastosalquiler WHERE idGasto=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }

}
?>