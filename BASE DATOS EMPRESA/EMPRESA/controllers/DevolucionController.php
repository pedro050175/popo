<?php
namespace controllers;

use repositories\DevolucionRepository;
use lib\Pages;

class DevolucionController {

    private DevolucionRepository $devolucionRepository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->devolucionRepository = new devolucionRepository();
    } 
    public function save(): void { 
        $devolucion=$_POST['devolucion']; //coge los datos del metodo POST
        if (isset($devolucion['idDevolucion'])) {
            $this->devolucionRepository->update($devolucion);
            header('Location: /mis_pruebas/nuevo_movimiento/'.$devolucion['movimiento']);//cargo el mismo movimiento que estaba editando 
            exit;
        } else { 
            $this->devolucionRepository->create($devolucion);
            header('Location: '.DIRECTORIO.'nuevo_movimiento/'.$devolucion['movimiento']);//cargo el mismo movimiento que estaba editando   
            exit;
        }
    }
    public function edit(int $id): void {
        $devolucion = $this->devolucionRepository->read($id);
        $this->pages->render('editar_devolucion', ['devolucion' => $devolucion] );
    }
    public function delete(int $id): void {
        $this->devolucionRepository->delete($id);
        $idMovimiento = $_GET['movimiento'];
        header('Location: '.DIRECTORIO.'nuevo_movimiento/'.$idMovimiento);//cargo el mismo movimiento que estaba editando    
        exit; 
    }
}