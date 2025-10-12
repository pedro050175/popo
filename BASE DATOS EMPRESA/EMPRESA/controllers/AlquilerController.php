<?php
namespace controllers;

use repositories\Alquiler;
use repositories\EntidadRepository;
use repositories\VehiculoRepository;
use lib\Pages;
use repositories\AlquilerRepository;
use repositories\AmpliacionAlquilerRepository;
use repositories\GastoAlquilerRepository;
use repositories\CobroAlquilerRepository;
use repositories\GastoVehiculoRepository;

class AlquilerController {

    private EntidadRepository $entidadRepository;
    private VehiculoRepository $vehiculoRepository;
    private AlquilerRepository $alquilerRepository;
    private AmpliacionAlquilerRepository $ampliacionRepository;
    private GastoAlquilerRepository $gastoAlquilerRepository;
    private CobroAlquilerRepository $cobroRepository;
    private GastoVehiculoRepository $gastoVehiculoRepository;
    private Pages $pages;
 
    function __construct(){
        $this->entidadRepository = new EntidadRepository();
        $this->vehiculoRepository = new VehiculoRepository();
        $this->alquilerRepository = new AlquilerRepository();
        $this->ampliacionRepository = new AmpliacionAlquilerRepository();
        $this->gastoAlquilerRepository = new GastoAlquilerRepository();
        $this->gastoVehiculoRepository = new GastoVehiculoRepository();
        $this->cobroRepository = new CobroAlquilerRepository();

        $this->pages = new Pages();
    
    }
    public function list() {
        $alquileres = $this->alquilerRepository->findAll();
        $numPaginas = $this->alquilerRepository->getnumpaginas();
        $error = $_GET['error'] ?? null;
        $this->pages->render('alquileres', ['alquileres' => $alquileres, 'error' => $error, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $entidades = $this->entidadRepository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nuevo_alquiler', ['entidades' => $entidades, 'vehiculos' => $vehiculos]);
    } 
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $alquiler=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->alquilerRepository->save($alquiler);
        header('Location: '.DIRECTORIO."nuevo_alquiler/".$idCreado);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $entidades = $this->entidadRepository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'coche' leo todas las entidades
        $alquiler = $this->alquilerRepository->read($id);
        $ampliaciones = $this->ampliacionRepository->ampliacionesAlquiler($id);
        $cobros = $this->cobroRepository->cobrosAlquiler($id);
        $gastos = $this->gastoAlquilerRepository->gastosAlquiler($id);

        $this->pages->render('nuevo_alquiler', ['alquiler' => $alquiler, 'vehiculos' => $vehiculos, 'entidades' => $entidades, 'ampliaciones' => $ampliaciones, 'cobros' => $cobros, 'gastos' => $gastos]);
    }
    public function detalles_alquiler(int $id): void {
        $alquiler = $this->alquilerRepository->read($id);
        $ampliaciones = $this->ampliacionRepository->ampliacionesAlquiler($id);
        $cobros = $this->cobroRepository->cobrosAlquiler($id);
        $gastos = $this->gastoAlquilerRepository->gastosAlquiler($id);

        $this->pages->render('detalles_alquiler', ['alquiler' => $alquiler, 'ampliaciones' => $ampliaciones, 'cobros' => $cobros, 'gastos' => $gastos]);
    }
    public function delete(int $id): void {
        $this->alquilerRepository->delete($id);
        header('Location: '.DIRECTORIO.'alquileres?num_pagina=1');
        exit; 
    }
    public function analizar(){
        $vehiculos = $this->vehiculoRepository->cochesAlquilados();//para rellenar el campo de lista desplegable 'coche' leo los coches que se han alquilado
        if (isset($_GET['cocheId'])){//ya se han leido las entidades, 2º vez que pasa por aqui
            $alquileres = $this->alquilerRepository->alquileresVehiculo(); 
            $ids = $this->leer_ids($alquileres);
            if (!empty($ids)){
                foreach ($ids as $id){
                    $ampliaciones[$id] = $this->ampliacionRepository->ampliacionesAlquiler($id);
                    $gastos[$id] = $this->gastoAlquilerRepository->gastosAlquiler($id);
                }
                $this->pages->render('analisis_alquileres', ['alquileres' => $alquileres, 'gastos' => $gastos, 'ampliaciones' => $ampliaciones, 'vehiculos' => $vehiculos]);
            } else {
                $error = "No hay alquileres para estos datos";
                $this->pages->render('analisis_alquileres', ['error' => $error, 'vehiculos' => $vehiculos]);
            }
        
        }else $this->pages->render('analisis_alquileres', ['vehiculos' => $vehiculos]); 
    }
    private function leer_ids (array $alquileres): ?array {
        foreach ($alquileres as $alquiler){
                $ids []= $alquiler->getid();
        }
        return ($ids ?? null);
    }
    
    public function totalAlquileresVehiculosFecha(){//version que lee todos los alquileres y ampliaciones en una sola consulta con IN
        //se trabaja con la tabla directamente leida del SELECT, no lo convierto en objetos
        //esto es una tabla con los alquileres de un vehiculo dentro del rango de fechas

        $input = json_decode(file_get_contents('php://input'), true);
        $desde = $input['desde'] ?? null;
        $hasta = $input['hasta'] ?? null;
        $cocheIds = $input['cocheIds'] ?? [];
        
        $datos = $this->alquilerRepository->totalAlquileresVehiculos($cocheIds, $desde, $hasta);
        if (!empty($datos)){ 
            $alquileresVehiculos= $datos;
        }
        //resultado de alquileres para dos vehiculos: id=82 (1 alquiler) y id=1 (3 alquileres)
        //      Array ( [0] => Array ( [vehiculo] => 1 [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        //              [1] => Array ( [vehiculo] => 1 [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 
        //              [2] => Array ( [vehiculo] => 1 [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) 
        //              [3] => Array ( [vehiculo] => 82 [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) ) )                                         [2] => Array ( [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) ) )
        //leo las ampliaciones de un coche dentro del rango fechas. no puedo leer las ampliaciones de un alquiler porque el alquiler puede que no este entre las fechas pero las ampliaciones si
        $datos = $this->ampliacionRepository->ampliacionesAlquilerCocheV2($desde, $hasta, $cocheIds);
        if (!empty($datos)){ 
            $ampliacionesVehiculos= $datos;
        }
        //resultado de las ampliaciones del vehiculo con id=1, tiene 3. el vehiculo 82 no tiene ampliaciones
        //Array ( [0] => Array ( [vehiculo] => 1 [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) 
        //        [1] => Array ( [vehiculo] => 1 [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) 
        //        [2] => Array ( [vehiculo] => 1 [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) )
        //concanteno las dos tablas
        $alquileresUnionAmpliaciones = [...$alquileresVehiculos ?? [], ...$ampliacionesVehiculos ?? []];//esto se llama unpacking y solo funciona con arrays con indices numericos, con asociativos no va, habria que usar array_merge()
        //, con los ... se crea una lista con los elementos y con [...$alquilere] crea una tabla de indices numericos de las dos listas creadas. 
        //pongo ?? [] porque puede ser que no exita empliaciones para un id, en ese caso ... de null es null y no se crea tabla, ni siquiera null
        //resultado de la union de los alquileres y las ampliaciones
        //Array ( [0] => Array ( [vehiculo] => 1 [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        //        [1] => Array ( [vehiculo] => 1 [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 
        //        [2] => Array ( [vehiculo] => 1 [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) 
        //        [3] => Array ( [vehiculo] => 82 [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) 
        //        [4] => Array ( [vehiculo] => 1 [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) 
        //        [5] => Array ( [vehiculo] => 1 [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) 
        //        [6] => Array ( [vehiculo] => 1 [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) )        
        //el año lo saco de la 1º fecha de la tabla Union
        //[0] => Array ( [vehiculo] => 1 [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        $año = substr($alquileresUnionAmpliaciones[0]['fechaInicio'], 0, 4);//con [0] me situo en el 1º alquiler de esa tabla y con ['fechaInicio'] en la fecha del alquiler
        //por cada id de coche creo una tabla asociativa con 12 meses, donde el indice de cada mes es ['2025-01' => suma importes alqui/ampliac,...'2025-12' => suma importes alqui/ampliac
        foreach ($cocheIds as $id){//el indice es el id de un coche 82, 1    
            for ($i=1; $i<=12; $i++){
                if ($i<10) {
                    $mesesAñoGananciaVehiculos [$id]["$año-0$i"]= 0;//a meses de un solo digito le añado el 0. inicializo a 0 el valor de cada mes
                }else $mesesAñoGananciaVehiculos [$id]["$año-$i"]= 0;
            }
        }
        //resultado de mesesGanacia para los 82 y 1. 1 array con dos array de 12 elementos (12 meses)
        //Array ( [82] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 0 [2025-11] => 0 [2025-12] => 0 ) 
        //         [1] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 0 [2025-11] => 0 [2025-12] => 0 ) )
        //cojo las ganancias de cada mes y las sumo a el mes correspondiente, todo se consigue por el indice asocietivo [año-mes]
        //Array ( [0] => Array ( [vehiculo] => 1 [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        //        [1] => Array ( [vehiculo] => 1 [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 
        //        [2] => Array ( [vehiculo] => 1 [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) 
        //        [3] => Array ( [vehiculo] => 82 [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) 
        //        [4] => Array ( [vehiculo] => 1 [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) 
        //        [5] => Array ( [vehiculo] => 1 [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) 
        //        [6] => Array ( [vehiculo] => 1 [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) ) 
        foreach ($alquileresUnionAmpliaciones as $id => $alquiler){//para cada vehiculo/id [82,1] saco su tabla de alquileres/ampiaciones
            //de su tabla de alquileres/ampliaciones: para cada alquiler/ampliacion 
                $indiceFecha = substr($alquiler['fechaInicio'],0,7);//calculo en que mes tengo que insertar la ganancia, lleyendo la fecha y quitandole el dia, de 2025-09-25 me quedo con 2025-09 que me srive de indice
                $indiceCoche = $alquiler['vehiculo'];
                $mesesAñoGananciaVehiculos[$indiceCoche][$indiceFecha] += $alquiler['ganancia']; //uso el inidce calculado para sumarlo a ese mes
            
        }
        //resultado de la suma:  
        //Array ( [82] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 5400 [2025-11] => 0 [2025-12] => 0 ) 
        //         [1] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 12650 [2025-10] => 4800 [2025-11] => 0 [2025-12] => 0 ) ) 
        //voy a obtener el nombre del coche para añadirlo a cada array $meseAño. aqyu hago un select para sacar el Marca_modelo
        foreach ($cocheIds as $id){
            $nombresCoche[$id] = $this->vehiculoRepository->nombreCoche($id);//esto me devuelve array asociativo con 1 elemento ['Marca_modelo' => 'Jeep']
        }
        //resultado nombresCoche: Array ( [82] => Array ( [Marca_modelo] => FERRARI 296GTS ) 
        //                                 [1] => Array ( [Marca_modelo] => JEEP GRANGLER V6 ) )    
        //aqui concateno la tabla con el nombre del coche con su array de mesAño
        foreach ($nombresCoche as $id => $nombreCoche){
            $mesesAñoGananciaVehiculos[$id] = array_merge($nombreCoche, $mesesAñoGananciaVehiculos[$id]);//['nombreCoche' => $nombreCoche['Marca_modelo']]
        }
        //resultado: Array ( [82] => Array ( [Marca_modelo] => FERRARI 296GTS [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 5400 [2025-11] => 0 [2025-12] => 0 ) 
        //                    [1] => Array ( [Marca_modelo] => JEEP GRANGLER V6 [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 12650 [2025-10] => 4800 [2025-11] => 0 [2025-12] => 0 ) ) 
        //calculo el total de todos los meses por cada coche
        foreach ($mesesAñoGananciaVehiculos as $coche => $meses12){
            $total = 0;
            foreach ($meses12 as $indice => $mes){
                if ($indice!="Marca_modelo") {
                    $total += $mes;
                } 
                $totales[$coche] = ['total' => $total]; 
            }
        }
        //resultado de sumar todos los meses: una tabla asociativa con el id y contiene dos tablas con id asociativo total = la suma de todos los meses 
        //Array ( [82] => Array ( [total] => 5400 ) 
        //         [1] => Array ( [total] => 18350 ) ) 
        //concateno a la los meses el total de cada coche
        foreach ($totales as $id => $total){
            $mesesAñoGananciaVehiculos[$id] = array_merge($mesesAñoGananciaVehiculos[$id], $total);
        }
        //resultado
        //Array ( [82] => Array ( [nombreCoche] => FERRARI 296GTS [2025-01] => 0 ...... [2025-10] => 5400 [2025-11] => 0 [2025-12] => 0 [total] => 5400 ) 
        //         [1] => Array ( [nombreCoche] => JEEP GRANGLER V6 [2025-01] => 0 [2025-02] => 0 .....[2025-09] => 13550 [2025-10] => 4800 [2025-12] => 0 [total] => 18350 ) ) 

        //$gastos = $this->gastoVehiculoRepository->gastosVehiculo();//leo los gastos de ese vehiculo (ojo no son los gastos de alquileres, son los del vehiculo)
        $this->pages->renderNoHeader('total_alquileres_vehiculo_fecha', ['mesesAñoGananciaVehiculos' => $mesesAñoGananciaVehiculos, 'desde' => $desde, 'hasta' => $hasta]);
    }

    public function totalAlquileresVehiculos(){//esta funcion lee todos los alquileres de vehiculos con el total de sus ampliaciones, como no hay fechas se puede leer alquiler y la suma del importe de sus ampliaciones 
        $input = json_decode(file_get_contents('php://input'), true);
        $cocheIds = $input['cocheIds'];

        $datos = $this->alquilerRepository->totalAlquileresVehiculos($cocheIds);
        if (!empty($datos)){ 
            $alquileresVehiculos= $datos;
        }
        /* resultado
            Array ( [0] => Array ( [vehiculo] => 1 [Marca_modelo] => JEEP GRANGLER V6 [primerAlquiler] => 2025-09-24 [totalGananciaAlquileres] => 18350.00 [totalPrecioAlquileres] => 19705.00 [totalDiasAlquileres] => 32 )
                    [1] => Array ( [vehiculo] => 82 [Marca_modelo] => FERRARI 296GTS [primerAlquiler] => 2025-10-03 [totalGananciaAlquileres] => 5400.00 [totalPrecioAlquileres] => 6000.00 [totalDiasAlquileres] => 2 ) ) */
        
         $this->pages->renderNoHeader('total_alquileres_vehiculo', ['alquileresVehiculos' => $alquileresVehiculos]);
        

    }




    //esta funcion no se esta usando la dejo para que se vea otra forma de trabajar las tablas
    public function totalAlquileresVehiculosFechaV2(){//version que lee los alquileres y las ampliaciones vehiculo por vehiclo
        //se trabaja con la tabla directamente leida del SELECT, no lo convierto en objetos
        //esto es una tabla con los alquileres de un vehiculo dentro del rango de fechas

        $input = json_decode(file_get_contents('php://input'), true);
        $desde = $input['desde'] ?? null;
        $hasta = $input['hasta'] ?? null;
        $cocheIds = $input['cocheIds'] ?? [];
        
        foreach ($cocheIds as $id){
            $datos = $this->alquilerRepository->totalAlquileresVehiculo($desde, $hasta, $id);
            if (!empty($datos)){ 
                $alquileresVehiculo[$id]= $datos;
            } 
        }
        //resultado de alquileres para dos vehiculos: id=82 (1 alquiler) y id=1 (3 alquileres)
        //Array (indices asociativo) ( [82] => Array ( [0] => Array ( [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) ) 
        //                              [1] => Array ( [0] => Array ( [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        //                                             [1] => Array ( [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 
        //                                             [2] => Array ( [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) ) )
        //leo las ampliaciones de un coche dentro del rango fechas. no puedo leer las ampliaciones de un alquiler porque el alquiler puede que no este entre las fechas pero las ampliaciones si
        foreach ($cocheIds as $id){
            $datos = $this->ampliacionRepository->ampliacionesAlquilerCoche($desde, $hasta, $id);
            if (!empty($datos)){ 
                $ampliacionesVehiculo[$id] = $datos;
            }
        } 
        //resultado de las ampliaciones del vehiculo con id=1, tiene 3. el vehiculo 82 no tiene ampliaciones
        //Array (indices asociativo) ( [1] => Array ( [0] => Array ( [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) 
        //                                            [1] => Array ( [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) 
        //                                            [2] => Array ( [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) ) ) 
        //concanteno las dos tablas
        foreach ($cocheIds as $id){
            $alquileresUnionAmpliaciones[$id] = [...$alquileresVehiculo[$id] ?? [], ...$ampliacionesVehiculo[$id] ?? []];//esto se llama unpacking y solo funciona con arrays con indices numericos, con asociativos no va, habria que usar array_merge()
            //, con los ... se crea una lista con los elementos y con [...$alquilere] crea una tabla de indices numericos de las dos listas creadas. 
            //pongo ?? [] porque puede ser que no exita empliaciones para un id, en ese caso ... de null es null y no se crea tabla, ni siquiera null
        }
        //resultado de la union de los alquileres y las ampliaciones
        //Array ( [82] => Array ( [0] => Array ( [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) ) 
        //         [1] => Array ( [0] => Array ( [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 ) 
        //                        [1] => Array ( [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 
        //                        [2] => Array ( [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) 
        //                        [3] => Array ( [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) 
        //                        [4] => Array ( [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) 
        //                        [5] => Array ( [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) ) )  
        //no es necesario ordenar porque cada alquiler/ampliacion se asigan a la tabla meseAñoGanancia por indice asociativo
            
        //el año lo saco de la 1º fecha de la tabla Union, como la tabla union es asociativa no puedo situarme con el indice 0,
        //current devuelve el 1º elemento de la tabla union, que es una tabla de alquileres: en este caso el 82 es una tabla con un alquiler, el alquiler [0] 
        //([0] => Array ( [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) ) 
        $alquiler = current($alquileresUnionAmpliaciones);
        $año = substr($alquiler[0]['fechaInicio'], 0, 4);//con [0] me situo en el 1º alquiler de esa tabla y con ['fechaInicio'] en la fecha del alquiler
        //creo una tabla asociativa con 12 meses por cada id, donde el indice de cada mes es ['2025-01' => suma importes alqui/ampliac,...'2025-12' => suma importes alqui/ampliac
        foreach ($alquileresUnionAmpliaciones as $indice => $fila){//el indice es el id de un coche 82, 1    
            for ($i=1; $i<=12; $i++){
                if ($i<10) {
                    $mesesAñoGanancia [$indice]["$año-0$i"]= 0;//a meses de un solo digito le añado el 0. inicializo a 0 el valor de cada mes
                }else $mesesAñoGanancia [$indice]["$año-$i"]= 0;
            }
        }
        //resultado de mesesGanacia para los 82 y 1. un array con dos array de 12 elementos (12 meses)
        //Array ( [82] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 0 [2025-11] => 0 [2025-12] => 0 ) 
        //         [1] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 0 [2025-11] => 0 [2025-12] => 0 ) )
        //cojo las ganancias de cada mes y las sumo a el mes correspondiente, todo se consigue por el indice asocietivo [año-mes]
        //Array ( [82] => Array ( [0] => Array ( [ganancia] => 5400.00 [fechaInicio] => 2025-10-03 [comisionComercial] => 600.00 ) ) 5400 los sumo con lo que tiene la celda [2025-10]
        //         [1] => Array ( [0] => Array ( [ganancia] => 4900.00 [fechaInicio] => 2025-09-24 [comisionComercial] => 100.00 )   4900.00 los sumo con lo que tiene la [2025-09]
        //                        [1] => Array ( [ganancia] => 5000.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 555.00 ) 5000.00 los sumo con lo que tiene la [2025-09]
        //                        [2] => Array ( [ganancia] => 2800.00 [fechaInicio] => 2025-10-04 [comisionComercial] => 200.00 ) ....
        //                        [3] => Array ( [ganancia] => 1350.00 [fechaInicio] => 2025-09-25 [comisionComercial] => 100.00 ) ...
        //                        [4] => Array ( [ganancia] => 1400.00 [fechaInicio] => 2025-09-23 [comisionComercial] => 100.00 ) ....
        //                        [5] => Array ( [ganancia] => 2000.00 [fechaInicio] => 2025-10-01 [comisionComercial] => 200.00 ) ) ) 2000.00 los sumo a la [2025-10]
        foreach ($alquileresUnionAmpliaciones as $id => $alquileresAmpliaciones){//para cada vehiculo/id [82,1] saco su tabla de alquileres/ampiaciones
            foreach ($alquileresAmpliaciones as $alquiler){//de su tabla de alquileres/ampliaciones: para cada alquiler/ampliacion 
                $indice = substr($alquiler['fechaInicio'],0,7);//calculo en que mes tengo que insertar la ganancia, lleyendo la fecha y quitandole el dia, de 2025-09-25 me quedo con 2025-09 que me srive de indice
                $mesesAñoGanancia[$id][$indice] += $alquiler['ganancia']; //uso el inidce calculado para sumarlo a ese mes
            }
        }
        //resultado de la suma: 
        //Array ( [82] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 5400 [2025-11] => 0 [2025-12] => 0 ) 
        //         [1] => Array ( [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 12650 [2025-10] => 4800 [2025-11] => 0 [2025-12] => 0 ) ) 
        //voy a obtener el nombre del coche para añadirlo a cada array $meseAño. aqyu hago un select para sacar el Marca_modelo
        foreach ($alquileresUnionAmpliaciones as $id => $fila){
            $nombresCoche[$id] = $this->vehiculoRepository->nombreCoche($id);//esto me devuelve array asociativo con 1 elemento ['Marca_modelo' => 'Jeep']
        }
        //resultado nombresCoche: Array ( [82] => Array ( [Marca_modelo] => FERRARI 296GTS ) [1] => Array ( [Marca_modelo] => JEEP GRANGLER V6 ) )    
        //aqui concateno el nombre de cada coche con su array de mesAño
        foreach ($nombresCoche as $id => $nombreCoche){
            $mesesAñoGanancia[$id] = array_merge(['Nombre coche' => $nombreCoche['Marca_modelo']], $mesesAñoGanancia[$id]);
        }
        //resultado: Array ( [82] => Array ( [Nombre coche] => FERRARI 296GTS [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 0 [2025-10] => 5400 [2025-11] => 0 [2025-12] => 0 ) 
        //                    [1] => Array ( [Nombre coche] => JEEP GRANGLER V6 [2025-01] => 0 [2025-02] => 0 [2025-03] => 0 [2025-04] => 0 [2025-05] => 0 [2025-06] => 0 [2025-07] => 0 [2025-08] => 0 [2025-09] => 12650 [2025-10] => 4800 [2025-11] => 0 [2025-12] => 0 ) ) 
        print_r($mesesAñoGanancia);
        //$gastos = $this->gastoVehiculoRepository->gastosVehiculo();//leo los gastos de ese vehiculo (ojo no son los gastos de alquileres, son los del vehiculo)
        //$this->pages->renderNoHeader('total_alquileres_vehiculo', ['alquileresUnionAmpliaciones' => $alquileresUnionAmpliaciones, 'gastos' => $gastos, 'alquileresVehiculo' => $alquileresVehiculo]);
    }
    public function ordenarTabla(array $tabla):array{
        for ( $i=0; $i<sizeof($tabla); $i++ ){  
            for ($j=$i; $j<sizeof($tabla); $j++){
                if ($tabla[$j]['fechaInicio']<$tabla[$i]['fechaInicio']){
                    $temp=$tabla[$i];
                    $tabla[$i]=$tabla[$j];
                    $tabla[$j]=$temp;
                }
            }
            
        }
    return $tabla;
    }
}