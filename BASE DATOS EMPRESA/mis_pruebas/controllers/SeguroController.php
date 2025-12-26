<?php
namespace controllers;
use lib\Pages;

use repositories\VehiculoRepository;
use repositories\SeguroRepository;
use repositories\EntidadRepository;

class SeguroController {
    private Pages $pages;
    private VehiculoRepository $vehiculoRepository;
    private SeguroRepository $seguroRepository;
    private EntidadRepository $entidadRepository;

    function __construct(){
        $this->pages = new Pages();
        $this->vehiculoRepository = new VehiculoRepository();
        $this->seguroRepository = new SeguroRepository();
        $this->entidadRepository = new EntidadRepository();
    }
    public function list (): void{
        $seguros = $this->seguroRepository->findAllDinamico();
        $numPaginas = $this->seguroRepository->getnumpaginas();
        //var_dump($seguros);
        $this->pages->render('seguros', ['seguros' => $seguros, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $empresas = $this->entidadRepository->empresasGrupo(); //carga solo empresas del grupo
        $this->pages->render('nuevo_seguro', ['empresas' => $empresas]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $seguro=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->seguroRepository->save($seguro);//por si quiero cargar la pagina con el recien creado en lugar del listado de seguros
        $mensaje = "Datos guardados correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO.'seguros?num_pagina=1&mensaje='.$mensaje.'&tipo='.$tipo);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $empresas = $this->entidadRepository->empresasGrupo(); //carga solo empresas del grupo
        $seguro = $this->seguroRepository->read($id);
        $this->pages->render('nuevo_seguro', ['seguro' => $seguro, 'empresas' => $empresas]);
    }
    public function delete(int $id): void {
        $this->seguroRepository->delete($id);
        $mensaje = "El seguro se ha borrado correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO.'seguros?num_pagina=1&mensaje='.$mensaje.'&tipo='.$tipo);
        exit; 
    }
}