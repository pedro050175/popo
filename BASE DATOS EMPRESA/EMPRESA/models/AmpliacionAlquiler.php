<?php
namespace models;

require_once "Funciones.php";

class AmpliacionAlquiler {
    
    function __construct (private ?int $idAmpliacion, private ?string $fechaInicio, private ?string $fechaFin, private ?int $kilometros, private ?string $dias, private ?int $precio,  
                            private ?int $comisionComercial, private ?int $ganancia, private ?string $observaciones, private ?int $alquiler){}

    public function getidAmpliacion(): ?int {
        return $this->idAmpliacion;
    }
    public function getfechaInicio(): ?string {
        return $this->fechaInicio;
    }
    public function getfechaFin(): ?string {
        return $this->fechaFin;
    }
    public function getkilometros(): ?int {
        return $this->kilometros;
    }
    public function getdias (): ?int {
        return $this->dias;
    }
    public function getprecio (): ?int {
        return $this->precio;
    } 
    public function getcomisionComercial (): ?int {
        return $this->comisionComercial;
    }
    public function getganancia(): ?int {
        return $this->ganancia;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public function getalquiler(): ?string {
        return $this->alquiler;
    }
    public static function fromArray(array $data): AmpliacionAlquiler {
        $modelo = duplicar_tabla (CAMPOS_AMPLIACION, $data);
        return new AmpliacionAlquiler ($modelo['idAmpliacion'], $modelo['fechaInicio'], $modelo['fechaFin'], $modelo['dias'], $modelo['kilometros'], $modelo['precio'], $modelo['ganancia'], 
                                        $modelo['comisionComercial'], $modelo['observaciones'], $modelo['alquiler']); 
    }
}