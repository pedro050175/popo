<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Alquiler;

class AlquilerRepository {

    private BaseDatosPDO $conexionPDO;
    private int $numPaginas;

    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
    }
    public function setnumpaginas(int $paginas){
        $this->numPaginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->numPaginas;
    }
    public function numeroPaginas(string $consulta) : int { //cuenta el numpero de paginas de 5 filas que tiene una $consultada
        $this->conexionPDO->consulta ($consulta);
        $registro = $this->conexionPDO->extraer_registro();
        $numFilas = $registro['num_filas'];
        intval($numFilas%FILAS_PAGINA)==0 ? $numeroPaginas = intval($numFilas/FILAS_PAGINA) : $numeroPaginas = intval(($numFilas/FILAS_PAGINA)+1);
        
        return $numeroPaginas;
    }
    public function findAll(): ?array {   
        
        $desplazamiento = 0;
        $this->numPaginas = $this->numeroPaginas("SELECT COUNT(*) as num_filas FROM alquileres");
        if (($_GET['num_pagina']) <= $this->numPaginas) {
            $numPagina = intval($_GET['num_pagina']);
            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
        }
        $buscar = $_GET['buscar'] ?? '';
        $ordenar= $_GET['ordenar'] ?? null;
        if ($buscar) {
            $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo, 
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                            WHERE AL.contrato LIKE '%$buscar%' OR V.Marca_modelo LIKE '%$buscar%' OR A.Nombre LIKE '%$buscar%'
                                            ORDER BY AL.fechaInicio desc");
        }else if ($ordenar) {
                $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                            ORDER BY $ordenar LIMIT $desplazamiento, ".FILAS_PAGINA);
                }else {
                    $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                            ORDER BY AL.fechaInicio LIMIT $desplazamiento, ".FILAS_PAGINA);
                }
        return $this->extraer_todos();    
    }
    public function extraer_todos(): ?array {
        $alquileres = [];
        $alquilerData = $this->conexionPDO->extraer_todos();
        foreach ($alquilerData as $data){
            $alquileres[] = Alquiler::fromArray($data);
        }
        return $alquileres;
    }
    public function extraer_registro(): ?Alquiler {
        return ($alquiler = $this->conexionPDO->extraer_registro()) ? Alquiler::fromArray($alquiler):null;
    }
    public function save (array $alquiler): string {
        if (isset($alquiler['id'])) {
            $this->update($alquiler);
            return $alquiler['id'];
        } else { 
            return $this->create($alquiler);
        }
    }
    public function create (array $alquiler):string{
        $parametros = [
            ':contrato'=> $alquiler['contrato'],
            ':vehiculo' => $alquiler['vehiculo'],
            ':cliente' => $alquiler['cliente'],
            ':fechaInicio' => $alquiler['fechaInicio'],
            ':fechaFin' => $alquiler['fechaFin'],
            ':kilometros' => $alquiler['kilometros'],
            ':kmInicio' => $alquiler['kmInicio'],
            ':kmFin' => $alquiler['kmFin'],
            ':dias' => $alquiler['dias'],
            ':precio' => $alquiler['precio'],
            ':precioKm' => $alquiler['precioKm'],
            ':fianza' => $alquiler['fianza'],
            ':fianzaDevuelta' => $alquiler['fianzaDevuelta'],
            ':comercial' => $alquiler['comercial'],
            ':empresa' => $alquiler['empresa'],
            ':ciudad' => $alquiler['ciudad'],
            ':entrega' => $alquiler['entrega'],
            ':comisionComercial' => $alquiler['comisionComercial'],
            ':ganancia' => $alquiler['ganancia'],
            ':observaciones' => $alquiler['observaciones'],
            ':estado' => $alquiler['estado'] ?? ''
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO alquileres (contrato, vehiculo, cliente, fechaInicio, fechaFin, kilometros, kmInicio, kmFin, dias, precio, precioKm, fianza, fianzaDevuelta, comercial, empresa, ciudad, entrega, comisionComercial, ganancia, observaciones, estado) VALUES 
                                         (:contrato,:vehiculo,:cliente,:fechaInicio,:fechaFin,:kilometros,:kmInicio,:kmFin,:dias,:precio,:precioKm,:fianza,:fianzaDevuelta,:comercial,:empresa,:ciudad,:entrega,:comisionComercial,:ganancia,:observaciones,:estado)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al ultimo creado
    }
    public function update (array $alquiler): void{ 
        $parametros = [
            ':id_alquiler'=> $alquiler['id'],
            ':contrato'=> $alquiler['contrato'],
            ':vehiculo' => $alquiler['vehiculo'],
            ':cliente' => $alquiler['cliente'],
            ':fechaInicio' => $alquiler['fechaInicio'],
            ':fechaFin' => $alquiler['fechaFin'],
            ':kilometros' => $alquiler['kilometros'],
            ':kmInicio' => $alquiler['kmInicio'],
            ':kmFin' => $alquiler['kmFin'],
            ':dias' => $alquiler['dias'],
            ':precio' => $alquiler['precio'],
            ':precioKm' => $alquiler['precioKm'],
            ':fianza' => $alquiler['fianza'],
            ':fianzaDevuelta' => $alquiler['fianzaDevuelta'],
            ':comercial' => $alquiler['comercial'],
            ':empresa' => $alquiler['empresa'],
            ':ciudad' => $alquiler['ciudad'],
            ':entrega' => $alquiler['entrega'],
            ':comisionComercial' => $alquiler['comisionComercial'],
            ':ganancia' => $alquiler['ganancia'],
            ':observaciones' => $alquiler['observaciones'],
            ':estado' => $alquiler['estado'] ?? ''
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE alquileres SET contrato = :contrato, vehiculo = :vehiculo, cliente = :cliente, fechaInicio = :fechaInicio, fechaFin = :fechaFin, kilometros = :kilometros, kmInicio = :kmInicio, kmFin = :kmFin, 
                                       dias = :dias, precio = :precio, precioKm = :precioKm, fianza = :fianza, fianzaDevuelta = :fianzaDevuelta,  comercial = :comercial, empresa = :empresa,
                                       ciudad = :ciudad, entrega = :entrega, comisionComercial = :comisionComercial, ganancia = :ganancia, observaciones = :observaciones, estado = :estado
                                     WHERE id_alquiler = :id_alquiler";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Alquiler {
        $this->conexionPDO->consulta("SELECT * FROM alquileres WHERE (id_alquiler=$id)");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM alquileres WHERE (id_alquiler=$id)");
    }  
}
?>