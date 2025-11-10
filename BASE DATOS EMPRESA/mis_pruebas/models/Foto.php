<?php
namespace models;
require_once "Funciones.php";

class Foto {

    function __construct(private ?int $id, private ?string $url, private ?bool $destacada, private ?int $id_vehiculo, private ?string $descripcion){}

    public function nombre_foto_server(): string{
        preg_match('/\.[a-zA-Z]+$/', $this->url, $extension);//saca la extension del nombre 
        return $this->id.$extension[0];//concatena id+extension y ya tiene el nombre del archivo para guardar en el servidor
    }
    public function getid(): ?int {
        return $this->id;
    }
    public function geturl(): ?string {
        return $this->url;
    }
    public function getdestacada(): ?int {
        return $this->destacada;
    }
    public function getid_vehiculo(): ?int {
        return $this->id_vehiculo;
    }
    public function getdescripcion(): ?string {
        return $this->descripcion;
    }
    public static function fromArray(array $data): Foto {
        return new Foto ($data['id']??null, $data['url']??null, $data['destacada']??null, $data['id_vehiculo']??null, $data['descripcion']??null); 
    }

}