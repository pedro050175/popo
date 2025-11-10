<?php
namespace controllers;

use repositories\EntidadRepository;
use repositories\AlquilerRepository;

use lib\Pages;
//las llamadas a metodo reder es para cargar una nueva pagina y las llamadas a service es para acceder a datos de la base de datos
class EntidadController {

    private EntidadRepository $entidad_repository;
    private AlquilerRepository $alquiler_repository;

    private Pages $pages;

    function __construct(){
        $this->entidad_repository = new EntidadRepository();
        $this->pages = new Pages();
        $this->alquiler_repository = new AlquilerRepository();
    }
    public function detalles_entidad(int $id):void{
        $entidad=$this->entidad_repository->read($id);
        /* $alquileres=$this->alquiler_repository->findAll($id); esto era para mostrar los alquileres de  una entidad*/
        $this->pages->render('detalles_entidad', ['entidad' => $entidad]); // para ver los alquileres de una entidad, se pasaban dos tablas de datos una con la entidad y otra con los alquilres, 'alquileres' => $alquileres]);

    }    
    public function list(): void {
        $entidades = $this->entidad_repository->findAll();
        $numero_paginas = $this->entidad_repository->getnumpaginas();
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('entidades', ['entidades' => $entidades, 'error' => $error, 'num_paginas' => $numero_paginas]);//en el otro lado la variable tiene el nombre de 'xxxx' y el valor de $xxxx
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $this->pages->render('nueva_entidad');
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $entidad=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $this->entidad_repository->save($entidad);
        header('Location: '.DIRECTORIO.'entidades?num_pagina=1');   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $entidad = $this->entidad_repository->read($id);
        $this->pages->render('nueva_entidad', ['entidad' => $entidad]);
    }
    public function delete(int $id): void {
        $relacionados=$this->entidad_repository->relacionados($id);
        
        if ($relacionados != "") {
            $mensaje = urlencode('No se puede borrar la entidad porque tiene registros relacionados con: ' . $relacionados);
            header('Location: '.DIRECTORIO."entidades?num_pagina=1&error=$mensaje");
            exit;
            /* $entidades = $this->service->findAll(); Estas dos lineas hacen lo mismo que lo anterior y sin cargar una nueva pagina con header
            $this->pages->render('entidades', ['entidades' => $entidades,'error' => 'No se puede borrar hay asociados.']); */
            
        }
        $this->entidad_repository->delete($id);
        header('Location: '.DIRECTORIO.'entidades?num_pagina=1');
        exit; 
    }
}
?>