<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Foto;

class FotoRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    
    public function fotos_vehiculo(int $id): ?array {
        $parametros = [':id' =>$id];
        $sql = "SELECT * FROM fotos WHERE id_vehiculo=:id";
        $this->conexionPDO->consulta ($sql, $parametros);
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Foto {
        return ($foto = $this->conexionPDO->extraer_registro()) ? foto::fromArray($foto):null;
    }
    public function extraer_todos(): ?array {
        $fotos = [];
        $fotoData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($fotoData as $data){
            $fotos[] = Foto::fromArray($data);
        }
        return $fotos;
    }
    public function save (array $foto, array $imagen):void {
        if (isset($foto['foto']['id'])) {
            $this->update($foto, $imagen);
        } else { $this->create($foto, $imagen);}
    }

    public function create (array $foto, array $imagen):void{
        
        $parametros = [
            ':url'=> $imagen['name'],
            ':destacada' => (isset($foto['destacada'])) ? 1 : '',
            ':id_vehiculo' => $foto['id_vehiculo'],
            ':descripcion' => $foto['descripcion']       
        ];
        // Limpia
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO fotos (url, destacada, id_vehiculo, descripcion) VALUES 
                                     (:url, :destacada, :id_vehiculo, :descripcion)"; 
        echo "$sql <br/>";
        print_r($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        //move_uploaded_file($imagen['tmp_name'], RUTA_FOTOS); //'RUTA_FOTOS', "/mis_pruebas/fotos/"
    }

    public function update (array $foto, array $imagen): void{ 
        $parametros = [
            ':url'=> $imagen['foto']['url'],
            ':destacada' => $foto['foto']['destacada'] ?? '',
            ':id_vehiculo' => $foto['foto']['id_vehiculo'],
            ':descripcion' => $foto['foto']['descripcion'], 
            ':id' => $foto['foto']['id']      
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE fotos SET url = :url, destacada = :destacada, id_vehiculo = :id_vehiculo, descripcion = :descripcion,
                                     WHERE id_foto = :id";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?Foto {
        $parametros = [':id' =>$id];
        $sql = "SELECT * FROM fotos WHERE id_vehiculo=:id";
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $parametros = [':id' =>$id];
       $sql = "DELETE FROM fotos WHERE id_vehiculo=:id"; 
       $this->conexionPDO->consulta($sql, $parametros);
    }
}