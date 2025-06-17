<?php
namespace lib;
use Mysqli;

class basedatos { 
    
    private Mysqli $conexion;
        
    function __construct(private string $servidor, private string $usuario, private string $pass, private string $base_datos){
        $this->conexion = $this->conectar();
    }
private function conectar (): Mysqli {
    $conexion = new Mysqli($this->servidor, $this->usuario, $this->pass, $this->base_datos);
    if ($conexion->connect_error){ die('Error de conexion');
    }
        return $conexion;
}
}
?>