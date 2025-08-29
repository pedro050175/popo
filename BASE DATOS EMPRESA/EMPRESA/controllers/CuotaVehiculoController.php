<?php
namespace controllers;

use repositories\CuotaVehiculoRepository;
use lib\Pages;

class CuotaVehiculoController{
    private CuotaVehiculoRepository $cuota_repository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->cuota_repository = new CuotaVehiculoRepository();
    }  

    public function save(): void { //se usa para guardar una nuevo o uno editado, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $cuota=$_POST['cuota']; //coge los datos del metodo POST, los graba y salta al listado entidades
        
       // var_dump($cuota['id_vehiculo']);
        //var_dump($cuota);

        if (isset($cuota['idCuota'])) {
            $this->cuota_repository->update($cuota);
            header('Location: /mis_pruebas/nuevo_vehiculo/'.$cuota['id_vehiculo']);//cargo el mismo vehiculo que estaba editando 
            exit;
        } else { 
            $this->cuota_repository->create($cuota);
            header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$cuota['id_vehiculo']);//cargo el mismo vehiculo que estaba editando   
            exit;
        }
    }
    
}