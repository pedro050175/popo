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
    public function create (array $cobro):void{
        
        $parametros = [
            ':fecha' => $cobro['fecha'],
            ':alquiler' => $cobro['alquiler'],
            ':importe' => $cobro['importe'],
            ':facturado' => (isset($cobro['facturado'])) ? 1 : 0,
            ':facturadoA' => $cobro['facturadoA'],
            ':contratoHacienda' => $cobro['contratoHacienda'], 
            ':fianza' => (isset($cobro['fianza'])) ? 1 : 0,
            ':parteImporteFianza' => $cobro['parteImporteFianza'], 
            ':banco' => $cobro['banco'],       
            ':observaciones' => $cobro['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO cobrosalquiler (fecha, alquiler, importe, facturado, facturadoA, contratoHacienda, fianza, parteImporteFianza, banco,observaciones) VALUES 
                                           (:fecha, :alquiler, :importe, :facturado, :facturadoA, :contratoHacienda, :fianza, :parteImporteFianza, :banco, :observaciones)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $cobro): void{ 
        //var_dump($gasto['id_vehiculo']);
        $parametros = [
            ':id' => $cobro['idCobro'],
            ':fecha' => $cobro['fecha'],
            ':alquiler' => $cobro['alquiler'],
            ':importe' => $cobro['importe'],
            ':facturado' => (isset($cobro['facturado'])) ? 1 : 0,
            ':facturadoA' => $cobro['facturadoA'],
            ':contratoHacienda' => $cobro['contratoHacienda'], 
            ':fianza' => (isset($cobro['fianza'])) ? 1 : 0,
            ':parteImporteFianza' => $cobro['parteImporteFianza'], 
            ':banco' => $cobro['banco'],       
            ':observaciones' => $cobro['observaciones']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE cobrosalquiler SET fecha = :fecha, alquiler = :alquiler, importe = :importe,  facturado = :facturado, facturadoA = :facturadoA, contratoHacienda = :contratoHacienda,
                                         fianza = :fianza, parteImporteFianza = :parteImporteFianza, banco = :banco, observaciones = :observaciones  WHERE idCobro = :id";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM cobrosalquiler WHERE idCobro=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
}
?>
