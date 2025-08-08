<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Foto;

class FotoRepository {

    private BaseDatosPDO $conexionPDO;
    
    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    
    public function fotos_vehiculo($id): ?array {
        $parametros = [':id' =>$id];
        $sql = "SELECT * FROM fotos WHERE id=:id";
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
    public function save (array $foto):void {
        if (isset($foto['foto']['id'])) {
            $this->update($foto);
        } else { $this->create($foto);}
    }

    public function create (array $data):void{
        
        $parametros = [
            ':url'=> $data['foto']['url'],
            ':destacada' => $data['foto']['destacada'] ?? 0,
            ':id_vehiculo' => $data['foto']['id_vehiculo'],
            ':descripcion' => $data['foto']['descripcion']       
        ];
        // Limpia
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO fotos (url, destacada, id_vehiculo, descripcion, VALUES 
                                     (:url, :destacada, :id_vehiculo, :descripcion)"; 
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $data): void{ 
        $parametros = [
            ':url'=> $data['foto']['url'],
            ':destacada' => $data['foto']['destacada'] ?? 0,
            ':id_vehiculo' => $data['foto']['id_vehiculo'],
            ':descripcion' => $data['foto']['descripcion'], 
            ':id' => $data['foto']['id']      
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE fotos SET url = :url, destacada = :destacada, id_vehiculo = :id_vehiculo, descripcion = :descripcion,
                                     WHERE id_foto = :id";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?Foto {
        $parametros = [':id' =>$id];
        $sql = "SELECT * FROM fotos WHERE id=:id";
        $this->conexionPDO->consulta("$sql, $parametros)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $parametros = [':id' =>$id];
       $sql = "DELETE FROM fotos WHERE id=:id"; 
       $this->conexionPDO->consulta($sql, $parametros);
    }
}