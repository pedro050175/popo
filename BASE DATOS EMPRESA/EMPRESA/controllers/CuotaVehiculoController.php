<?php
namespace controllers;


use repositories\EntidadRepository;
use repositories\CuotaVehiculoRepository;
use lib\Pages;

class CuotaVehiculoController{
    private CuotaVehiculoRepository $cuota_repository;
    private EntidadRepository $entidad_repository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->cuota_repository = new CuotaVehiculoRepository();
        $this->entidad_repository = new EntidadRepository;
    }  

    public function save(): void { //se usa para guardar una nuevo o uno editado, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        setcookie('menuVehiculo', 'cuotas', time()+600, "/");//para que despues de guardar los cambios vuelva al menu cuotas
        $cuota=$_POST['cuota']; //coge los datos del metodo POST, los graba y salta al listado entidades
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
    public function edit(int $id): void {
        $entidades = $this->entidad_repository->findAll(false);
        $cuota = $this->cuota_repository->read($id);
        $this->pages->render('editar_cuota_vehiculo', ['cuota' => $cuota, 'entidades' => $entidades] );
    }
    public function delete(int $id): void {
        $this->cuota_repository->delete($id);
        $id_vehiculo = $_GET['vehiculo'];
        setcookie('menuVehiculo', 'cuotas', time()+600, "/");//para que despues de guardar los cambios vuelva al menu cuotas
        header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$id_vehiculo);//cargo el mismo vehiculo que estaba editando    
        exit; 
    }
}