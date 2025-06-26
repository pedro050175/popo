<?php
namespace models;

class Entidad {
    
    function __construct (private int $id, private string $CIF_DNI, private string $Nombre, 
    private string $Apellidos,private string $Direccion, private string $Telefono,
    private string $Email){}

    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }
    public function getCIF_DNI(): string {
        return $this->CIF_DNI;
    }
    public function setCIF_DNI(string $cif_dni){
        $this->CIF_DNI = $cif_dni;
    }
    public function getNombre(): string {
        return $this->Nombre;
    }
    public function setNombre(string $nombre) {
        $this->Nombre = $nombre;
    }
    public function getApellidos(): String {
        return $this->Apellidos;
    }
    public function setApellidos(string $apellidos) {
        $this->Apellidos = $apellidos;
    }
    public function getDireccion(): string {
        return $this->Direccion;
    }
    public function setDireccion(string $direccion) {
        $this->Direccion = $direccion;
    }
    public function getTelefono(): string {
        return $this->Telefono;
    }
    public function setTelefono(string $telefono) {
        $this->Telefono = $telefono;
    }
    public function getEmail(): string {
        return $this->Email;
    }
    public function setEmail(string $email) {
        $this->Email = $email;
    }
    public static function fromArray(array $data): Entidad {
        return new Entidad ($data['id'], $data['CIF_DNI'], $data['nombre'], $data['Apellidos'], $data['Direccion'], $data['Telefono'], $data['Emil']); 
    }
}