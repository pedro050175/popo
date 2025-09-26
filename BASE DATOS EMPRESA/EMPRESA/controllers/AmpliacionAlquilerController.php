<?php

namespace controllers;
use repositories\AmpliacionAlquilerRepository;
use lib\Pages;

class AmpliacionAlquilerController {
    private AmpliacionAlquilerRepository $ampliacionAlquilerRepository;
    private Pages $pages;
    
    function __construct(){
        $this->ampliacionAlquilerRepository = new AmpliacionAlquilerRepository();
        $this->pages = new Pages();
    }

public function edit ($id){
    $ampliacion = $this->ampliacionAlquilerRepository->read($id);
    $this->pages->render('editar_ampliacion_alquiler', ['ampliacion' => $ampliacion]); 
}
public function save(){
    $ampliacion = $_POST['ampliacion'];
    if (isset($ampliacion['idAmpliacion'])) {
            $this->ampliacionAlquilerRepository->update($ampliacion);
            header('Location: /mis_pruebas/nuevo_alquiler/'.$ampliacion['alquiler']);//cargo el mismo alquiler que estaba editando 
            exit;
    } else { 
        $this->ampliacionAlquilerRepository->create($ampliacion);
        header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$ampliacion['alquiler']);//cargo el mismo alquiler que estaba editando   
        exit;
        }
}
public function delete(int $id): void {
    $this->ampliacionAlquilerRepository->delete($id);
    $alquiler = $_GET['alquiler'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nuevo_alquiler/'.$alquiler);//cargo el mismo vehiculo que estaba editando    
    exit; 
}
    
    
    



}
?>