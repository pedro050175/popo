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
        $this->pages->render('nueva_multa');
    }
    public function addMultiple(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nueva_multa_multiple', ['vehiculos' => $vehiculos]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $multa=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->multaRepository->save($multa);
        header('Location: '.DIRECTORIO.'multas?mensaje=El formulario se ha guardado correctamente&tipo=exito');   
        exit;
    }
    public function saveMultiple(): void { //se usa para guardar muchas multas recibe los datos por fetch de JS 
        $input = json_decode(file_get_contents('php://input'), true);
        $multas = $input['filasMultas'] ?? null;
        $this->multaRepository->createMultiple($multas);
        header("Content-Type: text/plain; charset=UTF-8");
        //print_r($multas);
        echo ("Actualizado correctamente");
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST        
        $multa = $this->multaRepository->read($id);
        $this->pages->render('nueva_multa', ['multa' => $multa]);
    }
    public function delete(int $id): void {
        $this->multaRepository->delete($id);
        header('Location: '.DIRECTORIO.'multas?num_pagina=1');
        exit; 
    }
}
?>