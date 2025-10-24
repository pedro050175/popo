<?php 
namespace controllers;
use repositories\PagoCompraventaRepository;
use lib\Pages;

class PagoCompraventaController{
    private PagoCompraventaRepository $pagoCompraventaRepository;
    private Pages $pages;
    function __construct(){
        $this->pages = new Pages();
        $this->pagoCompraventaRepository = new PagoCompraventaRepository;
        
    }
public function edit ($id){
    $pago = $this->pagoCompraventaRepository->read($id);
    $this->pages->render('editar_pago_compraventa', ['pago' => $pago]); 
}
public function save(){
    $pago = $_POST['pago'];
    if (isset($pago['idPago'])) {
            $this->pagoCompraventaRepository->update($pago);
            header("Location: /mis_pruebas/nueva_compraventa/{$pago['compraventa']}?mensaje=Pago guardado correctamente&tipo=exito");////uso "" y {} y no tengo que concatenar trozos  
            exit;
    } else { 
        $this->pagoCompraventaRepository->create($pago);  
        header('Location: '.DIRECTORIO."nueva_compraventa/{$pago['compraventa']}?mensaje=Pago creado correctamente&tipo=exito"); //DIRECTORIO al ser una constante no me deja ponerlo entre comillas "" y con el {}  
        exit;
        }
}
public function delete(int $id): void {
    $this->pagoCompraventaRepository->delete($id);
    $compraventa = $_GET['compraventa'];
    //setcookie('menuVehiculo', 'gastos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
    header('Location: '.DIRECTORIO.'nueva_compraventa/'.$compraventa.'?mensaje=Pago borrado correctamente&tipo=exito');//cargo el mismo vehiculo que estaba editando    
    exit; 
}
}