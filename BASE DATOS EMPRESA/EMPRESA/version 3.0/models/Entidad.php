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
    public function setId(?int $id) {
        $this->id_entidad = $id;
    }
    public function getCIF_DNI(): ?string {
        return $this->CIF_DNI;
    }
    public function setCIF_DNI(?string $cif_dni){
        $this->CIF_DNI = $cif_dni;
    }
    public function getNombre(): ?string {
        return $this->Nombre;
    }
    public function setNombre(?string $nombre) {
        $this->Nombre = $nombre;
    }
    public function getObservaciones(): ?string {
        return $this->Observaciones;
    }
    public function setObservaciones(?string $Observaciones) {
        $this->Observaciones = $Observaciones;
    }
    public function getDireccion(): ?string {
        return $this->Direccion;
    }
    public function setDireccion(?string $direccion) {
        $this->Direccion = $direccion;
    }
    public function getTelefono(): ?string {
        return $this->Telefono;
    }
    public function setTelefono(?string $telefono) {
        $this->Telefono = $telefono;
    }
    public function getEmail(): ?string {
        return $this->Email;
    }
    public function setEmail(?string $email) {
        $this->Email = $email;
    }
    /* he tenido que crear una tabla $modelo con todos los campos de la tabla entidad vacios, porque la tabla $data podria venir con menos campos si se hace un SELECT que no lleve el * 
    en el repositorio, para para ver solo algunos campos */
    public static function fromArray(array $data): Entidad {
        $modelo = duplicar_tabla (CAMPOS_ENTIDAD, $data); //CAMPOS_ENTIDAD tiene esto ('id' => 0, 'CIF_DNI' => '', 'Nombre' => '', 'Observaciones' => '', 'Direccion' => '', 'Telefono' =>'', 'Email' => ''); todos los campos
        return new Entidad ($modelo['id_entidad'], $modelo['CIF_DNI'], $modelo['Nombre'], $modelo['Observaciones'], $modelo['Direccion'], $modelo['Telefono'], $modelo['Email']); 
        //return new Entidad ($data['id_entidad'], $data['CIF_DNI'], $data['Nombre'], $data['Observaciones'], $data['Direccion'], $data['Telefono'], $data['Email'],); 
    }
}