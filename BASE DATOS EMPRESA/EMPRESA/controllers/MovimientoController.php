<?php

namespace controllers;

use repositories\MovimientoRepository;
use repositories\EntidadRepository;
use repositories\VehiculoRepository;
use repositories\EntregaRepository;
use repositories\DevolucionRepository;

use lib\Pages;

class MovimientoController{

    private MovimientoRepository $movimientoRepository;
    private EntidadRepository $entidad_repository;
    private VehiculoRepository $vehiculo_repository;
    private EntregaRepository $entregaRepository;
    private DevolucionRepository $devolucionRepository;

    private Pages $pages;

    function __construct(){
        $this->movimientoRepository = new MovimientoRepository();
        $this->entidad_repository = new EntidadRepository();
        $this->vehiculo_repository = new VehiculoRepository();
        $this->entregaRepository = new EntregaRepository();
        $this->devolucionRepository = new DevolucionRepository();
        $this->pages = new Pages();
    }

    public function list(): void {
        $movimientos = $this->movimientoRepository->findAll();
        $numPaginas = $this->movimientoRepository->getnumpaginas();

        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('movimientos', ['movimientos' => $movimientos, 'error' => $error, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $entidades = $this->entidad_repository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculo_repository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nuevo_movimiento', ['entidades' => $entidades, 'vehiculos' => $vehiculos]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $movimiento=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->movimientoRepository->save($movimiento);
        header('Location: '.DIRECTORIO."nuevo_movimiento/".$idCreado);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $entidades = $this->entidad_repository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculo_repository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'propietario' leo todas las entidades
        $movimiento = $this->movimientoRepository->read($id);
        $entregas = $this->entregaRepository->entregasMovimiento($id);
        $devoluciones = $this->devolucionRepository->devolucionesMovimiento($id);
        $this->pages->render('nuevo_movimiento', ['movimiento' => $movimiento, 'vehiculos' => $vehiculos, 'entidades' => $entidades, 'entregas' => $entregas, 'devoluciones' => $devoluciones]);
    }
    public function detalles_movimiento(int $id) {
        $entregas = $this->entregaRepository->entregasMovimiento($id);
        $devoluciones = $this->devolucionRepository->devolucionesMovimiento($id);
        $movimiento = $this->movimientoRepository->detalles_movimiento($id);
        $this->pages->render('detalles_movimiento', ['movimiento' => $movimiento, 'entregas' => $entregas, 'devoluciones' => $devoluciones]);
    }
    public function delete(int $id): void {
        $this->movimientoRepository->delete($id);
        header('Location: '.DIRECTORIO.'movimientos?num_pagina=1');
        exit; 
    }
    public function analisis (){
        if (isset($_GET['envia'])){//ya se han leido las entidades, 2º vez que pasa por aqui
            $movimientos1 = $this->movimientoRepository->findAnalisis(false);
            $movimientos2 = $this->movimientoRepository->findAnalisis(true);

            $ids = $this->leer_ids($movimientos1, $movimientos2);
            if (isset($ids)) {
                foreach ($ids as $id){//entregas[[entre_mov_id1]=Obj1,Obj2.., [entre_mov_id2]=Obj1,Obj2.., [entre_mov_id3] = ..., ...] el indice de cada tabla de entregas es el id de un movimiento
                    $entregas [$id]= $this->entregaRepository->entregasMovimiento($id);
                    $devoluciones [$id]= $this->devolucionRepository->devolucionesMovimiento($id);
                }
                //var_dump($entregas);
                $this->pages->render('analisis_movimientos', ['movimientos1' => $movimientos1, 'movimientos2' => $movimientos2, 'entregas' => $entregas, 'devoluciones' => $devoluciones]);
            }else { 
                $error = "no hay movimientos para esas entidades";
                $this->pages->render('analisis_movimientos', ['error' => $error]);
                }
        } else $this->pages->render('analisis_movimientos');//1º vez que pasa solo muestra formulario para insertar las entidades a analizar
    }
    public function deudaEmpresas(){
        $empresasPrincipales = array ('Radikal World', 'Stelar Emotions', 'Universo Radikal');
        
        foreach ($empresasPrincipales as $empresa1){
            foreach ($empresasPrincipales as $empresa2){
                if ($empresa1 != $empresa2){
                    $deuda = $this->movimientoRepository->deuda_empresas($empresa1, $empresa2);
                    $deudasEmpresas[] = array ($empresa1, $empresa2, $deuda);
                }
            }
        }
        $this->pages->render('movimiento_deuda_empresas', ['deudasEmpresas' => $deudasEmpresas]);
    }
    private function leer_ids (?array $movimientos1, ?array $movimientos2): ?array {
        foreach ($movimientos1 as $movimiento){
                $ids []= $movimiento->getidMovimiento();
        }
        foreach ($movimientos2 as $movimiento){
                $ids []= $movimiento->getidMovimiento();
        }
        return ($ids ?? null);
    }
}