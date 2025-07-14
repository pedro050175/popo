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
        
        $this->conexion->consulta ("SELECT * FROM entidad");
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
        /* $this->conexion->consulta ("insert into entidad (CIF_DNI, Nombre, Apellidos, Direccion, Telefono, Email) 
        values ($entidad[entidad][CIF_DNI], $entidad[entidad][Nombre], $entidad[entidad][Apellidos], $entidad[entidad][Direccion], $entidad[entidad][Telefono], $entidad[entidad][Email])"); */
//esta manera de hacerlo obliga a modificar la consulta cada vez que se añade o elimina un campo a la base de datos
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
        $consulta = "SELECT COUNT(*) as total FROM vehiculos WHERE Propietario = $id";
        $this->conexion->consulta($consulta);
        $resultado = $this->conexion->extraer_registro();
        //file_put_contents("log.txt", "Hay relacionados: ".$resultado['total']. "\n" , FILE_APPEND);
        return $resultado && $resultado['total'] > 0; //$resultado (existe) AND $resultado['total']>0
}    
}
?>