<?php
namespace repositories;

use lib\BaseDatosPDO;
use models\Alquiler;

class AlquilerRepository {

    private BaseDatosPDO $conexionPDO;
    private int $numPaginas;

    public function __construct() {
        $this->conexionPDO = new BaseDatosPDO();
        $this->numPaginas = 1;
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
    public function alquileresVehiculo(){
        if (!empty($_GET['cocheId'])){//listado para analisis, se usa el id del coche para buscar alquileres en lugar del nombre
                    $desde = $_GET['desde'];
                    $hasta = $_GET['hasta'];
                    $coche = $_GET['cocheId']; 
                    $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                            COALESCE(AM.sumaPrecio, 0) AS sumaPrecio,
                                            COALESCE(AM.sumaDias, 0) AS sumaDias,
                                            COALESCE(AM.sumaKilometros, 0) AS sumaKilometros,
                                            COALESCE(AM.sumaGanancia, 0) AS sumaGanancia,
                                            COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial 
                                    FROM alquileres AL
                                        LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                        LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                        LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                        LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                    SUM(dias) AS sumaDias,
                                                                    SUM(kilometros) AS sumaKilometros,
                                                                    SUM(ganancia) AS sumaGanancia,
                                                                    SUM(comisionComercial) AS sumaComisionComercial
                                                    FROM ampliaciones
                                                    GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler    
                                    WHERE AL.fechaInicio BETWEEN '$desde' AND '$hasta' AND AL.vehiculo = '$coche'");                   
        }
        return $this->extraer_todos();                    
    }
    public function findAll(): ?array {   
        $buscar = $_GET['buscar'] ?? '';
        if ($buscar) {
            $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                                    COALESCE(AM.sumaPrecio, 0) AS sumaPrecio,
                                                    COALESCE(AM.sumaDias, 0) AS sumaDias,
                                                    COALESCE(AM.sumaKilometros, 0) AS sumaKilometros,
                                                    COALESCE(AM.sumaGanancia, 0) AS sumaGanancia,
                                                    COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial 
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                                LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                            SUM(dias) AS sumaDias,
                                                                            SUM(kilometros) AS sumaKilometros,
                                                                            SUM(ganancia) AS sumaGanancia,
                                                                            SUM(comisionComercial) AS sumaComisionComercial
                                                            FROM ampliaciones
                                                            GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler    
                                            WHERE AL.contrato LIKE '%$buscar%' OR A.Nombre LIKE '%$buscar%'
                                            ORDER BY AL.fechaInicio");
        }else if (!empty($_GET['desde']) | !empty($_GET['hasta']) | !empty($_GET['coche'])){//para buscar por nombre coche o fechas
                                $desde = $_GET['desde'] != '' ? $_GET['desde'] : '1900-01-01'; // si no escribe en la fecha de inicio tomo la fecha 1900-01-01 como inicial
                                $hasta = $_GET['hasta'] != '' ? $_GET['hasta'] : date("Y-m-d");
                                $coche = $_GET['coche'] ?? '';
                                $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                                    COALESCE(AM.sumaPrecio, 0) AS sumaPrecio,
                                                    COALESCE(AM.sumaDias, 0) AS sumaDias,
                                                    COALESCE(AM.sumaKilometros, 0) AS sumaKilometros,
                                                    COALESCE(AM.sumaGanancia, 0) AS sumaGanancia,
                                                    COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial 
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                                LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                            SUM(dias) AS sumaDias,
                                                                            SUM(kilometros) AS sumaKilometros,
                                                                            SUM(ganancia) AS sumaGanancia,
                                                                            SUM(comisionComercial) AS sumaComisionComercial
                                                            FROM ampliaciones
                                                            GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler    
                                            WHERE AL.fechaInicio BETWEEN '$desde' AND '$hasta' AND V.Marca_modelo LIKE '%$coche%'
                                            ORDER BY AL.fechaInicio"); 

                }else {//listado por defecto
                        $desplazamiento = 0;
                        $this->numPaginas = $this->numeroPaginas("SELECT COUNT(*) as num_filas FROM alquileres");
                        $num_pagina = $_GET['num_pagina'] ?? 1;
                        if (($num_pagina) <= $this->numPaginas) {
                            $numPagina = intval($num_pagina);
                            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
                        }
                        $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                                        COALESCE(AM.sumaPrecio, 0) AS sumaPrecio,
                                                        COALESCE(AM.sumaDias, 0) AS sumaDias,
                                                        COALESCE(AM.sumaKilometros, 0) AS sumaKilometros,
                                                        COALESCE(AM.sumaGanancia, 0) AS sumaGanancia,
                                                        COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial
                                                FROM alquileres AL
                                                    LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                    LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                    LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                                    LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                                SUM(dias) AS sumaDias,
                                                                                SUM(kilometros) AS sumaKilometros,
                                                                                SUM(ganancia) AS sumaGanancia,
                                                                                SUM(comisionComercial) AS sumaComisionComercial
                                                                FROM ampliaciones
                                                                GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler
                                                ORDER BY AL.fechaInicio desc LIMIT $desplazamiento, ".FILAS_PAGINA);
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
        $ok = $this->conexionPDO->consulta($sql, $parametros);
        
        if ($ok) {
            return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al ultimo creado
        }else return "0";//hay que controlar el error si se duplica contrato,en consultaPDO hay un catch (PDOException hay qeu ver como pasar ese error al cliente 
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
       
        $this->conexionPDO->consulta($sql, $parametros);//hay que controlar el error si se duplica contrato,en consultaPDO hay un catch (PDOException hay qeu ver como pasar ese error al cliente 
    }
    public function read (int $id): ?Alquiler {
        $this->conexionPDO->consulta("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo
                                            FROM alquileres AL
                                                LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                                LEFT JOIN entidad B ON AL.empresa = B.id_entidad
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                            WHERE (id_alquiler=$id)");        
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM alquileres WHERE (id_alquiler=$id)");
    }  
    public function totalAlquileresVehiculoTabla(): array{//en esta funcion devuelvo la tabla leida del SELECT no lo meto en objetos
        $parametros = [
        ':desde' => $_GET['desde'],
        ':hasta' => $_GET['hasta'],
        ':cocheId' => $_GET['cocheId'] 
        ]; //tengo que leer id_alquiler aunqeu no lo muestre porque lo necesito para luego sacas las ampliaciones de este alquiler
        $sql = "SELECT id_alquiler, ganancia, fechaInicio, comisionComercial FROM alquileres
                        WHERE fechaInicio BETWEEN :desde AND :hasta AND vehiculo = :cocheId";
        $this->conexionPDO->consulta($sql, $parametros); 
        return $this->conexionPDO->extraer_todos();       
        
    }
}
?>