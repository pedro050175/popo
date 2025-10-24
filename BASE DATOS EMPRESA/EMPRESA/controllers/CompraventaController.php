<?php
namespace controllers;
use lib\Pages;
use models\CobroCompraventa;
use repositories\VehiculoRepository;
use repositories\EntidadRepository;
use repositories\CompraventaRepository;
use repositories\CobroCompraventaRepository;
use repositories\PagoCompraventaRepository;
use repositories\GastoCompraventaRepository;

class CompraventaController{
    
    private Pages $pages;
    private VehiculoRepository $vehiculoRepository;
    private EntidadRepository $entidadRepository;
    private CompraventaRepository $compraventaRepository;
    private CobroCompraventaRepository $cobroCompraventaRepository;
    private PagoCompraventaRepository $pagoCompraventaRepository;
    private GastoCompraventaRepository $gastoCompraventaRepository;
    
    function __construct(){
        $this->vehiculoRepository = new VehiculoRepository();
        $this->entidadRepository = new EntidadRepository();
        $this->pages = new Pages();
        $this->compraventaRepository = new CompraventaRepository();
        $this->cobroCompraventaRepository = new CobroCompraventaRepository();
        $this->pagoCompraventaRepository = new PagoCompraventaRepository();
        $this->gastoCompraventaRepository = new GastoCompraventaRepository();
    }
    public function list (): void{
        $compraventas = $this->compraventaRepository->findAll();
        $numPaginas = $this->compraventaRepository->getnumpaginas();
        $error = $_GET['error'] ?? null;
        $this->pages->render('compraventas', ['compraventas' => $compraventas, 'error' => $error, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $entidades = $this->entidadRepository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//carga los vehiculos para la lista desplegable vehiculo
        $this->pages->render('nueva_compraventa', ['entidades' => $entidades, 'vehiculos' => $vehiculos]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $movimiento=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->compraventaRepository->save($movimiento);
        $mensaje = "El formulario se ha guardado correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO."nueva_compraventa/".$idCreado.'?mensaje='.$mensaje.'&tipo='.$tipo);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $entidades = $this->entidadRepository->listReducida(); //carga los propietarios para la lista desplegable propietario
        $vehiculos = $this->vehiculoRepository->findAll($paginar=false);//para rellenar el campo de lista desplegable 'coche' leo todas las entidades
        $cobros = $this->cobroCompraventaRepository->cobrosCompraventa($id);
        $pagos = $this->pagoCompraventaRepository->pagosCompraventa($id);
        $gastos = $this->gastoCompraventaRepository->gastosCompraventa($id);
        $compraventa = $this->compraventaRepository->read($id);
        $this->pages->render('nueva_compraventa', ['compraventa' => $compraventa, 'vehiculos' => $vehiculos, 'entidades' => $entidades, 'pagos' => $pagos, 'cobros' => $cobros, 'gastos' => $gastos]);
    }
    public function delete(int $id): void {
        $this->compraventaRepository->delete($id);
        header('Location: '.DIRECTORIO.'compraventas?num_pagina=1');
        exit; 
    }    
}
?>