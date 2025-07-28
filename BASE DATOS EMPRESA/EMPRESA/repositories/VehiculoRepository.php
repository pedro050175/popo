<?php
namespace repositories;

use lib\BaseDatos;
use models\Entidad;
use models\Vehiculo;

class VehiculoRepository {

    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }
    public function findAll(): ?array {
        $campo_ord= $_GET['ordenar'] ?? null;
        if ($campo_ord) {
            $this->conexion->consulta ("SELECT * FROM vehiculos ORDER BY $campo_ord");
        } else {
            $busca = $_GET['buscar_marca'] ?? null;
            if ($busca) {
                //file_put_contents("log.txt", "busca: ". $busca. " \n" , FILE_APPEND);
                $this->conexion->consulta ("SELECT * FROM vehiculos WHERE Marca_modelo LIKE '%$busca%'");
            } else {
                $busca = $_GET['buscar_matr_bast'] ?? null;
                if ($busca) {
                    $this->conexion->consulta ("SELECT * FROM vehiculos WHERE Matricula LIKE '%$busca%' OR Bastidor LIKE '%$busca%'");
                } else $this->conexion->consulta ("SELECT * FROM vehiculos"); //ojo con los nombres de los campos si se hace un SELECT de ciertos campos, hay que poner el nombre tal y como esta en la base de datos
            }
        }    
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Vehiculo {
        return ($vehiculo = $this->conexion->extraer_registro()) ? Vehiculo::fromArray($vehiculo):null;
    }
    public function extraer_todos(): ?array {
        $vehiculos = [];
        $vehiculoData = $this->conexion->extraer_todos();
        //var_dump($entidadData);
        foreach ($vehiculoData as $data){
            $vehiculos[] = Vehiculo::fromArray($data);
        }
        return $vehiculos;
    }
    public function save (array $vehiculo):void {
        if (isset($vehiculo['vehiculo']['id_vehiculo'])) {
            $this->update($vehiculo);
        } else { $this->create($vehiculo);}
    }
    public function create (array $data):void{
        foreach (['Fecha_itv', 'Fecha_matricula', 'Prox_itv', 'Km', 'propietario'] as $campo) {//para todos los campos fecha si existe y tiene '' le asigna null. Trim devuelve si es igual a '' o '  'y === significa igual calor e igual tipo
            if (isset($data['vehiculo'][$campo]) && trim($data['vehiculo'][$campo]) === '') {//trim nos dice si hay 1 o mas espacios en blanco, el usuario podria poner varios '   ' espacios y daria error
                $data['vehiculo'][$campo] = null;
                //echo "cambiado: ". $campo."<br/>";
            }
        }
        //$fields = implode(',', array_keys($data['vehiculo']));
        //echo "$fields <br/>";
        //$values = implode("', '", $data['vehiculo']);
        $campos = [];
        $valores = [];

        foreach ($data['vehiculo'] as $campo => $valor) {
            $campos[] = $campo;

            if (is_null($valor)) {
                $valores[] = "NULL";
            } else {
                $valor_escapado = addslashes($valor);
                $valores[] = "'$valor_escapado'";
            }
        }

        $fields = implode(", ", $campos);
        $values = implode(", ", $valores);

        /* foreach ($data['vehiculo'] as $indice => $valor){
            if ($valor===null) {
                $values [] = NULL; 
            } else $values []=  $data['vehiculo'][$indice];
        }
        $valores = implode("', '", $values); */
        /* echo "$fields";
        echo "$values"; */
        $sql = "INSERT INTO vehiculos ($fields) VALUES ($values)";
       // echo "<pre>$sql</pre>";
        $this->conexion->consulta ($sql);

    }
    public function update (array $data): void{       
        //en un campo date de mysql no se puede guaradar un '' hay que guardar null. Lo mismo ocurre con el campo int de mysql    
        foreach (['Fecha_itv', 'Fecha_matricula', 'Prox_itv', 'Km', 'propietario'] as $campoFecha) {//para todos los campos fecha si existe y tiene '' le asigna null. Trim devuelve si es igual a '' o '  'y === significa igual calor e igual tipo
            if (isset($data['vehiculo'][$campoFecha]) && trim($data['vehiculo'][$campoFecha]) === '') {//trim nos dice si hay 1 o mas espacios en blanco, el usuario podria poner varios '   ' espacios y daria error
                $data['vehiculo'][$campoFecha] = null;
            }
        }
        //despues de cambiar los '' por null se vuelve a producir el fallo porque la sentencia $updates[] = "$indice='{$valor}'"; converte los null en ''
        $updates=[];
        foreach ($data['vehiculo'] as $indice => $valor){
            if (is_null($valor)) {  //si es null en updates meto "indice=NULL"
                $updates[] = "$indice=NULL";
            } else {//sino es null hace lo que hacia antes
                $updates[] = "$indice='{$valor}'";
            } 
        }
        $changes=implode(', ', $updates);
        /*print_r($changes);
        echo 'final: <br/>'; */
        $this->conexion->consulta("UPDATE vehiculos SET $changes where id_vehiculo =".$data['vehiculo']['id_vehiculo']); //vease que se cierra la consulta con " y se concatena con . Esto se hace porque
        //para poner un array dentro de dobles comillas hay que quitar las comillas simples a los indices asociativos, y entonces falla en tiempo de ejecucion pk intenta hacer una conversion arry to string  
    }
    public function read (int $id): ?Vehiculo {
        $this->conexion->consulta("SELECT * FROM vehiculos WHERE (id_vehiculo=$id)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexion->consulta("DELETE FROM vehiculos WHERE (id_vehiculo=$id)");
    }
    public function relacionados(int $id): bool {
        $encontrados=0; //he definido una constante de tipo array asociativo que contiene ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla']  
        foreach (TABLAS_VEHICULO as $campo => $tabla){
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