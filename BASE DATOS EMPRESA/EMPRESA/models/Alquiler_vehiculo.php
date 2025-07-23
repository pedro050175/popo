<?php

namespace models;
use models\Alquiler;
use lib\duplicar_tabla;

class Alquiler_vehiculo extends Alquiler {
        
    function __construct (int $id_alquiler, string $Contrato, int $id_vehiculo, int $Cliente, string $Fecha_inicio, ?string $Fecha_fin, ?int $Km, ?int $Km_inicio, ?int $Km_fin, ?string $Dias,
                          ?int $Precio, ?int $Precio_km, ?int $id_comercial, ?int $Empresa, ?string $Ciudad, ?string $Entrega, ?int $Comision_comercial, ?int $Ganancia,
                          ?string $Observaciones, private string $Marca_modelo, private ?string $Matricula){
                            
                            parent::__construct($id_alquiler, $Contrato, $id_vehiculo, $Cliente, $Fecha_inicio, $Fecha_fin, $Km, $Km_inicio, $Km_fin, $Dias, $Precio, $Precio_km, $id_comercial,
                                                $Empresa, $Ciudad, $Entrega, $Comision_comercial, $Ganancia, $Observaciones);
                          }
    
    public function getMarca_modelo(): string {
        return $this->Marca_modelo;
    }
    public function setMarca_modelo(string $marca_modelo) {
        $this->Marca_modelo = $marca_modelo;
    }

    public function getMatricula(): ?string {
        return $this->Matricula;
    }
    public function setMatricula(?string $matricula) {
        $this->Matricula = $matricula;
    }
    public static function fromArray(array $data): Alquiler_vehiculo {
        
        $modelo = duplicar_tabla::duplica (CAMPOS_ALQUILER_VEHICULO, $data);
        return new Alquiler_vehiculo ($modelo['id_alquiler'], $modelo['Contrato'], $modelo['id_vehiculo'], $modelo['Cliente'], $modelo['Fecha_inicio'], $modelo['Fecha_fin'], $modelo['Km'],
        $modelo['Km_inicio'], $modelo['Km_fin'], $modelo['Dias'], $modelo['Precio'], $modelo['Precio_km'], $modelo['id_comercial'], $modelo['Empresa'],
        $modelo['Ciudad'], $modelo['Entrega'], $modelo['Comision_comercial'], $modelo['Ganancia'], $modelo['Observaciones'], $modelo['Marca_modelo'], $modelo['Matricula']); 
    }    
}

?>