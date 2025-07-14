<?php
namespace controllers;

use services\EntidadService;
use lib\Pages;
//las llamadas a metodo reder es para cargar una nueva pagina y las llamadas a service es para acceder a datos de la base de datos
class EntidadController {

    private EntidadService $service;
    private Pages $pages;

    function __construct(){
        $this->service = new EntidadService();
        $this->pages = new Pages();
    }
        
    public function list(): void {
        $entidades = $this->service->findAll();
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('entidades', ['entidades' => $entidades, 'error' => $error]);//ver explicacion de la IA
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $this->pages->render('nueva_entidad');
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $entidad=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $this->service->save($entidad);
        header('Location: /mis_pruebas/entidades');   
        exit;     
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $entidad = $this->service->read($id);
        $this->pages->render('nueva_entidad', ['entidad' => $entidad]);
    }
    public function delete(int $id): void {
        $relacionados=$this->service->relacionados($id);
        
        if ($relacionados) {
            $mensaje = urlencode('No se puede borrar la entidad porque hay relacionados.');
            header("Location: /mis_pruebas/entidades?error=$mensaje");
            exit;
            /* $entidades = $this->service->findAll(); Estas dos lineas hacen lo mismo que lo anterior y sin cargar una nueva pagina con header
            $this->pages->render('entidades', ['entidades' => $entidades,'error' => 'No se puede borrar hay asociados.']); */
            
        } else {
            $this->service->delete($id);
            header('Location: /mis_pruebas/entidades');
            exit;
        } 
    }
}
?>