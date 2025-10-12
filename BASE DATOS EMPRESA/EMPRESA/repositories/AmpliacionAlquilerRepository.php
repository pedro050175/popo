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
    public function ampliacionesAlquilerCoche($desde, $hasta, $vehiculo){//leo las ampliaciones de un coche
        //como la tabla ampliaciones no esta relacionada con vehiculos, tengo que usar ampliaciones para cruzarlas y poder sacar las ampliaciones de un coche 
        $parametros = [
        ':desde' => $desde,
        ':hasta' => $hasta,
        ':vehiculo' => $vehiculo
        ];
        $sql = "SELECT   AM.ganancia, AM.fechaInicio, AM.comisionComercial FROM ampliaciones AM
                                JOIN alquileres AL ON AM.alquiler = AL.id_alquiler
                                JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                        WHERE AM.fechaInicio BETWEEN :desde AND :hasta AND V.id_vehiculo = :vehiculo";
        $this->conexionPDO->consulta($sql, $parametros);        
        return $this->conexionPDO->extraer_todos();       
    }
    public function ampliacionesAlquilerCocheV2($desde, $hasta, $cocheIds){//leo todas las ampliaciones de todos los vehiculos
        //como la tabla ampliaciones no esta relacionada con vehiculos, tengo que usar ampliaciones para cruzarlas y poder sacar las ampliaciones de un coche 
        $parametros = [];//los parametros tiene que ser un array asociativo
        $placeholders = [];
        foreach ($cocheIds as $i => $id) {
            $key = ':id' . $i;              // Ejemplo: :id0, :id1, :id2...
            $placeholders[] = $key; //aqui se crea una tabla [:id1,:id5,:id9] que es la que ira dentro del IN
            $parametros[$key] = (int)$id;  //[':id0' => 1, ':id1' => 5, ':id2' => 9] array asociativo       Forzamos a entero por seguridad
        }
        
        $in = implode(',', $placeholders); //la tabla del IN la convierte a string separado por ,
        $parametros[':desde'] = $desde;//añade los dos parametros de fechas
        $parametros[':hasta'] = $hasta;
        $sql = "SELECT   AL.vehiculo, AM.ganancia, AM.fechaInicio FROM ampliaciones AM
                                JOIN alquileres AL ON AM.alquiler = AL.id_alquiler
                                JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                        WHERE AM.fechaInicio BETWEEN :desde AND :hasta AND V.id_vehiculo IN ($in)";

        $this->conexionPDO->consulta($sql, $parametros);        
        return $this->conexionPDO->extraer_todos();       
    }
}
?>