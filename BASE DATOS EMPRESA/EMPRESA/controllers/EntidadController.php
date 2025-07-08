<?php
namespace controllers;

use services\EntidadService;
use lib\Pages;

class EntidadController {

    private EntidadService $service;
    private Pages $pages;

    function __construct(){
        $this->service = new EntidadService();
        $this->pages = new Pages();
    }
        
    public function list(): void {
        $entidades = $this->service->findAll();
        $this->pages->render('entidades', ['entidades' => $entidades]);//ver explicacion de la IA
    }
    public function add(): void {
        $this->pages->render('nueva_entidad');
    }
    public function save(): void {
        $entidad=$_POST['data'];
        $this->service->save($entidad);
        header('Location: /mis_pruebas/entidades');      
        
    }
    public function edit(int $id): void {
        $entidad = $this->service->read($id);
        $this->pages->render('nueva_entidad', ['entidad' => $entidad]);
    }
}
?>