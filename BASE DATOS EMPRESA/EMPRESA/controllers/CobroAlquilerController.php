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
    $ampliacion = $_POST['ampliacion'];
    if (isset($ampliacion['idAmpliacion'])) {
            $this->ampliacionAlquilerRepository->update($ampliacion);
            header('Location: /mis_pruebas/nuevo_alquiler/'.$ampliacion['alquiler']);//cargo el mismo alquiler que estaba editando 
            exit;
    } else { 
        $$this->ampliacionAlquilerRepository->create($ampliacion);
        header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$ampliacion['alquiler']);//cargo el mismo alquiler que estaba editando   
        exit;
        }
}
public function delete(int $id): void {
    $this->gasto_repository->delete($id);
    $id_vehiculo = $_GET['vehiculo'];
    setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$id_vehiculo);//cargo el mismo vehiculo que estaba editando    
    exit; 
}

}
?>