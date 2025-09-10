<?php
namespace controllers;

use repositories\EntregaRepository;
use lib\Pages;

class EntregaController {

    private EntregaRepository $entregaRepository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->entregaRepository = new EntregaRepository();
    } 
    public function save(): void { 
        $entrega=$_POST['entrega']; //coge los datos del metodo POST
        if (isset($entrega['idEntrega'])) {
            $this->entregaRepository->update($entrega);
            header('Location: /mis_pruebas/nuevo_movimiento/'.$entrega['movimiento']);//cargo el mismo movimiento que estaba editando 
            exit;
        } else { 
            $this->entregaRepository->create($entrega);
            header('Location: '.DIRECTORIO.'nuevo_movimiento/'.$entrega['movimiento']);//cargo el mismo movimiento que estaba editando   
            exit;
        }
    }
    public function edit(int $id): void {
        $entrega = $this->entregaRepository->read($id);
        $this->pages->render('editar_entrega', ['entrega' => $entrega] );
    }
    public function delete(int $id): void {
        $this->entregaRepository->delete($id);
        $idMovimiento = $_GET['movimiento'];
        header('Location: '.DIRECTORIO.'nuevo_movimiento/'.$idMovimiento);//cargo el mismo movimiento que estaba editando    
        exit; 
    }
}