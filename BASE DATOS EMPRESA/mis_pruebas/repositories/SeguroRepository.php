<?php
namespace repositories;
use lib\BaseDatosPDO;
use models\Seguro;

class SeguroRepository{
    private BaseDatosPDO $conexionPDO;
    private int $numPaginas;

    function __construct(){
        $this->conexionPDO = new BaseDatosPDO();
        $this->numPaginas = 1;
    }
    public function setnumpaginas(int $paginas){
        $this->numPaginas = $paginas;
    }
    public function getnumpaginas():int{
        return $this->numPaginas;
    }
    /* cuando la fecha de la tabla sql es nula porque no se ha introducido nada, el select no lee esa fila 
    si se busca por ese campo,pero es logico ya qe si filtro por una fecha de venta pero no se ha vendido 
    no debe salir*/
    public function findAllDinamico(): ?array {
        $num_pagina = $_GET['num_pagina'] ?? 1;
        $numPagina = intval($num_pagina);
        $desplazamiento = ($numPagina - 1) * FILAS_PAGINA;
        $coche = $_GET['coche'] ?? '';
        $otroRiesgo = $_GET['otro'] ?? '';
        $tomador = $_GET['tomador'] ?? '';
        $compania = $_GET['compania'] ?? '';
        $desde = $_GET['desde'] ?? '';
        $hasta = $_GET['hasta'] ?? '';
        $sql = "SELECT S.*, VV.Marca_modelo, VV.Matricula, VV.Bastidor, E.Nombre,
            COUNT(*) OVER() AS totalFilas 
            FROM seguros S
            JOIN vehiculos VV ON S.vehiculo = VV.id_vehiculo
            JOIN entidad E ON S.tomador = E.id_entidad
            WHERE (VV.Marca_modelo LIKE CONCAT('%', ?, '%')
                OR VV.Matricula LIKE CONCAT('%', ?, '%')
                OR VV.Bastidor LIKE CONCAT('%', ?, '%'))
            AND COALESCE(S.otroRiesgo,'') LIKE CONCAT('%', ?, '%')
            AND COALESCE(E.Nombre,'') LIKE CONCAT('%', ?, '%')
            AND (COALESCE(S.compania,'') LIKE CONCAT('%', ?, '%') 
            OR COALESCE(S.mediador,'') LIKE CONCAT('%', ?, '%'))";
        $params = [$coche, $coche, $coche, $otroRiesgo, $tomador, $compania, $compania];
        if (!empty($desde) && !empty($hasta)) {
            $sql .= " AND S.fecha >= ? AND S.fecha <= ? ";
            $params[] = $desde;
            $params[] = $hasta;
        }         
        if (!empty($desde) && empty($hasta)) {
            $sql .= " AND S.fecha >= ? ";
            $params[] = $desde;
        } elseif (empty($desde) && !empty($hasta)) {
            $sql .= " AND S.fecha <= ? ";
            $params[] = $hasta;
            }
        $desplazamiento = intval($desplazamiento);
        $filasPagina   = intval(FILAS_PAGINA);
        $sql .= " ORDER BY (S.baja = 1), S.fecha DESC LIMIT $desplazamiento, $filasPagina";
        //s.baja=1 es una comparacion, los que esta de baja dan true en la comparacion y los pone al final
        $this->conexionPDO->consulta($sql, $params);
        $resultado = $this->extraer_todos($filasLeidas);
        $this->numPaginas = $filasLeidas > 0 ? ceil($filasLeidas / FILAS_PAGINA) : 1; /* ceil redondea al entero mayor, si la division da 2,3 devuelve 3 */
        return $resultado;
    }
    public function extraer_registro(): ?Seguro {
        return ($compraventa = $this->conexionPDO->extraer_registro()) ? Seguro::fromArray($compraventa):null;
    }
    public function extraer_todos(? int &$filasLeidas = null): ?array {
        $compraventas = [];
        $compraventaData = $this->conexionPDO->extraer_todos();
        $filasLeidas = $compraventaData[0]['totalFilas'] ?? 0; /* $filasLeidas se pasa por referencia, se usa para paginacion */
        foreach ($compraventaData as $data){
            $compraventas[] = Seguro::fromArray($data);
        }
        return $compraventas;
    }
    public function save (array $seguro): string {
        if (isset($seguro['idSeguro'])) {
            $this->update($seguro);
            return $seguro['idSeguro']; //devuelvo el id del compraventa para regresar a la pagina con el movimiento que se acaba de actualizar
        } else { return $this->create($seguro);} //devuelvo el id del compraventa creado para regresar a la pagina con el movimiento que se acaba de actualizar
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM seguros WHERE (idSeguro=$id)");
    }
    public function create (array $data):string{
        $parametros = [
            ':poliza'=> $data['poliza'],
            ':vehiculo' => $data['vehiculo'] ?? '',
            ':otroRiesgo' => $data['otroRiesgo'],
            ':importe' => $data['importe'],
            ':fecha' => $data['fecha'],
            ':vencimiento' => $data['vencimiento'],
            ':periodo' => $data['periodo'],
            ':tomador' => $data['tomador'],
            ':cuentaBanco' => $data['cuentaBanco'],
            ':compania' => $data['compania'],
            ':mediador' => $data['mediador'],
            ':fechaBaja'=> $data['fechaBaja'],
            ':motivoBaja' => $data['motivoBaja'],
            ':baja' => (isset($data['baja'])) ? 1 : 0,
            ':comentarios' => $data['comentarios']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO seguros ( poliza, vehiculo, otroRiesgo, importe, fecha, vencimiento, periodo, tomador, cuentaBanco, compania, 
                                            mediador, fechaBaja, motivoBaja, baja, comentarios) VALUES 
                                         (:poliza, :vehiculo, :otroRiesgo, :importe, :fecha, :vencimiento, :periodo, :tomador, :cuentaBanco, :compania, 
                                            :mediador, :fechaBaja, :motivoBaja, :baja, :comentarios)"; 
       
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al movimiento creado
    }
    public function update (array $data): void{ 
        $parametros = [
            ':idSeguro'=> $data['idSeguro'],
            ':poliza'=> $data['poliza'],
            ':vehiculo' => $data['vehiculo'] ?? '',
            ':otroRiesgo' => $data['otroRiesgo'],
            ':importe' => $data['importe'],
            ':fecha' => $data['fecha'],
            ':vencimiento' => $data['vencimiento'],
            ':periodo' => $data['periodo'],
            ':tomador' => $data['tomador'],
            ':cuentaBanco' => $data['cuentaBanco'],
            ':compania' => $data['compania'],
            ':mediador' => $data['mediador'],
            ':fechaBaja'=> $data['fechaBaja'],
            ':motivoBaja' => $data['motivoBaja'],
            ':baja' => (isset($data['baja'])) ? 1 : 0,
            ':comentarios' => $data['comentarios']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE seguros SET poliza=:poliza, vehiculo=:vehiculo, otroRiesgo=:otroRiesgo, importe=:importe, fecha=:fecha, 
                                        vencimiento=:vencimiento, periodo=:periodo, tomador=:tomador, cuentaBanco=:cuentaBanco, compania=:compania, mediador=:mediador, 
                                        fechaBaja=:fechaBaja, motivoBaja=:motivoBaja, baja=:baja, comentarios=:comentarios
                                     WHERE idSeguro = :idSeguro";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Seguro {
        $this->conexionPDO->consulta("SELECT S.*, V.Marca_modelo, V.Matricula, V.Bastidor
                                        FROM seguros S
                                        JOIN vehiculos V ON S.vehiculo = V.id_vehiculo
                                        WHERE (idSeguro=$id)");        
        return $this->extraer_registro();
    }

}