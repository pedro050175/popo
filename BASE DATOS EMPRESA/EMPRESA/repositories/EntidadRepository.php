<?php
namespace repositories;

use lib\BaseDatos;
use models\Entidad;

class EntidadRepository {

    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }
    public function findAll(): ?array {
        $campo_ord= $_GET['ordenar'] ?? null;
        if ($campo_ord) {
            $this->conexion->consulta ("SELECT * FROM entidad ORDER BY $campo_ord");
        } else {
            $busca = $_GET['texto_buscar'] ?? null;
            if ($busca) {
                file_put_contents("log.txt", "busca: ". $busca. " \n" , FILE_APPEND);
                $this->conexion->consulta ("SELECT * FROM entidad WHERE Nombre LIKE '%$busca%'");
            } else{ $this->conexion->consulta ("SELECT * FROM entidad");}
        }
        return $this->extraer_todos();
    }    
    public function extraer_registro(): ?Entidad {
        return ($entidad = $this->conexion->extraer_registro()) ? Entidad::fromArray($entidad):null;
    }
    public function extraer_todos(): ?array {
        $entidades = [];
        $entidadData = $this->conexion->extraer_todos();
        foreach ($entidadData as $data){
            $entidades[] = Entidad::fromArray($data);
        }
        return $entidades;
    }
    public function save (array $entidad):void {
        if (isset($entidad['entidad']['id'])) {
            $this->update($entidad);
        } else { $this->create($entidad);}
    }
    public function create (array $entidad):void{
        $fields = implode(',', array_keys($entidad['entidad']));
        $values = implode("', '", $entidad['entidad']);
        $this->conexion->consulta ("INSERT INTO entidad ($fields) VALUES ('$values')");

    }
    public function update (array $entidad): void{
        $updates=[];
        foreach ($entidad['entidad'] as $indice => $valor){
            $updates[] = "$indice='{$valor}'";
        }
        $changes=implode(', ', $updates);
        $this->conexion->consulta("UPDATE entidad SET $changes where id =".$entidad['entidad']['id']); //vease que se cierra la consulta con " y se concatena con . Esto se hace porque
        //para poner un array dentro de dobles comillas hay que quitar las comillas simples a los indices asociativos, y entonces falla en tiempo de ejecucion pk intenta hacer una conversion arry to string  
    }
    public function read (int $id): ?Entidad {
        $this->conexion->consulta("SELECT * FROM entidad WHERE (id=$id)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexion->consulta("DELETE FROM entidad WHERE (id=$id)");
    }
    public function relacionados(int $id): bool {
        $encontrados=0; //he definido una constante de tipo array asociativo que contiene ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla']  
        foreach (TABLAS as $campo => $tabla){
            $consulta = "SELECT COUNT(*) as total FROM $tabla WHERE $campo = $id";
            $this->conexion->consulta($consulta);
            $resultado = $this->conexion->extraer_registro();
            $encontrados += $resultado['total']; 
        }
        // return $resultado && $resultado['total'] > 0; //$resultado (existe) AND $resultado['total']>0
        return $encontrados > 0;
    }    
}
?>