<?php
namespace repositories;

use lib\BaseDatos;
use models\Entidad;

class EntidadRepository {

    private int $num_paginas;
    private BaseDatos $conexion;
    
    
    public function __construct() {
        $this->conexion = new BaseDatos();
        $this->num_paginas = 1;
    }
    public function setnumpaginas(int $paginas){
        $this->num_paginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->num_paginas;
    }
    public function findAll(): ?array { 
        $desplazamiento = 0;
        $this->num_paginas = numeroPaginas("SELECT COUNT(*) AS num_filas FROM entidad");
        $num_pagina = $_GET['num_pagina'] ?? 1;
        if (($num_pagina) <= $this->num_paginas) {
            $num_pagina = intval($num_pagina);
            $desplazamiento = ($num_pagina-1) * FILAS_PAGINA;
        }
        //file_put_contents("log.txt", "deplazamiento: ". $num_filas. "num paginas: ". $numero_paginas. " \n" , FILE_APPEND);
        //solo voy a paginar cuando se saca un listado de todas o se saca listado ordenado, cuando se hacen busquedas no pagino
        $campo_ord= $_GET['ordenar'] ?? null;
        if ($campo_ord) {
            $this->conexion->consulta ("SELECT * FROM entidad ORDER BY $campo_ord LIMIT $desplazamiento, ".FILAS_PAGINA);
        } else {
            $busca = $_GET['buscar_nombre'] ?? null;//si no se escribe en el campo formulario seria $_GET['buscar_nombre']=='' con lo que $busca=='' y luego en if ($busca) devuelve false porque cadena vacia en un if devuelve false
            if ($busca) {//no se puede poner directamente if ($_GET['buscar_nombre']) porque solo evaluamos si es o no '', pero no evaluamos si existe, si no existiera daria warning
                $this->conexion->consulta ("SELECT * FROM entidad WHERE Nombre LIKE '%$busca%'");
            } else {
                $busca = $_GET['buscar_dnicif'] ?? null;
                if ($busca) {
                    $this->conexion->consulta ("SELECT * FROM entidad WHERE CIF_DNI LIKE '%$busca%'");
                } else $this->conexion->consulta ("SELECT * FROM entidad LIMIT $desplazamiento, ".FILAS_PAGINA); //ojo con los nombres de los campos si se hace un SELECT de ciertos campos, hay que poner el nombre tal y como esta en la base de datos
            }
        }    
        return $this->extraer_todos();    
    }
    public function listReducida(): ?array{    
        $this->conexion->consulta ("SELECT id_entidad, Nombre FROM entidad ORDER BY Nombre");
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
        if (isset($entidad['entidad']['id_entidad'])) {
            $this->update($entidad);
        } else { $this->create($entidad);}
    }
    public function create (array $entidad):void{
        $fields = implode(',', array_keys($entidad['entidad']));
        foreach ($entidad['entidad'] as $indice => $valor){
            $valor_escapado = addslashes($valor);//esto es por si el valor que inserta el usuario en el formulario lleva 'xxx' le pone \'xxx\' lo escapa, si no lo escapara no se insertaria correctamente porque confundiria las 'xxx' con los delimitadores de campo de la consulta sql
            $entidad['entidad'][$indice] = $valor_escapado;
        }
        $values = implode("', '", $entidad['entidad']);$fields = implode(',', array_keys($entidad['entidad']));
        $this->conexion->consulta ("INSERT INTO entidad ($fields) VALUES ('$values')");
    }
    public function update (array $entidad): void{
        $updates=[];
        foreach ($entidad['entidad'] as $indice => $valor){
            $valor_escapado = addslashes($valor); //esto es por si el valor que inserta el usuario en el formulario lleva 'xxx' le pone \'xxx\' lo escapa, si no lo escapara no se insertaria correctamente porque confundiria las 'xxx' con los delimitadores de campo de la consulta sql
            $updates[] = "$indice='$valor_escapado'";
        }
        $changes=implode(', ', $updates);
        $this->conexion->consulta("UPDATE entidad SET $changes where id_entidad =".$entidad['entidad']['id_entidad']); //vease que se cierra la consulta con " y se concatena con . Esto se hace porque
        //para poner un array dentro de dobles comillas hay que quitar las comillas simples a los indices asociativos, y entonces falla en tiempo de ejecucion pk intenta hacer una conversion arry to string  
    }
    public function read (int $id): ?Entidad {
        $this->conexion->consulta("SELECT * FROM entidad WHERE (id_entidad=$id)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexion->consulta("DELETE FROM entidad WHERE (id_entidad=$id)");
    }
    public function relacionados(int $id): string {
        $relacionada = ""; //he definido una constante de tipo array asociativo que contiene   
        foreach (TABLAS_ENTIDAD as $tabla => $campos){
            foreach ($campos as $campo){
                $consulta = "SELECT COUNT(*) as total FROM $tabla WHERE $campo = $id";
                $this->conexion->consulta($consulta);
                $resultado = $this->conexion->extraer_registro();
                if ($resultado['total'] > 0) {
                    $relacionada .= "Tabla: $tabla Campo: $campo Registros: ". $resultado['total']; 
                }
            } 
        }
        return $relacionada;
    }    
}
?>