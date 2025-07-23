<?php
namespace repositories;

use lib\BaseDatos;
use models\Alquiler;
use models\Alquiler_vehiculo;

class AlquilerRepository {

    private BaseDatos $conexion;

    public function __construct() {
        $this->conexion = new BaseDatos();
    }
    public function findAll(?int $id): ?array {   
        if ($id) { 
            $this->conexion->consulta ("SELECT alquileres.id_alquiler, alquileres.Contrato, alquileres.Fecha_inicio, alquileres.Fecha_fin, alquileres.Precio, alquileres.id_comercial, alquileres.Empresa,
                                        alquileres.Ciudad, vehiculos.Marca_modelo, vehiculos.Matricula FROM alquileres, vehiculos WHERE alquileres.Cliente=$id && alquileres.id_vehiculo=vehiculos.id_vehiculo");
        }else {
            $campo_ord= $_GET['ordenar'] ?? null;
            if ($campo_ord) {
                $this->conexion->consulta ("SELECT * FROM alquileres ORDER BY $campo_ord");
            }else {
                $busca = $_GET['buscar_nombre'] ?? null;
                if ($busca) {
                    //file_put_contents("log.txt", "busca: ". $busca. " \n" , FILE_APPEND);
                    $this->conexion->consulta ("SELECT * FROM alquileres WHERE Nombre LIKE '%$busca%'");
                }else {
                    $busca = $_GET['buscar_dnicif'] ?? null;
                    if ($busca) {
                        $this->conexion->consulta ("SELECT * FROM alquileres WHERE CIF_DNI LIKE '%$busca%'");
                    } else $this->conexion->consulta ("SELECT * FROM alquileres");
                }
            }
        }    
        return $this->extraer_todos();    
    }
    public function extraer_todos(): ?array {
        $alquileres = [];
        $alquilerData = $this->conexion->extraer_todos();
        foreach ($alquilerData as $data){
            $alquileres[] = Alquiler_vehiculo::fromArray($data);
        }
        //var_dump($alquilerData);
        return $alquileres;
    }
    public function extraer_registro(): ?Alquiler {
        return ($alquiler = $this->conexion->extraer_registro()) ? Alquiler::fromArray($alquiler):null;
    }
    public function save (array $alquiler):void {
        if (isset($alquiler['alquiler']['id_alquiler'])) {
            $this->update($alquiler);
        } else { $this->create($alquiler);}
    }
    public function create (array $alquiler):void{
        $fields = implode(',', array_keys($alquiler['alquiler']));
        $values = implode("', '", $alquiler['alquiler']);
        $this->conexion->consulta ("INSERT INTO alquiler ($fields) VALUES ('$values')");

    }
    public function update (array $alquiler): void{
        $updates=[];
        foreach ($alquiler['alquiler'] as $indice => $valor){
            $updates[] = "$indice='{$valor}'";
        }
        $changes=implode(', ', $updates);
        $this->conexion->consulta("UPDATE alquiler SET $changes where id =".$alquiler['alquiler']['id_alquiler']); //vease que se cierra la consulta con " y se concatena con . Esto se hace porque
        //para poner un array dentro de dobles comillas hay que quitar las comillas simples a los indices asociativos, y entonces falla en tiempo de ejecucion pk intenta hacer una conversion arry to string  
    }
    public function read (int $id): ?Alquiler {
        $this->conexion->consulta("SELECT * FROM alquiler WHERE (id_alquiler=$id)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexion->consulta("DELETE FROM alquiler WHERE (id_alquiler=$id)");
    }  
}
?>