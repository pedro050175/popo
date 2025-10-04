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
    public function create (array $gasto):void{
        
        $parametros = [
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':pagaOtro' => (isset($gasto['pagaOtro'])) ? 1 : 0,
            ':alquiler' => $gasto['alquiler'],
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0,
            ':observaciones' => $gasto['observaciones']       
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO gastosalquiler (tipo, Importe, fecha, pagaOtro, alquiler, pagado, observaciones) VALUES 
                                           (:tipo, :importe, :fecha, :pagaOtro, :alquiler, :pagado, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $gasto): void{ 
        //var_dump($gasto['id_vehiculo']);
        $parametros = [
            ':id' => $gasto['idGasto'],
            ':tipo' => $gasto['tipo'],
            ':importe' => $gasto['importe'],
            ':fecha' => $gasto['fecha'],
            ':pagaOtro' => (isset($gasto['pagaOtro'])) ? 1 : 0,
            ':alquiler' => $gasto['alquiler'],
            ':pagado' => (isset($gasto['pagado'])) ? 1 : 0,
            ':observaciones' => $gasto['observaciones']       
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE gastosalquiler SET tipo = :tipo, importe = :importe, fecha = :fecha, pagaOtro = :pagaOtro, alquiler = :alquiler,  pagado = :pagado, observaciones = :observaciones WHERE idGasto = :id";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM gastosalquiler WHERE idGasto=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}

?>