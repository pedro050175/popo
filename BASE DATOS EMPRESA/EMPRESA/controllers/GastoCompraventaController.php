<?php

namespace controllers;
use repositories\GastoCompraventaRepository;
use lib\Pages;

class GastoCompraventaController {
    private GastoCompraventaRepository $gastoCompraventaRepository;
    private Pages $pages;
    
    function __construct(){
        $this->gastoCompraventaRepository = new GastoCompraventaRepository();        
        $this->pages = new Pages();
    }

public function edit ($id){
    $gasto = $this->gastoCompraventaRepository->read($id);
    $this->pages->render('editar_gasto_compraventa', ['gasto' => $gasto]); 
}
public function save(){
    $gasto = $_POST['gasto'];
    if (isset($gasto['idGasto'])) {
            $this->gastoCompraventaRepository->update($gasto);
            header('Location: /mis_pruebas/nueva_compraventa/'.$gasto['compraventa'].'?mensaje=Gasto guardado correctamente&tipo=exito');//cargo el mismo alquiler que estaba editando 
            exit;
    } else {
        $this->gastoCompraventaRepository->create($gasto);
        header('Location: '.DIRECTORIO.'nueva_compraventa/'.$gasto['compraventa'].'?mensaje=Gasto creado correctamente&tipo=exito');//cargo el mismo alquiler que estaba editando   
        exit;
        }
}
public function delete(int $id): void {
    $this->gastoCompraventaRepository->delete($id);
    $compraventa = $_GET['compraventa'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nueva_compraventa/'.$compraventa.'?mensaje=Gasto borrado correctamente&tipo=exito');//cargo el mismo vehiculo que estaba editando    
    exit; 
}
}
?>