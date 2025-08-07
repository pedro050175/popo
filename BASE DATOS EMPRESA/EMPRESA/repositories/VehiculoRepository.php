<?php
namespace repositories;

use lib\BaseDatos;
use lib\BaseDatosPDO;
use models\Entidad;
use models\Vehiculo;

class VehiculoRepository {

    private BaseDatos $conexion;
    private BaseDatosPDO $conexionPDO;
    private int $num_paginas;

    public function __construct() {
        $this->conexion = new BaseDatos();
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function setnumpaginas(int $paginas){
        $this->num_paginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->num_paginas;
    }
    public function numero_paginas(string $consulta) : int { //cuenta el numpero de paginas de 5 filas que tiene una $consultada
        $num_filas = $this->conexion->contar_filas ($consulta);
        intval($num_filas%FILAS_PAGINA)==0 ? $numero_paginas = intval($num_filas/FILAS_PAGINA) : $numero_paginas = intval(($num_filas/FILAS_PAGINA)+1);
        
        return $numero_paginas;
    }
    public function findAll(?bool $paginar=true): ?array {
        if (!$paginar){//$paginar=false no pagina, se usa para campo de lista desplegable en formularios relacionados donde deben cargarse todos los vehiculos
            $this->conexion->consulta ("SELECT id_vehiculo, Marca_modelo FROM vehiculos ORDER BY Marca_modelo");
            return $this->extraer_todos();
        }
        $desplazamiento = 0;
        $this->num_paginas = $this->numero_paginas("SELECT COUNT(*) FROM vehiculos");
        if (($_GET['num_pagina']) <= $this->num_paginas) {
            $num_pagina = intval($_GET['num_pagina']);
            $desplazamiento = ($num_pagina-1) * FILAS_PAGINA;
        }
        $campo_ord= $_GET['ordenar'] ?? null;
        if ($campo_ord) {
            $this->conexion->consulta ("SELECT * FROM vehiculos ORDER BY $campo_ord LIMIT $desplazamiento, ".FILAS_PAGINA);
        } else {
            $busca = $_GET['buscar_marca'] ?? null;
            if ($busca) {
                //file_put_contents("log.txt", "busca: ". $busca. " \n" , FILE_APPEND);
                $this->conexion->consulta ("SELECT * FROM vehiculos WHERE Marca_modelo LIKE '%$busca%'");
            } else {
                $busca = $_GET['buscar_matr_bast'] ?? null;
                if ($busca) {
                    $this->conexion->consulta ("SELECT * FROM vehiculos WHERE Matricula LIKE '%$busca%' OR Bastidor LIKE '%$busca%'");
                } else $this->conexion->consulta ("SELECT vehiculos.*, Nombre FROM vehiculos LEFT JOIN entidad ON propietario=id_entidad LIMIT $desplazamiento, ".FILAS_PAGINA); //ojo con los nombres de los campos si se hace un SELECT de ciertos campos, hay que poner el nombre tal y como esta en la base de datos
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
        //var_dump($vehiculoData);
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
        
        $parametros = [
            ':Matricula'=> $data['vehiculo']['Matricula'],
            ':Bastidor' => $data['vehiculo']['Bastidor'],
            ':Marca_modelo' => $data['vehiculo']['Marca_modelo'],
            ':Km' => $data['vehiculo']['Km'],
            ':Fecha_matricula' => $data['vehiculo']['Fecha_matricula'],
            ':Observaciones' => $data['vehiculo']['Observaciones'],
            ':Combustible' => $data['vehiculo']['Combustible'] ?? '', //si no existe le asigo vacio. Podria no existir si en select no se pusiera value="" en el texto del mensaje y se diera a crear sin elejir una opcion
            ':Fecha_itv' => $data['vehiculo']['Fecha_itv'],           //con esto se eliminarian espacios vacios ':Combustible' => trim($data['vehiculo']['Combustible'] ?? '') y sino exote le asigna ''
            ':Estado' => $data['vehiculo']['Estado'] ?? '',
            ':Clase' => $data['vehiculo']['Clase'] ?? '',
            ':propietario' => $data['vehiculo']['propietario'] ?? '',
            ':Prox_itv' => $data['vehiculo']['Prox_itv']        
        ];
        // Limpia
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO vehiculos (Matricula, Bastidor, Marca_modelo, Km, Fecha_matricula, Observaciones, Combustible, Fecha_itv, Estado, Clase, propietario, Prox_itv) VALUES 
                                     (:Matricula,:Bastidor,:Marca_modelo,:Km,:Fecha_matricula,:Observaciones,:Combustible,:Fecha_itv,:Estado,:Clase,:propietario,:Prox_itv)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $data): void{ 
        $parametros = [
            ':Matricula'=> $data['vehiculo']['Matricula'],
            ':Bastidor' => $data['vehiculo']['Bastidor'],
            ':Marca_modelo' => $data['vehiculo']['Marca_modelo'],
            ':Km' => $data['vehiculo']['Km'],
            ':Fecha_matricula' => $data['vehiculo']['Fecha_matricula'],
            ':Observaciones' => $data['vehiculo']['Observaciones'],
            ':Combustible' => $data['vehiculo']['Combustible'] ?? '',
            ':Fecha_itv' => $data['vehiculo']['Fecha_itv'],
            ':Estado' => $data['vehiculo']['Estado']?? '',
            ':Clase' => $data['vehiculo']['Clase']?? '',
            ':propietario' => $data['vehiculo']['propietario'] ?? '',
            ':Prox_itv' => $data['vehiculo']['Prox_itv']        
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE vehiculos SET Matricula = :Matricula, Bastidor = :Bastidor, Marca_modelo = :Marca_modelo, Km = :Km, Fecha_matricula = :Fecha_matricula, Observaciones = :Observaciones, 
                                        Combustible = :Combustible, Fecha_itv = :Fecha_itv, Estado = :Estado, Clase = :Clase, propietario = :propietario, Prox_itv = :Prox_itv
                                     WHERE id_vehiculo =".$data['vehiculo']['id_vehiculo'];
       
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?Vehiculo {
        $this->conexion->consulta("SELECT * FROM vehiculos WHERE (id_vehiculo=$id)");
        return $this->extraer_registro();
    }
    public function detalles_vehiculo (int $id): ?Vehiculo{
        $this->conexion->consulta("SELECT vehiculos.*, Nombre FROM vehiculos LEFT JOIN entidad ON propietario=id_entidad && id_vehiculo=$id");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexion->consulta("DELETE FROM vehiculos WHERE (id_vehiculo=$id)");
    }
    public function relacionados(int $id): bool {
        $encontrados=0; //he definido una constante de tipo array asociativo que contiene ["campo_tabla_relacionado_con_id_entidad"=>'nombre_tabla']  
        foreach (TABLA_VEHICULO as $tabla => $campo){
           
            $consulta = "SELECT COUNT(*) as total FROM $tabla WHERE $campo = $id";
            //echo "<pre>$consulta</pre>";
            $this->conexion->consulta($consulta);
            $resultado = $this->conexion->extraer_registro();
            $encontrados += $resultado['total']; 
        }
        // return $resultado && $resultado['total'] > 0; //$resultado (existe) AND $resultado['total']>0
        return $encontrados > 0;
    }  
    /* public function create (array $data):void{ PARA USAR CON LA CLASE BaseDatos de mysql
        //en un campo date, o int o uno que sea unique como matricula o bastidor de mysql no se puede guaradar un '' hay que guardar null. en los campos unique da error de que ya existe y en los date o int dice que el tipo no es correcto
        foreach ($data[vehiculo] as $campo => $valor) {//para todos los campos de la lista si existe y tiene '' le asigna null. Trim devuelve si es igual a '' o '  'y === significa igual calor e igual tipo
            if (isset($data['vehiculo'][$campo]) && trim($data['vehiculo'][$campo]) === '') {//trim nos dice si hay 1 o mas espacios en blanco, el usuario podria poner varios '   ' espacios y daria error
                $data['vehiculo'][$campo] = null;
            }
        }
        $campos = [];
        $valores = [];
        foreach ($data['vehiculo'] as $campo => $valor) {
            $campos[] = $campo;
            if (is_null($valor)) {
                $valores[] = "NULL";
            } else {
               // $valor_escapado = addslashes($valor); $valores[] = "'$valor_escapado'";
                $valores[] = "'{$valor}'";
            }
        }
        $fields = implode(", ", $campos);
        $values = implode(", ", $valores);
        $sql = "INSERT INTO vehiculos ($fields) VALUES ($values)";
        //echo "<pre>$sql</pre>";
        $this->conexion->consulta ($sql);
    } */ 

    /* public function create(array $data): void {PARA USAR CON LA CLASE PDO
    // Limpia campos vacíos
    foreach ($data[vehiculo] as $campo => $valor) {
        if (isset($data['vehiculo'][$campo]) && trim($data['vehiculo'][$campo]) === '') {
            $data['vehiculo'][$campo] = null;
        }
    }

    $campos = array_keys($data['vehiculo']);
    $placeholders = array_map(fn($campo) => ':' . $campo, $campos);

    $sql = "INSERT INTO vehiculos (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $placeholders) . ")";

    // Armar array de parámetros
    $parametros = [];
    foreach ($data['vehiculo'] as $campo => $valor) {
        $parametros[":$campo"] = $valor;
    }

    // Ejecutar la consulta preparada
    $this->conexion->consulta($sql, $parametros);
} */
    
    /* public function update (array $data): void{   PARA USAR CON LA CLASE BaseDatos de mysql    
        //en un campo date, o int o uno que sea unique como matricula o bastidor de mysql no se puede guaradar un '' hay que guardar null. en los campos unique da error de que ya existe y en los date o int dice que el tipo no es correcto    
        foreach ($data[vehiculo] as $campo => $valor) {//para todos los campos de la lista si existe y tiene '' le asigna null. Trim devuelve si es igual a '' o '  'y === significa igual calor e igual tipo
            if (isset($data['vehiculo'][$campo]) && trim($data['vehiculo'][$campo]) === '') {//trim nos dice si hay 1 o mas espacios en blanco, el usuario podria poner varios '   ' espacios y daria error
                $data['vehiculo'][$campo] = null;
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
        
        //echo 'final: <br/>';
        $this->conexion->consulta("UPDATE vehiculos SET $changes where id_vehiculo =".$data['vehiculo']['id_vehiculo']); //vease que se cierra la consulta con " y se concatena con . Esto se hace porque
        //para poner un array dentro de dobles comillas hay que quitar las comillas simples a los indices asociativos, y entonces falla en tiempo de ejecucion pk intenta hacer una conversion array to string  
    } */ 
   /* public function update(array $data): void { PARA USAR CON LA CLASE PDO
    // Limpia campos vacíos
    foreach ($data[vehiculo] as $campo => $valor) {
        if (isset($data['vehiculo'][$campo]) && trim($data['vehiculo'][$campo]) === '') {
            $data['vehiculo'][$campo] = null;
        }
    }

    // Extraer el ID y quitarlo del array de campos a actualizar
    $id = $data['vehiculo']['id_vehiculo'];
    unset($data['vehiculo']['id_vehiculo']);

    // Construir pares campo = :campo
    $asignaciones = [];
    foreach ($data['vehiculo'] as $campo => $_) {
        $asignaciones[] = "$campo = :$campo";
    }

    $sql = "UPDATE vehiculos SET " . implode(', ', $asignaciones) . " WHERE id_vehiculo = :id";

    // Armar parámetros
    $parametros = [':id' => $id];
    foreach ($data['vehiculo'] as $campo => $valor) {
        $parametros[":$campo"] = $valor;
    }

    // Ejecutar la consulta
    $this->conexion->consulta($sql, $parametros);
}
 */
}
?>