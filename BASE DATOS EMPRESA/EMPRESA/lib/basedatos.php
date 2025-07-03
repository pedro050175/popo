<?php
namespace lib;
use Mysqli;

class BaseDatos { 
    
    private Mysqli $conexion;
    private mixed $resultado;
        
function __construct(private string $servidor=SERVIDOR, private string $usuario=USUARIO, private string $pass=PASS, private string $base_datos=BASE_DATOS){
        $this->conexion = $this->conectar();
    }
private function conectar (): Mysqli {
    $conectando = new Mysqli($this->servidor, $this->usuario, $this->pass, $this->base_datos);
    if ($conectando->connect_error){ die('Error de conexion');
    }
    return $conectando;
}
public function consulta(string $consultaSQL) : bool {   //Si la consulta es incorrecta, $this->resultado no será false.
    
    $this->resultado = $this->conexion->query($consultaSQL);
    return $this->resultado !== false;//si la consulta es exitosa $this->resultado almacena el valor de la consulta, tabla llena de valores, que es diferente de False
} //si la consulta es diferente de false devuelve true y si es false devuelve false porque es falso que sea diferente de false
//en PHP una variable puede tener un valor, string, tabla, etc o tener un false que es booleano

public function extraer_registro(): mixed{
    return ($fila = $this->resultado->fetch_array(MYSQLI_ASSOC)) ? $fila:false;
}
public function extraer_todos(): array | bool {//fetch_all extrae todos los registros de una sola vez en una tabla de 2 dimensiones
    return $this->resultado ? $this->resultado->fetch_all(MYSQLI_ASSOC) : false;
  //no hace falta $fila = $this->resultado->fetch... para saber si se ha llegado al final, solo se va a llamar una vez este metodo
  //si $this->resultado es true, es decir, tiene datos de la consulta ejecutada, devuelve $this->resultado->fech_all
}
}
?>