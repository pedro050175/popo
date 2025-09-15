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
        $this->conexionPDO->consulta ($consulta);
        $registro = $this->conexionPDO->extraer_registro();
        $numFilas = $registro['num_filas'];
        intval($numFilas%FILAS_PAGINA)==0 ? $numeroPaginas = intval($numFilas/FILAS_PAGINA) : $numeroPaginas = intval(($numFilas/FILAS_PAGINA)+1);
        
        return $numeroPaginas;
    }
    public function findAll($invertir=false): ?array {
        $desplazamiento = 0;
        $this->numPaginas = $this->numeroPaginas("SELECT COUNT(*) as num_filas FROM movimientos");
        if (($_GET['num_pagina']) <= $this->numPaginas) {
            $numPagina = intval($_GET['num_pagina']);
            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
        }
        if ($invertir) {
            $recibe = $_GET['envia'] ?? null;
            $envia = $_GET['recibe'] ?? null;
        } else {
            $envia = $_GET['envia'] ?? null;
            $recibe = $_GET['recibe'] ?? null;
            }
        if (($envia) or ($recibe)) {
            $this->conexionPDO->consulta ("SELECT   M.*, A.Nombre AS nombreEnvia, B.Nombre AS nombreRecibe, V.Marca_modelo, C.Nombre AS nombrePropietario, 
                                                    COALESCE(E.totalImporte, 0) AS totalEntregas,
                                                    COALESCE(D.totalImporte, 0) AS totalDevoluciones,
                                                    COALESCE(E.totalImporte, 0) - COALESCE(D.totalImporte, 0) AS diferencia
                                            FROM movimientos M
                                                LEFT JOIN entidad A ON M.envia = A.id_entidad
                                                LEFT JOIN entidad B ON M.recibe = B.id_entidad
                                                LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
                                                LEFT JOIN entidad C ON V.propietario = C.id_entidad

                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM entregas
                                                    GROUP BY movimiento
                                                ) E ON M.idMovimiento = E.movimiento

                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM devoluciones
                                                    GROUP BY movimiento
                                                ) D ON M.idMovimiento = D.movimiento
                                            WHERE A.Nombre LIKE '%$envia%' and B.Nombre LIKE '%$recibe%'
                                            ORDER BY A.nombre");//OR A.Nombre LIKE '%$recibe%' and B.Nombre LIKE '%$envia%'
        }else {
            $this->conexionPDO->consulta ("SELECT   M.*, A.Nombre AS nombreEnvia, B.Nombre AS nombreRecibe, V.Marca_modelo, C.Nombre AS nombrePropietario, 
                                                    COALESCE(E.totalImporte, 0) AS totalEntregas,
                                                    COALESCE(D.totalImporte, 0) AS totalDevoluciones,
                                                    COALESCE(E.totalImporte, 0) - COALESCE(D.totalImporte, 0) AS diferencia
                                            FROM movimientos M
                                                LEFT JOIN entidad A ON M.envia = A.id_entidad
                                                LEFT JOIN entidad B ON M.recibe = B.id_entidad
                                                LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
                                                LEFT JOIN entidad C ON V.propietario = C.id_entidad

                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM entregas
                                                    GROUP BY movimiento
                                                ) E ON M.idMovimiento = E.movimiento

                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM devoluciones
                                                    GROUP BY movimiento
                                                ) D ON M.idMovimiento = D.movimiento                
                                            ORDER BY m.fecha LIMIT $desplazamiento, ".FILAS_PAGINA);            
            }    
        return $this->extraer_todos();    
    }
    public function extraer_registro(): ?Movimiento {
        return ($movimiento = $this->conexionPDO->extraer_registro()) ? Movimiento::fromArray($movimiento):null;
    }
    public function extraer_todos(): ?array {
        $movimientos = [];
        $movimientoData = $this->conexionPDO->extraer_todos();
        //var_dump($vehiculoData);
        foreach ($movimientoData as $data){
            $movimientos[] = Movimiento::fromArray($data);
        }
        return $movimientos;
    }
    public function save (array $movimiento):void {
        if (isset($movimiento['movimiento']['idMovimiento'])) {
            $this->update($movimiento);
        } else { $this->create($movimiento);}
    }
    public function create (array $data):void{
        
        $parametros = [
            ':envia'=> $data['movimiento']['envia'],
            ':recibe' => $data['movimiento']['recibe'],
            ':fecha' => $data['movimiento']['fecha'],
            ':concepto' => $data['movimiento']['concepto'],
            ':vehiculo' => $data['movimiento']['vehiculo'] ?? '',
            ':observaciones' => $data['movimiento']['observaciones']
        ];
        
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO movimientos (envia, recibe, fecha, concepto, vehiculo, observaciones) VALUES 
                                         (:envia,:recibe,:fecha,:concepto,:vehiculo,:observaciones)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function update (array $data): void{ 
        $parametros = [
            ':idMovimiento'=> $data['movimiento']['idMovimiento'],
            ':envia'=> $data['movimiento']['envia'],
            ':recibe' => $data['movimiento']['recibe'],
            ':fecha' => $data['movimiento']['fecha'],
            ':concepto' => $data['movimiento']['concepto'],
            ':vehiculo' => $data['movimiento']['vehiculo'] ?? '',
            ':observaciones' => $data['movimiento']['observaciones']        
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE movimientos SET envia = :envia, recibe = :recibe, fecha = :fecha, concepto = :concepto, vehiculo = :vehiculo, observaciones = :observaciones
                                     WHERE idMovimiento = :idMovimiento";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }

    public function read (int $id): ?Movimiento {
        $this->conexionPDO->consulta("SELECT * FROM movimientos WHERE (idMovimiento=$id)");
        return $this->extraer_registro();
    }
    public function detalles_movimiento (int $id): ?Movimiento{
        $this->conexionPDO->consulta("SELECT M.*, A.Nombre AS nombreEnvia, B.Nombre AS nombreRecibe, V.Marca_modelo, C.Nombre AS nombrePropietario FROM movimientos M 
                    LEFT JOIN entidad A ON M.envia = A.id_entidad
                    LEFT JOIN entidad B ON M.recibe = B.id_entidad
                    LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
                    LEFT JOIN entidad C ON V.propietario = C.id_entidad WHERE idMovimiento=$id");
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM movimientos WHERE (idMovimiento=$id)");
    }
}