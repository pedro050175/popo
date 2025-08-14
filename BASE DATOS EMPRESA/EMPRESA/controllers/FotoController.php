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
    /* public function detalles_foto(int $id) {
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        //print_r($fotos);
        $this->pages->render('detalles_vehiculo', ['fotos' => $fotos]);
    } */
    /* public function list($id): void {
        $fotos = $this->foto_repository->fotos_vehiculo($id);
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('fotos', ['fotos' => $fotos, 'error' => $error]);//ver explicacion de la IA
    } */
   /*  public function add(): void {//no existe metodo add porque el formulario de añadir foto se carga en editar vehiculo */
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $foto=$_POST['foto']; //coge los datos del metodo POST, los graba y salta al listado entidades

        if (!isset($_FILES['imagen'])) {//es una modificadion de datos de foto
            $this->foto_repository->update($foto);
            header('Location: /mis_pruebas/pages/nuevo_vehiculo/'.$foto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando 
            exit;
        }
        $imagen = $_FILES['imagen'];
        //print_r($imagen);
        
        if ($imagen["type"] == "image/jpeg" && $imagen['error'] == UPLOAD_ERR_OK) {
            $this->foto_repository->create($foto, $imagen);
            header('Location: /mis_pruebas/pages/nuevo_vehiculo/'.$foto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando   
            exit;
        }else {
            switch ($imagen['error']){
                case UPLOAD_ERR_FORM_SIZE: $mensaje = "Archivo mayor de 2.000.000 bytes"; break;
                case UPLOAD_ERR_INI_SIZE: $mensaje = "Archivo supera limite directiva servidor"; break;
                case UPLOAD_ERR_PARTIAL: $mensaje = "Error durante la transferencia al servidor"; break;
                case UPLOAD_ERR_NO_TMP_DIR: $mensaje = "Error directorio temporal del servidor"; break;
                case UPLOAD_ERR_CANT_WRITE: $mensaje = "Error al escribir en disco"; break;
                case UPLOAD_ERR_EXTENSION: $mesanje = "Transferencia detenida por la extension"; break;
            }
            header("Location: /mis_pruebas/vehiculos?num_pagina=1&error=$mensaje");
        }
    }
    public function edit(int $id): void {
        $foto = $this->foto_repository->read($id);
        $this->pages->render('editar_foto', ['foto' => $foto]);
    }
    public function delete(int $id): void {
        $this->foto_repository->delete($id);
        $id_vehiculo = $_GET['vehiculo'];
        header('Location: /mis_pruebas/pages/nuevo_vehiculo/'.$id_vehiculo);//cargo el mismo vehiculo que estaba editando    
        exit; 
    }
}
?>