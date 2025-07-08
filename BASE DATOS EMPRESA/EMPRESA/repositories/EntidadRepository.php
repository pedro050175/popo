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
        /* $this->conexion->consulta ("insert into entidad (CIF_DNI, Nombre, Apellidos, Direccion, Telefono, Email 
        values ($entidad[entidad][CIF_DNI], [entidad][Nombre], [entidad][Apellidos], [entidad][Direccion], [entidad][Telefono], [entidad][Email])"); */
//esta manera de hacerlo obliga a modificar la consulta cada vez que se añade o elimina un campo a la base de datos
        $fields = implode(',', array_keys($entidad['entidad']));
        $values = implode("', '", $entidad['entidad']);
        $this->conexion->consulta ("INSERT INTO entidad ($fields) VALUES ('$values')");

    }
    public function update (array $entidad): void{
        $cadena='';
        foreach ($entidad as $indice => $valor){
            $cadena = $cadena . "'$indice'  =  \"$valor\", ";
        }
        $cadena=trim($cadena,', ');
        $this->conexion->consulta("UPDATE entidad SET ($cadena) where (id=$entidad[entidad][id]");
    }
    public function read (int $id): ?Entidad {
        $this->conexion->consulta("SELECT * FROM entidad WHERE (id=$id)");
        return $this->extraer_registro();
    }
    
}
?>