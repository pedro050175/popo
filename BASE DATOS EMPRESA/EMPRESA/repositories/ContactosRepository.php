<?php
namespace repositories;

use lib\BaseDatos;

class ContactosRepository {

    private BaseDatos $conexion;

    public function __construct() {
        $conexion = new BaseDatos();
    }
    public function findAll(): ?array {
        $this->conexion->consulta ("SELECT * FROM entidad");
        return $this->conexion->extraer_todos();
    }    
    public function extraer_registro(): ?array {
        return ($contacto = $this->conexion->extraer_registro()) ? $contacto:null;
    }
    public function extraer_todos(): ?array {
        return $this->conexion->extraer_todos();
    }
    }
?>