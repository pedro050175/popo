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
    public function alquileresVehiculo($desde, $hasta, $coche){
        $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, V.Marca_modelo                                                 
                                        FROM alquileres AL
                                        LEFT JOIN entidad A ON AL.cliente = A.id_entidad
                                        LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                        WHERE AL.fechaInicio BETWEEN '$desde' AND '$hasta' AND AL.vehiculo = '$coche'");                   
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
                                                    COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial,
                                                    COALESCE(C.sumaCobros, 0) AS sumaCobros 
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
                                                LEFT JOIN (SELECT alquiler, 
                                                                    COALESCE(SUM(importe))-COALESCE(SUM(parteImporteFianza)) AS sumaCobros
                                                                FROM cobrosalquiler
                                                                WHERE facturado = 0
                                                                GROUP BY alquiler) C ON C.alquiler = AL.id_alquiler    
                                            WHERE AL.contrato LIKE '%$buscar%' OR A.Nombre LIKE '%$buscar%'
                                            ORDER BY (AL.estado <> 'entregado') asc, AL.fechaInicio DESC");
        }else if (!empty($_GET['desde']) | !empty($_GET['hasta']) | !empty($_GET['coche'])){//para buscar por nombre coche o fechas
                                $desde = $_GET['desde'] != '' ? $_GET['desde'] : INICIO; // si no escribe en la fecha de inicio tomo la fecha 1900-01-01 como inicial
                                $hasta = $_GET['hasta'] != '' ? $_GET['hasta'] : FIN;
                                $coche = $_GET['coche'] ?? '';
                                $this->conexionPDO->consulta ("SELECT   AL.*, A.Nombre, B.Nombre AS nombreEmpresa, V.Marca_modelo,
                                                    COALESCE(AM.sumaPrecio, 0) AS sumaPrecio,
                                                    COALESCE(AM.sumaDias, 0) AS sumaDias,
                                                    COALESCE(AM.sumaKilometros, 0) AS sumaKilometros,
                                                    COALESCE(AM.sumaGanancia, 0) AS sumaGanancia,
                                                    COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial, 
                                                    COALESCE(C.sumaCobros, 0) AS sumaCobros
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
                                                LEFT JOIN (SELECT alquiler, 
                                                                    COALESCE(SUM(importe))-COALESCE(SUM(parteImporteFianza)) AS sumaCobros
                                                                FROM cobrosalquiler
                                                                WHERE facturado = 0
                                                                GROUP BY alquiler) C ON C.alquiler = AL.id_alquiler   
                                            WHERE AL.fechaInicio BETWEEN '$desde' AND '$hasta' AND V.Marca_modelo LIKE '%$coche%'
                                            ORDER BY (AL.estado <> 'entregado') asc, AL.fechaInicio DESC"); 
                /* la expresión <> (no igual, tmb se puede poner !=) devuelve 0(false) para los entregados y 1(true) para el resto, y 0 va primero y 1 despues. Esta forma solo sirve para poner 1º los entregados */

                }else {//listado por defecto para pagina alquileres
                        $desplazamiento = 0;
                        $this->numPaginas = numeroPaginas("SELECT COUNT(*) as num_filas FROM alquileres");
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
                                                        COALESCE(AM.sumaComisionComercial, 0) AS sumaComisionComercial,
                                                        COALESCE(C.sumaCobros, 0) AS sumaCobros
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
                                                    LEFT JOIN (SELECT alquiler, 
                                                                    COALESCE(SUM(importe))-COALESCE(SUM(parteImporteFianza)) AS sumaCobros
                                                                FROM cobrosalquiler
                                                                WHERE facturado = 0
                                                                GROUP BY alquiler) C ON C.alquiler = AL.id_alquiler
                                                ORDER BY 
                                                    CASE 
                                                        WHEN AL.estado = 'Entregado' THEN 1 /* asigna un nº a cada fila segun el valor del campo estado y luego ordenar por ese valor */
                                                        WHEN AL.estado = 'Sin entregar' THEN 2 /* en el SELECT de arriba uso otra forma mas ingeniosa by IA*/
                                                        ELSE 3
                                                    END, AL.fechaInicio desc 
                                                    LIMIT $desplazamiento, ".FILAS_PAGINA);
    } /* ultimo SELECT es para calcular lo que esta sin facturar. Cobros sin facturar quitandole la parte de fianza, a cada cobro resta la parte que es de fianza */
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
            ':carpeta' => $alquiler['carpeta'],
            ':estado' => $alquiler['estado'] ?? ''
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO alquileres (contrato, vehiculo, cliente, fechaInicio, fechaFin, kilometros, kmInicio, kmFin, dias, precio, precioKm, fianza, fianzaDevuelta, comercial, empresa, ciudad, entrega, comisionComercial, ganancia, observaciones, estado, carpeta) VALUES 
                                         (:contrato,:vehiculo,:cliente,:fechaInicio,:fechaFin,:kilometros,:kmInicio,:kmFin,:dias,:precio,:precioKm,:fianza,:fianzaDevuelta,:comercial,:empresa,:ciudad,:entrega,:comisionComercial,:ganancia,:observaciones,:estado,:carpeta)"; 
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
            ':carpeta' => $alquiler['carpeta'],
            ':estado' => $alquiler['estado'] ?? ''
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE alquileres SET contrato = :contrato, vehiculo = :vehiculo, cliente = :cliente, fechaInicio = :fechaInicio, fechaFin = :fechaFin, kilometros = :kilometros, kmInicio = :kmInicio, kmFin = :kmFin, 
                                       dias = :dias, precio = :precio, precioKm = :precioKm, fianza = :fianza, fianzaDevuelta = :fianzaDevuelta,  comercial = :comercial, empresa = :empresa,
                                       ciudad = :ciudad, entrega = :entrega, comisionComercial = :comisionComercial, ganancia = :ganancia, observaciones = :observaciones, estado = :estado, carpeta = :carpeta
                                     WHERE id_alquiler = :id_alquiler";
       
        $this->conexionPDO->consulta($sql, $parametros);//hay que controlar el error si se duplica contrato,en consultaPDO hay un catch (PDOException hay qeu ver como pasar ese error al cliente 
    }
    public function read (int $id): ?Alquiler {
        $this->conexionPDO->consulta("SELECT AL.*, V.Marca_modelo, V.Bastidor, V.Matricula, E.Nombre, EM.Nombre as nombreEmpresa 
                                        FROM alquileres AL 
                                        JOIN vehiculos V ON V.id_vehiculo = AL.vehiculo
                                        JOIN entidad E ON E.id_entidad = AL.cliente
                                        LEFT JOIN entidad EM ON EM.id_entidad = AL.empresa
                                        WHERE (id_alquiler=$id)");        
            /* es necesario leer datos de vehiculo, cliente, empresa porque se usa en la pagina "detalles_alquiler" */
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM alquileres WHERE (id_alquiler=$id)");
    }  
    public function totalAlquileresVehiculo($desde, $hasta, $idCoche): array{//en esta funcion devuelvo la tabla leida del SELECT no lo meto en objetos
        /*leo los alquileres de un vehiculo entre fechas, se usa en analisis para ver los alquileres de un vehiculo en fechas*/
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
    public function totalAlquileresVehiculosGastos($cocheIds, $desde = null, $hasta = null): array{ /* se usa en la pagina total_alquileres_vehiculo_fecha y total_alquileres_vehiculo,
        es llamado por  Controller/totalAlquileresVehiculosFecha y totalAlquileresVehiculos*/
    //leo todos los alquileres de todos los vehiculos que me pasan en parametro $cocheIds
    //para poder hacer la consulta con varios ids voy a esponer un ejemplo para que se entienda como hay que formar el array de $parametros
    //ya que $cocheIds no se puede poner directamente en los parametros de la consulta, hay que crear un :id por cada id del array $cochesIds
    //Si seleccionas 3 coches ($cocheIds = [1, 5, 9]) y pasas fechas: $desde = '2025-09-01'; $hasta = '2025-09-30'; tengo que construir esto:
    //                           SELECT vehiculo, ganancia, fechaInicio, comisionComercial
    //                                  FROM alquileres
    //                                  WHERE vehiculo IN (:id0, :id1, :id2) tengo que crear tantos paramentros como :idx hay en la consulta
    //                                  AND fechaInicio BETWEEN :desde AND :hasta
    //                                 $parametros = [    ':id0' => 1,
    //                                                    ':id1' => 5,
    //                                                    ':id2' => 9,
    //                                                    ':desde' => '2025-09-01',
    //                                                    ':hasta' => '2025-09-30'
    //                                                  ]
    //  
        $parametros = [];//los parametros tiene que ser un array asociativo
        $in = [];//:id0, :id1, :id2
        parametrosIn($in, $parametros, $cocheIds);//$in y $parametros se pasan por referencia a la funcion, alli seran modificados, $in lleva los ids para el IN y $parametros los parametros para la consulta  
            
        if (!empty($desde) && !empty($hasta)){  //usada por totalAlquileresVehiculosFecha para formar la tabla de meses del año, no se incluyen gastos de alquileres  
            $parametros[':desde'] = $desde;//añade los dos parametros de fechas
            $parametros[':hasta'] = $hasta;//como necesito los alquileres por separado no hace falta cruzar tablas
            $sql = "SELECT vehiculo, ganancia, fechaInicio FROM alquileres
                            WHERE vehiculo IN ($in) 
                            AND fechaInicio BETWEEN :desde AND :hasta" ;
        }else {//todos los alquileres de vehiculos, usada por totalAlquileresVehiculosFecha para forma la tabla del todos los alquileres mas gastos mas cuota
            $sql = "SELECT TAL.*, TG.totalGastos, C.cuota, C.inicio AS fechaInicioCuota, C.entrada  /*todos los campos de TAL (total ampliaciones), el total de gastos de TG, y la cuota de C.aqui esta lo que se va a mandar a la pagina*/
                        FROM /* SELECT de la tabla que nos da este SELECT de abajo */
                            (SELECT ALS.vehiculo, ALS.Marca_modelo, MIN(ALS.fechaInicio) AS primerAlquiler,/*SELECT de alquileres y agrupa los vehiculos por la suma (SUM) de Precio, Ganancia, Dias y la fecha menor MIN */
                                    SUM(ALS.TotalGananciaAlquiler) AS totalGananciaAlquileres,SUM(ALS.TotalPrecioAlquiler) AS totalPrecioAlquileres,SUM(ALS.TotalDiasAlquiler) AS totalDiasAlquileres 
                                FROM
                                            (SELECT AL.vehiculo, V.Marca_modelo, AL.fechaInicio,/* SELECT que calcula alquileres+ampliaciones, pero repite un coche tantas veces como alquileres */
                                                    COALESCE(AM.sumaGanancia, 0) + COALESCE(AL.ganancia) AS TotalGananciaAlquiler,
                                                    COALESCE(AM.sumaDias, 0) + COALESCE(AL.dias) AS TotalDiasAlquiler, 
                                                    COALESCE(AM.sumaPrecio, 0) + COALESCE(AL.precio) AS TotalPrecioAlquiler
                                                FROM alquileres AL
                                                LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo /* union para para sacar el nombre del coche */
                                                LEFT JOIN /* union alquiler con sus ampliaciones */
                                                    (SELECT alquiler, SUM(precio) AS sumaPrecio,  SUM(dias) AS sumaDias, SUM(ganancia) AS sumaGanancia /* SELECT de ampliaciones y agrupa por la suma de precio... de las ampliaciones */        
                                                        FROM ampliaciones
                                                    GROUP BY alquiler) AM /* las ampliaciones me salen repetidas y las agrupo por alquiler sumando el total*/
                                                ON AM.alquiler = AL.id_alquiler /* union alquiler con ampliaciones */
                                            WHERE vehiculo IN ($in)) AS ALS /* (ALS alquil+ampli) solo de los coches indicados, y esos alquileres son los indices a buscar de las ampliaciones, sino se pusiera sacaria los alquileres de todos los coches */
                            GROUP BY Al.vehiculo) TAL /* (TAL total alquileres). agrupo por la suma para que no me repita los coches */
                    LEFT JOIN /* JOIN mas externo que junta los alqui/amplia con los gastos */
                        (SELECT id_vehiculo, SUM(Importe) AS totalGastos  /* saco total de gastos sumando precio*/
                               FROM gastosvehiculo  /* SELECT que saca todos los gastos de los coches */ 
									WHERE id_vehiculo IN ($in)
						GROUP BY id_vehiculo) TG /* (TG total gastos) agrupo para sumar total gastos ya que salen coches repetidos*/
                    ON TG.id_vehiculo = TAL.vehiculo /* TAL se junta con TG */
                    LEFT JOIN /* este JOIN junta la cuota con los vehiculos */
                        (SELECT id_vehiculo, cuota, inicio, entrada 
                            FROM cuotasvehiculo/* leo la cuota */
                                WHERE id_vehiculo IN ($in)) C 
                    ON C.id_vehiculo = TAL.vehiculo"; 
                    /*añadiendo esto al final de la consulta se saca el total de gastos de las compreaventas de cada vehiculo 
                    LEFT JOIN (SELECT vehiculo, GCV.sumaGastosCompraventa FROM compraventas
                                LEFT JOIN 
                                    (SELECT compraventa, SUM(importe) AS sumaGastosCompraventa FROM gastoscompraventa 
                                GROUP BY compraventa) GCV 
                                    ON id_compraventa = GCV.compraventa
                        WHERE vehiculo IN ($in)) VGCV ON VGCV.vehiculo = TAL.vehiculo"
                        arriba del todo hay que añadir esto: VGCV.sumaGastosCompraventa que es el campo que se ve en la tabla resultado
                         */
        /*inicialmente saco las alquileres y ampliaciones de los coches con una estructura de 3 SELECT anidados. de los 3 SELECT, 
        el 2º select me da este resultado, todos los alquileres de los dos coches del IN, con el total del precio, ganancia y dias (suma del alquliles mas todas las amplia):
                1	JEEP GRANGLER V6	2025-09-24	8550.00	13	8950.00
                1	JEEP GRANGLER V6	2025-09-25	5000.00	15	5555.00
                1	JEEP GRANGLER V6	2025-10-04	4800.00	4	5200.00
                82	FERRARI 296GTS 	    2025-10-03	5400.00	2	6000.00
        con el 3º SELECT (mas interno) se se suman todas las ampliaciones (importe, ganancia, dias)(SELECT alquiler, SUM(precio) AS sumaPrecio ...FROM ampliaciones GROUP BY alquiler)       
        el 2º SELECT no agrupa nada, solo muestra la suma del precio del alquiler con la suma de las ampliaciones (AM.sumaPrecio) + (AL.precio)
        Como necesito el total de ganacia de alquileres de cada coche tengo que agrupar por coche (Al.vehiculo) el resultado del 2º SELECT, asi que como el 2º SELECT me da una tabla
        lo meto todo entre parentisis y hago el 1º SELECT sobre la tabla que me da el 2º SELECT y obtengo esto:
                1	JEEP GRANGLER V6	2025-09-24	18350.00	19705.00	32
                82	FERRARI 296GTS 	    2025-10-03	5400.00	    6000.00	    2
        y como colofon con MIN(ALS.fechaInicio) agrupo por la menor fechaInicio y asi obntengo la fecha del 1º alquiler para luego saber desde cuando se alquila ese coche
        Despues tengo que sacar los gastos de los vehiculos, tengo un select individual, que me los da en una tabla asi:
        LEFT JOIN (SELECT G.id_vehiculo, SUM(Importe) AS totalGastos FROM gastosvehiculo G
									WHERE G.id_vehiculo IN(82, 1)
									GROUP BY G.id_vehiculo) TG ON TG.id_vehiculo = TAL.vehiculo
            1	2900.00
            82	3000.00 
        pues junto el select de los gastos con toda la estructura del select total de alquileres y ampliaciones con
        un LEFT JOIN y lo saco todo de una:
            1	JEEP GRANGLER V6	2025-09-24	18350.00	19705.00	32	2900.00
            82	FERRARI 296GTS 	    2025-10-03	5400.00	    6000.00	    2	3000.00
        ahora añado otro JOIN de una subconsulta para sacar la cuota de los vehiculos   
        LEFT JOIN (SELECT id_vehiculo, cuota FROM cuotasvehiculo
                    WHERE id_vehiculo IN(82, 1)) C ON C.id_vehiculo = TAL.vehiculo; 
         resultado:   82	5300.00
         resultado de la consulta global (solo tiene cuota el 82):
            1	JEEP GRANGLER V6	2025-09-24	18350.00	19705.00	32	2900.00	
            82	FERRARI 296GTS 	    2025-10-03	5400.00	    6000.00	    2	3000.00	5300.00
        
        */            
        } 
        $this->conexionPDO->consulta($sql, $parametros); 
        return $this->conexionPDO->extraer_todos();   
    }
    public function estadoAlquiler(string $id, string $estado){
        $parametros = [$estado, $id,]; 
        $sql = "UPDATE alquileres SET estado = ?
                    WHERE id_alquiler = ?";
        $this->conexionPDO->consulta($sql, $parametros);
    }
}
?>