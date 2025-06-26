<?php
namespace services;
use repositories\EntidadRepository;

class EntidadService {

    private EntidadRepository $repository;

    public function __construct() {
        $this->repository = new EntidadRepository();
    }
    public function findAll(): ?array { 
        return $this->repository->findAll();
    }
}