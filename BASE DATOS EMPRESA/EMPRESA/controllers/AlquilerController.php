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
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'coche' leo todos los vehiculos
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
    
    public function totalAlquileresVehiculo(){
        //leo la tabla leida del SELECT, no lo meto en objetos
        $alquileres = $this->alquilerRepository->totalAlquileresVehiculoTabla();
        //$alquileresUnionAmpliaciones=[];
        foreach ($alquileres as $alquiler){
            $ampliacionesAlquileres[] = $this->ampliacionRepository->ampliacionesAlquilerFecha($alquiler['id_alquiler']);//leo las ampliaciones de todos los alquileres
            //y aprovecho el foreach para meter los alquileres leidos en una tabla que leevara alquileres y ampliaciones
            $alquileresUnionAmpliaciones[] = ['fecha' => $alquiler['fechaInicio'], 'ganacia' => $alquiler['ganancia'], 'comision' => $alquiler['comisionComercial']];
        }
        foreach ($ampliacionesAlquileres as $ampliacionesAlquiler){//ampliacionesAlquileres es una tabla q por cada alquiler tiene sus ampliaciones, [0]->tabla de ampliaciones, [1]->tabla de amplia... y a su vez cada tabla de ampliaciones sera [0]->ampliacion0 [1]->ampliacion1...
            foreach ($ampliacionesAlquiler as $ampliacion){//el 1º for recorre todas las tablas que contienen ampliaciones y en el 2º recorro esas ampliaciones y cada ampliacion la meto en la tabla union
                $alquileresUnionAmpliaciones[] = ['fecha' => $ampliacion['fechaInicio'], 'ganacia' => $ampliacion['ganancia'], 'comision' => $ampliacion['comisionComercial']];
            }
        }
        //ordenar por fecha
        $this->ordenarTabla($alquileresUnionAmpliaciones);
        
        $gastos = $this->gastoVehiculoRepository->gastosVehiculo();//leo los gastos de ese vehiculo (ojo no son los gastos de alquileres, son los del vehiculo)
        $this->pages->renderNoHeader('total_alquileres_vehiculo', ['alquileresUnionAmpliaciones' => $alquileresUnionAmpliaciones, 'gastos' => $gastos, 'alquileres' => $alquileres]);
    }
    public function ordenarTabla(array $tabla):array{
        for ( $i=0; $i<count($tabla); $i++ ){
            $posicionMenor=0;
            $fechaMenor=$tabla[$i];// ['fecha'];

            
        }
    //return $array;
    }
}