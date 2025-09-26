<?php
namespace repositories;
use lib\BaseDatosPDO;
use models\CobroAlquiler;

class CobroAlquilerRepository{
    private BaseDatosPDO $conexionPDO;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();       
    }

    public function cobrosAlquiler(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM cobrosAlquiler WHERE alquiler=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?CobroAlquiler {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? CobroAlquiler::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $ampliaciones = [];
        $Datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($Datos as $data){
            $ampliaciones[] = CobroAlquiler::fromArray($data);
        }
        return $ampliaciones;
    }
    public function read (int $id): ?CobroAlquiler {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM cobrosalquiler WHERE idCobro=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }




}
?>
