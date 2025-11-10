<?php
namespace repositories;
use models\Multa;
use lib\BaseDatosPDO;

class MultaRepository{
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
    public function extraer_registro(): ?Multa {
        return ($compraventa = $this->conexionPDO->extraer_registro()) ? Multa::fromArray($compraventa):null;
    }
    public function extraer_todos(? int &$filasLeidas = null): ?array {
        $compraventas = [];
        $compraventaData = $this->conexionPDO->extraer_todos();
        $filasLeidas = $compraventaData[0]['totalFilas'] ?? 0; /* $filasLeidas se pasa por referencia, se usa para paginacion */
        foreach ($compraventaData as $data){
            $compraventas[] = Multa::fromArray($data);
        }
        return $compraventas;
    }
    public function findAll(): ?array {
        $num_pagina = $_GET['num_pagina'] ?? 1;
        $numPagina = intval($num_pagina);
        $desplazamiento = ($numPagina - 1) * FILAS_PAGINA;
        $coche = $_GET['coche'] ?? '';
        $desde = $_GET['desde'] ?? '';
        $hasta = $_GET['hasta'] ?? '';
        $parametros = [$coche, $coche];
        $sql = "SELECT M.*, V.Marca_modelo, V.Matricula FROM multas M
                    JOIN vehiculos V ON V.id_vehiculo = M.vehiculo
                    WHERE (V.Marca_modelo LIKE CONCAT('%', ?, '%')
                    OR V.Matricula LIKE CONCAT ('%', ?, '%'))";
        
        if (!empty($desde) && !empty($hasta)){
             $sql .= " AND M.fecha >= ? AND M.fecha <= ? ";
            $parametros[] = $desde; 
            $parametros[] = $hasta; 
        } elseif (!empty($desde) && empty($hasta)){
            $sql .= " AND M.fecha >= ? ";
            $parametros[] = $desde;  
            } elseif (empty($desde) && !empty($hasta)){
                $sql .= " AND M.fecha <= ? ";
                $parametros[] = $hasta;  
                }
       
        $desplazamiento = intval($desplazamiento);
        $filasPagina   = intval(FILAS_PAGINA);
        $sql .= " ORDER BY M.terminada, M.fecha DESC, V.Marca_modelo LIMIT $desplazamiento, $filasPagina";
        $this->conexionPDO->consulta($sql, $parametros);
        $resultado = $this->extraer_todos($filasLeidas);
        $this->numPaginas = $filasLeidas > 0 ? ceil($filasLeidas / FILAS_PAGINA) : 1;
        return $resultado;
    }
    public function save (array $multa): string {
        if (isset($multa['idMulta'])) {
            $this->update($multa);
            return $multa['idMulta']; //devuelvo el id de la multa para regresar a la pagina con el movimiento que se acaba de actualizar
        } else { return $this->create($multa);} //devuelvo el id del multa creado para regresar a la pagina con el movimiento que se acaba de actualizar
    }
    public function create (array $data):string{
        
        $parametros = [
            ':expediente'=> $data['expediente'],
            ':fecha' => $data['fecha'],
            ':importe' => $data['importe'],
            ':importePagado' => $data['importePagado'],
            ':fechaPago' => $data['fechaPago'],
            ':pagaDesde' => $data['pagaDesde'],
            ':identificar' => (isset($data['identificar'])) ? 1 : 0,
            ':fechaIdentificada' => $data['fechaIdentificada'],
            ':vencimiento' => $data['vencimiento'],
            ':vehiculo' => $data['vehiculo'],
            ':lugar' => $data['lugar'],
            ':importeCobrado' => $data['importeCobrado'],
            ':conductor' => $data['conductor'],
            ':conductorIdentificado' => $data['conductorIdentificado'],
            ':terminada' => (isset($data['terminada'])) ? 1 : 0,
            ':comentarios' => $data['comentarios']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO multas (expediente, fecha, importe, importePagado, fechaPago, pagaDesde, identificar, fechaIdentificada, vencimiento, vehiculo, 
                                            lugar, importeCobrado, conductor, conductorIdentificado, terminada, comentarios) VALUES 
                                         (:expediente, :fecha, :importe, :importePagado, :fechaPago, :pagaDesde, :identificar, :fechaIdentificada, :vencimiento, :vehiculo, 
                                            :lugar, :importeCobrado, :conductor, :conductorIdentificado, :terminada, :comentarios)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al movimiento creado
    }
    public function update (array $data): void{ 
        $parametros = [
            ':idMulta'=> $data['idMulta'],
            ':expediente'=> $data['expediente'],
            ':fecha' => $data['fecha'],
            ':importe' => $data['importe'],
            ':importePagado' => $data['importePagado'],
            ':fechaPago' => $data['fechaPago'],
            ':pagaDesde' => $data['pagaDesde'],
            ':identificar' => (isset($data['identificar'])) ? 1 : 0,
            ':fechaIdentificada' => $data['fechaIdentificada'],
            ':vencimiento' => $data['vencimiento'],
            ':vehiculo' => $data['vehiculo'],
            ':lugar' => $data['lugar'],
            ':importeCobrado' => $data['importeCobrado'],
            ':conductor' => $data['conductor'],
            ':conductorIdentificado' => $data['conductorIdentificado'],
            ':terminada' => (isset($data['terminada'])) ? 1 : 0,
            ':comentarios' => $data['comentarios']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE multas SET expediente=:expediente, fecha=:fecha, importe=:importe, importePagado=:importePagado, fechaPago=:fechaPago, 
                                        pagaDesde=:pagaDesde, identificar=:identificar, fechaIdentificada=:fechaIdentificada, vencimiento=:vencimiento, vehiculo=:vehiculo, lugar=:lugar, 
                                        importeCobrado=:importeCobrado, conductor=:conductor, conductorIdentificado=:conductorIdentificado, terminada=:terminada, comentarios=:comentarios
                                     WHERE idMulta = :idMulta";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Multa {
        /*leo tmb datos de tablas relacionadas para que esta funcion read me sirva para ver los detalles de una compraventa 
        se usa en nueva_compraventa, los totales de pagos, cobros y gastos no los necesito porque tengo que leer esas tablas para mostar todas las lineas, asi que con esos datos 
        sumare y calculo*/
        $this->conexionPDO->consulta("SELECT M.* 
                                        FROM multas M 
                                        LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
                                            WHERE (idMulta=$id)");        
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM multas WHERE (idMulta=$id)");
    }  
}

?>