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
        return $this->repository->read($id);
    }
    public function delete(int $id){
        $this->repository->delete($id);
    }
    public function relacionados(int $id): bool {
        return $this->repository->relacionados($id);
}
}