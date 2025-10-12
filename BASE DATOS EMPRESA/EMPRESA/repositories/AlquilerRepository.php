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
//con esto se consigue el total de precio, dias, ganacia, es decir, la suma de todas las ampliaciones mas la del alquiler para no tener que sumarlo luego en la pagina
/* SELECT   AL.vehiculo, AL.fechaInicio, V.Marca_modelo, 
                                        COALESCE(AM.sumaGanancia, 0) + COALESCE(AL.ganancia) AS TotalGanancia,
                                        COALESCE(AM.sumaDias, 0) + COALESCE(AL.dias) AS TotalDias, 
                                        COALESCE(AM.sumaPrecio, 0) + COALESCE(AL.precio) AS TotalPrecio
                                FROM alquileres AL
                                    LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                    LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                SUM(dias) AS sumaDias,
                                                                SUM(ganancia) AS sumaGanancia
                                                FROM ampliaciones
                                                GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler
                                                WHERE vehiculo IN (82, 1) 
                                                ORDER BY AL.fechaInicio;*/
     
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
    public function totalAlquileresVehiculo($desde, $hasta, $idCoche): array{//en esta funcion devuelvo la tabla leida del SELECT no lo meto en objetos
        /*leo los alquileres de un vehiculo entre fechas*/
        $parametros = [
        ':desde' => $desde,
        ':hasta' => $hasta,
        ':cocheId' => $idCoche 
        ];
        $sql = "SELECT ganancia, fechaInicio, comisionComercial FROM alquileres
                        WHERE fechaInicio BETWEEN :desde AND :hasta AND vehiculo = :cocheId";
        $this->conexionPDO->consulta($sql, $parametros); 
        return $this->conexionPDO->extraer_todos();       
        
    }
    public function totalAlquileresVehiculos($cocheIds, $desde = null, $hasta = null): array{
    //leo todos los alquileres de todos los vehiculos que me pasan en parametro $cocheIds
    //para poder hacer la consulta con varios ids voy a esponer un ejemplo para que se entienda como hay que formar el array de $parametros
    //ya que $cocheIds no se puede poner directamente en los parametros de la consulta, hay que crear un :id por cada id del array $cochesIds
    //Si seleccionas 3 coches ($cocheIds = [1, 5, 9]) y pasas fechas: $desde = '2025-09-01'; $hasta = '2025-09-30'; tengo que construir esto:
    //                           SELECT vehiculo, ganancia, fechaInicio, comisionComercial
    //                                  FROM alquileres
    //                                  WHERE vehiculo IN (:id0, :id1, :id2) tengo que crear tantos paramentros como :idx hay en la consulta
    //                                  AND fechaInicio BETWEEN :desde AND :hasta
    //                                 $parametros = [
    //                                                    ':id0' => 1,
    //                                                    ':id1' => 5,
    //                                                    ':id2' => 9,
    //                                                    ':desde' => '2025-09-01',
    //                                                    ':hasta' => '2025-09-30'
    //  
        $parametros = [];//los parametros tiene que ser un array asociativo
        $placeholders = [];
        foreach ($cocheIds as $i => $id) {
            $key = ':id' . $i;              // Ejemplo: :id0, :id1, :id2...
            $placeholders[] = $key; //aqui se crea una tabla [:id1,:id5,:id9] que es la que ira dentro del IN
            $parametros[$key] = (int)$id;  //[':id0' => 1, ':id1' => 5, ':id2' => 9] array asociativo       Forzamos a entero por seguridad
        }
        $in = implode(',', $placeholders); //la tabla del IN la convierte a string separado por ,                                  ]
        
        if (!empty($desde) && !empty($hasta)){  //alquileres de vehiculos por fechas      
            $parametros[':desde'] = $desde;//añade los dos parametros de fechas
            $parametros[':hasta'] = $hasta;
            $sql = "SELECT vehiculo, ganancia, fechaInicio FROM alquileres
                            WHERE vehiculo IN ($in) 
                            AND fechaInicio BETWEEN :desde AND :hasta";
        }else {//todos los alquileres de vehiculos
            $sql = "SELECT ALS.vehiculo, ALS.Marca_modelo,  MIN(ALS.fechaInicio) AS primerAlquiler,
                           SUM(ALS.TotalGananciaAlquiler) AS totalGananciaAlquileres,SUM(ALS.TotalPrecioAlquiler) AS totalPrecioAlquileres,SUM(ALS.TotalDiasAlquiler) AS totalDiasAlquileres FROM
                            (SELECT AL.vehiculo, V.Marca_modelo, AL.fechaInicio,
                                        COALESCE(AM.sumaGanancia, 0) + COALESCE(AL.ganancia) AS TotalGananciaAlquiler,
                                        COALESCE(AM.sumaDias, 0) + COALESCE(AL.dias) AS TotalDiasAlquiler, 
                                        COALESCE(AM.sumaPrecio, 0) + COALESCE(AL.precio) AS TotalPrecioAlquiler
                            FROM alquileres AL
                                    LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                    LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
                                                                SUM(dias) AS sumaDias,
                                                                SUM(ganancia) AS sumaGanancia
                                                FROM ampliaciones
                                                GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler
                            WHERE vehiculo IN ($in)) AS ALS
                    GROUP BY Al.vehiculo";
        /*hay 3 SELECT, el 2º select me da este resultado, todos los alquileres de los dos coches del IN, con el total del precio, ganancia y dias (suma del alquliles mas todas las amplia):
                1	JEEP GRANGLER V6	2025-09-24	8550.00	13	8950.00
                1	JEEP GRANGLER V6	2025-09-25	5000.00	15	5555.00
                1	JEEP GRANGLER V6	2025-10-04	4800.00	4	5200.00
                82	FERRARI 296GTS 	    2025-10-03	5400.00	2	6000.00
        con el 3º SELECT (mas interno) se se suman todas las ampliaciones (importe, ganancia, dias)(SELECT alquiler, SUM(precio) AS sumaPrecio ...FROM ampliaciones GROUP BY alquiler)       
        el 2º SELECT no agrupa nada solo muestra la suma del precio del alquiler con la suma de las ampliaciones (AM.sumaPrecio) + (AL.precio)
        Como necesito el total de ganacia de alquileres de cada coche tengo que agrupar por coche (Al.vehiculo) el resultado del 2º SELECT, asi que como el 2º SELECT me da una tabla
        lo meto todo entre parentisis y hago el 1º SELECT sobre la tabla que me da el 2º SELECT y obtengo esto:
                1	JEEP GRANGLER V6	2025-09-24	18350.00	19705.00	32
                82	FERRARI 296GTS 	    2025-10-03	5400.00	    6000.00	    2
        y como colofon con MIN(ALS.fechaInicio) agrupo por la menor fechaInicio y asi obntengo la fecha del 1º alquiler para luego saber desde cuando se alquila ese coche
        */            

        } 
        $this->conexionPDO->consulta($sql, $parametros); 
        return $this->conexionPDO->extraer_todos();   
    }
}
?>