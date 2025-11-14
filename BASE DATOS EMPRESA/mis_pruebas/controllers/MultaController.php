<?php
namespace controllers;
use repositories\MultaRepository;
use repositories\VehiculoRepository;
use lib\Pages;

class MultaController {
    private MultaRepository $multaRepository;
    private VehiculoRepository $vehiculoRepository;
    private Pages $pages;
    function __construct(){
        $this->vehiculoRepository = new VehiculoRepository();
        $this->multaRepository = new MultaRepository();
        $this->pages = new Pages();
    }
    public function list (): void{
        $multas = $this->multaRepository->findAll();
        $numPaginas = $this->multaRepository->getnumpaginas();
        $this->pages->render('multas', ['multas' => $multas, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nueva_multa', ['vehiculos' => $vehiculos]);
    }
    public function addMultiple(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nueva_multa_multiple', ['vehiculos' => $vehiculos]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $multa=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->multaRepository->save($multa);
        $mensaje = "El formulario se ha guardado correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO.'multas?mensaje='.$mensaje.'&tipo='.$tipo);   
        exit;
    }
    public function saveMultiple(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $multa=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->multaRepository->save($multa);
        $mensaje = "El formulario se ha guardado correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO.'multas?mensaje='.$mensaje.'&tipo='.$tipo);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'coche' leo todas las entidades
        $multa = $this->multaRepository->read($id);
        $this->pages->render('nueva_multa', ['multa' => $multa, 'vehiculos' => $vehiculos]);
    }
    public function delete(int $id): void {
        $this->multaRepository->delete($id);
        header('Location: '.DIRECTORIO.'multas?num_pagina=1');
        exit; 
    }
}
?>