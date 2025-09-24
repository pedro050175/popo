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
        if (($envia) or ($recibe) and ($invertir)) { //listado para analizar no lee los movimientos terminados
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
                                            WHERE A.Nombre LIKE '%$envia%' and B.Nombre LIKE '%$recibe%' and  M.terminado is null 
                                            ORDER BY M.fecha desc");//muestra los no terminados (terminado==null)
        } else if (($envia) or ($recibe)) {//listado para buscar
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
                                            ORDER BY M.fecha desc");
            } else {  //listado buscar 
                $buscar = $_GET['vehiculo_id'] ?? null;
                if ($buscar){
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
                                                WHERE M.idMovimiento LIKE '%$buscar%' OR V.Marca_modelo LIKE '%$buscar%' OR M.concepto LIKE '%$buscar%'               
                                            ORDER  BY m.fecha DESC");
                            } else {//por defecto
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
                                                ORDER BY m.fecha DESC LIMIT $desplazamiento, ".FILAS_PAGINA);            
                                    }
            }
        return $this->extraer_todos();    
    }
    public function deuda_empresas(string $empresa1, string $empresa2): ?int{
        //A.Nombre AS nombreEnvia, B.Nombre AS nombreRecibe, poniendo esto y el group de abajo sale el nombre de las 2 entidades
        $this->conexionPDO->consulta("SELECT    
                                SUM(COALESCE(E.totalImporte, 0) - COALESCE(D.totalImporte, 0)) AS deuda 
                                            FROM movimientos M
                                                LEFT JOIN entidad A ON M.envia = A.id_entidad
                                                LEFT JOIN entidad B ON M.recibe = B.id_entidad
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
                                                WHERE A.Nombre LIKE '%$empresa1%' and B.Nombre LIKE '%$empresa2%'");//GROUP BY A.Nombre, B.Nombre;    
        $deuda = $this->conexionPDO->extraer_registro(); //un unico registro que sera una tabla con un elemento que es la deuda total de entidad 2 con entidad 1
        return $deuda['deuda'];
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
    public function save (array $movimiento): string {
        if (isset($movimiento['movimiento']['idMovimiento'])) {
            $this->update($movimiento);
            return $movimiento['movimiento']['idMovimiento']; //devuelvo el id del movimiento para regresar a la pagina con el movimiento que se acaba de actualizar
        } else { return $this->create($movimiento);} //devuelvo el id del moim creado para regresar a la pagina con el movimiento que se acaba de actualizar
    }
    public function create (array $data):string{
        
        $parametros = [
            ':envia'=> $data['movimiento']['envia'],
            ':recibe' => $data['movimiento']['recibe'],
            ':fecha' => $data['movimiento']['fecha'],
            ':concepto' => $data['movimiento']['concepto'],
            ':vehiculo' => $data['movimiento']['vehiculo'] ?? '',
            ':observaciones' => $data['movimiento']['observaciones'],
            ':terminado' => (isset($data['movimiento']['terminado'])) ? 1 : 0
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO movimientos (envia, recibe, fecha, concepto, vehiculo, observaciones, terminado) VALUES 
                                         (:envia,:recibe,:fecha,:concepto,:vehiculo,:observaciones,:terminado)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al movimiento creado
    }

    public function update (array $data): void{ 
        $parametros = [
            ':idMovimiento'=> $data['movimiento']['idMovimiento'],
            ':envia'=> $data['movimiento']['envia'],
            ':recibe' => $data['movimiento']['recibe'],
            ':fecha' => $data['movimiento']['fecha'],
            ':concepto' => $data['movimiento']['concepto'],
            ':vehiculo' => $data['movimiento']['vehiculo'] ?? '',
            ':observaciones' => $data['movimiento']['observaciones'],  
            ':terminado' => (isset($data['movimiento']['terminado'])) ? 1 : 0    
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE movimientos SET envia = :envia, recibe = :recibe, fecha = :fecha, concepto = :concepto, vehiculo = :vehiculo, observaciones = :observaciones, terminado = :terminado
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