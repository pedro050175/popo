<?php

namespace controllers;
use repositories\GastoAlquilerRepository;
use lib\Pages;

class GastoAlquilerController {
    private GastoAlquilerRepository $gastoAlquilerRepository;
    private Pages $pages;
    
    function __construct(){
        $this->gastoAlquilerRepository = new GastoAlquilerRepository();
        $this->pages = new Pages();
    }

public function edit ($id){
    $gasto = $this->gastoAlquilerRepository->read($id);
    $this->pages->render('editar_gasto_alquiler', ['gasto' => $gasto]); 
}
public function save(){
    $gasto = $_POST['gasto'];
    if (isset($gasto['idGasto'])) {
            $this->gastoAlquilerRepository->update($gasto);
            header('Location: /mis_pruebas/nuevo_alquiler/'.$gasto['alquiler']);//cargo el mismo alquiler que estaba editando 
            exit;
    } else { 
        $this->gastoAlquilerRepository->create($gasto);
        header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$gasto['alquiler']);//cargo el mismo alquiler que estaba editando   
        exit;
        }
}
public function delete(int $id): void {
    $this->gastoAlquilerRepository->delete($id);
    $alquiler = $_GET['alquiler'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$alquiler);//cargo el mismo vehiculo que estaba editando    
    exit; 
}
}
?>