<?php
namespace controllers;

use repositories\EntidadRepository;
use repositories\VehiculoRepository;
use repositories\FotoRepository;
use repositories\GastoVehiculoRepository;
use repositories\CuotaVehiculoRepository;

use lib\Pages;
//las llamadas a metodo reder es para cargar una nueva pagina y las llamadas a service es para acceder a datos de la base de datos
class VehiculoController {

    private EntidadRepository $entidad_repository;
    private VehiculoRepository $vehiculo_repository;
    private FotoRepository $foto_repository;
    private GastoVehiculoRepository $gasto_repository;
    private CuotaVehiculoRepository $cuota_repository;
    private Pages $pages;

    function __construct(){
        $this->entidad_repository = new EntidadRepository();
        $this->pages = new Pages();
        $this->vehiculo_repository = new VehiculoRepository();
        $this->foto_repository = new FotoRepository();
        $this->gasto_repository = new GastoVehiculoRepository();
        $this->cuota_repository = new cuotaVehiculoRepository();
    }  
    public function detalles_vehiculo(int $id) {
        $gastos = $this->gasto_repository->gastos_vehiculo($id); 
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        $cuotas = $this->cuota_repository->cuotas_vehiculo($id);
        $vehiculo = $this->vehiculo_repository->detalles_vehiculo($id);
        $this->pages->render('detalles_vehiculo', ['vehiculo' => $vehiculo, 'fotos' => $fotos, 'gastos' => $gastos, 'cuotas' => $cuotas]);
    }
    public function list(): void {
        $vehiculos = $this->vehiculo_repository->findAll($paginar=true);
        $numero_paginas = $this->vehiculo_repository->getnumpaginas();
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('vehiculos', ['vehiculos' => $vehiculos, 'error' => $error, 'num_paginas' => $numero_paginas]);//ver explicacion de la IA
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $entidades = $this->entidad_repository->findAll($paginar=false); //carga los propietarios para la lista desplegable propietatio
        $this->pages->render('nuevo_vehiculo', ['entidades' => $entidades]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $vehiculo=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        //print_r($vehiculo);
        $this->vehiculo_repository->save($vehiculo);
        header('Location: '.DIRECTORIO.'vehiculos?num_pagina=1');   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $vehiculo = $this->vehiculo_repository->read($id);
        $entidades = $this->entidad_repository->findAll(false);//para rellenar el campo de lista desplegable 'propietario' leo todas las entidades
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        $gastos = $this->gasto_repository->gastos_vehiculo($id);
        $cuotas = $this->cuota_repository->cuotas_vehiculo($id);
        //var_dump($cuotas);
        $this->pages->render('nuevo_vehiculo', ['vehiculo' => $vehiculo, 'entidades' => $entidades, 'fotos' => $fotos, 'gastos' => $gastos, 'cuotas' => $cuotas]);
    }
    public function delete(int $id): void {
        $relacionados=$this->vehiculo_repository->relacionados($id);
        
        if ($relacionados) {
            // echo "esta relacionado";
            $mensaje = urlencode('No se puede borrar el vehiculo porque tiene registros relacionados en otras tablas.');
            header("Location: '.DIRECTORIO.'vehiculos?num_pagina=1&error=$mensaje");
            exit;
            /* $entidades = $this->service->findAll(); Estas dos lineas hacen lo mismo que lo anterior y sin cargar una nueva pagina con header
            $this->pages->render('entidades', ['entidades' => $entidades,'error' => 'No se puede borrar hay asociados.']); */
            
        }
        $this->vehiculo_repository->delete($id);
        header('Location: '.DIRECTORIO.'vehiculos?num_pagina=1');
        exit; 
    }
}
?>