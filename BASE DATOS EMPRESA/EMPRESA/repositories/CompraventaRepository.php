<?php

namespace repositories;
use lib\BaseDatosPDO;
use models\Compraventa;


class CompraventaRepository{
    
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
    /* problema en este SELECT, cuando las fechas de la tabla sql son nulas porqeu no se han introducido el selecto no lee esas filas */
    public function findAllDinamico(): ?array {
        /* se pagina con los campos de busqueda este nuevo sistema de consulta dinamica puede paginar con todo.
        No necesito comprobar si el num_pagina del $_GET es mayor que la cantidad de paginas porque eso se controla en la pagina HTML, asi que no necesito saber la cantidad de paginas antes
        de hacer la consulta*/
        $num_pagina = $_GET['num_pagina'] ?? 1;
        $numPagina = intval($num_pagina);
        $desplazamiento = ($numPagina - 1) * FILAS_PAGINA;
        /*si no se envia formulario con submit los campos no existen, y se se envia los campos vacios vienen con ''*/
        $empresa = $_GET['empresa'] ?? ''; //si no existe se carga con '' 
        $coche = $_GET['coche'] ?? '';
        $compraA = $_GET['compraA'] ?? '';
        $vendeA = $_GET['vendeA'] ?? '';
        $trimestre = $_GET['trimestre'] ?? 0;
        $compraDesde = $_GET['compraDesde'] ?? '';
        $compraHasta = $_GET['compraHasta'] ?? '';
        $vendeDesde = $_GET['vendeDesde'] ?? '';
        $vendeHasta = $_GET['vendeHasta'] ?? '';
        // Base de la consulta
        /*COUNT OVER me devuelve la filas leidas en resultado[0]['totalFilas'] para paginar. Como he visto que no hace falta saber el numero de paginas antes de hacer la consulta, porque se 
        controla en HTML, el COUNT OVER no seria necesario porque puedo saber las filas leidas haciendo un count(resultado_consulta) en la funcion $this->extraer_todos o incluso aqui
        puedo hacer el COUNT de lo que me devuelve $this->extraer_todos. COn el COUNT OVER me ahora hacer el COUNT del relsultado que tmb gasta tiempo */
        $sql = "SELECT CV.*, C.Nombre AS nombreComprador, V.Nombre AS nombreVendedor, E.Nombre AS nombreEmpresa, 
            VV.Marca_modelo, VV.Matricula, VV.Bastidor, VV.Km, VV.Fecha_matricula,
            COALESCE(CC.sumaCobros,0) AS sumaCobros,
            COALESCE(PC.sumaPagos,0) AS sumaPagos,
            COALESCE(GC.sumaGastos,0) AS sumaGastos,
            COUNT(*) OVER() AS totalFilas 
        FROM compraventas CV
        LEFT JOIN entidad C ON CV.compraA = C.id_entidad
        LEFT JOIN entidad V ON CV.vendeA  = V.id_entidad
        LEFT JOIN entidad E ON CV.empresa = E.id_entidad
        LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo
        LEFT JOIN (
            SELECT compraventa, SUM(importe) AS sumaCobros 
            FROM cobroscomven 
            GROUP BY compraventa
        ) CC ON CC.compraventa = CV.id_compraventa
        LEFT JOIN (
            SELECT compraventa, SUM(importe) AS sumaPagos 
            FROM pagoscomven 
            GROUP BY compraventa
        ) PC ON PC.compraventa = CV.id_compraventa
        LEFT JOIN (
            SELECT compraventa, SUM(importe) AS sumaGastos 
            FROM gastoscompraventa 
            GROUP BY compraventa
        ) GC ON GC.compraventa = CV.id_compraventa
        WHERE E.Nombre LIKE CONCAT('%', ?, '%')
        AND (VV.Marca_modelo LIKE CONCAT('%', ?, '%')
            OR VV.Matricula LIKE CONCAT('%', ?, '%')
            OR VV.Bastidor LIKE CONCAT('%', ?, '%'))
        AND COALESCE(C.Nombre,'') LIKE CONCAT('%', ?, '%')
        AND COALESCE(V.Nombre,'') LIKE CONCAT('%', ?, '%')";
        /* el nombre del comprador o el vendedor puede estar vacio y ser null, entonces en la busqueda, aunque no se este buscando por nombre, no mostraria esas filas, (el filtro esta montado 
        siempre en la consulta base), uso COALESCE que los null los sustituye por '' en la comparacion LIKE  */
        // Parámetros iniciales, usamos consulta por orden de parametros, donde hay un ? se sustituye por el parametro usando el mismo orden que esta en la tabla parametros, es decir, el 1º ? se sustituye por el 1º parametro 
        /* RESUMEN SI EL campo de filtro es de texto se puede meter en la consulta base porque con %% y asignadole al filtro '' aparecen todos. Si es tipo fecha o entero hay que añadir 
        el filtro a la consulta base solo si existe el campo de busqueda.
        Si el campo puede tener nulos en la BBDD hay que poner COALESCE en el SELECT de lo contrario los nulos no salen en la consulta base. Si es un filtro que se añade despues no hace falta 
        poner COALESCEN porque al no añadir la consulta da igual que en la BBDD sea null, no se existe filtro de comparacion por lo que se ven todos los null*/
        $params = [$empresa, $coche, $coche, $coche, $compraA, $vendeA];
        /* si filtro por fecha y el campo en BBDD esta vacio no se muestra ese registro, es correcto porque una compraventa sin fecha no se muestra en una consulta por fechas */
        if (!empty($compraDesde) && !empty($compraHasta)) {
            $sql .= " AND CV.fechaCompra >= ? AND CV.fechaCompra <= ? ";
            $params[] = $compraDesde;
            $params[] = $compraHasta;
        }         
        if (!empty($compraDesde) && empty($compraHasta)) {
            $sql .= " AND CV.fechaCompra >= ? ";
            $params[] = $compraDesde;
        } elseif (empty($compraDesde) && !empty($compraHasta)) {
            $sql .= " AND CV.fechaCompra <= ? ";
            $params[] = $compraHasta;
            }
        if (!empty($vendeDesde) && !empty($vendeHasta)) {
            $sql .= " AND CV.fechaVenta >= ? AND CV.fechaVenta <= ? ";
            $params[] = $vendeDesde;
            $params[] = $vendeHasta;
        }
        if (!empty($vendeDesde) && empty($vendeHasta)) {
            $sql .= " AND CV.fechaVenta >= ? ";
            $params[] = $vendeDesde;
        } elseif (empty($vendeDesde) && !empty($vendeHasta)) {
            $sql .= " AND CV.fechaVenta <= ? ";
            $params[] = $vendeHasta;
            }
        // --- Trimestre ---
        if (!empty($trimestre)) {/* que exista y no sea '', sino se filtra por tri no se añade este filtro y se muestran todos  */
            $sql .= " AND CV.trimestre >= ? ";
            $params[] = $trimestre;
        }
        /* En MySQL con PDO, los parámetros preparados no funcionan para LIMIT y OFFSET si los pasas como parámetros de tipo string. MySQL requiere enteros literales en LIMIT offset, filas.
        PDO trata todos los placeholders ? como strings, por eso pone comillas a desplazamiento y a FILAS_PAGINA y rompe la sintaxis. Solucion: Convertir a entero antes de concatenar con intval
        y no usar parametros ? */
        $desplazamiento = intval($desplazamiento);
        $filasPagina   = intval(FILAS_PAGINA);
        $sql .= " ORDER BY CV.trimestre DESC, CV.id_compraventa DESC LIMIT $desplazamiento, $filasPagina";
        // Preparar y ejecutar
        $this->conexionPDO->consulta($sql, $params);
        // Obtener resultados
        $resultado = $this->extraer_todos($filasLeidas);
        $this->numPaginas = $filasLeidas > 0 ? ceil($filasLeidas / FILAS_PAGINA) : 1; /* ceil redondea al entero mayor, si la division da 2,3 devuelve 3 */
        return $resultado;
    }
    public function analisis(){
        /* usada en pag analisis_compraventas_tri. lee las compraventas del trimestre ordenadas por empresa para mostrar benficio e IVA de cada una */
        $sql = "SELECT CV.precioCompraReal, CV.precioCompraDeclarado, CV.precioVentaReal, CV.precioVentaDeclarado, CV.impuestoCompra, CV.impuestoVenta, CV.empresa,
                        E.Nombre AS nombreEmpresa, VV.Marca_modelo,
                        COALESCE(GC.sumaGastos,0) AS sumaGastos
                    FROM compraventas CV
                    LEFT JOIN entidad E ON CV.empresa = E.id_entidad
                    LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo
                    LEFT JOIN (
                        SELECT compraventa, SUM(importe) AS sumaGastos 
                        FROM gastoscompraventa 
                        GROUP BY compraventa
                    ) GC ON GC.compraventa = CV.id_compraventa
                    WHERE CV.trimestre = 1 
                    ORDER BY E.Nombre";
    
        $this->conexionPDO->consulta($sql);
        $resultado = $this->extraer_todos();
        return $resultado;    
    } 
    public function extraer_registro(): ?Compraventa {
        return ($compraventa = $this->conexionPDO->extraer_registro()) ? Compraventa::fromArray($compraventa):null;
    }
    public function extraer_todos(? int &$filasLeidas = null): ?array {
        $compraventas = [];
        $compraventaData = $this->conexionPDO->extraer_todos();
        $filasLeidas = $compraventaData[0]['totalFilas'] ?? 0; /* $filasLeidas se pasa por referencia, se usa para paginacion */
        foreach ($compraventaData as $data){
            $compraventas[] = Compraventa::fromArray($data);
        }
        return $compraventas;
    }
    public function save (array $compraventa): string {
        if (isset($compraventa['id_compraventa'])) {
            $this->update($compraventa);
            return $compraventa['id_compraventa']; //devuelvo el id del compraventa para regresar a la pagina con el movimiento que se acaba de actualizar
        } else { return $this->create($compraventa);} //devuelvo el id del compraventa creado para regresar a la pagina con el movimiento que se acaba de actualizar
    }
    public function create (array $data):string{
        
        $parametros = [
            ':fechaCompra'=> $data['fechaCompra'],
            ':precioCompraReal' => $data['precioCompraReal'],
            ':precioCompraDeclarado' => $data['precioCompraDeclarado'],
            ':fechaFactComp' => $data['fechaFactComp'],
            ':nodeclaraComp' => (isset($data['nodeclaraComp'])) ? 1 : 0,
            ':impuestoCompra' => $data['impuestoCompra'] ?? '',
            ':compraA' => $data['compraA'] ?? '',
            ':anuladaCompra' => (isset($data['anuladaCompra'])) ? 1 : 0,
            ':vehiculo' => $data['vehiculo'],
            ':reserva' => (isset($data['reserva'])) ? 1 : 0,
            ':comercialVenta' => $data['comercialVenta'],
            ':fechaVenta'=> $data['fechaVenta'],
            ':precioVentaReal' => $data['precioVentaReal'],
            ':precioVentaDeclarado' => $data['precioVentaDeclarado'],
            ':fechaFactVent' => $data['fechaFactVent'],
            ':nodeclaraVent' => (isset($data['nodeclaraVent'])) ? 1 : 0,
            ':impuestoVenta' => $data['impuestoVenta'] ?? '',
            ':vendeA' => $data['vendeA'] ?? '',
            ':anuladaVenta' => (isset($data['anuladaVenta'])) ? 1 : 0,
            ':observaciones' => $data['observaciones'],
            ':trimestre' => (isset($data['trimestre'])) ? 1 : 0,
            ':empresa' => $data['empresa']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "INSERT INTO compraventas (fechaCompra, precioCompraReal, precioCompraDeclarado, fechaFactComp, nodeclaraComp, impuestoCompra, compraA, anuladaCompra, vehiculo, reserva, 
                                            comercialVenta, fechaVenta, precioVentaReal, precioVentaDeclarado, fechaFactVent, nodeclaraVent, impuestoVenta, vendeA, anuladaVenta, observaciones, trimestre, empresa) VALUES 
                                         (:fechaCompra, :precioCompraReal, :precioCompraDeclarado, :fechaFactComp, :nodeclaraComp, :impuestoCompra, :compraA, :anuladaCompra, :vehiculo, :reserva, 
                                            :comercialVenta, :fechaVenta, :precioVentaReal, :precioVentaDeclarado, :fechaFactVent, :nodeclaraVent, :impuestoVenta, :vendeA, :anuladaVenta, :observaciones, :trimestre, :empresa)"; 
        //var_dump($parametros);
        $this->conexionPDO->consulta($sql, $parametros);
        return $this->conexionPDO->id_ultimo_insertado();//devuelvo el id ultimo creado para regresar al movimiento creado
    }
    public function update (array $data): void{ 
        $parametros = [
            ':id_compraventa'=> $data['id_compraventa'],
            ':fechaCompra'=> $data['fechaCompra'],
            ':precioCompraReal' => $data['precioCompraReal'],
            ':precioCompraDeclarado' => $data['precioCompraDeclarado'],
            ':fechaFactComp' => $data['fechaFactComp'],
            ':nodeclaraComp' => (isset($data['nodeclaraComp'])) ? 1 : 0,
            ':impuestoCompra' => $data['impuestoCompra'] ?? '',
            ':compraA' => $data['compraA'] ?? '',
            ':anuladaCompra' => (isset($data['anuladaCompra'])) ? 1 : 0,
            ':vehiculo' => $data['vehiculo'],
            ':reserva' => (isset($data['reserva'])) ? 1 : 0,
            ':comercialVenta' => $data['comercialVenta'],
            ':fechaVenta'=> $data['fechaVenta'],
            ':precioVentaReal' => $data['precioVentaReal'],
            ':precioVentaDeclarado' => $data['precioVentaDeclarado'],
            ':fechaFactVent' => $data['fechaFactVent'],
            ':nodeclaraVent' => (isset($data['nodeclaraVent'])) ? 1 : 0,
            ':impuestoVenta' => $data['impuestoVenta'] ?? '',
            ':vendeA' => $data['vendeA'] ?? '',
            ':anuladaVenta' => (isset($data['anuladaVenta'])) ? 1 : 0,
            ':observaciones' => $data['observaciones'],
            ':trimestre' => (isset($data['trimestre'])) ? 1 : 0,
            ':empresa' => $data['empresa']
        ];
        $parametros = Limpiar_parametros($parametros);
        $sql = "UPDATE compraventas SET fechaCompra=:fechaCompra, precioCompraReal=:precioCompraReal, precioCompraDeclarado=:precioCompraDeclarado, fechaFactComp=:fechaFactComp, nodeclaraComp=:nodeclaraComp, 
                                        impuestoCompra=:impuestoCompra, compraA=:compraA, anuladaCompra=:anuladaCompra, vehiculo=:vehiculo, reserva=:reserva, comercialVenta=:comercialVenta, 
                                        fechaVenta=:fechaVenta, precioVentaReal=:precioVentaReal, precioVentaDeclarado=:precioVentaDeclarado, fechaFactVent=:fechaFactVent, nodeclaraVent=:nodeclaraVent,
                                        impuestoVenta=:impuestoVenta, vendeA=:vendeA, anuladaVenta=:anuladaVenta, observaciones=:observaciones, trimestre=:trimestre, empresa=:empresa
                                     WHERE id_compraventa = :id_compraventa";
       
        $this->conexionPDO->consulta($sql, $parametros);
    }
    public function read (int $id): ?Compraventa {
        /*se usa en nueva_compraventa, los totales de pagos, cobros no los necesito porque tengo que leer esas tablas para mostar todas las lineas, asi que con esos datos 
        sumare y calculo. total de gastos si lo leo poara calcualr beneficio de la compra venta sin tener que sumar los gastos, porque lo muestro antes de mostrar la tabla con los gastos*/
        $this->conexionPDO->consulta("SELECT CV.*, COALESCE(GC.sumaGastos,0) AS sumaGastos 
                                        FROM compraventas CV
                                        LEFT JOIN entidad C ON CV.compraA = C.id_entidad 
                                        LEFT JOIN entidad V ON CV.vendeA = V.id_entidad 
                                        LEFT JOIN entidad E ON CV.empresa = E.id_entidad 
                                        LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo
                                        LEFT JOIN (SELECT compraventa, SUM(importe) AS sumaGastos 
                                                   FROM gastoscompraventa 
                                                   GROUP BY compraventa) GC ON GC.compraventa = CV.id_compraventa
                                            WHERE (id_compraventa=$id)");        
        return $this->extraer_registro();
    }
    public function delete (int $id): void {
       $this->conexionPDO->consulta("DELETE FROM compraventas WHERE (id_compraventa=$id)");
    }
    public function compraventasVehiculosGastos(array $cocheIds): ? array{
        $parametros = [];//los parametros tiene que ser un array asociativo
        $in = [];
        parametrosIn($in, $parametros, $cocheIds);//$in y $parametros se pasan por referencia a la funcion, alli seran modificados, $in lleva los ids para el IN y $parametros los parametros para la consulta  
        $sql = "SELECT CV.*, VV.Marca_modelo, COALESCE(GC.sumaGastos,0) AS sumaGastos 
                                /*con COALESCE, los campos con null, en lugar de nulos me da ceros */
                                FROM compraventas CV
                                LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo 
                                LEFT JOIN  
                                    (SELECT compraventa, SUM(importe) AS sumaGastos FROM gastoscompraventa 
                                        GROUP BY compraventa) GC ON GC.compraventa = CV.id_compraventa
                                WHERE CV.vehiculo IN ($in)";      
        $this->conexionPDO->consulta($sql, $parametros); 
        return $this->extraer_todos();

    }
    public function actualizaTri($datos, $valor){
        foreach ($datos as $indice => $nada) {
            $parametros[] = $valor;
            $parametros[] = $indice;
            $sql = "UPDATE compraventas SET trimestre = ? WHERE id_compraventa = ?";
            $this->conexionPDO->consulta($sql, $parametros);
            $parametros = [];
        }
    }
       /* no se usa ---------------------------------------------------*/ 
    public function findAll(): ?array {
        /* se pagina con los campos de busqueda tamb */
        $desplazamiento = 0;
        $this->numPaginas = numeroPaginas("SELECT COUNT(*) as num_filas FROM compraventas");
        $num_pagina = $_GET['num_pagina'] ?? 1;
        if (($num_pagina) <= $this->numPaginas) {
            $numPagina = intval($num_pagina);
            $desplazamiento = ($numPagina-1) * FILAS_PAGINA;
        }
        /*si no se envia formulario con submit los campos no existen, y se se envia los campos vacios vienen con ''*/
        $empresa = $_GET['empresa'] ?? ''; //si no existe se carga con '' 
        $coche = $_GET['coche'] ?? '';
        $compraA = $_GET['compraA'] ?? '';
        $vendeA = $_GET['vendeA'] ?? '';
        $trimestre = $_GET['trimestre'] ?? 0;
    
        $compraDesde = $_GET['compraDesde'] ?? '';
        $compraHasta = $_GET['compraHasta'] ?? '';

        $vendeDesde = $_GET['vendeDesde'] ?? '';
        $vendeHasta = $_GET['vendeHasta'] ?? '';

        $compraDesde = $compraDesde != '' ? $compraDesde : INICIO; // si no escribe en la fecha de inicio tomo la fecha 1900-01-01 como inicial
        $compraHasta = $compraHasta != '' ? $compraHasta : FIN; // si pongo date(Y-mm-dd) es la fecha actual con lo que si tiene fecha despus de hoy no aparece en el SELECT
        
        $vendeDesde = $vendeDesde != '' ? $vendeDesde : INICIO; 
        $vendeHasta = $vendeHasta != '' ? $vendeHasta : FIN;
            /* problema en este SELECT, cuando las fechas de la tabla sql son nulas porqeu no se han introducido el selecto no lee esas filas 
            asi que lo solucion poniendo OR CV.fechaCompra IS NULL, la otra posibilidad es poner COALESCE(CV.fechaVenta, '1900-01-01') si es null le da valor 1900-01-01 */

        $this->conexionPDO->consulta("SELECT CV.*, C.Nombre AS nombreComprador, V.Nombre AS nombreVendedor, E.Nombre AS nombreEmpresa, 
                                                VV.Marca_modelo, VV.Matricula, VV.Bastidor, VV.Km, VV.Fecha_matricula, 
                                                COALESCE(CC.sumaCobros,0) AS sumaCobros, 
                                                COALESCE(PC.sumaPagos,0) AS sumaPagos, 
                                                COALESCE(GC.sumaGastos,0) AS sumaGastos 
                                        /*con COALESCE, los campos con null, en lugar de nulos me da ceros */
                                        FROM compraventas CV
                                        LEFT JOIN entidad C ON CV.compraA = C.id_entidad 
                                        LEFT JOIN entidad V ON CV.vendeA = V.id_entidad 
                                        LEFT JOIN entidad E ON CV.empresa = E.id_entidad 
                                        LEFT JOIN vehiculos VV ON CV.vehiculo = VV.id_vehiculo 
                                        LEFT JOIN 
                                            (SELECT compraventa, SUM(importe) AS sumaCobros FROM cobroscomven 
                                                GROUP BY compraventa) CC ON CC.compraventa = CV.id_compraventa
                                        LEFT JOIN 
                                            (SELECT compraventa, SUM(importe) AS sumaPagos FROM pagoscomven 
                                                GROUP BY compraventa) PC ON PC.compraventa = CV.id_compraventa
                                        LEFT JOIN  
                                            (SELECT compraventa, SUM(importe) AS sumaGastos FROM gastoscompraventa 
                                                GROUP BY compraventa) GC ON GC.compraventa = CV.id_compraventa

            WHERE E.Nombre LIKE '%$empresa%' AND (VV.Marca_modelo LIKE '%$coche%' OR VV.Matricula LIKE '%$coche%'
                    OR VV.Bastidor LIKE '%$coche%') AND C.Nombre LIKE '%$compraA%' AND V.Nombre LIKE '%$vendeA%'
                    AND CV.fechaCompra BETWEEN '$compraDesde' AND '$compraHasta' OR CV.fechaCompra IS NULL
                    AND COALESCE(CV.fechaVenta, '1900-01-01') BETWEEN '$vendeDesde' AND '$vendeHasta'
                    AND CV.trimestre >= '$trimestre' ORDER BY CV.trimestre desc
                                        LIMIT $desplazamiento, ".FILAS_PAGINA); /* ordeno por trimestre para que salgan primero los del trimestre */ 
    /* CV.trimestre >= '$trimestre' esto es una filigrana, una casilla de verificacion CV sera 1 si esta marcada y sino lo esta aqui no llega nada
    pero yo le asigono 0, si la incluyo en el SELECT de esta forma CV.trimestre=$trimestre o veo los trimestre=1 o =0 pero no ambos, 
    no es como un campo text que si esta vacio '' compara con %''% que equivale a verlos todos como el * en msdos. 
    Lo soluciono con >= que si no marco la casilla, $trimestre tendra valor 0 y en el SELECT cojo los mayores o iguales que 0, es decir
    todos, y si marco la CV solo se veran los que tiene valor 1*/                          
        return $this->extraer_todos();
    }
}