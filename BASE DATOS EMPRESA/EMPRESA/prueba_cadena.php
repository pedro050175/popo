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

/* $objeto = new b ("hijo", 5, "padre");
echo $objeto->getcadena();
echo $objeto->getnumero();
echo $objeto->gettexto();
 */
function create(array $data): array {
    // Limpia campos vacíos
    foreach ($data as $indice => $campo) {
        if (isset($campo) && trim($campo) === '') {
            $data[$indice] = null;
        }
    }

    $campos = array_keys($data);
    $placeholders = array_map(fn($campo) => ':' . $campo, $campos);

    $sql = "INSERT INTO vehiculos (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $placeholders) . ")";

    // Armar array de parámetros
    $parametros = [];
    foreach ($data as $campo => $valor) {
        $parametros[":$campo"] = $valor;
    }
    return $parametros;
}
$tabla = array("Matricula" => '1234', "Bastidor" => '', "Marca_modelo" => 'audi', "Km" => 23, "Fecha_matricula" => '202-12-04', "Observaciones" => '', "Combustible" => '', "Fecha_itv" => '', 
                "Estado" => '', "Clase" => '', "propietario" => '', "Prox_itv" =>'2025-12-12');

$preparada= create($tabla);

print_r($preparada);


<option selected> Selecciona tipo de combustible</option>
                <?php if (isset($vehiculo)) :?>
                    <option value="<?=$vehiculo->getCombustible()?>" selected style="font-weight: bold"><?=$vehiculo->getCombustible()?></option>
                <?php endif ;?>
                <option value="Gasolina">Gasolina</option>
                <option value="Diesel">Diesel</option>
                <option value="Hibrido">Hibrido</option>
                <option value="Electrico">Electrico</option>
            
?>