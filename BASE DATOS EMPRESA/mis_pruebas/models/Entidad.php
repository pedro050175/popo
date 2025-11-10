<?php
namespace models;
require_once "Funciones.php";

class Entidad {
    
    function __construct (private ?int $id_entidad, private ?string $CIF_DNI, private ?string $Nombre, 
                        private ?string $Observaciones, private ?string $Direccion, private ?string $Telefono,
                        private ?string $Email){}

    public function getId(): ?int {
        return $this->id_entidad;
    }
    public function getCIF_DNI(): ?string {
        return $this->CIF_DNI;
    }
    public function getNombre(): ?string {
        return $this->Nombre;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function getDireccion(): ?string {
        return $this->Direccion;
    }
    public function getTelefono(): ?string {
        return $this->Telefono;
    }
    public function getEmail(): ?string {
        return $this->Email;
    }
    //de esta forma aunque se siguen manejando obejtos, pero los campos que no se usan van a null y antes iban con '' ó con 0 
    public static function fromArray(array $data): Entidad {
        return new Entidad ($data['id_entidad'] ?? null, $data['CIF_DNI'] ?? null, $data['Nombre'] ?? null, $data['Observaciones'] ?? null, $data['Direccion'] ?? null, $data['Telefono'] ?? null, 
                            $data['Email'] ?? null);
    }
}