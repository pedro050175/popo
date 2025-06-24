<?php
namespace controllers;
use services\ContactosService;

class ContactosController {

    private ContactosService $service;
    
    function __construct(){
        $this->service = new ContactosService();
    }
        
    public function list(): mixed {
        return $this->service->findAll();
    }
}
?>