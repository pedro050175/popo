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
}
?>