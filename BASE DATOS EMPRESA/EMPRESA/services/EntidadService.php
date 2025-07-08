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
    public function save(array $entidad):void{
        $this->repository->save($entidad);
    }
    public function read(int $id){
        $this->repository->read($id);
    }
}