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
    
    public function save(): void { 
        setcookie('menuVehiculo', 'fotos', time()+600, "/");//para que despues de guardar los cambios vuelva al menu fotos
        $foto=$_POST['foto']; 
        if (!isset($_FILES['imagen'])) {
            $this->foto_repository->update($foto);
            header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$foto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando 
            exit;
        }
        $imagen = $_FILES['imagen'];
        //print_r($imagen);
        
        if ($imagen["type"] == "image/jpeg" && $imagen['error'] == UPLOAD_ERR_OK) {
            $this->foto_repository->create($foto, $imagen);
            header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$foto['id_vehiculo']);//cargo el mismo vehiculo que estaba editando   
            exit;
        }else { $mensaje = errorFile($imagen['error']);
            
            header('Location: '.DIRECTORIO.'vehiculos?num_pagina=1&error=$mensaje');
        }
    }
    public function edit(int $id): void {
        $foto = $this->foto_repository->read($id);
        $this->pages->render('editar_foto', ['foto' => $foto]);
    }
    public function delete(int $id): void {
        $this->foto_repository->delete($id);
        $id_vehiculo = $_GET['vehiculo'];
        setcookie('menuVehiculo', 'fotos', time()+600, "/");//el delete no pasa por header ya que no hace render asi que creo la cookie aqui
        header('Location: '.DIRECTORIO.'nuevo_vehiculo/'.$id_vehiculo);//cargo el mismo vehiculo que estaba editando    
        exit; 
    }
}
?>