<?php
namespace repositories;

use lib\BaseDatos;
use lib\BaseDatosPDO;
use models\AmpliacionAlquiler;


class AmpliacionAlquilerRepository{
    private BaseDatosPDO $conexionPDO;
    
    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }

    public function ampliacionesAlquiler(int $id): ?array {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM ampliaciones WHERE alquiler=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?AmpliacionAlquiler {
        return ($gasto = $this->conexionPDO->extraer_registro()) ? AmpliacionAlquiler::fromArray($gasto):null;
    }
    public function extraer_todos(): ?array {
        $ampliaciones = [];
        $Datos = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($Datos as $data){
            $ampliaciones[] = AmpliacionAlquiler::fromArray($data);
        }
        return $ampliaciones;
    }
    public function read (int $id): ?AmpliacionAlquiler {
        $parametros = [':id' => $id];
        $sql = "SELECT * FROM ampliaciones WHERE idAmpliacion=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function update (array $ampliacion): void{ 
        //var_dump($gasto['id_vehiculo']);
        $parametros = [
            ':idAmpliacion' => $ampliacion['idAmpliacion'],
            ':fechaInicio' => $ampliacion['fechaInicio'],
            ':fechaFin' => $ampliacion['fechaFin'],
            ':dias' => $ampliacion['dias'],
            ':kilometros' => $ampliacion['kilometros'],
            ':precio' => $ampliacion['precio'], 
            ':ganancia' => $ampliacion['ganancia'],       
            ':comisionComercial' => $ampliacion['comisionComercial'],
            ':observaciones' => $ampliacion['observaciones'],
            ':alquiler' => $ampliacion['alquiler']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE ampliaciones SET fechaInicio = :fechaInicio, fechaFin = :fechaFin, dias = :dias, kilometros = :kilometros, precio = :precio, 
                ganancia = :ganancia, comisionComercial = :comisionComercial, observaciones = :observaciones, alquiler = :alquiler WHERE idAmpliacion = :idAmpliacion";
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function create (array $ampliacion):void{
        
        $parametros = [
            ':fechaInicio' => $ampliacion['fechaInicio'],
            ':fechaFin' => $ampliacion['fechaFin'],
            ':dias' => $ampliacion['dias'],
            ':kilometros' => $ampliacion['kilometros'],
            ':precio' => $ampliacion['precio'], 
            ':ganancia' => $ampliacion['ganancia'],       
            ':comisionComercial' => $ampliacion['comisionComercial'],
            ':observaciones' => $ampliacion['observaciones'],
            ':alquiler' => $ampliacion['alquiler']     
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO ampliaciones (fechaInicio, fechaFin, dias, kilometros, precio, ganancia, comisionComercial, observaciones, alquiler) VALUES 
                                           (:fechaInicio, :fechaFin, :dias, :kilometros, :precio, :ganancia, :comisionComercial, :observaciones, :alquiler)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function delete (int $id): void {
        $parametros = [':id' =>$id];
        $sql = "DELETE FROM ampliaciones WHERE idAmpliacion=:id"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function ampliacionesAlquilerFecha($alquiler){
        $parametros = [
        ':desde' => $_GET['desde'],
        ':hasta' => $_GET['hasta'],
        ':alquiler' => $alquiler
        ];
        $sql = "SELECT   ganancia, fechaInicio, comisionComercial FROM ampliaciones 
                                            WHERE fechaInicio BETWEEN :desde AND :hasta AND alquiler = :alquiler";
        $this->conexionPDO->consulta($sql, $parametros);        
        return $this->conexionPDO->extraer_todos();       
    }
}
?>