<?php
namespace controllers;

use repositories\FotoRepository;
use lib\Pages;
//las llamadas a metodo reder es para cargar una nueva pagina y las llamadas a service es para acceder a datos de la base de datos
class FotoController {

    private FotoRepository $foto_repository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->foto_repository = new FotoRepository();

    }  
    public function detalles_foto(int $id) {
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        //print_r($fotos);
        $this->pages->render('detalles_vehiculo', ['fotos' => $fotos]);
    }
    public function list($id): void {
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('fotos', ['fotos' => $fotos, 'error' => $error]);//ver explicacion de la IA
    }
   /*  public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $this->pages->render('nueva_foto');
    } */
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $foto=$_POST['foto']; //coge los datos del metodo POST, los graba y salta al listado entidades
        //print_r($foto);

        $imagen=$_FILES['imagen'];
        //print_r($imagen);
        if ($imagen["type"] == "image/jpeg") {
            $this->foto_repository->save($foto, $imagen);
            header('Location: /mis_pruebas/nuevo_vehiculo/'.$foto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando   
            exit;
        }else {
            $mensaje = urlencode('La imagen debe ser jpeg');
            header("Location: /mis_pruebas/vehiculos?num_pagina=1&error=$mensaje");
        }
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $foto = $this->foto_repository->read($id);
        $this->pages->render('nuevo_foto', ['vehiculo' => $foto]);
    }
    public function delete(int $id): void {
        $this->foto_repository->delete($id);
        header('Location: /mis_pruebas/vehiculos?num_pagina=1');
        exit; 
    }
}
?>