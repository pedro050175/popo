<?php
namespace models;

require_once "Funciones.php";

class AmpliacionAlquiler {
    
    function __construct (private ?int $idAmpliacion, private ?string $fechaInicio, private ?string $fechaFin, private ?int $kilometros, private ?int $dias, private ?float $precio,  
                            private ?float $comisionComercial, private ?float $ganancia, private ?string $observaciones, private ?int $alquiler){}

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
    public function getprecio (): ?float {
        return $this->precio;
    } 
    public function getcomisionComercial (): ?float {
        return $this->comisionComercial;
    }
    public function getganancia(): ?float {
        return $this->ganancia;
    }
    public function getobservaciones(): ?string {
        return $this->observaciones;
    }
    public function getalquiler(): ?string {
        return $this->alquiler;
    }
    public static function fromArray(array $data): AmpliacionAlquiler {
        return new AmpliacionAlquiler ($data['idAmpliacion']??null, $data['fechaInicio']??null, $data['fechaFin']??null, $data['kilometros']??null, $data['dias']??null, $data['precio']??null,  
                                        $data['comisionComercial']??null, $data['ganancia']??null, $data['observaciones']??null, $data['alquiler']??null); 
    }
}