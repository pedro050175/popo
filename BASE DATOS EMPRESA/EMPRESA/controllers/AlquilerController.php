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

class AlquilerController {

    private EntidadRepository $entidadRepository;
    private VehiculoRepository $vehiculoRepository;
    private AlquilerRepository $alquilerRepository;
    private AmpliacionAlquilerRepository $ampliacionRepository;
    private GastoAlquilerRepository $gastoRepository;
    private CobroAlquilerRepository $cobroRepository;
    private Pages $pages;
 
    function __construct(){
        $this->entidadRepository = new EntidadRepository();
        $this->vehiculoRepository = new VehiculoRepository();
        $this->alquilerRepository = new AlquilerRepository();
        $this->ampliacionRepository = new AmpliacionAlquilerRepository();
        $this->gastoRepository = new GastoAlquilerRepository();
        $this->cobroRepository = new CobroAlquilerRepository();
        $this->pages = new Pages();
    
    }
    public function list() {
        $alquileres = $this->alquilerRepository->findAll();
        $numero_paginas = $this->alquilerRepository->getnumpaginas();
        $error = $_GET['error'] ?? null;
        $this->pages->render('alquileres', ['alquileres' => $alquileres, 'error' => $error, 'num_paginas' => $numero_paginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $entidades = $this->entidadRepository->findAll($paginar=false); //carga los propietarios para la lista desplegable propietario
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
        $entidades = $this->entidadRepository->findAll($paginar=false); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'propietario' leo todas las entidades
        $alquiler = $this->alquilerRepository->read($id);
        $ampliaciones = $this->ampliacionRepository->ampliacionesAlquiler($id);
        $cobros = $this->cobroRepository->cobrosAlquiler($id);
        $gastos = $this->gastoRepository->gastosAlquiler($id);

        $this->pages->render('nuevo_alquiler', ['alquiler' => $alquiler, 'vehiculos' => $vehiculos, 'entidades' => $entidades, 'ampliaciones' => $ampliaciones, 'cobros' => $cobros, 'gastos' => $gastos]);
    }
    public function delete(int $id): void {
        $this->alquilerRepository->delete($id);
        header('Location: '.DIRECTORIO.'alquileres?num_pagina=1');
        exit; 
    }


}