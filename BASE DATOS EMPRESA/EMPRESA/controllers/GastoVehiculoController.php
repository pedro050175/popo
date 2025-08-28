<?php
namespace controllers;

use repositories\GastoVehiculoRepository;
use lib\Pages;
//las llamadas a metodo reder es para cargar una nueva pagina y las llamadas a service es para acceder a datos de la base de datos
class GastoVehiculoController {

    private GastoVehiculoRepository $gasto_repository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->gasto_repository = new GastoVehiculoRepository();

    }  
    
    public function save(): void { //se usa para guardar una nuevo o uno editado, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $gasto=$_POST['gasto']; //coge los datos del metodo POST, los graba y salta al listado entidades
        
       // var_dump($gasto['id_vehiculo']);
        //var_dump($gasto);

        if (isset($gasto['id_gasto'])) {
            $this->gasto_repository->update($gasto);
            header('Location: /mis_pruebas/nuevo_vehiculo/'.$gasto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando 
            exit;
        } else { 
            $this->gasto_repository->create($gasto);
            header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$gasto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando   
            exit;
        }
    }
    public function edit(int $id): void {
        $gasto = $this->gasto_repository->read($id);
        $this->pages->render('editar_gasto_vehiculo', ['gasto' => $gasto]);
    }
    public function delete(int $id): void {
        $this->gasto_repository->delete($id);
        $id_vehiculo = $_GET['vehiculo'];
        header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$id_vehiculo);//cargo el mismo vehiculo que estaba editando    
        exit; 
    }
}
?>