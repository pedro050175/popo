<?php
namespace models;
require_once "Funciones.php";

class Foto {

    function __construct(private ?int $id, private ?string $url, private ?bool $destacada, private ?int $id_vehiculo, private ?string $descripcion){}

    public function nombre_foto_server(): string{
        preg_match('/\.[a-zA-Z]+$/', $this->url, $extension);//saca la extensdion del nombre 
        return $this->id.$extension[0];//concatena id+extension y ya tiene el nombre del archivo para guardar en el servidor
    }
    public function setid(?int $id) {
        $this->id = $id;
    }
    public function getid(): ?int {
        return $this->id;
    }
    public function seturl(?string $url) {
        $this->url = $url;
    }
    public function geturl(): ?string {
        return $this->url;
    }
    public function setdestacada(?int $destacada) {
        $this->destacada = $destacada;
    }
    public function getdestacada(): ?int {
        return $this->destacada;
    }
    public function setid_vehiculo(?int $id_vehiculo) {
        $this->id = $id_vehiculo;
    }
    public function getid_vehiculo(): ?int {
        return $this->id_vehiculo;
    }
    public function setdescripcion(?string $descripcion) {
        $this->id = $descripcion;
    }
    public function getdescripcion(): ?string {
        return $this->descripcion;
    }

    public static function fromArray(array $data): Foto {
        
        $modelo = duplicar_tabla(CAMPOS_FOTO, $data);
        //var_dump($data);
        return new Foto ($modelo['id'], $modelo['url'], $modelo['destacada'], $modelo['id_vehiculo'], $modelo['descripcion']); 
    }

}