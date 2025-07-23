<?php
class a {
    public function __construct (private string $cadena){}
   
    public function getcadena(): string {
        return $this->cadena;
    }
}
class b extends a {
    public function __construct(private string $texto, private int $num, string $cadena){ //private string $cadena
        parent::__construct($cadena);
    }
    
    public function gettexto(): string {
        return $this->texto;
    }
    public function getnumero(): int {
        return $this->num;
    }
}

$objeto = new b ("hijo", 5, "padre");
echo $objeto->getcadena();
echo $objeto->getnumero();
echo $objeto->gettexto();

/* $modelo = array('id' => 0, 'nombre' => '', 'apellido' => '', 'dir' => '');
$duplicar = array('id' => 1, 'nombre' => 'pedro', 'dir' => 'xxx');
$modelo = $duplicar; 
foreach ($duplicar as $indice => $valor ){
    $modelo[$indice] = $duplicar[$indice]; 
}
echo $indice; */

?>