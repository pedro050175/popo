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
        
        $ok = $this->conexionPDO->consulta($sql, $parametros);
        $carpetaDestino = __DIR__ ."/../fotos_vehiculo/";// __DIR__ constante de PHP que devuelve la ruta absoluta del directorio donde está el archivo PHP actual
        //en mi caso tiene /srv/www/api/mis_pruebas/repositories/FotoRepository.php  /../fotos/ con .. sale de repositories y pone /fotos al final obtengo /srv/www/api/mis_pruebas/fotos/ que es donde estan las fotos en el servidor
        //podria usar la constante FOTOS_VEHICULOS_SERVIDOR pero dejo esto porque es interesante
        if ($ok) {//si se inserta la foto en la BBDD
            if (!is_dir($carpetaDestino)) {//si no existe la carpeta de destino la crea
            mkdir($carpetaDestino, 0777, true);
            }
            //a la foto le pongo el numero del id de la foto insertada para que no coincida con otras fotos de la caperpeta fotos
            $id_ultimo_insertado = $this->conexionPDO->id_ultimo_insertado();
            $obj_foto = new Foto ($id_ultimo_insertado, $imagen['name'], 0, $foto['id_vehiculo'], $foto['descripcion']);//para poder usar la funcion get_nombre_foto_server tengo que crear un objeto clase Foto
            $nombre = $obj_foto->nombre_foto_server();
            $Destino=$carpetaDestino.$nombre;//destino es la carpeta y el nombre del archivo
            
            if (!@move_uploaded_file($imagen['tmp_name'], $Destino)){//si falla el traslado de la foto a la carpeta fotos borro el registro de la base de datos. 
                //la @ es para que no salgan warning en pantalla al fallar la copia del archivo
                $parametros = [':id' => $id_ultimo_insertado];
                $sql = "DELETE FROM fotos WHERE id=:id"; 
                $this->conexionPDO->consulta($sql, $parametros);
            }
        }
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
       $sql = "DELETE FROM fotos WHERE id=:id"; 
       $this->conexionPDO->consulta($sql, $parametros);
    }
}