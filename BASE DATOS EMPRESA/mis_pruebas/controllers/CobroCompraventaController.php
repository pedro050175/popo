<?php 
namespace controllers;
use repositories\CobroCompraventaRepository;
use lib\Pages;

class CobroCompraventaController{
    private CobroCompraventaRepository $cobroCompraventaRepository;
    private Pages $pages;
    function __construct(){
        $this->pages = new Pages();
        $this->cobroCompraventaRepository = new CobroCompraventaRepository;
        
    }
public function edit ($id){
    $cobro = $this->cobroCompraventaRepository->read($id);
    $this->pages->render('editar_cobro_compraventa', ['cobro' => $cobro]); 
}
public function save(){
    $cobro = $_POST['cobro'];
    if (isset($cobro['idCobro'])) {
            $this->cobroCompraventaRepository->update($cobro);
            header("Location: /mis_pruebas/nueva_compraventa/{$cobro['compraventa']}?mensaje=Cobro guardado correctamente&tipo=exito");//uso "" y {} y no tengo que concatenar trozos 
            exit;
    } else { 
        $this->cobroCompraventaRepository->create($cobro);
        header('Location: '.DIRECTORIO.'nueva_compraventa/'.$cobro['compraventa'].'?mensaje=Cobro creado correctamente&tipo=exito');//DIRECTORIO al ser una constante no me deja ponerlo entre comillas "" y con el {}   
    exit;   
        exit;
        }
}
public function delete(int $id): void {
    $this->cobroCompraventaRepository->delete($id);
    $compraventa = $_GET['compraventa'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nueva_compraventa/'.$compraventa.'?mensaje=Cobro borrado correctamente&tipo=exito');
}
}