<?php

namespace controllers;
use repositories\CobroAlquilerRepository;
use lib\Pages;

class CobroAlquilerController {
    private CobroAlquilerRepository $cobroAlquilerRepository;
    private Pages $pages;
    
    function __construct(){
        $this->cobroAlquilerRepository = new CobroAlquilerRepository();
        $this->pages = new Pages();
    }

public function edit ($id){
    $cobro = $this->cobroAlquilerRepository->read($id);
    $this->pages->render('editar_cobro_alquiler', ['cobro' => $cobro]); 
}
public function save(){
    $cobro = $_POST['cobro'];
    if (isset($cobro['idCobro'])) {
            $this->cobroAlquilerRepository->update($cobro);
            header('Location: /mis_pruebas/nuevo_alquiler/'.$cobro['alquiler']);//cargo el mismo alquiler que estaba editando 
            exit;
    } else { 
        $this->cobroAlquilerRepository->create($cobro);
        header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$cobro['alquiler']);//cargo el mismo alquiler que estaba editando   
        exit;
        }
}
public function delete(int $id): void {
    $this->cobroAlquilerRepository->delete($id);
    $alquiler = $_GET['alquiler'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$alquiler);//cargo el mismo vehiculo que estaba editando    
    exit; 
}

}
?>