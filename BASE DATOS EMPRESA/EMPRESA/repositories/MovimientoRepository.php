<?php

namespace repositories;
use lib\BaseDatosPDO;
use models\Movimiento;

class MovimientoRepository{
    
    private BaseDatosPDO $conexionPDO;
    private int $numPaginas;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
    }

    public function setnumpaginas(int $paginas){
        $this->numPaginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->numPaginas;
    }
    public function numeroPaginas(string $consulta) : int { //cuenta el numpero de paginas de 5 filas que tiene una $consultada
        $numFilas = $this->conexionPDO->contarFilas ($consulta);
        intval($numFilas%FILAS_PAGINA)==0 ? $numeroPaginas = intval($numFilas/FILAS_PAGINA) : $numeroPaginas = intval(($numFilas/FILAS_PAGINA)+1);
        
        return $numeroPaginas;
    }
    public function findAll(): ?array {
        $desplazamiento = 0;
        $this->numPaginas = $this->numeroPaginas("SELECT COUNT(*) FROM movimientos");
        if (($_GET['num_pagina']) <= $this->numPaginas) {
            $numPagina = intval($_GET['num_pagina']);
            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
        }
        $campo_ord = $_GET['ordenar'] ?? null;
        if ($campo_ord) {
            $this->conexionPDO->consulta ("SELECT m.*, A.Nombre as NombreEnvia, B.Nombre as NombreRecibe, V.Marca_Modelo FROM movimientos M LEFT JOIN entidad A ON envia=A.id_entidad LEFT JOIN entidad B ON recibe=B.id_entidad LEFT JOIN vehiculos V ON vehiculo=V.id_vehiculo ORDER BY $campo_ord LIMIT $desplazamiento, ".FILAS_PAGINA);
        } else {
            $busca = $_GET['envia'] ?? null;
            $busca2 = $_GET['recibe'] ?? null;
            
            if (($busca) or ($busca2)) {
                $this->conexionPDO->consulta ("SELECT m.*, A.Nombre as NombreEnvia, B.Nombre as NombreRecibe, V.Marca_Modelo FROM movimientos M LEFT JOIN entidad A ON envia=A.id_entidad LEFT JOIN entidad B ON recibe=B.id_entidad LEFT JOIN vehiculos V ON vehiculo=V.id_vehiculo WHERE envia LIKE '%$busca%' and recibe LIKE '%$busca2%'");
            }else {
                $this->conexionPDO->consulta ("SELECT m.*, A.Nombre as NombreEnvia, B.Nombre as NombreRecibe, V.Marca_Modelo FROM movimientos M LEFT JOIN entidad A ON envia=A.id_entidad LEFT JOIN entidad B ON recibe=B.id_entidad LEFT JOIN vehiculos V ON vehiculo=V.id_vehiculo LIMIT $desplazamiento, ".FILAS_PAGINA);
            }
        }    
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Movimiento {
        return ($vehiculo = $this->conexionPDO->extraer_registro()) ? Movimiento::fromArray($vehiculo):null;
    }
    public function extraer_todos(): ?array {
        $vehiculos = [];
        $vehiculoData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($vehiculoData as $data){
            $vehiculos[] = Movimiento::fromArray($data);
        }
        return $vehiculos;
    }

}