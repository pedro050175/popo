<?php
namespace repositories;

use lib\BaseDatos;
use models\Entidad;

class EntidadRepository {

    private BaseDatos $conexion;

    public function __construct() {
        $conexion = new BaseDatos();
    }
    public function findAll(): ?array {
        $this->conexion->consulta ("SELECT * FROM entidad");
        return $this->conexion->extraer_todos();
    }    
    public function extraer_registro(): ?Entidad {
        return ($entidad = $this->conexion->extraer_registro()) ? Entidad::fromArray($entidad):null;
    }
    public function extraer_todos(): ?array {
        $entidades = [];
        $entidadData = $this->conexion->extraer_todos();
        foreach ($entidadData as $data){
            $entidades = Entidad::fromArray($data);
        }
        return $entidades;
    }
    }
?>